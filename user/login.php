<?php
include ("functions.php");
$strongRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = escape($_POST['email']);
	$password = escape($_POST['password']);
    
	$error = [
		'password'=> '',
		'username'=>'',
        'email' => '',
		
	];
	
	if($email == ''){
		$error['email'] = 'Email cannot be empty';
	}
	if(!empty($email) && !email_exists($email)){
		$error['email'] = $email . " does not exist";
	}

	if($password == ''){
		$error['password'] = 'Password cannot be empty.';
	}
    if(notVerifiedUser($email)){
        $error['email'] = 'Email not verified. Please check your email and Verify';
    }
    if(!empty($email) && !notVerifiedUser($email) && (email_exists($email)) && !login_user($email, $password)){
            $error['email'] = 'Invalid username and passsword';
    }
    // if(!empty($remember)){
    //     setcookie('email', $_POST['email'], time()+86400);
    //     setcookie('password', $_POST['password'], time()+86400);
    // }
    // if(empty($remember)){
    //     setcookie('username', '', time()-86400);
    //     setcookie('password', '', time()-86400);
    // }
	foreach ($error as $key => $value){
		if(empty($value)){
			unset($error[$key]);
		}
	}
	
	if(empty($error)){
        
        
        login_user($email, $password);
            
	}
}

?>


<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Login Form </title>

        <!-- CSS -->
        <link rel="stylesheet" href="login.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
                        
    </head>
    <body>
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Login</header>
                    <form action="" method="POST">
                        <div class="field input-field">
                            <input type="email" name="email" placeholder="Email" class="input">
                            <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>

                        <div class="field input-field">
                            <input type="password" name="password"placeholder="Password" class="password">
                            <i class='bx bx-hide eye-icon'></i>
                            <p class="text-danger" style="font-size:12px; color:red">
                            <?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>

                        <div class="form-link">
                            <a href="forgot_password.php" class="forgot-pass">Forgot password?</a>
                        </div>

                        <div class="field button-field">
                            <button name='login-button'>Login</button>
                        </div>
                    </form>

                    <div class="form-link">
                        <span>Don't have an account? <a href="signup.php" >Signup</a></span>
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
                        <span>Login with Google</span>
                    </a>
                </div> -->

            </div>

        </section>

        <!-- JavaScript -->
        <script src="login.js"></script>
    </body>