<?php include "db.php" ?>
<?php
session_start();


//-------------------  -------------------
function redirect($location){
    return header("Location: " . $location);
    exit;
}
//-------------------  -------------------
function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}
//------------------- confirms if the SQL query is running -------------------
function confirm_Query($result) {
    global $connection;
    if (!$result){
        die ('Query Failed' . mysqli_error($connection));
    }
}

//------------------- checks if the user already exists during registration -------------------
function username_exists($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    $row = mysqli_num_rows($result);
    
    if ($row > 0){
        return true;
    }
    else{
        return false;
    }
}

//------------------- checks if the email already exists during registration -------------------
function email_exists($email){
    global $connection;
    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    $row = mysqli_num_rows($result);
    
    if ($row > 0){
        return true;
    }
    else{
        return false;
    }
}

//------------------- registers new user -------------------
function register_user($fullname, $phone, $country, $email, $password){
    global $connection;
    date_default_timezone_set("Asia/Kathmandu");
    $date=date('d-m-Y');
    $status='inactive';
    $role='user';
    $profile_image = 'profile.png';
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
    $stmt = mysqli_prepare($connection, "INSERT INTO users(date, fullName, email, profile_image, phone_number, country, password, status, role) VALUES(?,?,?,?,?,?,?,?,?) ");
    mysqli_stmt_bind_param($stmt, 'sssssssss',$date, $fullname, $email,$profile_image, $phone, $country, $password, $status, $role);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if($stmt){
        $subject="Email Verification";
        $from = "noreply@ismt.com";
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $message ="
        <html>
        <head>
        <title>Email Verification</title>
        </head>
        <body>
        <h2>Dear $fullname,</h2>
        <p>Thank you for requesting user registration. Please click link given below to activate your user account.</p>
        <center><a href='http://localhost/RABINFunOlympics/user/verify_email.php?email=$email'>Verify</a><center>
        </body>
        </html>";
        
        mail($email, $subject, $message, $headers);

        echo "<script type='text/javascript'> alert('Pleace Check your email and verify your email')</script>";
        return true;
    }
}
//------------------- checks if the registered user is verified or not -------------------
function notVerifiedUser($email){
    global $connection;
    $email = escape(trim($email));
    $query = "SELECT * FROM users WHERE (email = '{$email}' ) AND status = 'inactive'";
    $select_user = mysqli_query($connection, $query);
    confirm_Query($select_user);
    $row = mysqli_num_rows($select_user);
    if ($row > 0){
        return true;
    }
    else{
        return false;
    }

}

function verify_email($email){
    global $connection;
    $email = escape($email);
    $query = "UPDATE users SET status = 'active' WHERE email = '{$email}'";
    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    if(!$result){
        return false;
    }
    return true;
}


function login_user($email, $password){
    global $connection;
    
    $query = "SELECT * FROM users WHERE (email = '{$email}') AND status = 'active'";
    $select_user = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_array($select_user)) {
    $db_uid = $row ['userId'];
    $db_email = $row ['email'];
    $db_password = $row ['password'];
    $role = $row['role'];
        if (password_verify($password, $db_password)) {
        $_SESSION['uid'] = $db_uid;
        $_SESSION['email'] = $db_email;
        $_SESSION['logged_in'] = "logged_in";
        if($role == 'user'){
            redirect("loggeduser.php");
        }
        else{
            redirect("../admin/admin.php");
        }
        }
    }
    
}
// --------------Comment Function----------------------------------------

function add_comment($user_id, $video_id, $comment, $date, $time){
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO comment (user_id, video_id, comment, date, time) VALUES(?,?,?,?,?) ");
    mysqli_stmt_bind_param($stmt, 'sssss', $user_id, $video_id, $comment, $date, $time);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if($stmt){
        return true;
    }
}


function request_password_reset($email){
    global $connection;
    date_default_timezone_set("Asia/Kathmandu");
    $date=date('d-m-Y');
    $stmt = mysqli_prepare($connection, "INSERT INTO password_reset_request(email, requested_date) VALUES(?,?) ");
    mysqli_stmt_bind_param($stmt, 'ss', $email, $date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if($stmt){
        return true;
    }
}

function upload_profile($db_uid, $fullName, $email, $country, $phone){

    global $connection;
    $email = escape($email);
    $query = "UPDATE users SET fullName = '$fullName', ";
    $query .= "email='$email', ";
    $query .= "country='$country', ";
    $query .= "phone_number='$phone' ";
    $query .= "WHERE userId = $db_uid";

    $result = mysqli_query($connection, $query);
    confirm_Query($result);
    if(!$result){
        return false;
    }
    return true;
}

function change_password($email, $new_password){
    global $connection;
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT, array('cost'=>12));
        $query = "UPDATE users SET password = '{$hashed_password}' WHERE email = '{$email}'";
        $result = mysqli_query($connection, $query);
        confirm_Query($result);
        if(!$result){
            return false;
        }
        return true;
}

function check_old_password($email, $old_password){
    global $connection;
    $select_query = "SELECT password FROM users WHERE email = '$email'";
    $query_result = mysqli_query($connection, $select_query);
    while ($row = mysqli_fetch_array($query_result)) {
            $db_user_password = $row ['password'];
            if (password_verify($old_password, $db_user_password)) {
                return true;
            }
        }
}