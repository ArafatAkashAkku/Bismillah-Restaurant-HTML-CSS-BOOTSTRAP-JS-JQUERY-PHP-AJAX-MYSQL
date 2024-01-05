<?php

include("includes/require.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$maintainance = mysqli_real_escape_string($con, $_POST['maintainance']);

$website_exist = "SELECT * FROM `website_info` WHERE `id`='1'";
$result = mysqli_query($con, $website_exist);

if ($result) {
   if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE `website_info` SET `maintainance`='$maintainance',`update_at`= NOW() WHERE `id`='1'";
        if (mysqli_query($con, $query)) {
            // echo "Website Maintainance updated";
            echo 1;
        } else {
            // echo "Server Down";
            echo 2;
        }
    } 
}else {
    // echo "Can not run query";
    echo 3;
}
}else{
    header("Location: index");
}
?>