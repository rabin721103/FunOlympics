
<?php include "admin_header.php" ?>
<?php
if (isset($_POST['add_sports_category'])) {
    
    $sports_category = escape($_POST['category']);

    $category_error = [
        'category_error' => '',
        
    ];


    if (empty($sports_category)) {
        $category_error['category_error'] = 'Field cannot be empty.';
    }

    foreach ($category_error as $key => $value) {
        if (empty($value)) {
            unset($category_error[$key]);
        }
    }
    if (empty($category_error)) {
        
        if (add_sports_categories($sports_category)) {

            $category_upload_message = "Category has been added";
            $category_upload_message_color = "green";
        } else {
            $category_upload_message = "Category could not be added";
            $category_upload_message_color = "red";
        }
    }
}
?>

<link rel="stylesheet" href="categories.css">


<div class="container">
    <div class="bottom-container">
        <h3>Add Category</h3>
        <p style="color:<?php echo isset($category_upload_message_color) ? $category_upload_message_color : ''?>">
                <?php echo isset($category_upload_message) ? $category_upload_message : ''?></p>
        <form action="" method="POST" >
            <label for="category">Category</label>
            <input type="text" id="category" name="category">
            <p class="text-danger" style="font-size:12px; color:red">
            <?php echo isset($category_error['category_error']) ? $category_error['category_error'] : '' ?></p>
            <input type="submit" name="add_sports_category" value="Add Category">

        </form>
    </div>
    <h3>All Categories</h3>
    <div class="top-container">
        <?php
        deleteCategories();
        $query = "SELECT * FROM categories";
        $select_categories = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($select_categories)) {
            $category_id = $row['categoryId'];
            $category_title     = $row['title'];  
        echo "<div class='card'>
            <a href='categories.php?delete=$category_id' onClick=\"javascript: return confirm('Are you sure you want to delete? All videos related to this category will also be deleted.'); \">
            <i class='fa-solid fa-x'></i></a>
            <p>$category_title</p>
        </div>";
        }
        ?>

    </div>
</div>

<?php include "admin_footer.php" ?>