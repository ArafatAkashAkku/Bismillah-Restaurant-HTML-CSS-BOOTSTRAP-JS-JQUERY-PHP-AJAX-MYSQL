<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$email = $_SESSION['admin_email'];
$id = $_SESSION['admin_id'];
$token = $_SESSION['admin_token'];

$name = mysqli_real_escape_string($con, $_POST['name']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$gender = mysqli_real_escape_string($con, $_POST['gender']);
$dob = mysqli_real_escape_string($con, $_POST['dob']);
$blood = mysqli_real_escape_string($con, $_POST['blood']);
$oldimage = mysqli_real_escape_string($con, $_POST['oldimage']);

$admin_exist = "SELECT * FROM `admin_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
$result = mysqli_query($con, $admin_exist);

if (empty(trim($name)) || empty(trim($phone))) { 
    // echo "Name or Phone should not be empty";
    echo 1;
}elseif (strlen(trim($name)) < 5 || strlen(trim($phone)) < 11 ) {
    // echo "Provide full details of Name or Phone";    
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
                    $fileDestination = "../images/admins/". $id ."/" . $fileNameNew;
                    $dir = "../images/admins/". $id ;
                    if (!is_dir($dir)) {
                        mkdir("../images/admins/". $id);
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "UPDATE `admin_info` SET `name`='$name',`phone`='$phone',`gender`='$gender',`dob`='$dob',`blood`='$blood',`image`='$fileNameNew',`update_at`= NOW() WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
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
        $query = "UPDATE `admin_info` SET `name`='$name',`phone`='$phone',`gender`='$gender',`dob`='$dob',`blood`='$blood',`image`='$oldimage',`update_at`= NOW() WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
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
}}else{
    header("Location: index");
}
?>