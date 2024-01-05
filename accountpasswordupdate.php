<?php

include("includes/require.php");

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
$email = $_SESSION['user_email'];
$id = $_SESSION['user_id'];
$token = $_SESSION['user_token'];
$password = mysqli_real_escape_string($con, $_POST['password']);
$newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
$conpassword = mysqli_real_escape_string($con, $_POST['conpassword']);
$user_exist = "SELECT * FROM `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
$result = mysqli_query($con, $user_exist);

if (empty(trim($password)) || empty(trim($newpassword)) || empty(trim($conpassword))) { 
    // echo "Password should not be empty";
    echo 1;
}elseif (strlen(trim($newpassword)) < 8 || strlen(trim($conpassword)) < 8) { 
    // echo "New & Confirm Password should be greater than 8 character";
    echo 7;
}elseif (trim($password) == trim($newpassword)) { 
    // echo "This is a current password";
    echo 8;
}else{
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $user_fetch = mysqli_fetch_assoc($result);
            if ($user_fetch['verified'] == 1) {
                if (password_verify($password, $user_fetch['password'])) {
                    if($newpassword == $conpassword){
                        $hashpassword = password_hash($newpassword, PASSWORD_BCRYPT);
                        $query = "UPDATE `user_info` SET `password`='$hashpassword' , `update_at`= NOW() WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
                            if (mysqli_query($con, $query)) {
                                // echo "Password updated successfully";
                                setcookie("userpass", "", time() - 3600, "/");
                                echo 2;
                            } else {
                                // echo "Server Down";
                                echo 3;
                            }
                    }else{
                        // echo "New & Confirm Password not matched";
                        echo 4;
                    }                  
                } else {
                    // echo "Incorrect Current Password";
                    echo 5;
                }
        }
        } else {
        // echo "Can not run query";
        echo 6;
        }   
    } 
}
}else{
    header("Location: index");
}
    ?>
