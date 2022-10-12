<?php include '../user/functions.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All News</title>
    <link rel="stylesheet" href="unloggedLandingPage.css">

</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="b-container" style="margin-top: 100px;">
        <h3 style="font-size: inherit; font-weight:bold;">Fun Olympics News Section</h3>
        <div class="row">
            <?php
            $select_news = mysqli_query($connection, "SELECT * FROM news");
            while ($row = mysqli_fetch_assoc($select_news)) {
                $newsId = $row['newsId'];
                $nPath = $row['imagePath'];
                $nTitle = $row['nTitle'];
                $nDescription = $row['nDescription'];
                $uploaded_date= $row['date']
            ?>
                <a href="news_description.php?vid=<?php echo $newsId ?>">
                    <div class="video-card">
                        <img src="../admin/admin_images/<?php echo $nPath ?>" height="250" width="300">
                        <p><?php echo $nTitle ?></p>
                        <p><?php echo $nDescription?></p>
                        <p style="color: red;"><?php echo $uploaded_date?></p>
                    </div>
                </a>
            <?php } ?>
        </div>

</body>

</html>