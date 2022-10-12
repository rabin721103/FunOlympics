<?php include "admin_header.php" ?>
<?php
$allowed_image_ext = array('jpg', 'jpeg', 'png');
if (isset($_POST['add_image'])) {
    $img_title = escape($_POST['img_title']);
    $img_category = escape($_POST['img_category']);

    $image_path = escape($_FILES['img_path']['name']);
    $image_path_temp   = escape($_FILES['img_path']['tmp_name']);
    $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

    $upload_date = escape($_POST['uploaded_date']);

    $image_error = [
        'upload_error' => '',
        'title_error' => '',
        'category_error' => '',
        'date_error' => '',
    ];

    if (empty($img_title)) {
        $image_error['title_error'] = 'Title cannot be empty.';
    }
    if (empty($img_category)) {
        $image_error['category_error'] = 'Select at least one category.';
    }
    if (empty($upload_date)) {
        $image_error['date_error'] = 'Please enter upload date.';
    }
    if (empty($image_path)) {
        $image_error['upload_error'] = 'Please select image.';
    }

    if (!($image_path == "") && !in_array($image_ext, $allowed_image_ext)) {
        $image_error['upload_error'] = 'Invalid image format. Available format(jpg, jpeg, png)';
    }
    foreach ($image_error as $key => $value) {
        if (empty($value)) {
            unset($image_error[$key]);
        }
    }
    if (empty($image_error)) {
        copy($image_path_temp, "image_gallery/" . time() . $image_path);
        if (add_image($img_title, $img_category, time() . $image_path, $upload_date)) {

            $image_upload_message = "Image has been uploaded successfully";
            $image_upload_message_color = "text-success";
        } else {
            $image_upload_message = "Image could not be uploaded";
            $image_upload_message_color = "text-danger";
        }
    }
}
?>
<link rel="stylesheet" href="news.css">
<h3>Add Images To The Gallery</h3>
<div class="top-container">


    <form action="" method="POST" enctype="multipart/form-data">
        <select name="img_category" id="" class="form-control">
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
            <?php echo isset($image_error['category_error']) ? $image_error['category_error'] : '' ?></p>

        
        <input type="text" id="title" name="img_title" placeholder="Image Title"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($image_error['title_error']) ? $image_error['title_error'] : '' ?></p>

        <input type="date" id="date" name="uploaded_date" placeholder="Uploaded Date"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($image_error['date_error']) ? $image_error['date_error'] : '' ?></p>
        <input type="file" name="img_path" id="" class="form-control"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($image_error['upload_error']) ? $image_error['upload_error'] : '' ?></p>
        <input type="submit" name="add_image" value="Add Image to Gallery">

    </form>
</div>
<div class="bottom-container">
    <div class="header">
        <h4 style="margin-top: 15px;">Gallery Table View</h4>
        <a href="../user/gallery.php" class="navigate-button">View Gallery Page</a>

    </div>

    <table style="width:100%; ">
        <tr>
            <th>Image Title</th>
            <th>Category</th>
            <th>Thumbnail</th>
            <th>Upload Date</th>
            <th>Action</th>

        </tr>
        <?php
        deletePhotos();
        $query = "SELECT *FROM admin_gallery ORDER BY upload_Date DESC";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_image)) {
            $image_id = $row['imgId'];
            $title = $row['img_Title'];
            $category = $row['img_Category'];
            $thumbnail = $row['img_Path'];
            $upload_date = $row['upload_Date'];
        ?>
            <tr>
                <td><?php echo $title ?></td>
                <td><?php echo $category ?></td>
                <td><img src="image_gallery/<?php echo $thumbnail ?>" height="100" width="200"></td>
                <td><?php echo $upload_date ?></td>

                <td> <span><a href='edit_admin_gallery.php?edit=<?php echo $image_id ?>' id='edit'>Edit</a>
                    <?php echo
                    "<a id='delete' href='admin_gallery.php?delete=$image_id' onClick=\"javascript: return confirm('Are you sure you want to delete?'); \">
                Delete</a>
                </td>

            

            </tr>";
                }
                    ?>
                    <?php

                    ?>

    </table>

</div>

<?php include "admin_footer.php" ?>