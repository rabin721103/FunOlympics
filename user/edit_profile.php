<?php include 'functions.php';
$db_uid = $_GET['edit'];
if (isset($_POST['update_profile'])){
    $fullName = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $error = [
        'name_error' => '',
        'email_error' => '',
        'phone_error' => '',
        'country_error' => '',
    ];
    if ($fullName == "") {
        $error['name_error'] = 'Please Enter Name ';
    }
    if ($email == "") {
        $error['email_error'] = 'Please Enter email';
    }
    if ($country == "") {
        $error['country_error'] = 'Please Enter country ';
    }
    if ($phone == "") {
        $error['phone_error'] = 'Please Enter Phone Number ';
    }
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {

        if (upload_profile($db_uid, $fullName, $email, $country, $phone)) {
            $upload_message = "Profile has been Updated successfully";
            $message_color = "green";
        } else {
            $upload_message = "Profile could not be uploaded";
            $message_color = "red";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php include 'navbar.php' ?>
    <div class="profile" style="margin-top:75px;">
    <p style="text-align:center;color:<?php echo isset($message_color)?$message_color:'' ?>"><?php echo isset($upload_message)?$upload_message:'' ?></p>
    <?php
    $select_user = mysqli_query($connection, "SELECT * FROM users WHERE userId = $db_uid");
    while ($row = mysqli_fetch_assoc($select_user)) {
        $db_uid = $row['userId'];
        $db_email = $row['email'];
        $profile_image = $row['profile_image'];
        $fullName = $row['fullName'];
        $country = $row['country'];
        $phone_number = $row['phone_number'];
    }
    ?>


    <form action="" method="POST">
        <label for="">Email</label>
        <input type="email" name="email" value="<?php echo $db_email?>">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['email_error']) ? $error['email_error'] : '' ?></p>

            <label for="">Full Name</label>
        <input type="text" name="fullname" value="<?php echo $fullName?>">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['name_error']) ? $error['name_error'] : '' ?></p>

            <label for="">Phone Number</label>
        <input type="text" name="phone" value="<?php echo $phone_number?>">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['phone_error']) ? $error['phone_error'] : '' ?></p>

            <label for="">Country</label>
        <input type="text" name="country" value="<?php echo $country?>">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['country_error']) ? $error['country_error'] : '' ?></p>
        <input type="submit" name="update_profile" value="Update">
    </form>
    </div>

</body>

</html>