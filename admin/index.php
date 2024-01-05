<!-- require start  -->
<?php 
include("includes/require.php");
?>
<!-- require end  -->
<?php
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    header("Location: dashboard");
}elseif (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    header("Location: ../index");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta start  -->
    <?php include("includes/meta.php") ?>
    <!-- meta end  -->
    <!-- link start  -->
    <?php include("includes/link.php") ?>
    <!-- link end  -->
    <!-- website title  -->
    <title>Admin Login - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>
<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="bg-light">
        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <div class="bg-light p-3 border border-warning shadow-lg p-3 mb-5 bg-body-warning rounded">
                <h2 class="text-muted text-center pt-2">&nbsp;&nbsp; Enter admin login details &nbsp;&nbsp;</h2>
                <form id="login-form" class="p-3" autocomplete="off">
                    <div class="form-group py-2">
                        <div class="input-field">
                            <input type="email" id="email" name="email" placeholder="Enter your Email" required
                                class="form-control px-3 py-2"
                                value="<?php if (isset($_COOKIE['adminemail'])) {  echo $_COOKIE['adminemail']; }?>">
                        </div>
                    </div>
                    <div class="form-group py-2">
                        <div class="input-field">
                            <input type="password" id="password" name="password" placeholder="Enter your Password"
                                required class="form-control px-3 py-2 passtext"
                                value="<?php if (isset($_COOKIE['adminpass'])) {  echo $_COOKIE['adminpass']; }?>">
                        </div>
                    </div>
                    <div class="form-group pb-2">
                        <label for="showlogpassword">
                            <div class="input-field">
                                <input type="checkbox" id="showlogpassword" class="showpass">&nbsp;Show Password
                            </div>
                        </label>
                    </div>

                    <?php if (!isset($_COOKIE['adminpass']) || !isset($_COOKIE['adminemail'])) {  
                        echo '
                        <div class="form-group my-3 d-flex justify-content-center">
                        <label for="remember">
                            <div class="input-field">
                                <input type="checkbox" id="remember" name="remember">&nbsp;Remember me
                                </div>
                            </label>
                        </div>
                        ';                         
                    }?>             
                           
                    <button class="btn btn-width btn-outline-success bg-success text-light" id="login" type="submit">Log
                        in</button>
                </form>
            </div>
        </div>
    </main>
    <!-- main end  -->

    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->
    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <!-- internal script start  -->
    <script>
    // jquery ready start 
    $(document).ready(function() {
        // login php ajax code start
        $("#login").on('click', function(e) {
            e.preventDefault();
            let loginForm = $("#login-form").serialize();

            $.ajax({
                url: "indextoaccount.php",
                type: "POST",
                data: loginForm,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "Empty Field",
                            text: "Email or Password should not be empty",
                            icon: "error"
                        });
                    } else if (data == 6) {
                        Swal.fire({
                            title: "Query Problem",
                            text: "Can not run query",
                            icon: "error"
                        });
                    } else if (data == 5) {
                        Swal.fire({
                            title: "Email not registered yet?",
                            text: "Please check your email or Try to signup",
                            icon: "question"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            title: "Email not verified",
                            text: "Please sign up",
                            icon: "error"
                        });
                    } else if (data == 3) {
                        Swal.fire({
                            title: "Incorrect Password",
                            text: "Try again",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Login Successful",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "dashboard";
                        }, 2100);
                    }
                }
            });
        });
    });
    </script>
    <!-- internal script end  -->

</body>

</html>