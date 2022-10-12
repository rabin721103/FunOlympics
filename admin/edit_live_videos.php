<?php include 'admin_header.php';
include '../user/db.php';
?>
<?php
if (isset($_GET['edit'])) {
    $vid = $_GET['edit'];
}
// $upload_date = date('d-m-Y');
// $upload_time = date("h:i:sa");
if (isset($_POST['edit_live_video'])) {

    $title = escape($_POST['title']);
    $category = escape($_POST['category']);
    $description = escape($_POST['description']);
    $upload_date = escape($_POST['date']);
    $video_url        = escape($_POST['video_url']);
    $error = [
        'upload_error' => '',
        'title_error' => '',
        'description_error' => '',
    ];
    if ($video_url == "") {
        $error['upload_error'] = 'Insert Link.';
    }
    if ($title == "") {
        $error['title_error'] = 'Title cannot be empty.';
    }
    if ($description == "") {
        $error['description_error'] = 'Description cannot be empty.';
    }
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {

        if (edit_live_Video($vid, $title, $category, $description, $video_url, $upload_date)) {
            $upload_message = "Live Video has been updated successfully";
            $message_color = "text-success";
        } else {
            $upload_message = "Live Video could not be uploaded";
            $message_color = "text-danger";
        }
    }
}

$query = "SELECT * FROM livevideo WHERE liveVideoId = $vid";
$select_video = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_video)) {
    $db_video_title = $row['vTitle'];
    $db_video_description = $row['vDescription'];
    $db_video_url = $row['url'];
    $db_upload_date = $row['date'];
    $db_video_category = $row['vCategory'];
} ?>
<link rel="stylesheet" href="videos.css">

<h3>Edit Video</h3>
<div class="top-container">
    <?php echo isset($upload_message)? $upload_message:''?>

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

        <input type="text" name="video_url" value="<?php echo $db_video_url?>" id="" class="form-control" >
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['upload_error']) ? $error['upload_error'] : '' ?>
        </p>

        <input type="submit" name="edit_live_video" value="Update">
    </form>




</div>