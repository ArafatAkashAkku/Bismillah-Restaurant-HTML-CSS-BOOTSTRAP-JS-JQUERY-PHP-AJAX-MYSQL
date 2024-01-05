<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    
$foodid = mysqli_real_escape_string($con, $_POST['foodid']);
$name = mysqli_real_escape_string($con, $_POST['name']);
$about = mysqli_real_escape_string($con, $_POST['about']);
$price = mysqli_real_escape_string($con, $_POST['price']);
$status = mysqli_real_escape_string($con, $_POST['status']);
$oldimage = mysqli_real_escape_string($con, $_POST['oldimage']);

if ($_FILES["image"]["name"] != "") {
    $file = $_FILES['image'];
    $fileName = $_FILES['image']['name'];
    $fileTmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileError = $_FILES['image']['error'];
    $fileExtension = explode('.', $fileName);
    $fileActualExtension = strtolower(end($fileExtension));
    $allowed = array('jpg', 'jpeg');

    if (in_array($fileActualExtension, $allowed)) {
        if ($fileError == 0) {
            // 5000000=5000kb=5mb  10000000 = 10mb
            if ($fileSize < 10000000) {
                $fileNameNew = uniqid('', true) . "." . $fileActualExtension;
                $fileDestination = "../images/food/". $foodid . "/" . $fileNameNew;
                $dir = "../images/food/". $foodid;
                if (!is_dir($dir)) {
                    mkdir("../images/food/" . $foodid);
                }
                move_uploaded_file($fileTmpName, $fileDestination);
                
                $query = "UPDATE `food_info` SET `name`='$name', `about`='$about', `price`='$price', `image`='$fileNameNew', `status`='$status', `update_at`=NOW() WHERE `id`='$foodid'";
                if (mysqli_query($con, $query)) {
                    // echo "Food item added";
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
    $query = "UPDATE `food_info` SET `name`='$name', `about`='$about', `price`='$price', `image`='$oldimage', `status`='$status', `update_at`=NOW() WHERE `id`='$foodid'";
    if (mysqli_query($con, $query)) {
        // echo "Food item added";
        echo 4;
    } else {
        // echo "Server Down";
        echo 5;
    }
}
}else{
    header("Location: index");
}

?>