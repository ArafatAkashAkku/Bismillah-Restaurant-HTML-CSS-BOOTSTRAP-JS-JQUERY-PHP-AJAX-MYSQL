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
      $demail = $user_fetch["email"];
    }
}else{
    header("Location: index");
}

if(isset($_GET['orderno'])){
    $orderno = $_GET['orderno'];
}else{
    echo '
    <script>
    window.location.href= "orderhistory";
    </script>
    ';
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
    <title>Order Details - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
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
        <?php
        $result = mysqli_query($con, "SELECT * from `orders_info` WHERE `email`='$demail' AND `orderno`='$orderno' AND `statusMessage`='Successful'");
        $order_fetch = mysqli_fetch_array($result);
        if($order_fetch){
        ?>
        <div class="col-12 col-lg-7 overflow-x-scroll">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-link text-decoration-none"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded">Order No: <?php echo $order_fetch['orderno']; ?></a></button>
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
                    <strong>TOTAL PAYMENT: BDT:&nbsp;<?php echo $order_fetch['amount']; ?></strong>
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
        }else{
            echo '
            <script>
            window.location.href= "orderhistory";
            </script>
            ';
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