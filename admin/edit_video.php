<?php include 'admin_header.php';
include '../user/db.php';
?>
<?php
if (isset($_GET['edit'])) {
    $vid = $_GET['edit'];
}
// $upload_date = date('d-m-Y');
// $upload_time = date("h:i:sa");
$allowed = array('mp4', 'mov', 'avi');
if (isset($_POST['edit_video'])) {

    $title = escape($_POST['title']);
    $category = escape($_POST['category']);
    $description = escape($_POST['description']);
    $upload_date = escape($_POST['date']);
    $video_path        = escape($_FILES['video_path']['name']);
    $video_path_temp   = escape($_FILES['video_path']['tmp_name']);
    $ext = pathinfo($video_path, PATHINFO_EXTENSION);
    $error = [
        'upload_error' => '',
        'title_error' => '',
        'description_error' => '',
    ];
    if ($video_path == "") {
        $error['upload_error'] = 'Please select a video.';
    }
    if ($title == "") {
        $error['title_error'] = 'Title cannot be empty.';
    }
    if ($description == "") {
        $error['description_error'] = 'Description cannot be empty.';
    }
    if (!($video_path == "") && !in_array($ext, $allowed)) {
        $error['upload_error'] = 'Invalid video format. Available format(mp4, mov, avi)';
    }
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {

        if (editVideo($vid, $title, $category, $description, time() . $video_path, $upload_date)) {
            copy($video_path_temp, "admin_videos/" . time() . $video_path);
            $upload_message = "Video has been updated successfully";
            $message_color = "text-success";
        } else {
            $upload_message = "Video could not be uploaded";
            $message_color = "text-danger";
        }
    }
}

$query = "SELECT * FROM videos WHERE videoId = $vid";
$select_video = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_video)) {
    $db_video_title = $row['vTitle'];
    $db_video_description = $row['vDescription'];
    $db_video_path = $row['vPath'];
    $db_upload_date = $row['date'];
    $db_video_category = $row['vCategory'];
} ?>
<link rel="stylesheet" href="videos.css">

<h3>Edit Video</h3>
<div class="top-container">
    <p style="color:<?php echo isset($message_color) ? $message_color : '' ?>">
        <?php echo isset($upload_message) ? $upload_message : '' ?></p>

    <form action="" method="POST" enctype="multipart/form-data">


        <label for="title" style="font-weight:800;">Title</label>
        <input type="text" id="title" name="title" placeholder="Video Tilte" value="<?php echo $db_video_title ?>">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['title_error']) ? $error['title_error'] : '' ?></p>

        <label for="category" style="font-weight:800;">Category</label>
        <input type="text" id="category" name="category" placeholder="Video Category" value="<?php echo $db_video_category ?> ">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['category']) ? $error['catgory'] : '' ?></p>

        <label for="description" style="font-weight:800;">Description</label>
        <textarea name="description" id="description" cols="30" rows="5" placeholder="Description"><?php echo $db_video_description ?></textarea>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['description_error']) ? $error['description_error'] : '' ?></p>

        <label for="date" style="font-weight:800;">Upload Date</label>
        <input type="date" id="date" name="date" value="<?php echo $db_upload_date ?>">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['date']) ? $error['date'] : '' ?></p>

        <input type="file" name="video_path" id="" class="form-control">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['upload_error']) ? $error['upload_error'] : '' ?>
        </p>

        <input type="submit" name="edit_video" value="Update">
    </form>




</div>