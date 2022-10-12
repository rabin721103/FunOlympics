<?php include '../user/functions.php' ?>

<title>Change Password</title>
<?php include 'navbar.php' ?>
<link rel="stylesheet" href="contact.css">
<div class="container" style="margin-top:100px">


<?php
if(isset($_POST['change-pw-button'])){
    $strong_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/";
    $old_password = escape($_POST['old_password']);
    $new_password = escape($_POST['new_password']);
    $confirm_password = escape($_POST['confirm_password']);
    $error = [
        'old_password'=> '',
        'new_password'=> '',
        'confirm_password'=> '',        
    ];
    if(empty($old_password)){
       $error['old_password'] = 'Old password cannot be empty.';
    }
    if(empty($new_password)){
        $error['new_password'] = 'New password cannot be empty.';
    }
    if(empty($confirm_password)){
        $error['confirm_password'] = 'Confirm password cannot be empty.';
    }
    if(!empty($old_password && ($old_password == $new_password))){
        $error['new_password'] = 'New password cannot be same as old password.';
    }
    if($confirm_password != $new_password){
        $error['confirm_password'] = 'Passwords do not match.';
    }
    if(!empty($new_password) && !preg_match($strong_regex, $new_password)){
		$error['new_password'] = 'New password is not strong.';
	}
    if(!empty($old_password) && !check_old_password($_SESSION['email'], $old_password)){
        $error['old_password'] = 'Please enter correct old password.';
    }
    foreach ($error as $key => $value){
        if(empty($value)){
            unset($error[$key]);
        }
    }
    if(empty($error)){
        
        if(change_password($_SESSION['email'], $new_password)){
            $upload_message = "Password has been changed successfully.";
        }
        else{
            $upload_message = "Password could not be changed.";
        }
    }
}
?>

<section class="container forms">
            <div class="form login">
                <div class="form-content">
                    <header>Change Password Form</header>
                    <p style="font-size:12px; color:green">
                                <?php echo isset($upload_message) ? $upload_message : '' ?></p>
                    <form action="" method="POST">
                    <div class="field input-field">
                            <input type="password" name="old_password" placeholder="Old Password" class="input">
                            <p style="font-size:12px; color:red">
                                <?php echo isset($error['old_password']) ? $error['old_password'] : '' ?></p>
                        </div>
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

</div>