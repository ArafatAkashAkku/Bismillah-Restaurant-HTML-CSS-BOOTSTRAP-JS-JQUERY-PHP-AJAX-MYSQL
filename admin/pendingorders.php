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
    <title>Pending Orders - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>

<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="px-2 py-3 overflow-x-scroll">
        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Serial</th>
                    <th>OrderNo</th>
                    <th>BkashNo</th>
                    <th>Amount</th>
                    <th>PaymentID</th>
                    <th>Transaction</th>
                    <th>InvoiceNo</th>
                    <th>DeliveryStatus</th>
                    <th>OrderedAt</th>
                    <th>DeliveredAt</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $result = mysqli_query($con, "SELECT * from `orders_info` WHERE `deliverystatus`='pending' AND `statusMessage`='Successful' ORDER BY `id` DESC");
            if(mysqli_num_rows($result)>0){
                $serial = 0;
                while($order_fetch = mysqli_fetch_array($result)){
                $serial =$serial + 1;
                ?>
                <tr>
                    <td><?php echo $serial; ?> </td>
                    <td><?php echo $order_fetch['orderno']; ?></td>
                    <td><?php echo $order_fetch['customerMsisdn']; ?></td>
                    <td>BDT&nbsp;<?php echo $order_fetch['amount']; ?></td>
                    <td><?php echo $order_fetch['paymentID']; ?></td>
                    <td><?php echo $order_fetch['trxID']; ?></td>
                    <td><?php echo $order_fetch['merchantInvoiceNumber']; ?></td>
                    <td class="text-center"><?php if($order_fetch['deliverystatus']=="pending"){
                        echo '
                        <span class="badge rounded-pill text-bg-danger">pending</span>
                        ';
                    }elseif($order_fetch['deliverystatus']=="delivered"){
                        echo '
                        <span class="badge rounded-pill text-bg-success">delivered</span>
                        ';
                    }elseif($order_fetch['deliverystatus']=="canceled"){
                        echo '
                        <span class="badge rounded-pill text-bg-warning">canceled</span>
                        ';
                    } ?></td>
                    <td><?php echo $order_fetch['create_at']; ?></td>
                    <td><?php if($order_fetch['deliverystatus']=="pending"){ echo '
                        <span class="badge rounded-pill text-bg-danger">pending</span>
                        ';}elseif($order_fetch['deliverystatus']=="canceled"){
                            echo '
                            <span class="badge rounded-pill text-bg-warning">canceled</span>
                            ';
                        }else{ echo $order_fetch['update_at'];} ?>
                    </td>
                    <td><a href="orderdetails?orderno=<?php echo $order_fetch['orderno']; ?>">Details</a></td>
                </tr>
                <?php 
            }
            }
            ?>
            </tbody>

        </table>
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
    new DataTable('#example');
    </script>
    <!-- internal script end  -->
</body>

</html>