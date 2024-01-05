<?php

include("includes/require.php");

$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$query = "SELECT * FROM `admin_info` WHERE `email`='$email'";
$result = mysqli_query($con, $query);

if (empty(trim($email)) || empty(trim($password))) { 
    // echo "Email or Password should not be empty";
    echo 1;
}else{
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $admin_fetch = mysqli_fetch_assoc($result);
            if ($admin_fetch['verified'] == 1) {
                if (password_verify($password, $admin_fetch['password'])){
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $admin_fetch['id'];
                    $_SESSION['admin_email'] = $admin_fetch['email'];
                    $_SESSION['admin_token'] = $admin_fetch['v_code'];
                    // echo "Log in success";
                    echo 2;
                    if (isset($_POST['remember'])) {
                        setcookie("adminemail", $admin_fetch['email'], time() + (86400 * 30), "/");
                        setcookie("adminpass", $password, time() + (86400 * 30), "/");
                    }
                } else {
                    // echo "Incorrect Password";
                    echo 3;
                }
            } else {
                // echo "Email not verified";
                echo 4;
            }
        } else {
            // echo "Email not registered";
            echo 5;
        }
    } else {
        // echo "Can not run query";
        echo 6;
    }
}


?>