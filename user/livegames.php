<?php include '../user/functions.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Live Videos</title>
   <link rel="stylesheet" href="unloggedLandingPage.css">

</head>

<body>
   <?php include 'navbar.php' ?>
   <div class="a-container" style="margin-top: 100px;">
        <h3 style="font-size: inherit; font-weight:bold;">Latest Live Games</h3>
        <div class="row">
            <?php
            $select_videos = mysqli_query($connection, "SELECT * FROM livevideo");
            while($row = mysqli_fetch_assoc($select_videos)){
               $videoId = $row['liveVideoId'];
                $video_url = $row['url'];
                $vTitle = $row['vTitle'];
            ?>
            <a href="live_video_description.php?vid=<?php echo $videoId ?>">
            <div class="video-card">
                <iframe src="<?php echo $video_url?>" frameborder="0" ></iframe>
                <p><?php echo $vTitle ?></p>
            </div>
            </a>
<?php } ?>
        </div>

</body>

</html>