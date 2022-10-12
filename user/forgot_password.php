<?php
include("functions.php");
$strongRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = escape($_POST['email']);

    $error = [
        'email' => '',

    ];

    if ($email == '') {
        $error['email'] = 'Email cannot be empty.';
    }
    if (!empty($email) && !email_exists($email)) {
        $error['email'] = $email . " does not exist";
    }
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }

    if (empty($error)) {
        if (request_password_reset($email)) {
            $success_message = "<p style='text-align:center'>Password Reset Request sent</p>";
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
    <title> Forgot Password Form</title>

    <!-- CSS -->
    <link rel="stylesheet" href="login.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <a href="login.php" style="margin-top: 5px;">Go Back</a>

                <header>Forgot Password</header>
                <!-- <p>Enter your mail and request for password reset</p> -->

                <p style="font-size:12px; color:green">
                    <?php echo isset($success_message) ? $success_message : '' ?></p>

                <form action="" method="POST">
                    <div class="field input-field">
                        <input type="email" name="email" placeholder="Email" class="input">
                        <p style="font-size:12px; color:red">
                            <?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                    </div>
                    <div class="field button-field">
                        <button name='proceed-button'>Proceed</button>
                    </div>
                </form>
            </div>

        </div>

    </section>

    <!-- JavaScript -->
    <script src="login.js"></script>
</body>