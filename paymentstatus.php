<?php 
// require start
include("includes/require.php");
// require end
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    $email = $_SESSION['user_email'];
    $id = $_SESSION['user_id'];
    $token = $_SESSION['user_token'];
    $ret = mysqli_query($con, "SELECT * from `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'");
    $user_fetch = mysqli_fetch_array($ret);
    if ($user_fetch) {
      $dname = $user_fetch["name"];
      $demail = $user_fetch["email"];
      $dphone = $user_fetch["phone"];
      $daddress = $user_fetch["address"];
    }
}else{
    header("Location: index");
}
?>

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('vendor/autoload.php');


function sendMail($email,$order)
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
        $mail->Subject = "Order Placement Successful";
        $mail->Body    = "Thanks for your order. Order no: ".$order."<br>
        Please have patience. We will deliver it to you as soon as possible <a href='".WEBSITE_URL."'>Visit Website</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$app_key = BKASH_KEY;
$app_secret = BKASH_SECRET;
$username = BKASH_USERNAME;
$password = BKASH_PASSWORD;
$base_url = BKASH_BASE_URL;
$callbackURL = BKASH_CALLBACK_URL;

// Start Grant Token
$client = new \GuzzleHttp\Client();
$response = $client->request('POST', $base_url.'/v1.2.0-beta/tokenized/checkout/token/grant',
[
'body' => "{'app_key':$app_key, 'app_secret':$app_secret}",
'headers' => [
'accept' => 'application/json',
'content-type' => 'application/json',
'password' => $password,
'username' => $username,
],
]);
$response = json_decode($response->getBody());
$id_token = $response->id_token;
// End Grant Token

