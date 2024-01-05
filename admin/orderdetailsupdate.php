<?php

include("includes/require.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../vendor/autoload.php');


function sendMail($email,$order,$status)
{
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();                                   //Send using SMTP
        $mail->Host       = MAIL_HOST;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = MAIL_SMTPAUTH;                 //Enable SMTP authentication
        $mail->Username   = MAIL_USERNAME;                 //SMTP username
        $mail->Password   = MAIL_PASSWORD;                 //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   //Enable implicit TLS encryption
        $mail->Port       = MAIL_PORT;                     //TCP port to connect to; use 587 if 

        //Recipients
        $mail->setFrom(MAIL_SET_FROM, MAIL_SET_WEBSITENAME);
        $mail->addAddress($email);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Order Status";
        $mail->Body    = "Your Order no: ".$order." has been ".$status."<br>
        Please <a href='".WEBSITE_URL."'>Visit Website</a> for more info";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {

$oemail = mysqli_real_escape_string($con, $_POST['email']);
$orderno = mysqli_real_escape_string($con, $_POST['orderno']);
$deliverystatus = mysqli_real_escape_string($con, $_POST['deliverystatus']);

$updatestatus = "SELECT * from `orders_info` WHERE `orderno`='$orderno' AND `email`='$oemail'";
$result = mysqli_query($con, $updatestatus);

if ($result) {
    if (mysqli_num_rows($result) > 0) {
            $query = "UPDATE `orders_info` SET `deliverystatus`='$deliverystatus' , `update_at`=NOW() WHERE `orderno`='$orderno' AND `email`='$oemail'";
            if (mysqli_query($con, $query) && sendMail($oemail,$orderno,$deliverystatus)) {
                // echo "Delivery info updated";
                echo 1;
            } else {
                // echo "Server Down";
                echo 2;
            }              
    } else {
    // echo "Can not run query";
    echo 3;
    }
}else {
// echo "Can not run query";
echo 3;
}   
}else{
    header("Location: index");
}
?>