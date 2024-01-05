<!-- websiteinfo start  -->
<?php include("includes/websiteinfo.php") ?>
<!-- websiteinfo end  -->

<!-- server maintainance start  -->
<?php
if ($website_maintainance=="on") {
    header("Location: maintainance");
}
?>
<!-- server maintainance end  -->

<header>
    <nav class="navbar navbar-expand-lg bg-dark navigation-header">
        <div class="container-fluid">
            <a class="navbar-brand text-warning desktop-logo"
                href="index"><?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;}?></a>
            <a class="navbar-brand text-warning mobile-logo" href="index">
                <img width="50" height="50"
                    src="<?php if($website_logo==""){ echo "images/default/logo.png";} else{ echo "images/logo/".$website_logo;}?>"
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
                    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                        $email = $_SESSION['user_email'];
                        $id = $_SESSION['user_id'];
                        $token = $_SESSION['user_token'];
                        $user_exist = "SELECT `name` FROM `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
                        $result = mysqli_query($con, $user_exist); 
                        $user_fetch = mysqli_fetch_assoc($result);                        
                    ?>
                    <li class="nav-item">
                        <a class="nav-link text-light" aria-current="page" href="index">Welcome&nbsp;<span
                                class=text-warning><?php echo $user_fetch['name'];?></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="account">My Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="cart">Cart
                            <span class="text-warning">
                                <?php                    
                            if(!empty($_SESSION["shopping_cart"])){
                                $count = count(array_keys($_SESSION["shopping_cart"]));
                                echo '('; echo $count; echo ')';
                            }
                            ?>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="logout">Logout</a>
                    </li>
                    <?php
                    } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link text-light" aria-current="page" href="index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="login">Login</a>
                    </li>
                    <?php
                    }
                    ?>
                </ul>
                <div class="d-flex flex-column">
                    <div class="d-flex">
                        <input type="text" id="search" class="form-control" placeholder="Search food items"
                            autocomplete="off">
                    </div>
                </div>
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