<?php include 'admin_header.php' ?>
<?php
if (isset($_GET['edit'])) {
    $newsId = $_GET['edit'];
}
$allowed = array('jpg', 'jpeg', 'png');
//update news
if (isset($_POST['edit_news'])) {
    $news_title = $_POST['news_title'];
    $news_description = $_POST['news_description'];
    $news_thumbnail = escape($_FILES['imagePath']['name']);
    $news_thumbnail_temp   = escape($_FILES['imagePath']['tmp_name']);
    $image_ext = pathinfo($news_thumbnail, PATHINFO_EXTENSION);
    $news_category = $_POST['news_category'];
    $news_date = $_POST['date'];

    $news_error = [
        'title_error' => '',
        'description_error' => '',
        'thumbnail_error' => '',
        'date_error' => '',
    ];

    if (empty($news_title)) {
        $news_error['title_error'] = 'Title cannot be empty.';
    }
    if (empty($news_date)) {
        $news_error['date_error'] = 'Please select date.';
    }
    if (empty($news_description)) {
        $news_error['description_error'] = 'Description cannot be empty.';
    }
    if (empty($news_thumbnail)) {
        $news_error['thumbnail_error'] = 'Please select Image';
    }

    foreach ($news_error as $key => $value) {
        if (empty($value)) {
            unset($news_error[$key]);
        }
    }
    if (empty($news_error)) {

        if (edit_news($newsId, $news_title, $news_description, time() . $news_thumbnail, $news_category)) {
            copy($news_thumbnail_temp, "../admin/admin_images/" . time() . $news_thumbnail);

            $news_update_message = "News has been updated successfully";
            $news_update_message_color = "text-success";
        } else {
            $news_update_message = "News could not be updated";
            $news_update_message_color = "text-danger";
        }
    }
}


//fetch data from database
$query = "SELECT * FROM news WHERE newsId = $newsId";
$select_query = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_query)) {

    $db_news_title = $row['nTitle'];
    $db_news_description = $row['nDescription'];
    $db_news_thumbnail = $row['imagePath'];
    $db_news_category = $row['nCategory'];
    $db_news_date = $row['date'];
}
?>


<link rel="stylesheet" href="news.css">
<h3>Edit News</h3>
<div class="top-container">


    <form action="" method="POST" enctype="multipart/form-data">

        <input type="text" id="category" name="news_category" placeholder="News Category" value="<?php echo $db_news_category ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['category_error']) ? $news_error['category_error'] : '' ?></p>
        <input type="text" id="title" name="news_title" placeholder="Title" value="<?php echo $db_news_title ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['title_error']) ? $news_error['title_error'] : '' ?></p>

        <textarea name="news_description" id="description" cols="30" rows="5" placeholder="Description"><?php echo $db_news_description ?></textarea><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['description_error']) ? $news_error['description_error'] : '' ?></p>

        <input type="date" id="date" name="date" placeholder="Uploaded Date" value="<?php echo $db_news_date ?>"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['date_error']) ? $news_error['date_error'] : '' ?></p>
        <input type="file" name="imagePath" id="" class="form-control"><br>
        <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($news_error['upload_error']) ? $news_error['upload_error'] : '' ?></p>
        <input type="submit" name="edit_news" value="Update News">

    </form>
</div>