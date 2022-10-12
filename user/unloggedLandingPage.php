<?php include '../user/functions.php' ?>
<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <!-- <title> Responsive Drop Down Navigation Menu | CodingLab </title>-->
    <link rel="stylesheet" href="unloggedLandingPage.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unlogged User Page</title>
</head>

<body>
    <?php include 'navbar2.php' ?>
    <div class="login-section">

        <!-- <p>Login</p>
            <div class="input-fields">
                <label for="fname">Username</label>
                <input type="text" id="fname" name="fname">
            </div>
            <div class="input-fields">
                <label for="lname">Password</label>
                <input type="password" id="password" name="password">

            </div> -->
        <!-- <input type="submit" value="Login"> -->

        <a href="../user/login.php" id="btnSignup">Login</a>
        <small style="margin: 15px;">OR</small>
        <a href="../user/signup.php" id="btnSignup">SignUp</a>

    </div>
    <div class="a-container">
        <h3 style="font-size: inherit; font-weight:bold;">Latest Videos</h3>
        <div class="row">
            <?php
            $select_videos = mysqli_query($connection, "SELECT * FROM videos ORDER BY videoId DESC LIMIT 4");
            while ($row = mysqli_fetch_assoc($select_videos)) {
                $vPath = $row['vPath'];
                $vTitle = $row['vTitle'];
            ?>
                <div class="video-card" onClick="javascript: return confirm('Oops!! You must login or register to have full video access');">
                    <video controls src="../admin/admin_videos/<?php echo $vPath ?>"></video>
                    <p><?php echo $vTitle ?></p>
                </div>
            <?php } ?>
        </div>

        <h3 style="margin-top: 20px; font-size:inherit; font-weight:bold">News</h3>
        <div class="row">
            <?php
            $select_news = mysqli_query($connection, "SELECT * FROM news LIMIT 4");
            while ($row = mysqli_fetch_assoc($select_news)) {
                $imagePath = $row['imagePath'];
                $nTitle = $row['nTitle'];
            ?>
                <div class="news-card">
                    <img src="../admin/admin_images/<?php echo $imagePath ?>" alt="">
                    <p><?php echo $nTitle ?></p>
                    <a href="">Read More</a>
                </div>
            <?php } ?>
        </div>
        <h3 style="margin-top: 20px;">Highlights</h3>
        <div class="row">
            <?php
            $select_videos = mysqli_query($connection, "SELECT * FROM videos LIMIT 4");
            while ($row = mysqli_fetch_assoc($select_videos)) {
                $vPath = $row['vPath'];
                $vTitle = $row['vTitle'];
            ?>
                <div class="video-card">
                    <video controls src="../admin/admin_videos/<?php echo $vPath ?>"></video>
                    <p><?php echo $vTitle ?></p>
                </div>
            <?php } ?>

        </div>
        <h3 style="margin-top: 20px;">Gallery</h3>
        <div class="row">
            <?php
            $select_images = mysqli_query($connection, "SELECT * FROM admin_gallery LIMIT 4");
            while ($row = mysqli_fetch_assoc($select_images)) {
                $img_Path = $row['img_Path'];
                $img_Title = $row['img_Title'];
            ?>
                <div class="news-card">
                    <img src="../admin/image_gallery/<?php echo $img_Path ?>" alt="">
                    <p><?php echo $img_Title ?></p>
                </div>
            <?php } ?>
        </div>
        <a href="gallery2.php"><button id="gallery-btn">View Gallery</button></a>

    </div>
    <div class="footer">
        <footer>
            <p>All rights belongs to FunOlympics</p>
        </footer>
    </div>

    <script src="unloggedLandingPage.js"></script>
</body>

</html>