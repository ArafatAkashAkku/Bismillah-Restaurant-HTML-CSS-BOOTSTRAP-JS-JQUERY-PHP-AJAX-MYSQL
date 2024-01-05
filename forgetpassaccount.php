<?php

include("includes/require.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';

function sendMail($email, $reset_token)
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
        $mail->Subject = 'Password Reset Link For Bismillah Restaurant';
        $mail->Body    = "We got a reset password request from you. <br>
        Click the link below to reset your password <a href='".WEBSITE_URL."/updatepass?email=$email&resettoken=$reset_token'>Reset Password</a>";
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$email = mysqli_real_escape_string($con, $_POST['email']);
$user_fetch = " SELECT * FROM `user_info` WHERE `email`='$email'";
$result = mysqli_query($con, $user_fetch);

if (empty(trim($email))) { 
    // echo "Email should not be empty";
    echo 1;
}else{
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $reset_token = bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/Dhaka');
        $date = date("Y-m-d");
        $query = "UPDATE `user_info` SET `resettoken`='$reset_token',`resettokenexpire`='$date' WHERE `email`='$email'";
        if (mysqli_query($con, $query) && sendMail($email, $reset_token)) {
            // echo "Password reset link sent to mail";
            echo 2;
        } else {
            // echo "Server down";
            echo 3;
        }
    } else {
        // echo "Email not found";
        echo 4;
    }
} else {
    // echo "Can not run query";
    echo 5;
}
}

?>