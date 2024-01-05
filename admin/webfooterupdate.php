<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$facebook = mysqli_real_escape_string($con, $_POST['facebook']);
$instagram = mysqli_real_escape_string($con, $_POST['instagram']);
$twitter = mysqli_real_escape_string($con, $_POST['twitter']);
$youtube = mysqli_real_escape_string($con, $_POST['youtube']);

$website_exist = "SELECT * FROM `website_info` WHERE `id`='1'";
$result = mysqli_query($con, $website_exist);

if ($result) {
   if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE `website_info` SET `facebook`='$facebook',`instagram`='$instagram',`twitter`='$twitter',`youtube`='$youtube',`update_at`= NOW() WHERE `id`='1'";
        if (mysqli_query($con, $query)) {
            // echo "Website Footer updated";
            echo 4;
        } else {
            // echo "Server Down";
            echo 5;
        }
    } 
}else {
    // echo "Can not run query";
    echo 9;
}
}else{
    header("Location: index");
}
?>