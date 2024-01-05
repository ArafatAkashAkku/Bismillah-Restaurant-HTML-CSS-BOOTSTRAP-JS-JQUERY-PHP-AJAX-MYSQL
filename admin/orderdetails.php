<?php 
// require start
include("includes/require.php");
// require end
?>
<?php
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] == true) {
    $email = $_SESSION['admin_email'];
    $id = $_SESSION['admin_id'];
    $token = $_SESSION['admin_token'];
}else{
    header("Location: index");
}

if(isset($_GET['orderno'])){
    $orderno = $_GET['orderno'];
}else{
    echo '
    <script>
    window.location.href= "orders";
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
    <title>Order Details - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>

<body>

    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="bg-light d-flex justify-content-center px-2 py-3 row gap-4">
        <?php
        $result = mysqli_query($con, "SELECT * from `orders_info` WHERE `orderno`='$orderno' AND `statusMessage`='Successful'");
        $order_fetch = mysqli_fetch_array($result);
        if($order_fetch){
        ?>
        <div class="d-flex flex-column justify-content-center align-items-center">
            <label for="deliverystatus">
                <h2>Update Status</h2>
            </label>
            <form id="deliverystatus-form">
                <input type="hidden" name="email" value="<?php echo $order_fetch['email']; ?>">
                <input type="hidden" name="orderno" value="<?php echo $order_fetch['orderno']; ?>">
                <select name="deliverystatus" id="deliverystatus"  required
                                        class="border border-primary form-control px-3 py-2">
                    <option value="delivered" <?php if ($order_fetch["deliverystatus"] == 'delivered') {
                                                                        echo "selected";
                                                                    } ?>>Delivered</option>
                    <option value="pending" <?php if ($order_fetch["deliverystatus"] == 'pending') {
                                                                        echo "selected";
                                                                    } ?>>Pending</option>
                    <option value="canceled" <?php if ($order_fetch["deliverystatus"] == 'canceled') {
                                                                        echo "selected";
                                                                    } ?>>Canceled</option>
                </select>
                <button class="btn px-5 mt-3 btn-outline-warning text-dark bg-warning" id="deliverystatusinfo" type="submit">Update Order Status</button>
            </form>
        </div>
        <div class="col-12 col-lg-7 overflow-x-scroll">
            <div class="d-flex justify-content-center align-items-center">
                <button class="btn btn-link text-decoration-none"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded">Order
                        No: <?php echo $order_fetch['orderno']; ?></a></button>
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
        }else{
            echo '
            <script>
            window.location.href= "orders";
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
      <!-- internal script start  -->
      <script>
    // jquery ready start 
    $(document).ready(function() {
        // updating password php ajax code 
        $("#deliverystatus-form").on('submit', function(e) {
            e.preventDefault();
            let deliverystatusInfo = $('#deliverystatus-form').serialize();
            $.ajax({
                url: "orderdetailsupdate.php",
                type: "POST",
                data: deliverystatusInfo,
                success: function(data) {
                    if (data == 3) {
                        Swal.fire({
                            title: "Query Problem",
                            text: "Can not run query",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        Swal.fire({
                            title: "Server Down",
                            text: "Please try again later",
                            icon: "error"
                        });
                    } else if (data == 1) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Order Status Updated",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 2100);
                    }
                }
            });
        });


    });
    </script>
    <!-- internal script end  -->
</body>

</html>