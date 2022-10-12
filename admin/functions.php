<?php include "../user/db.php" ?>
<?php
session_start();

function redirect($location)
{
    return header("Location: " . $location);
    exit;
}

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function upload_video($title, $category, $description, $video_path, $upload_date)
{
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO videos(vTitle, vCategory, vDescription, vPath, date) VALUES(?,?,?,?,?) ");
    mysqli_stmt_bind_param($stmt, 'sssss', $title, $category, $description, $video_path, $upload_date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($stmt) {
        // add_statistics($title);
        return true;
    }
}
// function add_statistics($title){
//     global $connection;
//     $query = "INSERT INTO video_statistics(video_title, likes, dislikes, shares, views) VALUES('$title', 0, 0, 0, 0)";
//     $insert_query = mysqli_query($connection, $query);
// }
function add_sports_categories($title)
{
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO categories(title) VALUES(?) ");
    mysqli_stmt_bind_param($stmt, 's', $title);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($stmt) {
        return true;
    }
}

function add_news($date, $news_category, $news_description, $news_title, $image_path)
{
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO news(date, nCategory, nDescription , nTitle, imagePath) VALUES(?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $date, $news_category, $news_description, $news_title, $image_path);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($stmt) {
        return true;
    }
}

function add_image($img_title, $img_category, $img_path, $upload_date)
{
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO admin_gallery( img_Title, img_Category , img_Path , upload_Date) VALUES(?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'ssss', $img_title, $img_category, $img_path, $upload_date);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($stmt) {
        return true;
    }
}

function upload_live_video($title, $category, $description, $video_url, $date){
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO livevideo(vTitle, vDescription, url, date, vCategory) VALUES(?,?,?,?,?) ");
    mysqli_stmt_bind_param($stmt, 'sssss', $title, $description, $video_url, $date, $category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if($stmt){
        return true;
    }
}
// function upload_image($caption, $category_title, $image_path, $upload_date, $upload_time){
//     global $connection;
//     $stmt = mysqli_prepare($connection, "INSERT INTO photos(caption, category_title, image_path, upload_date, upload_time) VALUES(?,?,?,?,?) ");
//     mysqli_stmt_bind_param($stmt, 'sssss', $caption, $category_title, $image_path, $upload_date, $upload_time);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
//     if($stmt){
//         return true;
//     }
// }

function add_fixture($fixtures, $fixture_date, $image_path, $fixture_category)
{
    global $connection;
    $stmt = mysqli_prepare($connection, "INSERT INTO fixtures(fixtures, fixture_date, image_path, fixture_category) VALUES(?,?,?,?) ");
    mysqli_stmt_bind_param($stmt, 'ssss', $fixtures, $fixture_date, $image_path, $fixture_category);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    if ($stmt) {
        return true;
    }
}

function recordCount($table){
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_from_table = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_from_table);
    return $result;
}

function deleteCategories()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $category_id = $_GET['delete'];

        $query = "DELETE FROM categories WHERE categoryId = {$category_id}";
        mysqli_query($connection, $query);
    }
}
function delete_videos()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $vid = $_GET['delete'];
        $query = "DELETE FROM videos WHERE videoId = {$vid}";
        mysqli_query($connection, $query);
    }
}
function delete_live_videos(){
    global $connection;
    if (isset($_GET['delete'])) {
         $lvid = $_GET['delete'];
         $query = "DELETE FROM livevideo WHERE liveVideoId = {$lvid}";
         $delete_live = mysqli_query($connection, $query);
     }
}
function deletePhotos(){
    global $connection;
    if (isset($_GET['delete'])) {
         $pid = $_GET['delete'];
         $query = "DELETE FROM admin_gallery WHERE imgId = {$pid}";
         $delete_photo = mysqli_query($connection, $query);
     }
}
function deleteNews()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $nid = $_GET['delete'];
        $query = "DELETE FROM news WHERE newsId = {$nid}";
        mysqli_query($connection, $query);
    }
}
// function deleteComments(){
//     global $connection;
//     if (isset($_GET['delete'])) {
//          $comment_id = $_GET['delete'];
//          $query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
//          $delete_comment = mysqli_query($connection, $query);
//      }
// }
function deleteFixtures(){
    global $connection;
    if (isset($_GET['delete'])) {
         $fid = $_GET['delete'];
         $query = "DELETE FROM fixtures WHERE fixId = {$fid}";
         $delete_fixtures = mysqli_query($connection, $query);
     }
}
function editVideo($vid, $title, $category, $description, $video_path, $upload_date)
{
    global $connection;
    $query = "UPDATE videos SET ";
    $query .= "vTitle = '{$title}', ";
    $query .= "vCategory = '{$category}', ";
    $query .= "vDescription = '{$description}', ";
    $query .= "vPath = '{$video_path}', ";
    $query .= "date = '{$upload_date}' ";
    $query .= " WHERE videoId = {$vid}";
    $edit_video = mysqli_query($connection, $query);
    if ($edit_video) {
        return true;
    }
}
function edit_live_Video($vid, $title, $category, $description, $video_url, $upload_date)
{
    global $connection;
    $query = "UPDATE livevideo SET ";
    $query .= "vTitle = '{$title}', ";
    $query .= "vCategory = '{$category}', ";
    $query .= "vDescription = '{$description}', ";
    $query .= "url = '{$video_url}', ";
    $query .= "date = '{$upload_date}' ";
    $query .= " WHERE liveVideoId = {$vid}";
    $edit_video = mysqli_query($connection, $query);
    if ($edit_video) {
        return true;
    }
}


