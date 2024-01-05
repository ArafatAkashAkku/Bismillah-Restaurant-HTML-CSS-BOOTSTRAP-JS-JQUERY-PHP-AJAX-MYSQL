<?php

include("includes/require.php");

$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$query = "SELECT * FROM `user_info` WHERE `email`='$email'";
$result = mysqli_query($con, $query);

if (empty(trim($email)) || empty(trim($password))) { 
    // echo "Email or Password should not be empty";
    echo 1;
}else{
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user_fetch = mysqli_fetch_assoc($result);
            if ($user_fetch['verified'] == 1) {
                if (password_verify($password, $user_fetch['password'])) {
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['user_id'] = $user_fetch['id'];
                    $_SESSION['user_email'] = $user_fetch['email'];
                    $_SESSION['user_token'] = $user_fetch['v_code'];
                    // echo "Log in success";
                    echo 2;
                    if (isset($_POST['remember'])) {
                        setcookie("useremail", $user_fetch['email'], time() + (86400 * 30), "/");
                        setcookie("userpass", $password, time() + (86400 * 30), "/");
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