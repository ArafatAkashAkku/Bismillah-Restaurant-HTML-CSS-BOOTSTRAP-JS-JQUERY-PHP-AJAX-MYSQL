<?php 

session_start();

session_unset();

session_destroy();

header("Location: login");

?>


<tbody>
                <?php
            $result = mysqli_query($con, "SELECT * from `orders_info` WHERE `email`='$email' AND `statusMessage`='Successful' ORDER BY `id` DESC");
            if(mysqli_num_rows($result)>0){
                $serial = 0;
                $serial =$serial + 1;
            while($order_fetch = mysqli_fetch_array($result)){
                ?>
                <tr>
                    <td>
                        <?php echo $serial; ?> </td>
                    <td>
                        <?php echo $order_fetch['orderdescription']; ?> </td>
                </tr>
                <?php 
            }
            }else{
                ?>
                <tr>
                    <td colspan="4" class="text-center">No orders found</td>
                </tr>
                <?php
            }
            ?>
            </tbody>