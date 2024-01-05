<!-- require start  -->
<?php include("includes/require.php") ?>
<!-- require end  -->
<?php
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    header("Location: index");
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
    <title>Signup - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>
<!-- search bar display none  -->
<style>
#search {
    display: none;
}
</style>

<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="bg-light">
        <div class="d-flex flex-column align-items-center justify-content-center py-5">
            <div class="g-light p-3 border border-warning shadow-lg p-3 mb-5 bg-body-warning rounded">
                <h2 class="text-muted text-center pt-2">&nbsp;&nbsp; Enter your signup details &nbsp;&nbsp;</h2>
                <form class="p-3" id="signup-form" autocomplete="off">
                    <div class="form-group py-2">
                        <div class="input-field">
                            <input type="text" id="name" name="name" placeholder="Enter your name" required
                                class="form-control px-3 py-2">
                        </div>
                    </div>
                    <div class="form-group py-2">
                        <div class="input-field">
                            <input type="email" id="email" name="email" placeholder="Enter your email" required
                                class="form-control px-3 py-2">
                        </div>
                    </div>
                    <div class="form-group py-2">
                        <div class="input-field">
                            <input type="password" id="password" name="password" placeholder="Enter your password"
                                required class="form-control px-3 py-2 passtext">
                        </div>
                    </div>
                    <div class="form-group py-2">
                        <label for="showsignpassword">
                            <div class="input-field">
                                <input type="checkbox" id="showsignpassword" class="showpass"
                                    onclick="myFunction()">&nbsp;Show Password
                            </div>
                        </label>
                    </div>
                    <button class="btn btn-width btn-outline-success bg-success text-light" id="signup"
                        type="submit">Sign Up</button>
                    <div class="text-center mt-3 text-muted">Already a member? <a href="login">Sign In</a></div>
                    <div class="text-center mt-3 text-muted">
                        <a href="forgetpass">Forgot Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <!-- main end  -->

    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->
    <!-- script start -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <!-- internal script start -->
    <script>
    // jquery ready start 
    $(document).ready(function() {
        // signup php ajax code start
        $("#signup").on('click', function(e) {
            e.preventDefault();
            let signupForm = $("#signup-form").serialize();
            $.ajax({
                url: "signuptoaccount.php",
                type: "POST",
                data: signupForm,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "Empty Field",
                            text: "Email, Password or name should not be empty",
                            icon: "error"
                        });
                    } else if (data == 5) {
                        Swal.fire({
                            title: "Query Problem",
                            text: "Can not run query",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        $("#signup-form").trigger("reset");
                        Swal.fire({
                            title: "Email already taken",
                            text: "Signup with different email",
                            icon: "question"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            title: "Server Down",
                            text: "Please try again later",
                            icon: "error"
                        });nnnnnn
                    }else if (data == 6) {
                        Swal.fire({
                            title: "Name should be greater than 5 character",
                            text: "Provide your full name",
                            icon: "error"
                        });
                    } else if (data == 7) {
                        Swal.fire({
                            title: "Password should be greater than 8 character",
                            text: "Signup with strong password and no extra spaces",
                            icon: "error"
                        });
                    } else if (data == 8) {
                        Swal.fire({
                            title: "Provide valid email",
                            text: "Signup with your valid email address",
                            icon: "error"
                        });
                    }else if (data == 3) {
                        $("#signup-form").trigger("reset");
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Registration successful. Please check your email",
                            showConfirmButton: false,
                            timer: 10000
                        });
                    }
                }
            });
        });
    });
    </script>
    <!-- internal script end  -->
</body>

</html>