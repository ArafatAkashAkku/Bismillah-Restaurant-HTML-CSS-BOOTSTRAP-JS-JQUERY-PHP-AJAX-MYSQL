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
        <title>Food Items - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
        </title>
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
                        <th>Image</th>
                        <th>Name</th>
                        <th>About</th>
                        <th>Price</th>
                        <th>ItemNo</th>
                        <th>Status</th>
                        <th>ItemEdit</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
        $food_exist = "SELECT * FROM `food_info` ORDER BY `id` DESC";
        $result = mysqli_query($con, $food_exist);
        $serial = 0;
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
            while($food_fetch = mysqli_fetch_assoc($result)){
                $serial = $serial + 1;
                ?>
                    <tr>
                        <td><?php echo $serial;?></td>
                        <td>
                            <a href="<?php 
                            if($food_fetch['image']==""){
                            echo '../images/default/noimage.jpg';
                            }else{
                                echo '../images/food/'; echo $food_fetch['id']; echo '/'; echo $food_fetch['image'];
                            };
                            ?>" target="_blank">
                                <img width="75" loading="lazy" height="60" src="
                            <?php 
                            if($food_fetch['image']==""){
                            echo '../images/default/noimage.jpg" alt="No Image Found">';
                            }else{
                                echo '../images/food/'; echo $food_fetch['id']; echo '/'; echo $food_fetch['image']; echo '" alt="'; echo $food_fetch["name"]; echo '">';
                            };
                            ?>
                            </a>
                        </td>
                        <td><?php echo substr($food_fetch['name'],0,15).'...';?></td>
                        <td><?php echo substr($food_fetch['about'],0,15).'...';?></td>
                        <td>BDT&nbsp;<?php echo $food_fetch['price'];?></td>
                        <td><?php echo $food_fetch['itemno'];?></td>
                        <td><?php 
                        if($food_fetch['status']=='active'){
                            echo '
                            <span class="badge rounded-pill text-light bg-success">Active</span>
                            ';
                        }elseif($food_fetch['status']=='inactive'){
                            echo '
                            <span class="badge rounded-pill text-light bg-danger">Inactive</span>
                            ';
                        };
                        ?></td>
                        <td><a href=" fooditemedit?id=<?php echo $food_fetch['id'];?>"><span class="desktop-logo">Edit Item</span><span class="mobile-logo"><i class="fa-solid fa-pen-to-square"></i></span></a>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Serial</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>About</th>
                        <th>Price</th>
                        <th>Item no</th>
                        <th>Status</th>
                        <th>Item Edit</th>
                    </tr>
                </tfoot>
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