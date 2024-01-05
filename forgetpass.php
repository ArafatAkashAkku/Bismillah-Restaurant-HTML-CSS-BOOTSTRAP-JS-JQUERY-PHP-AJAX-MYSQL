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
    <title>Forget Password - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
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
            <div class="bg-light p-3 border border-warning shadow-lg p-3 mb-5 bg-body-warning rounded">
                <h2 class="text-muted text-center pt-2">&nbsp;&nbsp; Enter your email address &nbsp;&nbsp;</h2>
                <form class="p-3" autocomplete="off" id="forget-form">
                    <div class="form-group py-2">
                        <div class="input-field">
                            <input type="email" id="email" name="email" value="<?php if (isset($_COOKIE['useremail'])) {
                                                                        echo $_COOKIE['useremail'];
                                                                    }  ?>" placeholder="Enter your Email" required
                                class="form-control px-3 py-2">
                        </div>
                    </div>
                    <button class="btn btn-width bg-success text-light" id="reset" type="submit">Send Reset
                        Link</button>
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
        // forgetpass php ajax code start
        $("#reset").on('click', function(e) {
            e.preventDefault();
            let forgetForm = $("#forget-form").serialize();
            $.ajax({
                url: "forgetpassaccount.php",
                type: "POST",
                data: forgetForm,
                success: function(data) {
                    if (data == 1) {
                        Swal.fire({
                            title: "Empty Field",
                            text: "Email should not be empty",
                            icon: "error"
                        });
                    } else if (data == 5) {
                        Swal.fire({
                            title: "Query Problem",
                            text: "Can not run query",
                            icon: "error"
                        });
                    } else if (data == 3) {
                        Swal.fire({
                            title: "Server down",
                            text: "Try again later",
                            icon: "error"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            title: "Email not found",
                            text: "Please sign up",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        Swal.fire({
                            title: "Password reset link sent to mail",
                            icon: "success"
                        });
                        setTimeout(() => {
                            window.location.href = "index";
                        }, 5000);
                    }
                }
            });
        });
    });
    </script>
    <!-- internal script end  -->

</body>

</html>