function editImage($pid, $img_title, $img_category, $img_path, $upload_date)
{
    global $connection;
    $query = "UPDATE admin_gallery SET ";
    $query .= "img_Title = '{$img_title}', ";
    $query .= "img_Category = '{$img_category}', ";
    $query .= "img_Path = '{$img_path}', ";
    $query .= "upload_Date = '{$upload_date}'";
    $query .= " WHERE imgId = {$pid}";
    $edit_photo = mysqli_query($connection, $query);
    if ($edit_photo) {
        return true;
    }
}

function edit_fixture($fixture_Id, $fixtures, $fixture_date, $image_path, $fixture_category)
{
    global $connection;
    $query = "UPDATE fixtures SET ";
    $query .= "fixtures = '{$fixtures}', ";
    $query .= "fixture_date = '{$fixture_date}', ";
    $query .= "image_path = '{$image_path}', ";
    $query .= "fixture_category = '{$fixture_category}'";
    $query .= " WHERE fixId = {$fixture_Id}";
    $edit_fixture = mysqli_query($connection, $query);
    if ($edit_fixture) {
        return true;
    }
}

function edit_news($newsId, $news_title, $news_description, $news_thumbnail, $news_category)
{
    global $connection;
    $query = "UPDATE news SET ";
    $query .= "nTitle = '{$news_title}', ";
    $query .= "nDescription = '{$news_description}', ";
    $query .= "imagePath = '{$news_thumbnail}', ";
    $query .= "nCategory = '{$news_category}'";
    $query .= " WHERE newsId = {$newsId}";
    $edit_news = mysqli_query($connection, $query);
    if ($edit_news) {
        return true;
    }
}

// function edit_fixture(){

// }
function changeStatusToInactive()
{
    global $connection;
    if (isset($_GET['inactive'])) {
        $user_id = $_GET['inactive'];
        $query = "UPDATE users SET status = 'inactive' WHERE userId = {$user_id}";
        mysqli_query($connection, $query);
    }
}
function changeStatusToAactive()
{
    global $connection;
    if (isset($_GET['active'])) {
        $user_id = $_GET['active'];
        $query = "UPDATE users SET status = 'active' WHERE userId = {$user_id}";
        mysqli_query($connection, $query);
    }
}

//------------------- change_password_link -------------------
function send_mail_after_password_reset($email){
    global $connection;
    $subject="Password Reset Link";
    $from = "noreply@ismt.com";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: '.$from."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
    $message ="
    <html>
    <head>
    <title>Password Reset Link</title>
    </head>
    <body>
    <p style='text-align:center'>Kindly follow the link to change your password.</p>
    <center><a href='http://localhost/RABINFunOlympics/user/forgot_password_process.php?email=$email'><button style='background:#009a49;border:none;color:white;padding:5px 10px;border-radius:5px;cursor:pointer'>Change Password</button></a><center>
    </body>
    </html>";
    if(mail($email, $subject, $message, $headers)){
        mysqli_query($connection, "DELETE FROM password_reset_request WHERE email = '$email'");
    }
    
    return true;
}

?>
