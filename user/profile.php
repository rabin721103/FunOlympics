<?php include '../user/functions.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

</head>

<body>
   <?php include 'navbar.php';
   $email = $_SESSION['email'];
   $session_uid = $_SESSION['uid'];

   ?>
   <?php
   $select_user = mysqli_query($connection, "SELECT * FROM users WHERE userId = '$session_uid'");
   while ($row = mysqli_fetch_assoc($select_user)) {
      $db_uid = $row['userId'];
      $db_email = $row['email'];
      $profile_image = $row['profile_image'];
      $fullName = $row['fullName'];
      $country = $row['country'];
      $phone_number = $row['phone_number'];
   }
   ?>
   <h3 style="margin-top: 75px;">Hello User</h3>
   <div class="abc" style="margin-left:15px; margin-top: 15px;">
      <img src="../admin/admin_images/<?php echo $profile_image ?>" alt="" height="200" width="200">
      <br>
      Email:- <?php echo $db_email ?> <br>
      Fullname:- <?php echo $fullName ?><br>
      Country:- <?php echo $country ?><br>
      Phone Number:- <?php echo $phone_number ?>
      <br>
      <br>
      <a style="color: green;" href="edit_profile.php?edit=<?php echo $db_uid ?>">Update Profile</a><br><br>
      <a style="color: red;" href="change_password.php">Change Password?</a>

   </div>
   <script src="unloggedLandingPage.js"></script>

</body>

</html>