<!-- websiteinfo start  -->
<?php include("includes/websiteinfo.php") ?>
<!-- websiteinfo end  -->

<header>
    <nav class="navbar navbar-expand-lg bg-dark navigation-header">
        <div class="container-fluid">
            <a class="navbar-brand text-warning desktop-logo"
                href="index"><?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;}?></a>
            <a class="navbar-brand text-warning mobile-logo" href="index">
                <img width="50" height="50"
                    src="<?php if($website_logo==""){ echo "../images/default/logo.png";} else{ echo "../images/logo/".$website_logo;}?>"
                    alt="<?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;}?>"
                    loading="lazy" class="border border-warning rounded-circle">
            </a>
            <button class="navbar-toggler bg-light text-light" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
                        $email = $_SESSION['admin_email'];
                        $id = $_SESSION['admin_id'];
                        $token = $_SESSION['admin_token'];
                        $admin_exist = "SELECT `name` FROM `admin_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
                        $result = mysqli_query($con, $admin_exist); 
                        $admin_fetch = mysqli_fetch_assoc($result);                        
                    ?>
                    <li class="nav-item">
                        <a class="nav-link text-light" aria-current="page" href="dashboard">Welcome&nbsp;<span
                                class=text-warning><?php echo $admin_fetch['name'];?></span></a>
                    </li>
                    <li class="nav-item dropdown bg-dark">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Order Info
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-light bg-dark" href="pendingorders">Pending Orders</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="deliveredorders">Delivered Orders</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="canceledorders">Canceled Orders</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="orders">Orders Info</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown bg-dark">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Food Item
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-light bg-dark" href="fooditems">Food Items</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="fooditemadd">Item Add</a></li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" aria-current="page" href="userinformation">User Info</a>
                    </li>
                    <li class="nav-item dropdown bg-dark">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Site Configuration
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-light bg-dark" href="webheader">Header</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="webfooter">Footer</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="webseo">Seo</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="webmaintainance">Maintainance Mood</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown bg-dark">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Profile
                        </a>
                        <ul class="dropdown-menu bg-dark">
                            <li><a class="dropdown-item text-light bg-dark" href="account">Account</a></li>
                            <li><a class="dropdown-item text-light bg-dark" href="changepassword">Change Password</a>
                            </li>
                            <li><a class="dropdown-item text-light bg-dark" href="logout">Logout</a></li>
                        </ul>
                    </li>
                    <?php
                    } 
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
//  navbar on scroll fixed 
const navigationBar = document.querySelector(".navigation-header");
// windows scroll function 
window.onscroll = () => {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        navigationBar.style.position = "fixed";
    } else {
        navigationBar.style.position = "relative";
    }
};
</script>