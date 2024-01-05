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
        <title>User Information - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
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
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Dob</th>
                        <th>Gender</th>
                        <th>Blood</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>CreatedAt</th>
                        <th>UpdatedAt</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
        $user_exist = "SELECT * FROM `user_info` ORDER BY `id` DESC";
        $result = mysqli_query($con, $user_exist);
        $serial = 0;
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
            while($user_fetch = mysqli_fetch_assoc($result)){
                $serial = $serial + 1;
                ?>
                    <tr>
                        <td><?php echo $serial;?></td>
                        <td><?php
                            if($user_fetch["image"]==""){
                                ?>
                            <img src='../images/default/user.jpg' class="border rounded-circle" width="50" height="50"
                                alt="No Image" loading="lazy" />
                            <?php
                            }else{
                                ?>
                            <a href="../images/users/<?php echo ($user_fetch['id']);?>/<?php echo $user_fetch["image"]; ?>"
                                target="_blank">
                                <img class="border rounded-circle"
                                    src='../images/users/<?php echo ($user_fetch['id']);?>/<?php echo $user_fetch["image"]; ?>'
                                    width="50" height="50" alt="<?php echo $user_fetch["name"]; ?>"
                                    loading="lazy" /></a>
                            <?php
                            }
                            ?>
                        </td>
                        <td><?php echo $user_fetch['name'];?></td>
                        <td><?php echo $user_fetch['email'];?></td>
                        <td><?php echo $user_fetch['phone'];?></td>
                        <td><?php echo $user_fetch['dob'];?></td>
                        <td><?php echo $user_fetch['gender'];?></td>
                        <td><?php echo $user_fetch['blood'];?></td>
                        <td><?php echo $user_fetch['address'];?></td>
                        <td><?php 
                        if($user_fetch['verified']=='1'){
                            echo '
                            <span class="badge rounded-pill text-bg-success">Verified</span>
                            ';
                        }else{
                            echo '
                            <span class="badge rounded-pill text-bg-danger">Not Verified</span>
                            ';
                        };
                        ?></td>
                        <td><?php echo $user_fetch['create_at'];?></td>
                        <td><?php echo $user_fetch['update_at'];?></td>
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
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Dob</th>
                        <th>Gender</th>
                        <th>Blood</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                </tfoot>
            </table>
            <div class="d-flex justify-content-center align-items-center cart-buttons mt-5">
                <button class="btn btn-link text-decoration-none" id="deleteinactiveusers"><a
                        class="text-decoration-none bg-warning text-dark px-3 py-1 border border-warning rounded">Want
                        to delete users Who are not verified??</a></button>
            </div>
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
        <script>
        // jquery ready start 
        $(document).ready(function() {
            // updating account php ajax code start
            $("#deleteinactiveusers").on('click', function() {
                <?php 
                if($website_maintainance=='off'){ 
                ?>
                Swal.fire({
                    title: "Can not delete because of server maintainance is off",
                    text: "Turn On Server Maintainance",
                    icon: "error"
                });
                <?php
                }elseif($website_maintainance=='on'){
                ?>
                Swal.fire({
                    title: "Are you sure?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Delete Users Who Are Not Verified"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Going to delete all users who are not verified",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "deleteuserswhoarenotverified";
                        }, 2100);
                    }
                });
                <?php
                }
                ?>
            });
        });
        </script>
        <!-- internal script end  -->
    </body>

    </html>