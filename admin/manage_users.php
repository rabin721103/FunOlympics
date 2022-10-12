<?php include 'admin_header.php'?>

<link rel="stylesheet" href="manage_users.css">
<div class="bottom-container">
    <h4 style="margin-top: 15px;">Users Table</h4>
    <table style="width:100%; ">
        <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Profile Image</th>
            <th>Phone Number</th>
            <th>Country</th>
            <th>Status</th>
            <th>Action</th>

        </tr>
        <?php
        changeStatusToInactive();
        changeStatusToAactive();
        if(empty($status)){
            $query = "SELECT * FROM users WHERE is_admin=0";  
        }
        else{
            $query = "SELECT * FROM users WHERE is_admin=0 AND status  = '$status'";
        }
        $query = "SELECT *FROM users ORDER BY date ASC";
        $select_users = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_users)) {
            $user_id = $row['userId'];
            $full_name = $row['fullName'];
            $email = $row['email'];
            $thumbnail = $row['profile_image'];
            $phone_number = $row['phone_number'];
            $country = $row['country'];
            $status = $row['status'];
        ?>
      
        <tr>
            <td><?php echo $full_name ?></td>
            <td><?php echo $email?></td>
            <td><img src="admin_images/<?php echo $thumbnail ?>" height="50" width="70"></td>
            <td><?php echo $phone_number?></td>
            <td><?php echo $country?></td>
            <td><?php echo $status?></td>
            
            <?php 
            if($status=='active'){
                        echo "<td><a href='manage_users.php?inactive=$user_id' id='block'>Block</a></td>";
                    }
                    else{
                        echo "<td><a href='manage_users.php?active=$user_id' id='unblock'>Unblock</a></td>";
                    }
            ?>           
    

        </tr>
        <?php }
        ?>
        
    </table>

</div>
<?php include 'admin_footer.php'?>