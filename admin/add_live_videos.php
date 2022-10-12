<?php include "admin_header.php" ?>
<?php


// $upload_date = date('d-m-Y');
// $upload_time = date("h:i:sa");
// $allowed = array('mp4', 'mov', 'avi');

if (isset($_POST['upload_live_video'])) {
    $title = escape($_POST['title']);
    $category = escape($_POST['category']);
    $description = escape($_POST['description']);
    // $tags = escape($_POST['tags']);
    $date = escape($_POST['date']);
    $video_url        = escape($_POST['video_url']);
    // $video_path_temp   = escape($_FILES['video_path']['tmp_name']);
    // $ext = pathinfo($video_path, PATHINFO_EXTENSION);
    $error = [
        'upload_error' => '',
        'title_error' => '',
        'tag_error' => '',
        'description_error' => '',
    ];
    if ($video_url == "") {
        $error['upload_error'] = 'Enter Video URL';
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
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {
        
        if (upload_live_video($title, $category, $description, $video_url.'?autoplay=1&mute=1', $date)) {
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

<h3>Upload Live Games</h3>
<p style="text-align:center;color:<?php echo isset($message_color) ? $message_color : '' ?>"><?php echo isset($upload_message) ? $upload_message : '' ?></p>
<div class="top-container">

    <form action="" method="POST" enctype="multipart/form-data">

        <input type="text" id="title" name="title" placeholder="Video Title">
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

        <input type="text" name="video_url" id="" class="form-control" placeholder="Live Video URL">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['upload_error']) ? $error['upload_error'] : '' ?>
        </p>

        <input type="submit" name="upload_live_video" value="Upload Live Game">
    </form>




</div>
<div class="bottom-container">
    <div class="header">
        <h4 style="margin-top: 15px;">Uploaded Live Games Table</h4>
        <a href="../user/livegames.php" class="navigate-button">View in Page</a>
    </div>

    <table style="width:100%; ">
        <tr>
            <th>Video Title</th>
            <th>Category</th>
            <th>Video Thumbnail</th>
            <th>Description</th>
            <th>Uploaded Date</th>
            <th>Action</th>

        </tr>
        <?php
        delete_live_videos();
        $query = "SELECT *FROM livevideo ORDER BY date DESC";
        $select_video = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_video)) {
            $vid = $row['liveVideoId'];
            $video_title = $row['vTitle'];
            $video_url = $row['url'];
            $video_category = $row['vCategory'];
            $video_description = $row['vDescription'];
            $uploaded_date = $row['date'];

        ?>
            <tr>
                <td><?php echo $video_title ?></td>
                <td><?php echo $video_category ?></td>
                <td><iframe src="<?php echo $video_url?>" title="<?php echo $video_title?>"></iframe></td>
                <td><?php echo $video_description ?></td>
                <td><?php echo $uploaded_date ?></td>


                <td><a href="edit_live_videos.php?edit=<?php echo $vid ?>" id="edit">Edit</a>
                <?php echo
                "<a id='delete' href='add_live_videos.php?delete=$vid' onClick=\"javascript: return confirm('Are you sure you want to delete?'); \">
                Delete</a>
            ";
            }
                ?>
    </table>

</div>
<?php include "admin_footer.php" ?>