<?php include 'functions.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fixture</title>
    <link rel="stylesheet" href="loggeduser.css">
</head>
<body>
    <?php include 'navbar.php'?>
    <h3 style="margin-top: 75px; margin-left: 15px;">Fun Olympics Fixture 2022</h3>
    <div class="right-top-container">
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

    
</body>
</html>