<?php include "admin_header.php" ?>
<?php
if(isset($_GET['reset'])){
    $email_address= $_GET['reset'];
    send_mail_after_password_reset($email_address);
}
?>
<link rel="stylesheet" href="news.css">
<h4 style="margin-top: 15px;">Password Reset Table</h4>
<div class="top-container">

    <table style="width:100%; ">
        <tr>
            <th>Requested By</th>
            <th>Requested Date</th>
            <th>Action</th>

        </tr>
        <?php
        $select_password_reset_request = mysqli_query($connection, "SELECT * FROM password_reset_request");
        while ($row = mysqli_fetch_assoc($select_password_reset_request)) {
            $prrid = $row['prrid'];
            $email = $row['email'];
            $requested_date = $row['requested_date'];
        ?>
            <tr>
                <td><?php echo $email ?></td>
                <td><?php echo $requested_date?></td>
                <td>
                <?php echo
                "<a id='delete' href='password_reset.php?reset=$email' onClick=\"javascript: return confirm('Are you sure you want to reset?'); \">
                Reset</a>
                    
                </td>
                

            </tr>";
            
         }
        ?>

    </table>
</div>


<?php include "admin_footer.php" ?>