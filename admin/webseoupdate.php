<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$description = mysqli_real_escape_string($con, $_POST['description']);
$keywords = mysqli_real_escape_string($con, $_POST['keywords']);
$author = mysqli_real_escape_string($con, $_POST['author']);
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
        $allowed = array('ico');

        if (in_array($fileActualExtension, $allowed)) {
            if ($fileError == 0) {
                // 100000=100kb 10000000 = 10mb
                if ($fileSize < 100000) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExtension;
                    $fileDestination = "../images/favicon/". $fileNameNew;
                    $dir = "../images/favicon/";
                    if (!is_dir($dir)) {
                        mkdir("../images/favicon/");
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $query = "UPDATE `website_info` SET `description`='$description',`keywords`='$keywords',`author`='$author',`favicon`='$fileNameNew',`update_at`= NOW() WHERE `id`='1'";
                    if (mysqli_query($con, $query)) {
                        // echo "Website Seo updated";
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
        $query = "UPDATE `website_info` SET `description`='$description',`keywords`='$keywords',`author`='$author',`favicon`='$oldimage',`update_at`= NOW() WHERE `id`='1'";
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