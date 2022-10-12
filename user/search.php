<?php include 'functions.php' ?>
<?php
if (isset($_POST['search'])) {
    $search = $_POST['search'];
} ?>
<?php include 'navbar.php'?>
<div class="videos" style="margin-top: 75px; margin-left:15px;">
<?php

$query = "SELECT * FROM videos WHERE vDescription LIKE '%$search%'";
$select_videos = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_videos)) {
    $vid                = $row['videoId'];
    $title     = $row['vTitle'];
    $video_path     = $row['vPath'];
    $upload_date     = $row['date'];
?>

    <video height="100" width="150" controls>
        <source src="../admin/admin_videos/<?php echo $video_path ?>" type="video/mp4" >
    </video>
    <a href="video_description.php?vid=<?php echo $vid ?>&title=<?php echo $title ?>&type=highlight">
        <h5 class="card-title" style="overflow: hidden; display: -webkit-box; -moz-box-orient: vertical;
                                             -webkit-box-orient: vertical; box-orient: vertical; -webkit-line-clamp: 2; ine-clamp: 2; ">
            <?php echo $title ?></h5>
    </a>
    <small class="text-muted">Uploaded: <?php echo $upload_date  ?> </small>

<?php } ?>
</div>
<script src="unloggedLandingPage.js"></script>