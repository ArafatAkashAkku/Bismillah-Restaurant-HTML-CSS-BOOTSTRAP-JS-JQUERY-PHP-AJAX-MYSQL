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
    <title>Verify - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
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

    </main>
    <!-- main end  -->

    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->
    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <!-- verification by php  -->
    <?php
if (isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = mysqli_real_escape_string($con,$_GET['email']);
    $v_code = mysqli_real_escape_string($con,$_GET["v_code"]);

    $query = "SELECT * from `user_info` WHERE `email`='$email' AND `v_code`='$v_code'";
    $result = mysqli_query($con, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user_fetch = mysqli_fetch_assoc($result);
            if ($user_fetch['verified'] == 0) {
                $update = "UPDATE `user_info` SET `verified`='1',`create_at`= NOW() WHERE `email`='$user_fetch[email]'";
                if (mysqli_query($con, $update)) {
                    echo '
                    <script>
                    Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: "Email Verification Successful <br> You can now login",
                        showConfirmButton: false,
                        timer: 2500
                    });
                    setTimeout(() => {
                        window.location.href = "login";
                    }, 2700);
                    </script>
                    ';
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
                echo '
                <script>
                Swal.fire({
                    title: "Email already verified?",
                    text: "Please try to login",
                    icon: "success"
                });
                setTimeout(() => {
                    window.location.href = "login";
                }, 2700);
                </script>
                ';
            }
        }else {
            echo '
                <script>
                Swal.fire({
                    title: "Email not registered yet",
                    text: "Please signup with your details",
                    icon: "question"
                });
                setTimeout(() => {
                    window.location.href = "signup";
                }, 2700);
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
}else{
    echo '
    <script>
        window.location.href = "index";
    </script>
    '; 
}
?>


</body>

</html>