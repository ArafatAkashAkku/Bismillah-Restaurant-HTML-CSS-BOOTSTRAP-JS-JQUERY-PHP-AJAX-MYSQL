<!-- websiteinfo start  -->
<?php include("includes/websiteinfo.php") ?>
<!-- websiteinfo end  -->

<footer class="pt-3 px-2 bg-dark">
    <div class="row">
        <div class="col-12 col-md-3 mb-3">
            <a class="navbar-brand text-warning mobile-logo"
                href="index"><?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;}?></a>
            <a class="navbar-brand text-warning desktop-logo" href="index">
                <img width="90" height="90"
                    src="<?php if($website_logo==""){ echo "images/default/logo.png";} else{ echo "images/logo/".$website_logo;}?>"
                    alt="<?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;}?>"
                    loading="lazy" class="border border-warning rounded-circle">
            </a>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a
                        href="<?php if($website_email==""){ echo "index";} else{ echo "mailto:".$website_email;}?>"
                        class="nav-link p-0 text-light">
                        <?php
                    if($website_email==""){
                       echo "Website Email";
                    }else{
                        echo $website_email;
                    }
                    ?>
                    </a></li>
                <li class="nav-item mb-2"><a
                        href="<?php if($website_phone==""){ echo "index";} else{ echo "tel:".$website_phone;}?>"
                        class="nav-link p-0 text-light">
                        Phone No.
                        <?php
                        if($website_phone==""){
                           echo "Website Phone";
                        }else{
                            echo $website_phone;
                        }
                        ?>
                    </a></li>
            </ul>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <h5 class="text-light">Navbar</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a href="index" class="nav-link p-0 text-light">Home</a></li>
                <li class="nav-item mb-2"><a href="about" class="nav-link p-0 text-light">About</a></li>
                <?php
                    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                    ?>
                <li class="nav-item mb-2"><a href="account" class="nav-link p-0 text-light">Account</a></li>
                <li class="nav-item mb-2"><a href="cart" class="nav-link p-0 text-light">Cart</a></li>
                <?php
                    } else {
                    ?>
                <li class="nav-item mb-2"><a href="login" class="nav-link p-0 text-light">Account</a></li>
                <li class="nav-item mb-2"><a href="login" class="nav-link p-0 text-light">Cart</a></li>
                <?php
                    }
                    ?>
            </ul>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <h5 class="text-light">Account</h5>
            <ul class="nav flex-column">
                <?php
                    if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                    ?>
                <li class="nav-item mb-2"><a href="account" class="nav-link p-0 text-light">Account</a></li>
                <li class="nav-item mb-2"><a href="logout" class="nav-link p-0 text-light">Logout</a>
                </li>
                <?php
                    } else {
                    ?>
                <li class="nav-item mb-2"><a href="login" class="nav-link p-0 text-light">Account</a></li>
                <li class="nav-item mb-2"><a href="login" class="nav-link p-0 text-light">Login</a></li>
                <li class="nav-item mb-2"><a href="signup" class="nav-link p-0 text-light">Signup</a></li>
                <li class="nav-item mb-2"><a href="forgetpass" class="nav-link p-0 text-light">Forget</a></li>
                <?php
                    }
                    ?>
            </ul>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <h5 class="text-light">Payment Method</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2"><a class="nav-link p-0 text-light">Bkash</a>
                </li>
                <li class="nav-item mb-2"><a class="nav-link p-0 text-light">Rocket</a>
                </li>
                <li class="nav-item mb-2"><a class="nav-link p-0 text-light">Nagad</a>
                </li>
                <li class="nav-item mb-2"><a class="nav-link p-0 text-light">Upay</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="d-flex flex-column align-items-center flex-sm-row justify-content-between pt-4 border-top">
        <p class="text-light">© <span class="update-year"></span>
            <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;}?>. All rights reserved.
        </p>
        <ul class="list-unstyled d-flex">
            <li class="ms-3"><a class="text-light fs-4" href="<?php
                    if($website_facebook==""){
                       echo "https://www.facebook.com/";
                    }else{
                        echo $website_facebook;
                    }
                    ?>" target="_blank" title="Facebook"><i class="fa-brands fa-facebook"></i></a></li>
            <li class="ms-3"><a class="text-light fs-4" href="<?php
                    if($website_instagram==""){
                       echo "https://www.instagram.com/";
                    }else{
                        echo $website_instagram;
                    }
                    ?>" target="_blank" title="Instagram"><i class="fa-brands fa-square-instagram"></i></a></li>
            <li class="ms-3"><a class="text-light fs-4" href="<?php
                    if($website_twitter==""){
                       echo "https://twitter.com/";
                    }else{
                        echo $website_twitter;
                    }
                    ?>" target="_blank" title="Twitter"><i class="fa-brands fa-twitter"></i></a></li>
            <li class="ms-3"><a class="text-light fs-4" href="<?php
                    if($website_youtube==""){
                       echo "https://www.youtube.com/";
                    }else{
                        echo $website_youtube;
                    }
                    ?>" target="_blank" title="Youtube"><i class="fa-brands fa-youtube"></i></a></li>
        </ul>
    </div>
</footer>

<script>
// Auto update year 
const yearUpdate = document.querySelectorAll(".update-year");
yearUpdate.forEach((element) => {
    element.innerHTML = new Date().getFullYear();
});
</script>