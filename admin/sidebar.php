<nav>
    <div class="logo-name">
        <div class="logo-image">
            <img src="../user/images/logo_color.png" height="20" width="40">
        </div>

        <a href="admin.php"><span class="logo_name">FunOlympics</span></a>
    </div>

    <div class="menu-items">
        <ul class="nav-links">
            <li>
                <a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a>
            </li>

            <li><a href="categories.php">
                    <i class='bx bxs-category'></i>
                    <span class="link-name">Sports Categories</span>
                </a>
            </li>
            <li>
                <a href="add_video.php">
                    <i class='bx bx-football'></i>
                    <span class="link-name">Videos</span>
                </a>
            </li>
            <!-- <li class="dropdown">
                <div class="" style="display: flex; justify-content:flex-start; align-items:center;  font-size:19px; color:white;">
                    <i class='bx bx-football' style="font-size: 20px; min-width: 25px;   height: 100%; margin-right: 15px; display: flex; align-items: center; justify-content: center; color: white;"></i>
                    <a href="add_video.php">Videos</a> 
                </div>
                <div class="dropdown-options" style="width: auto; color:white; display:flex; flex-direction:column; justify-content:center;">
                    <a href="">Add Videos</a>
                    <a href="">View Videos</a>
                </div>
            </li> -->
            <li><a href="news.php">
                    <i class='bx bxs-news'></i>
                    <span class="link-name">News</span>
                </a></li>
            <li><a href="../admin/admin_gallery.php">
                    <i class='bx bx-folder-open'></i>
                    <span class="link-name">Gallery</span>
                </a></li>
            <li><a href="fixtures.php">
                    <i class='bx bx-list-ul'></i>
                    <span class="link-name">Fixtures</span>
                </a></li>
            <li><a href="manage_users.php">
                    <i class="bx bx-heart icon"></i>
                    <span class="link-name">Manage Users</span>
                </a></li>
            <li><a href="password_reset.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Password Reset </span>
                </a></li>
            <li><a href="add_live_videos.php">
                    <i class='bx bx-upload'></i>
                    <span class="link-name">Live Games</span>
                </a></li>
        </ul>

        <ul class="logout-mode">
            <li><a href="../user/logout.php" onClick="javascript: return confirm('Do you want to logout?');">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

            <!-- <li class="mode">
            <a href="#">
                <i class="uil uil-moon"></i>
            <span class="link-name">Dark Mode</span>
        </a> -->

            <!-- <div class="mode-toggle">
          <span class="switch"></span>
        </div> -->
            </li>
        </ul>

        <a href="../user/loggeduser.php" style="display:flex; width:fit-content !important; border-radius:.25em; font-weight:bold; text-decoration:none;  padding:.35em; background:white; color:var(--primary--);">

            Visit Site</a>

    </div>
</nav>

<!-- <script>
   let dropdown = document.querySelector('.videos-dropdown');
   let options = document.querySelector('.dropdown-options');

   dropdown.addEventListener('mouseover', ()=>{
      options.classList.add('dropdown-options-active');     
   });

   

</script> -->