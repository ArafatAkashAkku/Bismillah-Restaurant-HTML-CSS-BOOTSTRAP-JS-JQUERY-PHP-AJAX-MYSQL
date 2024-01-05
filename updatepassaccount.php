<?php

include("includes/require.php");

$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$hashpassword = password_hash($password, PASSWORD_BCRYPT);

if (empty(trim($email))) { 
    // echo "Email is not found";
    echo 1;
}elseif(empty(trim($password))){
    // echo "Password should not be empty";
    echo 2;
}elseif (strlen(trim($password)) < 8 ) { 
    // echo "Password should be greater than 8 character";
    echo 5;
}else{
    $update = "UPDATE `user_info` SET `password`='$hashpassword',`resettoken`=NULL,`resettokenexpire`=NULL, `update_at`= NOW() WHERE `email`='$email'";
    $result = mysqli_query($con, $update); 
    if ($result) {
        // echo "Password changed successfully";
        echo 3;
    } else {
        // echo "Server down";
        echo 4;
    }
}

    ?>