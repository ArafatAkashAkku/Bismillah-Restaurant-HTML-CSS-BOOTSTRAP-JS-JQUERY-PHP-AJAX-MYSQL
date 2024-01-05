<?php

include("includes/require.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendMail($email, $v_code)
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
        $mail->Subject = "Email Verification for Bismillah Restaurant";
        $mail->Body    = "Thanks for your registration. <br>
        Click the link below to verify your email address <a href='".WEBSITE_URL."/verify?email=$email&v_code=$v_code'>Verifiy</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$name = mysqli_real_escape_string($con,$_POST['name']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = mysqli_real_escape_string($con,$_POST['password']);
$queryexist = "SELECT * from `user_info` WHERE `email`='$email' AND `verified`=1";
$result = mysqli_query($con, $queryexist);
// email validation 
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
$validemail = test_input($email);

if (empty(trim($name)) || empty(trim($email)) || empty(trim($password))) { 
    // echo "Email, Password or name should not be empty";
    echo 1;
}elseif (strlen(trim($name)) < 5) {
    // echo "Name should be greater than 5 character";
    echo 6;
}elseif (strlen(trim($password)) < 8) {
    // echo "Password should be greater than 8 character";
    echo 7;
}elseif (!filter_var($validemail, FILTER_VALIDATE_EMAIL)) {
    // echo "Provide valid email";
    echo 8;
}else{
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $user_fetch = mysqli_fetch_assoc($result);
        if ($user_fetch['email'] == $validemail) {
            // echo "Email already taken";
            echo 2;
        }
    } else {
        $v_code = bin2hex(random_bytes(16));
        $hashpassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO `user_info`(`email`, `password`,`name`,`v_code`,`verified`,`create_at`) VALUES ('$validemail','$hashpassword','$name', '$v_code','0',NOW())";
        if (mysqli_query($con, $query) && sendMail($validemail, $v_code)) {
            // echo "Registration successful. Please check your email";
            echo 3;
        } else {
            // echo "Server Down";
            echo 4;
        }
    }
} else {
    // echo "Can not run query";
    echo 5;
}
}

?>