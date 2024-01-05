<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$name = mysqli_real_escape_string($con, $_POST['name']);
$email = mysqli_real_escape_string($con, $_POST['email']);
$phone = mysqli_real_escape_string($con, $_POST['phone']);
$about = mysqli_real_escape_string($con, $_POST['about']);
$oldimage = mysqli_real_escape_string($con, $_POST['oldimage']);

$website_exist = "SELECT * FROM `website_info` WHERE `id`='1'";
$result = mysqli_query($con, $website_exist);

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
        $allowed = array('png');

        if (in_array($fileActualExtension, $allowed)) {
            if ($fileError == 0) {
                // 5000000=5000kb=5mb  10000000 = 10mb
                if ($fileSize < 10000000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExtension;
                    $fileDestination = "../images/logo/". $fileNameNew;
                    $dir = "../images/logo/";
                    if (!is_dir($dir)) {
                        mkdir("../images/logo/");
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "UPDATE `website_info` SET `name`='$name',`phone`='$phone',`about`='$about',`email`='$email',`logo`='$fileNameNew',`update_at`= NOW() WHERE `id`='1'";
                    if (mysqli_query($con, $query)) {
                        // echo "Website Header updated";
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
        $query = "UPDATE `website_info` SET `name`='$name',`phone`='$phone',`about`='$about',`email`='$email',`logo`='$oldimage',`update_at`= NOW() WHERE `id`='1'";
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
}else{
    header("Location: index");
}
?>