<!-- require start  -->
<?php include("includes/require.php") ?>
<!-- require end  -->
<?php
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
    $email = $_SESSION['user_email'];
    $id = $_SESSION['user_id'];
    $token = $_SESSION['user_token'];
    $user_exist = "SELECT * FROM `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'";
    $result = mysqli_query($con, $user_exist);
    $user_fetch = mysqli_fetch_assoc($result);
}else{
    header("Location: index");
}
?>

<?php

require_once('vendor/autoload.php');

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

if (isset($_GET['amount'])) {
$amount = $_GET['amount'];
$total = $_SESSION['total_cart_amount'];
if( strlen($user_fetch['name']) < 5 || strlen($user_fetch['phone']) < 11 || strlen($user_fetch['address']) < 10){
    echo '
    <script>
    window.location.href="account";
    alert("Please update your information including name, phone, address");
    </script>
    ';
}elseif($amount == ''){
    echo '
    <script>
    window.location.href="index";
    alert("Please add to cart at least one item");
    </script>
    ';
}elseif($amount == 0){
    echo '
    <script>
    window.location.href="index";
    alert("Please add to cart at least one item");
    </script>
    ';
}elseif($amount == $total){

// if($amount==$total_price){

$InvoiceNumber = 'FoodItem'.rand();


// Strat Create Payment
$auth = $id_token;
$requestbody = array(
'mode' => '0011',
'amount' => $amount,
'currency' => 'BDT',
'intent' => 'sale',
'payerReference' => $InvoiceNumber,
'merchantInvoiceNumber' => $InvoiceNumber,
'callbackURL' => $callbackURL
);
$url = curl_init($base_url.'/v1.2.0-beta/tokenized/checkout/create');
$requestbodyJson = json_encode($requestbody);
$header = array(
'Content-Type:application/json',
'Authorization:'.$auth,
'X-APP-Key:'.$app_key
);
curl_setopt($url, CURLOPT_HTTPHEADER, $header);
curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
curl_setopt($url, CURLOPT_POSTFIELDS, $requestbodyJson);
curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
$resultdata = curl_exec($url);
curl_close($url);
$obj = json_decode($resultdata);
header("Location: " . $obj->{'bkashURL'});
// End Create Payment
}
else{
    echo '
    <script>
    window.location.href="cart";
    alert("Sorry, Please Try Again Later!!! Thank You!!");
    </script>
    ';
}
}
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
    <title>Cart - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>
<!-- search bar display none  -->
<style>
#search {
    display: none;
}
</style>

<body>
    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <?php
if (isset($_POST['action']) && $_POST['action'] == "remove") {
        if (!empty($_SESSION["shopping_cart"])) {
            foreach ($_SESSION["shopping_cart"] as $key => $value) {
                if ($_POST["item"] == $key) {
                    unset($_SESSION["shopping_cart"][$key]);
                    echo '
                    <script>
                    Swal.fire({
                        title: "Food is removed from your cart",
                        icon: "success"
                        });   
                    </script>
                    ';
                }
                if (empty($_SESSION["shopping_cart"]))
                    unset($_SESSION["shopping_cart"]);
                    unset($_SESSION['total_cart_amount']);
            }
        }
    }
