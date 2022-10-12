<?php include '../user/functions.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>All Videos</title>
   <link rel="stylesheet" href="unloggedLandingPage.css">

</head>

<body>
   <?php include 'navbar.php' ?>
   <div class="a-container" style="margin-top: 100px;">
        <h3 style="font-size: inherit; font-weight:bold;">Latest Videos</h3>
        <div class="row">
            <?php
            $select_videos = mysqli_query($connection, "SELECT * FROM videos");
            while($row = mysqli_fetch_assoc($select_videos)){
               $videoId = $row['videoId'];
                $vPath = $row['vPath'];
                $vTitle = $row['vTitle'];
            ?>
            <a href="video_description.php?vid=<?php echo $videoId ?>">
            <div class="video-card">
                <video controls src="../admin/admin_videos/<?php echo $vPath ?>"></video>
                <p><?php echo $vTitle ?></p>
            </div>
            </a>
<?php } ?>
        </div>

<script src="unloggedLandingPage.js"></script>
</body>


</html>