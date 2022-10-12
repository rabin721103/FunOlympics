<?php include '../user/functions.php' ?>
<?php
if(empty($_SESSION['logged_in']) || $_SESSION['logged_in'] == ''){
    redirect('login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="loggeduser.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="login-section">

    </div>
    <div class="main-container">
        <div class="left--container">

            <div class="head-row">
                <h3>All Videos</h3>

                <button id='btnLive'><a href="livegames.php">Watch Live</a> </button>

            </div>


            <div class="row--videos">
                <?php

                $query = "SELECT *FROM videos ORDER BY date DESC LIMIT 3";
                $select_video = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_video)) {
                    $vid = $row['videoId'];
                    $video_title = $row['vTitle'];
                    // $video_category = $row['vCategory'];
                    $video_thumbnail = $row['vPath'];
                    // $video_description = $row['vDescription'];
                    $uploaded_date = $row['date'];

                ?>
                    <a href="video_description.php?vid=<?php echo $vid ?>">
                        <div class="video-card">
                            <video controls src="../admin/admin_videos/<?php echo $video_thumbnail ?>"></video>
                            <p><?php echo $video_title ?></p>
                            <p><?php echo $uploaded_date ?></p>
                        </div>
                    </a>
                <?php
                }
                ?>

            </div>
            <div class="title">
                <div class="head-row" id="news-heading">
                    <h3>News Section</h3>
                    <button id='btnLive'><a href="livegames.php">View All</a> </button>

                </div>


            </div>
            <div class="row--videos">
                <?php
                $query = "SELECT *FROM news ORDER BY date DESC LIMIT 3";
                $select_news = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_news)) {
                    $newsId = $row['newsId'];
                    $news_title = $row['nTitle'];
                    $category = $row['nCategory'];
                    $thumbnail = $row['imagePath'];
                    $description = $row['nDescription'];
                    $upload_date = $row['date'];
                ?>
                    <a href="news_description.php?vid=<?php echo $newsId ?>">
                        <div class="video-card">
                            <img src="../admin/admin_images/<?php echo $thumbnail ?>" height="250">
                            <p><?php echo $news_title ?></p>
                            <p><?php echo $upload_date ?></p>
                        </div>
                    </a>
                <?php }
                ?>

            </div>
            <div class="title">
                <div class="head-row" id="news-heading">
                    <h3>Gallery</h3>
                    <button id='btnLive'><a href="gallery.php">View Gallery</a> </button>

                </div>
            </div>
            <div class="row--videos">
                <?php
                $query = "SELECT *FROM admin_gallery ORDER BY upload_Date DESC LIMIT 3";
                $select_image = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_image)) {
                    $imgId = $row['imgId'];
                    $image_title = $row['img_Title'];
                    $category = $row['img_Category'];
                    $thumbnail = $row['img_Path'];
                    $upload_date = $row['upload_Date'];
                ?>
                    <div class="video-card">
                        <img src="../admin/image_gallery/<?php echo $thumbnail ?>" height="250">
                        <p><?php echo $news_title ?></p>
                        <!-- <p><?php echo $upload_date ?></p> -->
                    </div>
                <?php }
                ?>

            </div>
            <!-- <h3>Gallery</h3>
            <div class="row">
                <div class="news-card">
                    <img src="images/image-2.jpg" alt="">
                    <p>Image Title</p>
                </div>
                <div class="news-card">
                    <img src="images/image-2.jpg" alt="">
                    <p>Image Title</p>
                </div>
                <div class="news-card">
                    <img src="images/image-2.jpg" alt="">
                    <p>Image Title</p>
                </div>

            </div>
            <button id="gallery-btn">View Gallery</button> -->
        </div>


        <!-- ======================================= -->
        <div class="right--container">
            <div class="right-top-container">
                <h3>Fixtures</h3>
                <?php
                $query = "SELECT *FROM fixtures ORDER BY fixture_date ASC";
                $select_fixtures = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_fixtures)) {
                    $fixture_id = $row['fixId'];
                    $fixtures = $row['fixtures'];
                    $fixture_category = $row['fixture_category'];
                    $thumbnail = $row['image_path'];
                    $fixture_date = $row['fixture_date'];

                ?>
                    <div class="fixture-card">
                        <p><?php echo $fixtures ?></p>
                        <p><?php echo $fixture_date ?></p>
                        <!-- <p><?php echo $fixture_category ?></p> -->
                    </div>
                <?php }
                ?>


            </div>
            <div class="right-bottom-container">
                <!-- <h3>Standings</h3> -->

            </div>
        </div>
    </div>

    <div class="a-footer">
        <footer>
            <p>All rights belongs to FunOlympics</p>
        </footer>
    </div>

    <script src="unloggedLandingPage.js"></script>
</body>

</html>