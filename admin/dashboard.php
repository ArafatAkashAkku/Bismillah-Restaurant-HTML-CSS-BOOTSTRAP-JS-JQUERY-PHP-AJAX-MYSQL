    <!-- require start  -->
    <?php include("includes/require.php") ?>
    <!-- require end  -->
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
        <title>Admin Dashboard - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
        </title>
    </head>

    <body>
        <!-- header start  -->
        <?php include("includes/header.php") ?>
        <!-- header end  -->
        <!-- main start  -->
        <main class="px-2 py-3">
            <div class="row d-flex justify-content-center px-2 py-3 gap-3 text-center">

                <div class="card col-lg-3 col-12 border border-warning shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-between">
                        <h1 class="card-title">Pending Orders</h1>
                        <h2 class="card-text"> 
                        <?php 
                        $totalorderspending = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `orders_info` WHERE `deliverystatus`='pending'"));
                        echo $totalorderspending; 
                        ?>
                        </h2>
                    </div>
                </div>

                <div class="card col-lg-3 col-12 border border-warning shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-between">
                        <h1 class="card-title">Delivered Orders</h1>
                        <h2 class="card-text">
                        <?php 
                        $totalordersdelivered = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `orders_info` WHERE `deliverystatus`='delivered'"));
                        echo $totalordersdelivered; 
                        ?>
                        </h2>
                    </div>
                </div>

                <div class="card col-lg-3 col-12 border border-warning shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-between">
                        <h1 class="card-title">Total Orders</h1>
                        <h2 class="card-text"> 
                        <?php 
                        $totalorders = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `orders_info`"));
                        echo $totalorders; 
                        ?>
                        </h2>
                    </div>
                </div>

                <div class="card col-lg-3 col-12 border border-warning shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-between">
                        <h1 class="card-title">Active Food Item</h1>
                        <h2 class="card-text">
                        <?php 
                        $activefooditem = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `food_info` WHERE `status`='active'"));
                        echo $activefooditem; 
                        ?>
                        </h2>
                    </div>
                </div>

                <div class="card col-lg-3 col-12 border border-warning shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-between">
                        <h1 class="card-title">Total Food Item</h1>
                        <h2 class="card-text">
                        <?php 
                        $totalfooditem = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `food_info`"));
                        echo $totalfooditem; 
                        ?>
                        </h2>
                    </div>
                </div>

                <div class="card col-lg-3 col-12 border border-warning shadow-lg">
                    <div class="card-body d-flex flex-column align-items-center justify-content-between">
                        <h1 class="card-title">Verified Users</h1>
                        <h2 class="card-text">
                        <?php 
                        $verifieduser = mysqli_num_rows(mysqli_query($con, "SELECT * FROM `user_info` WHERE `verified`='1'"));
                        echo $verifieduser; 
                        ?>
                        </h2>
                    </div>
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