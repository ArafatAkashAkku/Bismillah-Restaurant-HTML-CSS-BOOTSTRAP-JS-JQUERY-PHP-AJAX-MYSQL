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
    <title>Update Password - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
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

    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <script>
    // jquery ready start 
    $(document).ready(function() {
        // forgetpass php ajax code start
        $("#update").on('click', function(e) {
            e.preventDefault();
            let updateForm = $("#updatepass-form").serialize();
            $.ajax({
                url: "updatepassaccount.php",
                type: "POST",
                data: updateForm,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "Empty Field",
                            text: "Email is not found",
                            icon: "error"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            title: "Server Down",
                            text: "Try again later",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        Swal.fire({
                            title: "Password should not be empty",
                            text: "Please check again",
                            icon: "error"
                        });
                    } else if (data == 5) {
                        Swal.fire({
                            title: "Password should be greater than 8 characters",
                            text: "Please try again",
                            icon: "error"
                        });
                    } else if (data == 3) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Password changed successfully <br> Please try to login",
                            showConfirmButton: false,
                            timer: 3000
                        });
                        setTimeout(() => {
                            window.location.href = "login";
                        }, 3100);
                    }
                }
            });
        });
    });
    </script>
    <!-- internal script end  -->

    <!-- main start  -->
    <main class="bg-light">

        <?php

        if (isset($_GET['email']) && isset($_GET['resettoken'])) {
            $email = mysqli_real_escape_string($con,$_GET['email']);
            $resettoken = $_GET['resettoken'];
            date_default_timezone_set('Asia/Dhaka');
            $date = date("Y-m-d");
            $query = " SELECT * FROM `user_info` WHERE `email`='$email' AND `resettoken`='$resettoken' AND `resettokenexpire`='$date'";
            $result = mysqli_query($con, $query);
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    echo "
                    <div class='d-flex flex-column align-items-center justify-content-center py-5'>
                        <div class='bg-light p-3 border border-warning shadow-lg p-3 mb-5 bg-body-warning rounded'>
                            <h2 class='text-muted text-center pt-2'>&nbsp;&nbsp; Enter your new password &nbsp;&nbsp;</h2>
                            <form class='p-3' id='updatepass-form' autocomplete='off'>
                                <div class='form-group py-2'>
                                    <div class='input-field'> 
                                        <input type='password' id='password' name='password' placeholder='Enter your new password' required class='form-control px-3 py-2 passtext'> 
                                    </div>
                                    <input type='hidden' name='email' value='$email'> 
                                </div>
                                <div class='form-group py-2'>
                                <label for='showupdatepass'>
                                    <div class='input-field'>
                                        <input type='checkbox' id='showupdatepass' class='showpass'>&nbsp;Show Password
                                    </div>
                                </label>
                            </div>
                                    <button class='btn btn-width btn-outline-warning bg-warning text-dark' id='update'  type='submit'>Update Password</button>
                            </form>
                        </div>
                    </div>
                    <script>
                    const showpassword = document.getElementById('showupdatepass');
                    const passtextword = document.getElementById('password');
                    showpassword.onclick = () => {
                        if (passtextword.type === 'password') {
                            passtextword.type = 'text';
                        } else {
                            passtextword.type = 'password';
                        }
                    };
                    </script>
                    ";
                } else {
                    echo '
                    <script>
                    Swal.fire({
                        title: "Reset Token Expired",
                        text: "Try again later",
                        icon: "error"
                    });
                    setTimeout(() => {
                        window.location.href = "index";
                    }, 2500);
                    </script>
                    ';  
                }
            } else {
                echo '
                    <script>
                    Swal.fire({
                        title: "Query Problem",
                        text: "Can not run query",
                        icon: "error"
                    });
                    setTimeout(() => {
                        window.location.href = "index";
                    }, 2500);
                    </script>
                    ';  
            }
        } else {
            echo "
            <script>
            window.location.href='index';
            </script>
            ";
        }

        ?>
    </main>
    <!-- main end  -->


    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->

</body>

</html>