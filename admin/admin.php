<?php include 'functions.php' ?>
<?php
if(empty($_SESSION['logged_in']) || $_SESSION['logged_in'] == ''){
    redirect('login.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="admin.css">

    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42dc1d1233.js" crossorigin="anonymous"></script>

    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <!--<title>Admin Dashboard Panel</title>-->
</head>

<body>
    <?php include "sidebar.php" ?>
    <section class="dashboard">
        <!-- <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>
            
            <img src="images/profile.png" alt="">
        </div> -->

        <div class="dash-content">
            <div class="overview">
                <h3 style="color: blue; text-align:center;">Welcome to Admin Dashboard!!</h3>
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text" style="font-size: 18px;">Dashboard</span>
                </div>

                <div class="boxes">

                    <div class="box box1">

                        <i class='bx bxs-videos'></i>
                        <a href="add_video.php">
                            <span class="text">Total Videos</span>
                        </a>
                        <span class="number"><?php echo recordCount('videos') ?></span>

                    </div>

                    <div class="box box2">
                        <!-- <i class="uil uil-comments"></i> -->
                        <i class='bx bx-comment' ></i>
                        <span class="text">Comments</span>
                        <span class="number"><?php echo recordCount('comment') ?></span>
                    </div>
                    <div class="box box3">
                        <!-- <i class="uil uil-share"></i> -->
                        <i class='bx bx-user-circle'></i>
                        <span class="text">Number of User</span>
                        <span class="number"><?php echo recordCount('users') ?></span>
                    </div>
                    <div class="box box4" style="margin-top: 20px;">
                        <!-- <i class="uil uil-share"></i> -->
                        <i class='bx bx-photo-album' ></i>
                        <span class="text">Photos</span>
                        <span class="number"><?php echo recordCount('admin_gallery') ?></span>
                    </div>
                    <div class="box box5" style="margin-top: 20px;">
                        <!-- <i class="uil uil-share"></i> -->
                        <i class='bx bxs-circle'></i>
                        <span class="text">Live Videos</span>
                        <span class="number"><?php echo recordCount('livevideo') ?></span>
                    </div>
                    <div class="box box6" style="margin-top: 20px;">
                        <!-- <i class="uil uil-share"></i> -->
                        <i class='bx bxs-bell-ring'></i>
                        <span class="text">Reset Requests</span>
                        <span class="number"><?php echo recordCount('password_reset_request') ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="Admin.js">
        const body = document.querySelector("body"),
            modeToggle = body.querySelector(".mode-toggle");
        sidebar = body.querySelector("nav");
        sidebarToggle = body.querySelector(".sidebar-toggle");

        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark") {
            body.classList.toggle("dark");
        }

        let getStatus = localStorage.getItem("status");
        if (getStatus && getStatus === "close") {
            sidebar.classList.toggle("close");
        }

        modeToggle.addEventListener("click", () => {
            body.classList.toggle("dark");
            if (body.classList.contains("dark")) {
                localStorage.setItem("mode", "dark");
            } else {
                localStorage.setItem("mode", "light");
            }
        });

        sidebarToggle.addEventListener("click", () => {
            sidebar.classList.toggle("close");
            if (sidebar.classList.contains("close")) {
                localStorage.setItem("status", "close");
            } else {
                localStorage.setItem("status", "open");
            }
        })
    </script>
</body>

</html>