// execute payment
if (isset($_GET['paymentID'],$_GET['status']) && $_GET['status'] == 'success') {
$paymentID = $_GET['paymentID'];  
$auth = $id_token;
$post_token = array( 'paymentID' => $paymentID );
$url = curl_init($base_url.'/v1.2.0-beta/tokenized/checkout/execute');       
$posttoken = json_encode($post_token);
            $header = array(
                'Content-Type:application/json',
                'Authorization:' . $auth,
                'X-APP-Key:'.$app_key
            );
curl_setopt($url, CURLOPT_HTTPHEADER, $header);
curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
$resultdata = curl_exec($url);
curl_close($url);
$obj = json_decode($resultdata);

foreach($obj as $key=>$value){
  if($key=='paymentID'){
    $paymentID = $value;
  }elseif($key=='trxID'){
    $trxID = $value;
  }elseif($key=='transactionStatus'){
    $transactionStatus = $value;
  }elseif($key=='amount'){
    $amount = $value;
  }elseif($key=='currency'){
    $currency = $value;
  }elseif($key=='intent'){
    $intent = $value;
  }elseif($key=='paymentExecuteTime'){
    $paymentExecuteTime = $value;
  }elseif($key=='merchantInvoiceNumber'){
    $merchantInvoiceNumber = $value;
  }elseif($key=='payerReference'){
    $payerReference = $value;
  }elseif($key=='customerMsisdn'){
    $customerMsisdn = $value;
  }elseif($key=='statusCode'){
    $statusCode = $value;
  }elseif($key=='statusMessage'){
    $statusMessage = $value;
  }
}

if($statusCode != '0000'){ //success 0000
  echo '
  <script>
  window.location.href= "index";
  alert("Payment Error!!! Please Try Again");
  </script>
  ';
}else{

$dorder="";
foreach ($_SESSION["shopping_cart"] as $food) {
    $dorder .= '<tr>';
    $dorder .= '<td>';
    $dorder .= $food['name'];
    $dorder .= '</td>';
    $dorder .= '<td>';
    $dorder .= $food['item'];
    $dorder .= '</td>';
    $dorder .= '<td>';
    $dorder .= $food['quantity'];
    $dorder .= '</td>';
    $dorder .= '<td>';
    $dorder .= 'BDT&nbsp;';
    $dorder .= $food['price'];
    $dorder .= '</td>';
    $dorder .= '</tr>';
}

$fetchid=mysqli_query($con,"SELECT MAX(`id`) as 'oid' FROM `orders_info`");
$fetchsuccess=mysqli_fetch_assoc($fetchid);
$oid=$fetchsuccess['oid']+1;
$orderno = '000'.$oid;

$insert_orders = "INSERT INTO `orders_info`(`orderno`,`name`, `email`, `phone`, `address`, `orderdescription`, `paymentID`, `trxID`, `transactionStatus`, `amount`, `currency`, `intent`, `paymentExecuteTime`, `merchantInvoiceNumber`, `payerReference`, `customerMsisdn`, `statusCode`, `statusMessage`, `deliverystatus`,`create_at`) VALUES ('$orderno','$dname','$demail','$dphone','$daddress','$dorder','$paymentID','$trxID','$transactionStatus','$amount','$currency','$intent','$paymentExecuteTime','$merchantInvoiceNumber','$payerReference','$customerMsisdn','$statusCode','$statusMessage','pending',NOW())";

if(mysqli_query($con,$insert_orders) && sendMail($demail,$orderno)) {
  unset($_SESSION["shopping_cart"]);
  unset($_SESSION['total_cart_amount']);

  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta start  -->
    <?php include("includes/meta.php") ?>
    <!-- meta end  -->
    <!-- link start  -->
    <?php include("includes/link.php") ?>
    <!-- link end  -->
    <!-- website title  -->
    <title>Bkash Payment Success - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
    </title>
</head>
<!-- search bar display none  -->
<style>
#search {
    display: none;
}
</style>

<body>

    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="bg-light d-flex justify-content-center px-2 py-3 row gap-4">
        <div class="col-12">
            <h1 class="text-muted text-center py-2">Bkash Payment Status Successful</h1>
        </div>
        <?php
        $result = mysqli_query($con, "SELECT * from `orders_info` WHERE `email`='$demail' AND `paymentID`='$paymentID' AND `trxID`='$trxID' AND `merchantInvoiceNumber`='$merchantInvoiceNumber' AND `statusMessage`='Successful'");
        $order_fetch = mysqli_fetch_array($result);
        if($order_fetch){
        ?>
        <div class="col-12 col-lg-7 overflow-x-scroll">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-link text-decoration-none"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded">Your
                        orders are below. Order No: <?php echo $order_fetch['orderno']; ?></a></button>
            </div>
            <table class="table table-striped cart-table mt-5">
                <thead>
                    <tr>
                        <th scope="col">Food Name</th>
                        <th scope="col">Food Item No</th>
                        <th scope="col">Food Quantity</th>
                        <th scope="col">Food Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $order_fetch['orderdescription']; ?>
                </tbody>
                <td colspan="4" class="text-center pt-5">
                    <strong>TOTAL PAYMENT: BDT&nbsp;<?php echo $order_fetch['amount']; ?></strong>
                </td>
            </table>
        </div>
        <div class="col-12 col-lg-4">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-link text-decoration-none"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded">Account
                        order details</a></button>
            </div>
            <div class="table table-striped cart-table mt-5">

                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="email">Email</label></h5>
                            <input type="text" id="email" required value="<?php echo $order_fetch['email']; ?>"
                                class="border border-primary form-control px-3 py-2" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="name">Full Name</label></h5>
                            <input type="text" name="name" id="name" required
                                value="<?php echo $order_fetch['name']; ?>" placeholder="Update your full name"
                                class="border border-primary form-control px-3 py-2" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="phone">Phone Number</label></h5>
                            <input type="number" name="phone" id="phone" value="<?php echo $order_fetch['phone']; ?>"
                                placeholder="Update your phone no" class="border border-primary form-control px-3 py-2"
                                required readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="address">Address</label>
                            </h5>
                            <input name="address" id="address" placeholder="Update your address"
                                class="border border-primary form-control px-3"
                                value="<?php echo $order_fetch['address']; ?>" required readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

  
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

    $admins = mysqli_query($con, "SELECT `email` FROM `admin_info` WHERE `verified`='1'");
    while ($adminemail = mysqli_fetch_assoc($admins)) {
        $mail->addBCC($adminemail['email']);     //Add a recipient bcc prevenets other to see emails
    }

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "New Order Received";
    $mail->Body    = "Order no: ".$orderno."<br>
    Please Login to your admin account for more info <a href='".WEBSITE_URL."/admin'>Admin Login</a>";

    $mail->send();
    return true;
} catch (Exception $e) {
    return false;
}



        }
        ?>
    </main>
    <!-- main end  -->
    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->
    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
</body>

</html>

<?php
}else{
  echo '
  <script>
  window.location.href= "cart";
  alert("Please Try Again");
  </script>
  ';
}
}

}else{
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta start  -->
    <?php include("includes/meta.php") ?>
    <!-- meta end  -->
    <!-- link start  -->
    <?php include("includes/link.php") ?>
    <!-- link end  -->
    <!-- website title  -->
    <title>Bkash Payment Failed - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
    </title>
</head>
<!-- search bar display none  -->
<style>
#search {
    display: none;
}
</style>

<body>

    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <main class="bg-light d-flex justify-content-center px-2 py-3 row gap-4">
        <div class="col-12">
            <h1 class="text-muted text-center py-2">Bkash Payment Status Failed</h1>
            <h3 class="text-muted text-center py-2">Some Error Occured</h3>
            <h4 class="text-muted text-center py-2">Please try again</h4>
        </div>
        <div class="col-12 col-lg-7 overflow-x-scroll">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-link text-decoration-none"><a href="cart"
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded">Go to
                        Cart</a></button>
            </div>
        </div>
    </main>
    <!-- main end  -->
    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->
    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
</body>

</html>
<?php
}
?>