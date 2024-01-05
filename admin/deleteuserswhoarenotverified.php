<?php

include("includes/require.php");
include("includes/websiteinfo.php");

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    if($website_maintainance=='on'){
        $user_delete = "DELETE FROM `user_info` WHERE `verified`='0'";
        $result = mysqli_query($con, $user_delete);
        if ($result) {
            echo '
            <script>
            window.location.href="userinformation";
            </script>
            ';
        }
    }elseif($website_maintainance=='off'){
    echo '
    <script>
    window.location.href="index";
    </script>
    ';
   }
}else{
    header("Location: index");
}
?>