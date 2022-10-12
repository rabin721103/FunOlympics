<?php include "admin_header.php" ?>

<?php


// $upload_date = date('d-m-Y');
// $upload_time = date("h:i:sa");
$allowed = array('mp4', 'mov', 'avi');

if (isset($_POST['upload_video'])) {
    $title = escape($_POST['title']);
    $category = escape($_POST['category']);
    $description = escape($_POST['description']);
    // $tags = escape($_POST['tags']);
    $date = escape($_POST['date']);
    $video_path        = escape($_FILES['video_path']['name']);
    $video_path_temp   = escape($_FILES['video_path']['tmp_name']);
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
    // if($tags==""){
    //     $error['tag_error'] = 'Tags cannot be empty.';
    // }
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
        if (upload_video($title, $category, $description, time() . $video_path, $date)) {
            $upload_message = "Video has been uploaded successfully";
            $message_color = "green";
        } else {
            $upload_message = "Video could not be uploaded";
            $message_color = "red";
        }
    }
}
?>
<link rel="stylesheet" href="videos.css">

<h3>Add Video</h3>
<p style="text-align:center;color:<?php echo isset($message_color)?$message_color:'' ?>"><?php echo isset($upload_message)?$upload_message:'' ?></p>
<div class="top-container">

    <form action="" method="POST" enctype="multipart/form-data">

        <input type="text" id="title" name="title" placeholder="Video Tilte">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['title_error']) ? $error['title_error'] : '' ?></p>

        <select name="category" id="" class="form-control">
            <option value="" style="font:inherit; font-size:inherit">Select Category</option>
            <?php
            $select_query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $select_query);
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $category_title     = $row['title'];
                echo "<option value='$category_title'>$category_title</option>";
            } ?>
        </select>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['category']) ? $error['catgory'] : '' ?></p>

        <textarea name="description" id="description" cols="30" rows="5" placeholder="Description"></textarea>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['description_error']) ? $error['description_error'] : '' ?></p>

        <input type="date" id="date" name="date">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['date']) ? $error['date'] : '' ?></p>

        <input type="file" name="video_path" id="" class="form-control">
        <p class="text-danger" style="font-size:12px; color:red">
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
            <th>Video Path</th>
            <th>Description</th>
            <th>Uploaded Date</th>
            <th>Action</th>

        </tr>
        <?php
        delete_videos();
        $query = "SELECT *FROM videos ORDER BY date DESC";
        $select_video = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_video)) {
            $vid = $row['videoId'];
            $video_title = $row['vTitle'];
            $video_category = $row['vCategory'];
            $video_thumbnail = $row['vPath'];
            $video_description = $row['vDescription'];
            $uploaded_date = $row['date'];

        ?>
            <tr>
                <td><?php echo $video_title ?></td>
                <td><?php echo $video_category ?></td>
                <td><video src="admin_videos/<?php echo $video_thumbnail ?>" height="50" width="70"></td>
                <td><?php echo $video_description ?></td>
                <td><?php echo $uploaded_date ?></td>


                <td><a href="edit_video.php?edit=<?php echo $vid ?>" id="edit">Edit</a>
             <?php echo
                "<a id='delete' href='add_video.php?delete=$vid' onClick=\"javascript: return confirm('Are you sure you want to delete?'); \">
                Delete</a>
            ";
            
            }
                ?>
    </table>

</div>
<?php include "admin_footer.php" ?>