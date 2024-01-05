<?php

include("includes/require.php");

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
$email = $_SESSION['user_email'];
$id = $_SESSION['user_id'];
$token = $_SESSION['user_token'];

$name = mysqli_real_escape_string($con, $_POST['name']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$dob = mysqli_real_escape_string($con, $_POST['dob']);
$blood = mysqli_real_escape_string($con, $_POST['blood']);
$address = mysqli_real_escape_string($con, $_POST['address']);
$oldimage = mysqli_real_escape_string($con, $_POST['oldimage']);

$user_exist = "SELECT * FROM `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
$result = mysqli_query($con, $user_exist);

if (empty(trim($name)) || empty(trim($phone)) || empty(trim($address))) { 
    // echo "Name or Phone or Address should not be empty";
    echo 1;
}elseif (strlen(trim($name)) < 5 || strlen(trim($phone)) < 11  || strlen(trim($address)) < 10) {
    // echo "Provide full details of Name or Phone or Address";    
    echo 2;
}elseif(!is_numeric(trim($phone))){
// echo "Phone number should be numeric values only";   
echo 3;
}else{
if ($result) {
if (mysqli_num_rows($result) > 0) {
    if ($_FILES["updateimage"]["name"] != "") {
        $file = $_FILES['updateimage'];
        $fileName = $_FILES['updateimage']['name'];
        $fileTmpName = $_FILES['updateimage']['tmp_name'];
        $fileSize = $_FILES['updateimage']['size'];
        $fileError = $_FILES['updateimage']['error'];
        $fileExtension = explode('.', $fileName);
        $fileActualExtension = strtolower(end($fileExtension));
        $allowed = array('jpg', 'jpeg');

        if (in_array($fileActualExtension, $allowed)) {
            if ($fileError == 0) {
                // 5000000=5000kb=5mb  10000000 = 10mb
                if ($fileSize < 10000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExtension;
                    $fileDestination = "images/users/". $id ."/" . $fileNameNew;
                    $dir = "images/users/". $id ;
                    if (!is_dir($dir)) {
                        mkdir("images/users/". $id);
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "UPDATE `user_info` SET `name`='$name',`phone`='$phone',`gender`='$gender',`dob`='$dob',`blood`='$blood',`address`='$address',`image`='$fileNameNew',`update_at`= NOW() WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
                    if (mysqli_query($con, $query)) {
                        // echo "Account info updated";
                        echo 4;
                    } else {
                        // echo "Server Down";
                        echo 5;
                    }
                } else {
                    // echo "Your file is too big";
                    echo 6;
                }
            } else {
                // echo "There was an error uploading your file";
                echo 7;
            }
        } else {
            // echo "You cant upload a file here";
            echo 8;
        }
    } else {
        $query = "UPDATE `user_info` SET `name`='$name',`phone`='$phone',`gender`='$gender',`dob`='$dob',`blood`='$blood',`address`='$address',`image`='$oldimage',`update_at`= NOW() WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
        if (mysqli_query($con, $query)) {
            // echo "Account info updated";
            echo 4;
        } else {
            // echo "Server Down";
            echo 5;
        }
    }
}
} else {
// echo "Can not run query";
echo 9;
}
}
}else{
    header("Location: index");
}
?>