<?php include 'admin_header.php' ?>
<?php
if (isset($_GET['edit'])) {
    $fixture_Id = $_GET['edit'];
}
// $uploaded_date = date('d-m-Y');
//     $uploaded_time = date("h:i:sa");
$allowed = array('jpg', 'jpeg', 'png');
$allowed_image_ext = array('jpg', 'jpeg', 'png', 'jfif');
//update news
if (isset($_POST['edit_fixture'])) {
    $fixtures = escape($_POST['fixtures']);
    $fixture_date = escape($_POST['date']);
    $fixture_category = escape($_POST['fixture_category']);
    $image_path = escape($_FILES['imagePath']['name']);
    $image_path_temp   = escape($_FILES['imagePath']['tmp_name']);
    $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

    $fixture_error = [
        'upload_error' => '',
        'fixture_error' => '',
        'category_error' => '',
        'date_error' => '',
    ];

    if (empty($fixtures)) {
        $fixture_error['fixture_error'] = 'Fixtures must be entered.';
    }
    if (empty($fixture_category)) {
        $fixture_error['category_error'] = 'Select at least one category.';
    }
    if (empty($fixture_date)) {
        $fixture_error['date_error'] = 'Please enter upload date.';
    }
    if (empty($image_path)) {
        $fixture_error['upload_error'] = 'Please select image.';
    }

    if (!($image_path == "") && !in_array($image_ext, $allowed_image_ext)) {
        $fixture_error['upload_error'] = 'Invalid image format. Available format(jpg, jpeg, png)';
    }
    foreach ($fixture_error as $key => $value) {
        if (empty($value)) {
            unset($fixture_error[$key]);
        }
    }
    if (empty($fixture_error)) {
        copy($image_path_temp, "../admin/fixture_images/" . time() . $image_path);
        if (edit_fixture($fixture_Id, $fixtures, $fixture_date, time(). $image_path, $fixture_category)) {

            $fixture_upload_message = "Fixtures has been updated successfully";
            $fixture_upload_message_color = "green";
        } else {
            $fixture_upload_message = "Fixtures could not be updated";
            $fixture_upload_message_color = "red";
        }
    }
}
//fetch data from database
$query = "SELECT * FROM fixtures WHERE fixId = $fixture_Id";
$select_query = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_query)) {

    $db_fixture = $row['fixtures'];
    $db_fixture_category = $row['fixture_category'];
    $db_fixture_thumbnail = $row['image_path'];
    $db_fixture_date = $row['fixture_date'];
}
?>

<link rel="stylesheet" href="fixtures.css">
<h3>Edit Fixtures</h3>
<div class="top-container">
    <p style="color:<?php echo isset($fixture_upload_message_color) ? $fixture_upload_message_color : '' ?>">
        <?php echo isset($fixture_upload_message) ? $fixture_upload_message : '' ?></p>


    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" id="title" name="fixtures" placeholder="Fixtures" value="<?php echo $db_fixture ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['fixture_error']) ? $fixture_error['fixture_error'] : '' ?></p>

        <input type="text" id="category" name="fixture_category" placeholder="Category" value="<?php echo $db_fixture_category ?>"><br>

        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['category_error']) ? $fixture_error['category_error'] : '' ?></p>
        <input type="file" name="imagePath" id="" class="form-control"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['upload_error']) ? $fixture_error['upload_error'] : '' ?></p>
        <input type="date" id="date" name="date" placeholder="Fixture Date" value="<?php echo $db_fixture_date ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['date_error']) ? $fixture_error['date_error'] : '' ?></p>

        <input type="submit" name="edit_fixture" value="Update Fixture">

    </form>
</div>