<?php include 'functions.php';

$strongRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = escape($_POST['fullname']);
    $phone = escape($_POST['phone']);
    $email    = escape($_POST['email']);
    $country    = escape($_POST['country']);
    $password = escape($_POST['password']);
    $confirm_password = escape($_POST['confirm_password']);
    $error = [
        'fullname' => '',
        'phone' => '',
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'country' => ''

    ];
    if ($fullname == '') {
        $error['fullname'] = 'Fullname cannot be empty.';
    }
    if ($phone == '') {
        $error['phone'] = 'Phone number cannot be empty.';
    }
    // if($username == ''){
    // 	$error['username'] = 'Username cannot be empty.';
    // }
    // if(!($username == '') && strlen($username) < 4){
    // 	$error['username'] = 'Username should be longer than 4 characters.';
    // }
    // if(username_exists($username)){
    // 	$error['username'] = $username . " already exists. If it's you, <a href='login.php'>Login</a>'";
    // }
    if ($email == '') {
        $error['email'] = 'Email cannot be empty.';
    }
    if (email_exists($email)) {
        $error['email'] = $email . " already exists. If it's you, <a href='login.php'>Login</a>";
    }
    if ($password == '') {
        $error['password'] = 'Password cannot be empty.';
    }
    if (!($password == '') && !preg_match($strongRegex, $password)) {
        $error['password'] = 'Password is not strong.';
    }
    if ($confirm_password == '') {
        $error['confirm_password'] = 'Confirm Password cannot be empty.';
    }
    if ($confirm_password != $password) {
        $error['confirm_password'] = 'Passwords do not match.';
    }
    if ($country == '') {
        $error['country'] = 'Please select your country';
    }
    // if(empty($_POST['g-recaptcha-response'])){
    // 	$error['captcha_status'] = 'Please check the reCAPTCHA checkbox.';	
    // }

    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }

    if (empty($error)) {

        if (register_user($fullname, $phone, $country, $email, $password)) {
            echo ("<p class='text-success' style='width: 100%; height:50px; text-align: center; padding:10px; background-color: rgba(0, 128, 0, 1);color: white; );'>
            Registration successful!!!!!!</p>");
            $fullname = '';
            $phone = '';
            $email    = '';
            $country    = '';
            $password = '';
            $confirm_password = '';
        } else {
            echo ("<p class='text-danger'>Registration failed</p>");
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
    <title> Login and Signup Form </title>

    <!-- CSS -->
    <link rel="stylesheet" href="login.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <section class="container forms">
        <!-- Signup Form -->

        <div class="form signup">
            <div class="form-content">
                <header>Signup</header>
                <form action="" method="POST">
                    <div class="field input-field">
                        <input type="email" placeholder="Email" class="input" name="email" value="<?php echo isset($email) ? $email : '' ?>">
                        <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                    </div>
                    <div class="field input-field">
                        <input type="text" placeholder="Full Name" class="input" name="fullname" value="<?php echo isset($fullname) ? $fullname : '' ?>">
                        <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['fullname']) ? $error['fullname'] : '' ?></p>
                    </div>

                    <div class="field input-field">
                        <input type="text" placeholder="Phone Number" class="input" name="phone" value="<?php echo isset($phone) ? $phone : '' ?>">
                        <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['phone']) ? $error['phone'] : '' ?></p>
                    </div>

                        
                        <!-- <input type="text" placeholder="Country" class="input" name="country" value="<?php echo isset($country) ? $country : '' ?>" > -->
                        <?php include "country.php" ?>
                        <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['country']) ? $error['country'] : '' ?></p>



                    <div class="field input-field">
                        <input type="password" placeholder="Password" class="password" name="password" value="<?php echo isset($password) ? $password : '' ?>">
                        <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field input-field">
                        <input type="password" placeholder="Confirm password" class="password" name="confirm_password" value="<?php echo isset($confirm_password) ? $confirm_password : '' ?>">
                        <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['confirm_password']) ? $error['confirm_password'] : '' ?></p>
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="field button-field">
                        <button type="submit">Signup</button>
                    </div>
                </form>

                <div class="form-link">
                    <span>Already have an account? <a href="login.php">Login</a></span>
                </div>
            </div>

            <!-- <div class="line"></div> -->

            <!-- <div class="media-options">
                    <a href="#" class="field facebook">
                        <i class='bx bxl-facebook facebook-icon'></i>
                        <span>Login with Facebook</span>
                    </a>
                </div> -->

            <!-- <div class="media-options">
                <a href="#" class="field google">
                    <img src="images/google.png" alt="" class="google-img">
                    <span>Signup with Google</span>
                </a>
            </div> -->

        </div>
    </section>

    <!-- JavaScript -->
    <script src="login.js"></script>
</body>

</html>