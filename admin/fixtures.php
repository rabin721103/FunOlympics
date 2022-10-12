<?php include "admin_header.php" ?>
<?php
$allowed_image_ext = array('jpg', 'jpeg', 'png', 'jfif');
if (isset($_POST['add_fixture'])) {
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
        if (add_fixture($fixtures, $fixture_date, time() . $image_path, $fixture_category)) {

            $fixture_upload_message = "Fixtures has been uploaded successfully";
            $fixture_upload_message_color = "green";
        } else {
            $fixture_upload_message = "Fixtures could not be uploaded";
            $fixture_upload_message_color = "red";
        }
    }
}
?>


<link rel="stylesheet" href="fixtures.css">
<h3>Add fixtures</h3>
<div class="top-container">
    <p style="text-align:center;color:<?php echo isset($fixture_upload_message_color) ? $fixture_upload_message_color : '' ?>"><?php echo isset($fixture_upload_message) ? $fixture_upload_message : '' ?></p>


    <form action="" method="POST" enctype="multipart/form-data">

        <input type="text" id="fixtures" name="fixtures" placeholder="Fixtures"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['fixture_error']) ? $fixture_error['fixture_error'] : '' ?></p>

        <input type="date" id="date" name="date" placeholder="Uploaded Date"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['date_error']) ? $fixture_error['date_error'] : '' ?></p>

        <input type="file" name="imagePath" id="" class="form-control"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($fixture_error['upload_error']) ? $fixture_error['upload_error'] : '' ?></p>
        <select name="fixture_category" id="fixture_category" class="form-control" style="border-radius: 5px;">
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
            <?php echo isset($fixture_error['category_error']) ? $fixture_error['category_error'] : '' ?></p>

        <!-- <input type="text" id="fixture_category" name="fixture_category" placeholder="Fixture Category"><br> -->
        <input type="submit" name="add_fixture" value="Add Fixure" style="margin-top: 15px;">
    </form>
</div>
<div class="bottom-container">
    <h4 style="margin-top: 15px;">Fixtures Table</h4>
    <table style="width:100%; ">
        <tr>
            <th>Fixture</th>
            <th>Category</th>
            <th>Thumbnail</th>
            <th>Fixture Date</th>
            <th>Action</th>

        </tr>
        <?php
        deleteFixtures();
        $query = "SELECT *FROM fixtures ORDER BY fixture_date ASC";
        $select_fixtures = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_fixtures)) {
            $fixture_id = $row['fixId'];
            $fixtures = $row['fixtures'];
            $fixture_category = $row['fixture_category'];
            $thumbnail = $row['image_path'];
            $fixture_date = $row['fixture_date'];

        ?>

            <tr>
                <td><?php echo $fixtures ?> </td>
                <td><?php echo $fixture_category ?></td>
                <td><img src="fixture_images/<?php echo $thumbnail ?>" height="50" width="70"></td>
                <td><?php echo $fixture_date ?></td>
                <td><span><a href="edit_fixture.php?edit=<?php echo $fixture_id ?>" id="edit">Edit</a>
                    <?php echo
                    "<a id='delete' href='fixtures.php?delete=$fixture_id' onClick=\"javascript: return confirm('Are you sure you want to delete?'); \">
                Delete</a>
                </td>


                

            </tr>";
                }
                    ?>
    </table>

</div>

<?php include "admin_footer.php" ?>