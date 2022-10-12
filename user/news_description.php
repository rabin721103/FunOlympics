<?php include '../user/functions.php' ?>
<!-- if user clicks like or dislike button -->

<?php
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$uid = $_SESSION['uid'];
if (isset($_POST['action'])) {
    $vid = $_POST['vid'];
    $action = $_POST['action'];
    switch ($action) {
        case 'like':
            $sql = "INSERT INTO rating_info (uid, vid, action) 
         	   VALUES ($uid, $vid, 'like') 
         	   ON DUPLICATE KEY UPDATE action='like'";
            break;
        case 'dislike':
            $sql = "INSERT INTO rating_info (uid, vid, action) 
               VALUES ($uid, $vid, 'dislike') 
         	   ON DUPLICATE KEY UPDATE action='dislike'";
            break;
        case 'unlike':
            $sql = "DELETE FROM rating_info WHERE uid=$uid AND vid=$vid";
            break;
        case 'undislike':
            $sql = "DELETE FROM rating_info WHERE uid=$uid AND vid=$vid";
            break;
        default:
            break;
    }

    // execute query to effect changes in the database ...
    mysqli_query($connection, $sql);
    echo getRating($vid);
    exit(0);
}

// Get total number of likes for a particular post
function getLikes($id)
{
    global $connection;
    $sql = "SELECT COUNT(*) FROM rating_info 
  		  WHERE vid = $id AND action = 'like'";
    $rs = mysqli_query($connection, $sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

// Get total number of dislikes for a particular post
function getDislikes($id)
{
    global $connection;
    $sql = "SELECT COUNT(*) FROM rating_info 
  		  WHERE vid = $id AND action='dislike'";
    $rs = mysqli_query($connection, $sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

// Get total number of likes and dislikes for a particular post
function getRating($id)
{
    global $connection;
    $rating = array();
    $likes_query = "SELECT COUNT(*) FROM rating_info WHERE vid = $id AND action='like'";
    $dislikes_query = "SELECT COUNT(*) FROM rating_info 
		  			WHERE vid = $id AND action='dislike'";
    $likes_rs = mysqli_query($connection, $likes_query);
    $dislikes_rs = mysqli_query($connection, $dislikes_query);
    $likes = mysqli_fetch_array($likes_rs);
    $dislikes = mysqli_fetch_array($dislikes_rs);
    $rating = [
        'likes' => $likes[0],
        'dislikes' => $dislikes[0]
    ];
    return json_encode($rating);
}

// Check if user already likes post or not
function userLiked($vid)
{
    global $connection;
    global $uid;
    $sql = "SELECT * FROM rating_info WHERE uid=$uid 
  		  AND vid=$vid AND action='like'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

// Check if user already dislikes post or not
function userDisliked($vid)
{
    global $connection;
    global $uid;
    $sql = "SELECT * FROM rating_info WHERE uid=$uid 
  		  AND vid=$vid AND action='dislike'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <title> Responsive Drop Down Navigation Menu | CodingLab </title>-->
    <link rel="stylesheet" href="videodescription.css">
    <!-- Boxicons CDN Link -->

    <script src="https://kit.fontawesome.com/42dc1d1233.js" crossorigin="anonymous"></script>
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .fa {
            font-size: 1.2em;
        }

        .fa-thumbs-down,
        .fa-thumbs-o-down {
            color: red;
            transform: rotateY(180deg);
        }

        .logged_in_user {
            padding: 10px 30px 0px;
        }

        .fa-thumbs-up,
        .fa-thumbs-o-up {
            color: blue;
        }
    </style>
</head>


<body>
    <?php include 'navbar.php' ?>
    <div class="main-section">
        <div class="video-comment">



            <div class="video-container">

                <?php
                $upload_date = date('d-m-Y');
                $upload_time = date("h:i:sa");

                $vid = $_GET['vid'];

                $query = "SELECT *FROM news  WHERE newsId = $vid ORDER BY date DESC LIMIT 3";
                $select_news = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_news)) {
                    $vid = $row['newsId'];
                    $news_title = $row['nTitle'];
                    // $video_category = $row['vCategory'];
                    $news_thumbnail = $row['imagePath'];
                    $news_description = $row['nDescription'];
                    $uploaded_date = $row['date'];

                ?>

                    <img src="../admin/admin_images/<?php echo $news_thumbnail ?>" height="450">

                    <div class="header" style="margin-bottom:10px">
                        <div class="title-date">
                            <h5><?php echo $news_title ?></h5>
                            <p><?php echo $uploaded_date ?></p>
                            <p><?php echo $news_description?></p>
                            <div class="like-dislike">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <i <?php if (userLiked($row['newsId'])) : ?> class="fa fa-thumbs-up like-btn" <?php else : ?> class="fa fa-thumbs-o-up like-btn" <?php endif ?> data-id="<?php echo $row['newsId'] ?>"></i>
                                <span class="likes"><?php echo getLikes($row['newsId']); ?></span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <i <?php if (userDisliked($row['newsId'])) : ?> class="fa fa-thumbs-down dislike-btn" <?php else : ?> class="fa fa-thumbs-o-down dislike-btn" <?php endif ?> data-id="<?php echo $row['newsId'] ?>"></i>
                                <span class="dislikes"><?php echo getDislikes($row['newsId']); ?></span>

                                <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-black">Share</button>
                                <div id="id01" class="w3-modal">
                                    <div class="w3-modal-content">
                                        <div class="w3-container">
                                            <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                                            <input type="text" name="" id="inputURL" value="<?php echo $url ?>" class="form-control" disabled>
                                            <span onclick="copyURL()" style="cursor:pointer" class="input-group-text" id="copy-URL">
                                                <i class="fa-regular fa-copy"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!-- <i class="uil uil-bars sidebar-toggle"></i> -->



                <?php
                }
                ?>













            </div>
            <!-- Comment Section Codes -->
            <div class="comment-section">
                <h5>Comment Here</h5>

                <div class="cards">
                    <?php
                    if (isset($_POST['add_comment'])) {
                        $comment = $_POST['comment'];
                        add_comment($_SESSION['uid'], $vid, $comment, $upload_date, $upload_time);
                    }
                    $query = "SELECT * FROM comment WHERE video_id = $vid";
                    $select_comment = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_comment)) {
                        $comment = $row['comment'];
                        $uid = $row['user_id'];
                        $date = $row['date'];

                        $query = "SELECT * FROM users WHERE userId = $uid";
                        $select_user = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($select_user)) {
                            $username = $row['fullName'];
                            $profile_image = $row['profile_image'];
                    ?>

                            <div class="comment-card">
                                <div class="card--header">
                                    <img src="images/<?php echo $profile_image ?>" height="50" width="50" alt="">
                                    <p><?php echo $username ?></p>
                                    <small> <?php echo $upload_date ?></small>
                                </div>
                                <p><?php echo $comment ?></p>
                            </div>
                    <?php }
                    }
                    ?>

                </div>
                <div class="enter-comment">

                    <form action="" method="POST">
                        <div class="form">
                            <div class="field input-field">
                                <input type="text" name="comment">
                                <input type="submit" name="add_comment" value="Comment" id="">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>


    </div>
    <h3 style="margin-top: 60px; margin-left:20px;">Related News</h3>
    <div class="row--videos">

        <?php

        $query = "SELECT *FROM news ORDER BY date DESC";
        $select_news = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_news)) {
            $vid = $row['newsId'];
            $news_title = $row['nTitle'];
            // $video_category = $row['vCategory'];
            $news_thumbnail = $row['imagePath'];
            // $video_description = $row['vDescription'];
            $uploaded_date = $row['date'];

        ?>

            <div class="video-card">
                <img src="../admin/admin_images/<?php echo $news_thumbnail ?>" height="250">
                <p><?php echo $news_title ?></p>
                <p><?php echo $uploaded_date ?></p>
            </div>
        <?php
        }
        ?>


    </div>

    <div class="a-footer">
        <footer>
            <p>All rights belongs to FunOlympics</p>
        </footer>
    </div>

    <script>
        $(document).ready(function() {
            // if the user clicks on the like button ...
            $('.like-btn').on('click', function() {
                var vid = $(this).data('id');
                $clicked_btn = $(this);
                if ($clicked_btn.hasClass('fa-thumbs-o-up')) {
                    action = 'like';
                } else if ($clicked_btn.hasClass('fa-thumbs-up')) {
                    action = 'unlike';
                }
                $.ajax({
                    url: 'news_description.php',
                    type: 'post',
                    data: {
                        'action': action,
                        'vid': vid
                    },
                    success: function(data) {
                        res = JSON.parse(data);
                        if (action == "like") {
                            $clicked_btn.removeClass('fa-thumbs-o-up');
                            $clicked_btn.addClass('fa-thumbs-up');
                        } else if (action == "unlike") {
                            $clicked_btn.removeClass('fa-thumbs-up');
                            $clicked_btn.addClass('fa-thumbs-o-up');
                        }
                        // display the number of likes and dislikes
                        $clicked_btn.siblings('span.likes').text(res.likes);
                        $clicked_btn.siblings('span.dislikes').text(res.dislikes);

                        // change button styling of the other button if user is reacting the second time to post
                        $clicked_btn.siblings('i.fa-thumbs-down').removeClass(
                            'fa-thumbs-down').addClass('fa-thumbs-o-down');
                    }
                });
            });

            // if the user clicks on the dislike button ...
            $('.dislike-btn').on('click', function() {
                var vid = $(this).data('id');
                $clicked_btn = $(this);
                if ($clicked_btn.hasClass('fa-thumbs-o-down')) {
                    action = 'dislike';
                } else if ($clicked_btn.hasClass('fa-thumbs-down')) {
                    action = 'undislike';
                }
                $.ajax({
                    url: 'news_description.php',
                    type: 'post',
                    data: {
                        'action': action,
                        'vid': vid
                    },
                    success: function(data) {
                        res = JSON.parse(data);
                        if (action == "dislike") {
                            $clicked_btn.removeClass('fa-thumbs-o-down');
                            $clicked_btn.addClass('fa-thumbs-down');
                        } else if (action == "undislike") {
                            $clicked_btn.removeClass('fa-thumbs-down');
                            $clicked_btn.addClass('fa-thumbs-o-down');
                        }
                        // display the number of likes and dislikes
                        $clicked_btn.siblings('span.likes').text(res.likes);
                        $clicked_btn.siblings('span.dislikes').text(res.dislikes);

                        // change button styling of the other button if user is reacting the second time to post
                        $clicked_btn.siblings('i.fa-thumbs-up').removeClass('fa-thumbs-up')
                            .addClass('fa-thumbs-o-up');
                    }
                });
            });
        });
    </script>
    <script>
        function copyURL() {
            var copyText = document.getElementById("inputURL");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);
        }
        $(document).ready(function() {
            $('#copy-URL').tooltip({
                title: "Copied",
                trigger: "click"
            });
        });
    </script>
</body>

</html>