if (isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION["shopping_cart"] as &$value) {
        if ($value['item'] === $_POST["item"]) {
            $value['quantity'] = $_POST["quantity"];
            echo '
            <script>
            window.location.href="cart";
            </script>
            ';
            break; // Stop the loop after we've found the product
         }
    }
}
?>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="bg-light d-flex justify-content-center px-2 py-3 row gap-4">

        <div class="col-12 col-lg-7 overflow-x-scroll">
            <div class="d-flex justify-content-between align-items-center cart-buttons">
                <button class="btn btn-link text-decoration-none "><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded"
                        href="orderhistory">Order History</a></button>
                <button class="btn btn-link text-decoration-none"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded"
                        href="index">Continue buying</a></button>
            </div>
            <?php
            if (isset($_SESSION["shopping_cart"])) {
                $total_price = 0;
            ?>
            <table class="table table-striped cart-table mt-5">
                <thead>
                    <tr>
                        <th scope="col">Food Image</th>
                        <th scope="col">Food Name</th>
                        <th scope="col">Food Quantity</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Item Price</th>
                        <th scope="col">Remove Item</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($_SESSION["shopping_cart"] as $food) {
                        ?>
                    <tr>
                        <td>
                            <?php
                            if($food["image"]==""){
                                ?>
                            <img src='images/default/noimage.jpg' width="70" height="50" alt="No Image"
                                loading="lazy" />

                            <?php
                            }else{
                                ?>
                            <img src='images/food/<?php echo ($food['id']);?>/<?php echo $food["image"]; ?>' width="70"
                                height="50" alt="<?php echo $food["name"]; ?>" loading="lazy" />
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo substr($food["name"],0,20) . '...'; ?></td>
                        <td>
                            <form method='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
                                <input type='hidden' name='item' value="<?php echo $food["item"]; ?>" />
                                <input type='hidden' name='action' value="change" />
                                <select name='quantity' class='quantity' onchange="this.form.submit()">
                                    <option <?php if ($food["quantity"] == 1) echo "selected"; ?> value="1">1
                                    </option>
                                    <option <?php if ($food["quantity"] == 2) echo "selected"; ?> value="2">2
                                    </option>
                                    <option <?php if ($food["quantity"] == 3) echo "selected"; ?> value="3">3
                                    </option>
                                    <option <?php if ($food["quantity"] == 4) echo "selected"; ?> value="4">4
                                    </option>
                                    <option <?php if ($food["quantity"] == 5) echo "selected"; ?> value="5">5
                                    </option>
                                    <option <?php if ($food["quantity"] == 6) echo "selected"; ?> value="6">6
                                    </option>
                                    <option <?php if ($food["quantity"] == 7) echo "selected"; ?> value="7">7
                                    </option>
                                    <option <?php if ($food["quantity"] == 8) echo "selected"; ?> value="8">8
                                    </option>
                                    <option <?php if ($food["quantity"] == 9) echo "selected"; ?> value="9">9
                                    </option>
                                    <option <?php if ($food["quantity"] == 10) echo "selected"; ?> value="10">10
                                    </option>
                                </select>
                            </form>
                        </td>
                        <td><?php echo "BDT&nbsp;" . $food["price"]; ?></td>
                        <td><?php echo "BDT&nbsp;" . $food["price"] * $food["quantity"]; ?></td>
                        <td>
                            <form method='POST' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>'>
                                <input type='hidden' name='item' value="<?php echo $food["item"]; ?>" />
                                <input type='hidden' name='action' value="remove" />
                                <button type='submit'
                                    class='remove px-3 py-1 bg-danger border text-light border-warning rounded'><span
                                        class="desktop-logo"> Remove Food </span> <span class="mobile-logo"><i
                                            class="fa-solid fa-trash"></i></span></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                <?php
                            $total_price += ($food["price"] * $food["quantity"]);
                        }
                ?>
                <td colspan="7" class="text-center pt-5">
                    <?php $_SESSION['total_cart_amount'] = $total_price; ?>
                    <strong>TOTAL PRICE: <?php echo "BDT&nbsp;" . $total_price; ?></strong>
                </td>
            </table>
            <?php
                    $ret = mysqli_query($con, "SELECT * from `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'");
                    $row = mysqli_fetch_array($ret);
                    if ($row) {
                     if(empty(trim($row["name"])) || empty(trim($row["phone"])) || empty(trim($row["address"]))){
                        echo '
                        <div class="text-center border bg-warning border-warning rounded my-4">
                        <a href="account"><button class="btn btn-width btn-outline-warning text-dark">Missing some information please update account to purchase</button></a>
                        </div>
                        ';
                     }else{
                        echo '
                        <div class="text-center bg-warning border border-warning rounded my-4">
                        <a href="?amount='. $total_price . '"><button class="btn btn-width btn-outline-warning text-dark">Pay With Bkash<img src="images/default/bkash.png" alt="Bkash"  width="30" height="30" loading="lazy" class="border rounded-circle ms-2"></button></a>
                        </div>
                        ';
                     }                                                             
            
                    } 
            } else {
               echo '
                <h3 class="text-center mt-4">Your cart is empty!</h3>
                ';
            }
            ?>
        </div>
        <div class="col-12 col-lg-4">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-link text-decoration-none"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded"
                        href="account">Account order details</a></button>
            </div>
            <div class="table table-striped cart-table mt-5">
                <?php
                    $ret = mysqli_query($con, "SELECT * from `user_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'");
                    $row = mysqli_fetch_array($ret);
                    if ($row) {
                    ?>
                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="email">Email</label></h5>
                            <input type="text" id="email" required value="<?php echo htmlentities($row["email"]); ?>"
                                class="border border-primary form-control px-3 py-2" readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="name">Full Name</label></h5>
                            <input type="text" name="name" id="name" required value="<?php
                                                                                                echo htmlentities($row["name"]);
                                                                                                ?>"
                                placeholder="Update your full name" class="border border-primary form-control px-3 py-2"
                                readonly>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <div class="input-field">
                            <h5 class="text-muted"><label for="phone">Phone Number</label></h5>
                            <input type="number" name="phone" id="phone" value="<?php
                                                                                                echo htmlentities($row["phone"]);
                                                                                                ?>"
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
                                value="<?php echo htmlentities($row["address"]); ?>" required readonly>
                        </div>
                    </div>
                </div>
                <?php
                    } 
                    ?>
            </div>
        </div>

    </main>
    <!-- main end  -->
    <!-- footer start  -->
    <?php include("includes/footer.php") ?>
    <!-- footer end  -->
</body>

</html>