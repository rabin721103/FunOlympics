
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <title> Responsive Drop Down Navigation Menu | CodingLab </title>-->
    <link rel="stylesheet" href="unloggedLandingPage.css">
    <!-- Boxicons CDN Link -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <!-- Contact Page CSS CDN link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <nav>
        <div class="navbar">
            <div class="logo"><a href="../user/unloggedLandingPage.php"><img src="../user/images/logo_color.png" height="60" width="120"></a></div>
            <div class="nav-links">
                <ul class="links">
                    <li><a href="unloggedLandingPage.php">HOME</a></li>
                    <!-- <li>
                        <a href="#">SPORTS</a>
                        <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
                        <ul class="htmlCss-sub-menu sub-menu">
                            <li><a href="#">Football</a></li>
                            <li><a href="#">Cricket</a></li>
                            <li><a href="#">Rugby</a></li>
                            <li class="more">
                                <span><a href="#">More</a>
                                    <i class='bx bxs-chevron-right arrow more-arrow'></i>
                                </span>
                                <ul class="more-sub-menu sub-menu">
                                    <li><a href="#">Table Tennis</a></li>
                                    <li><a href="#">Batminton</a></li>
                                    <li><a href="#">Chess</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <li><a href="login.php" onClick="javascript: return confirm('Oops!! You need to Login/Register to FunOlympics First');">ALL VIDEOS</a></li>
                    <li>
                    <a href="login.php" onClick="javascript: return confirm('Oops!!  You need to Login/Register to FunOlympics First');">NEWS</a>
                        <!-- <i class='bx bxs-chevron-down js-arrow arrow '></i>
                        <ul class="js-sub-menu sub-menu">
                            <li><a href="#">Latest</a></li>
                            <li><a href="#">Old News</a></li>
                            <li><a href="#">Blogs</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul> -->
                    </li>
                    
                    <li><a href="fixture.php">FIXTURES</a></li>
                    <li><a href="gallery2.php">GALLERY</a></li>
                    <li><a href="contact2.php">CONTACT</a></li>

                    <li><a href="login.php" onClick="javascript: return confirm('Oops!! You must login or register to watch and enjoy live games...');">LIVE GAMES</a></li>
        
                    <!-- <li><a href="../admin/admin.php">ADMIN PANEL</a></li> -->
                    
                </ul>
            </div>
            <div class="search-box">
                <i class='bx bx-search'></i>
                <div class="input-box">
                    <input type="text" placeholder="Search...">
                </div>
            </div>
        </div>
    </nav>

</body>

</html>