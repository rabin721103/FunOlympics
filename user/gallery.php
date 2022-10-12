<?php include '../user/functions.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gallery</title>
   <link rel="stylesheet" href="gallery.css">

</head>

<body>
   <?php include 'navbar.php' ?>
   <div class="gallery-container">
      <div class="gallery-grid">
         <?php
         $query = "SELECT *FROM admin_gallery ORDER BY upload_Date DESC";
         $select_image = mysqli_query($connection, $query);
         while ($row = mysqli_fetch_assoc($select_image)) {
            $title = $row['img_Title'];
            $category = $row['img_Category'];
            $thumbnail = $row['img_Path'];
            $upload_date = $row['upload_Date'];
         ?>
            <div class="image-card">
               <a href="#img1">
                  <img class="small" src="../admin/image_gallery/<?php echo $thumbnail ?>" height="500" width="400">
                  <p><?php echo $title?></p>
                  <p><?php echo $upload_date?></p>
               </a>
            </div>
            <!-- Thumbnails -->


            <!--Lightboxes-->
            <a href="#_" class="lightbox" id="img1">
               <div>
                  
                  <img src="../admin/image_gallery/<?php echo $thumbnail ?>" height="500" width="400">
                  <p style="color:azure;"><?php echo $title ?></p>
               </div>
            </a>
         <?php
         }
         ?>
      </div>

</body>

</html>