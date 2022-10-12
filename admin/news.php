<?php include "admin_header.php" ?>
<?php
$allowed_image_ext = array('jpg', 'jpeg', 'png', 'jfif');
if (isset($_POST['add_news'])) {
    $date = escape($_POST['date']);
    $news_category = escape($_POST['news_category']);
    $news_description = escape($_POST['news_description']);
    $news_title = escape($_POST['news_title']);

    $image_path = escape($_FILES['imagePath']['name']);
    $image_path_temp   = escape($_FILES['imagePath']['tmp_name']);
    $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);

    $news_error = [
        'upload_error' => '',
        'title_error' => '',
        'description_error' => '',
        'category_error' => '',
        'date_error' => '',
    ];

    if (empty($news_title)) {
        $news_error['title_error'] = 'Title cannot be empty.';
    }
    if (empty($news_description)) {
        $news_error['description_error'] = 'Description cannot be empty.';
    }
    if (empty($news_category)) {
        $news_error['category_error'] = 'Select at least one category.';
    }
    if (empty($date)) {
        $news_error['date_error'] = 'Please enter upload date.';
    }
    if (empty($image_path)) {
        $news_error['upload_error'] = 'Please select image.';
    }

    if (!($image_path == "") && !in_array($image_ext, $allowed_image_ext)) {
        $news_error['upload_error'] = 'Invalid image format. Available format(jpg, jpeg, png)';
    }
    foreach ($news_error as $key => $value) {
        if (empty($value)) {
            unset($news_error[$key]);
        }
    }
    if (empty($news_error)) {
        copy($image_path_temp, "../admin/admin_images/" . time() . $image_path);
        if (add_news($date, $news_category, $news_description, $news_title, time() . $image_path)) {

            $news_upload_message = "News has been uploaded successfully";
            $news_upload_message_color = "text-success";
        } else {
            $news_upload_message = "News could not be uploaded";
            $news_upload_message_color = "text-danger";
        }
    }
}
?>
<link rel="stylesheet" href="news.css">
<h3>Add News</h3>
<div class="top-container">
    <p style="text-align:center;color:<?php echo isset($news_upload_message_color) ? $news_upload_message_color : '' ?>"><?php echo isset($news_upload_message) ? $news_upload_message : '' ?></p>


    <form action="" method="POST" enctype="multipart/form-data">

        <select name="news_category" id="" class="form-control">
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
            <?php echo isset($news_error['category_error']) ? $news_error['category_error'] : '' ?></p>
        <input type="text" id="title" name="news_title" placeholder="Title" style="margin-bottom: 15px; font-weight:500;">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['title_error']) ? $news_error['title_error'] : '' ?></p>

        <textarea name="news_description" id="description" cols="30" rows="5" placeholder="Description" style="margin-bottom: 15px; font-weight:500;"></textarea>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['description_error']) ? $news_error['description_error'] : '' ?></p>

        <input type="date" id="date" name="date" placeholder="Uploaded Date" style="margin-bottom: 15px; font-weight:500;">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['date_error']) ? $news_error['date_error'] : '' ?></p>
        <input type="file" name="imagePath" id="" class="form-control">
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['upload_error']) ? $news_error['upload_error'] : '' ?></p>
        <input type="submit" name="add_news" value="Add News">

    </form>
</div>
<div class="bottom-container">
    <h4 style="margin-top: 15px;">News Table</h4>
    <table style="width:100%; ">
        <tr>
            <th>News Title</th>
            <th>Category</th>
            <th>Thumbnail</th>
            <th>Description</th>
            <th>Uploaded Date</th>
            <th>Action</th>

        </tr>
        <?php
        deleteNews();
        $query = "SELECT *FROM news ORDER BY date DESC";
        $select_news = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_news)) {
            $newsId = $row['newsId'];
            $news_title = $row['nTitle'];
            $category = $row['nCategory'];
            $thumbnail = $row['imagePath'];
            $description = $row['nDescription'];
            $upload_date = $row['date'];
        ?>
            <tr>
                <td><?php echo $news_title ?></td>
                <td><?php echo $category ?></td>
                <td><img src="admin_images/<?php echo $thumbnail ?>" height="80" width="140"></td>
                <td><?php echo $description ?></td>
                <td><?php echo $upload_date ?></td>

                <td><a href='edit_news.php?edit=<?php echo $newsId ?>' id='edit'>Edit</a>
                <?php echo
                "<a id='delete' href='news.php?delete=$newsId' onClick=\"javascript: return confirm('Are you sure you want to delete?'); \">
                Delete</a>
                    
                </td>
                

            </tr>";
            }
                ?>

    </table>
    <img src="admin_images/1663824182skating.jpg" alt="">
</div>

<?php include "admin_footer.php" ?>