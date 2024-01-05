<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$email = $_SESSION['admin_email'];
$id = $_SESSION['admin_id'];
$token = $_SESSION['admin_token'];
$password = mysqli_real_escape_string($con, $_POST['password']);
$newpassword = mysqli_real_escape_string($con, $_POST['newpassword']);
$conpassword = mysqli_real_escape_string($con, $_POST['conpassword']);
$admin_exist = "SELECT * FROM `admin_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
$result = mysqli_query($con, $admin_exist);

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
            $admin_fetch = mysqli_fetch_assoc($result);
            if ($admin_fetch['verified'] == 1) {
                if (password_verify($password, $admin_fetch['password'])) {
                    if($newpassword == $conpassword){
                        $hashpassword = password_hash($newpassword, PASSWORD_BCRYPT);
                        $query = "UPDATE `admin_info` SET `password`='$hashpassword' , `update_at`= NOW() WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
                            if (mysqli_query($con, $query)) {
                                // echo "Password updated successfully";
                                setcookie("adminpass", "", time() - 3600, "/");
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
}}else{
    header("Location: index");
}
    ?>
