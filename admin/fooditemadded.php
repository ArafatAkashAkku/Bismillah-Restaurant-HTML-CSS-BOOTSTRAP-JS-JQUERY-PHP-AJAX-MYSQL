<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
$name = mysqli_real_escape_string($con, $_POST['name']);
$about = mysqli_real_escape_string($con, $_POST['about']);
$price = mysqli_real_escape_string($con, $_POST['price']);

$fetchid=mysqli_query($con,"SELECT MAX(`id`) as 'fid' FROM `food_info`");
$result=mysqli_fetch_assoc($fetchid);
$id=$result['fid']+1;
$item = '000'.$id;


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
                $fileDestination = "../images/food/". $id . "/" . $fileNameNew;
                $dir = "../images/food/". $id;
                if (!is_dir($dir)) {
                    mkdir("../images/food/" . $id);
                }
                move_uploaded_file($fileTmpName, $fileDestination);
                
                $query = "INSERT INTO `food_info`(`itemno`, `name`, `about`, `price`, `image`, `status`, `create_at`) VALUES ('$item','$name','$about','$price','$fileNameNew','active',NOW())";
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
    $query = "INSERT INTO `food_info`(`itemno`, `name`, `about`, `price`, `status`, `create_at`) VALUES ('$item','$name','$about','$price','active',NOW())";
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