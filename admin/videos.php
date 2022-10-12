<?php include "admin_header.php";

?>

<?php
$upload_date = date('d-m-Y');
$upload_time = date("h:i:sa");
$allowed = array('mp4', 'mov', 'avi');

if (isset($_POST['upload_video'])) {
    $title = escape($_POST['title']);
    $category = escape($_POST['category']);
    $description = escape($_POST['description']);
    $tags = escape($_POST['tags']);

    $video_path        = escape($_FILES['video']['name']);
    $video_path_temp   = escape($_FILES['video']['tmp_name']);

    $ext = pathinfo($video_path, PATHINFO_EXTENSION);
    $error = [
        'upload_error' => '',
        'title_error' => '',
        'tag_error' => '',
        'description_error' => '',
    ];
    if ($video_path == "") {
        $error['upload_error'] = 'Please select a video.';
    }
    if ($title == "") {
        $error['title_error'] = 'Title cannot be empty.';
    }
    if ($tags == "") {
        $error['tag_error'] = 'Tags cannot be empty.';
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
        copy($video_path_temp, "admin_videos/" . time() . $video_path);
        if (upload_video($title, $category, $description, time() . $video_path, $tags, $upload_date, $upload_time)) {
            $upload_message = "Video has been uploaded successfully";
            $message_color = "text-success";
        } else {
            $upload_message = "Video could not be uploaded";
            $message_color = "text-danger";
        }
    }
}
?>
<link rel="stylesheet" href="videos.css">

<h3>Add Video</h3>
<?php echo isset($video_path) ? $video_path : '' ?>
<div class="top-container">

    <form action="" method="POST">

        <input type="text" id="title" name="title" placeholder="Video Tilte"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['title_error']) ? $error['title_error'] : '' ?></p>

        <input type="text" id="category" name="category" placeholder="Video Category"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['category']) ? $error['catgory'] : '' ?></p>

        <input type="text" id="tags" name="tags" placeholder="Tags"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['tag_error']) ? $error['tag_error'] : '' ?></p>

        <textarea name="description" id="description" cols="30" rows="5" placeholder="Description"></textarea><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['description_error']) ? $error['description_error'] : '' ?></p>

        <input type="date" id="date" name="date"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['date']) ? $error['date'] : '' ?></p>

        <input type="file" name="video" id="" class="form-control">
        <p class="text-danger" style="font-size:12px">
            <?php echo isset($error['upload_error']) ? $error['upload_error'] : '' ?>
        </p>

        <input type="submit" name="upload_video" value="Add Video">
    </form>




</div>
<div class="bottom-container">
    <h4 style="margin-top: 15px;">Videos Table</h4>
    <table style="width:100%; ">
        <tr>
            <th>Video Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Uploaded Date</th>
            <th>Action</th>

        </tr>
        <tr>
            <td>Bolt in Action </td>
            <td>Marathon</td>
            <td>sdkhasdkahskjdhkashdkashdk</td>
            <td>07/08/2022</td>
            <td><button id="edit">Edit</button><button id="delete">Delete</button></td>

        </tr>
        <tr>
            <td>De bruyne wife slept with courtios....See what happens next</td>
            <td>Football</td>
            <td>HJdasdjkskjdkjasjdsajdjaksdhkasdksahk</td>
            <td>02/08/2022</td>
            <td><button id="edit">Edit</button><button id="delete">Delete</button></td>
        </tr>
    </table>

</div>


<?php include "admin_footer.php" ?>