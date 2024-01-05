<?php 
// require start
include("includes/require.php");
// require end
?>
<?php
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    $email = $_SESSION['admin_email'];
    $id = $_SESSION['admin_id'];
    $token = $_SESSION['admin_token'];
}else{
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
    <title>Admin Password Change - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>

<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="bg-light">
        <div class="d-flex flex-column align-items-center justify-content-center py-2">
            <div class="bg-light px-2">
                <?php
                    $ret = mysqli_query($con, "SELECT * from `admin_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'");
                    $row = mysqli_fetch_array($ret);
                    if ($row) {
                    ?>
                <h2 class="text-muted text-center py-2 mt-3">Update password info</h2>
                <form autocomplete="off" id="accountpass-form">
                    <div class="row gap-2 d-flex justify-content-center">

                        <div class="col-md-3 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="password">Current Password</label></h5>
                                    <input type="password" id="password" required
                                        value="<?php if (isset($_COOKIE['adminpass'])) {  echo $_COOKIE['adminpass']; }?>"
                                        placeholder="Enter your current password" name="password"
                                        class="border border-primary form-control px-3 py-2 passtext">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="newpassword">New Password</label></h5>
                                    <input type="password" id="newpassword" required name="newpassword"
                                        placeholder="Enter your new password"
                                        class="border border-primary form-control px-3 py-2 passtext">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="conpassword">Confirm Password</label></h5>
                                    <input type="password" id="conpassword" required name="conpassword"
                                        placeholder="Enter your confirm password"
                                        class="border border-primary form-control px-3 py-2 passtext">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <label for="showchangepassword">
                                        <div class="input-field">
                                            <input type="checkbox" id="showchangepassword" class="showpass">&nbsp;Show
                                            Password
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <button class="btn px-5 btn-outline-warning text-dark bg-warning" id="accountpass"
                                        type="submit">Update Password</button>
                                </div>
                            </div>
                        </div>
                </form>

                <?php
                    } 
                    ?>
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
        // updating password php ajax code 
        $("#accountpass-form").on('submit', function(e) {
            e.preventDefault();
            let accountPassForm = $('#accountpass-form').serialize();
            $.ajax({
                url: "changepasswordupdate.php",
                type: "POST",
                data: accountPassForm,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "Empty Field",
                            text: "Password should not be empty",
                            icon: "error"
                        });
                    } else if (data == 8) {
                        Swal.fire({
                            title: "Current Password Matches New & Confirm Password",
                            text: "Please change your password",
                            icon: "error"
                        });
                    } else if (data == 6) {
                        Swal.fire({
                            title: "Query Problem",
                            text: "Can not run query",
                            icon: "error"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            title: "New & Confirm Password not matched",
                            text: "Please try again",
                            icon: "question"
                        });
                    } else if (data == 7) {
                        Swal.fire({
                            title: "New & Confirm Password should be greater than 8 character",
                            text: "Please try again",
                            icon: "question"
                        });
                    } else if (data == 3) {
                        Swal.fire({
                            title: "Server Down",
                            text: "Please try again later",
                            icon: "error"
                        });
                    } else if (data == 5) {
                        Swal.fire({
                            title: "Current Password Incorrect",
                            text: "Try again",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Password updated successfully <br> Please login again ",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "logout";
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