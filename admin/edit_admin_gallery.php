<?php include 'admin_header.php' ?>
<?php
if (isset($_GET['edit'])) {
    $pid = $_GET['edit'];
}

$allowed = array('jpg', 'jpeg', 'png');
if (isset($_POST['edit_image'])) {
    $img_title = escape($_POST['img_title']);
    $img_category = escape($_POST['img_category']);

    $img_path        = escape($_FILES['img_path']['name']);
    $img_path_temp   = escape($_FILES['img_path']['tmp_name']);

    $ext = pathinfo($img_path, PATHINFO_EXTENSION);
    $upload_date = escape($_POST['upload_date']);
    $error = [
        'upload_error' => '',
        'caption_error' => '',
        'category_error' => '',
    ];
    if ($img_path == "") {
        $error['upload_error'] = 'Please select image.';
    }
    if ($img_category == "") {
        $error['category_error'] = 'Please select category.';
    }
    if ($img_title == "") {
        $error['caption_error'] = 'Title cannot be empty.';
    }
    if (!($img_path == "") && !in_array($ext, $allowed)) {
        $error['upload_error'] = 'Invalid image format. Available format(jpeg, jpg, png)';
    }
    foreach ($error as $key => $value) {
        if (empty($value)) {
            unset($error[$key]);
        }
    }
    if (empty($error)) {

        if (editImage($pid, $img_title, $img_category, time() . $img_path, $upload_date)) {
            copy($img_path_temp, "image_gallery/" . time() . $img_path);
            $upload_message = "Successfully Updated the Image Table";
            $message_color = "green";
        } else {
            $upload_message = "Could Not Update Image Table. Please try again";
            $message_color = "red";
        }
    }
}

$query = "SELECT * FROM admin_gallery WHERE imgId = $pid";
$select_photo = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_photo)) {
    $db_image_title = $row['img_Title'];
    $db_category = $row['img_Category'];
    $db_image_path = $row['img_Path'];
    $db_upload_date = $row['upload_Date'];
}
?>


<link rel="stylesheet" href="news.css">
<h3>Edit Images From The Gallery</h3>
<div class="top-container">
    <p style="color:<?php echo isset($message_color) ? $message_color : '' ?>">
        <?php echo isset($upload_message) ? $upload_message : '' ?></p>


    <form action="" method="POST" enctype="multipart/form-data">

        <input type="text" id="category" name="img_category" placeholder="Image Category" value="<?php echo $db_category ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['category_error']) ? $error['category_error'] : '' ?></p>
        <input type="text" id="title" name="img_title" placeholder="Image Title" value="<?php echo $db_image_title ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['title_error']) ? $error['title_error'] : '' ?></p>

        <input type="date" id="date" name="upload_date" placeholder="Uploaded Date" value="<?php echo $db_upload_date ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['date_error']) ? $error['date_error'] : '' ?></p>
        <input type="file" name="img_path" id="" class="form-control"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($error['upload_error']) ? $error['upload_error'] : '' ?></p>
        <input type="submit" name="edit_image" value="Update Gallery">

    </form>
</div>

<?php include "admin_footer.php" ?>