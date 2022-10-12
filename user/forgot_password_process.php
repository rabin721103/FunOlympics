<?php
include ("functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $strong_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";
    $new_password = escape($_POST['new_password']);
    $confirm_password = escape($_POST['confirm_password']);
    $error = [
        'new_password'=> '',
        'confirm_password'=> '',        
    ];
    if(empty($new_password)){
        $error['new_password'] = 'New password cannot be empty.';
    }
    if(empty($confirm_password)){
        $error['confirm_password'] = 'Confirm password cannot be empty.';
    }
    if($confirm_password != $new_password){
        $error['confirm_password'] = 'Passwords do not match.';
    }
    if(!empty($new_password) && !preg_match($strong_regex, $new_password)){
		$error['new_password'] = 'New password is not strong.';
	}
    foreach ($error as $key => $value){
        if(empty($value)){
            unset($error[$key]);
        }
    }
    if(empty($error)){
        
        if(change_password($_GET['email'], $new_password)){
            $upload_message = "Password has been changed successfully.";
        }
        else{
            $upload_message = "Password could not be changed.";
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
        <title>Password Reset Form</title>

        <!-- CSS -->
        <link rel="stylesheet" href="login.css">
                
        <!-- Boxicons CSS -->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
                        
    </head>
    <body>
        <section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Password Reset Form</header>
                    <p style="font-size:12px; color:green">
                                <?php echo isset($upload_message) ? $upload_message : '' ?></p>
                    <form action="" method="POST">
                        <div class="field input-field">
                            <input type="password" name="new_password" placeholder="New Password" class="input">
                            <p style="font-size:12px; color:red">
                                <?php echo isset($error['new_password']) ? $error['new_password'] : '' ?></p>
                        </div>
                        <div class="field input-field">
                            <input type="password" name="confirm_password" placeholder="Confirm Password" class="input">
                            <p style="font-size:12px; color:red">
                                <?php echo isset($error['confirm_password']) ? $error['confirm_password'] : '' ?></p>
                        </div>
                        <div class="field button-field">
                            <button name='change-pw-button'>Change Password</button>
                        </div>
                    </form>
                </div>

            </div>

        </section>

        <!-- JavaScript -->
        <script src="login.js"></script>
    </body>