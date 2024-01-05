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
    <title>Edit Food Item - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>

<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->

    <?php
    if(isset($_GET['id'])){
        $foodid=$_GET['id'];
        $food_exist = "SELECT * FROM `food_info` WHERE `id`='$foodid'";
        $result = mysqli_query($con, $food_exist);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $food_fetch = mysqli_fetch_assoc($result);
    ?>

    <!-- main start  -->
    <main class="bg-light">
        <div class="d-flex flex-column align-items-center justify-content-center py-2">
            <div class="bg-light px-2">
                <h2 class="text-muted text-center pt-2">Edit Food Item</h2>
                <form autocomplete="off" id="editfooditem-form">
                    <div class="row gap-2 d-flex justify-content-center">
                        <div class="col-12 text-center d-flex align-items-center justify-content-center">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <?php
                                    if($food_fetch["image"]==""){                          
                                    ?>
                                    <img src="../images/default/noimage.jpg" width="150" height="150"
                                        class="border rounded preview-image" alt="No Image" loading="lazy">
                                    <?php
                                    }else{
                                    ?>
                                    <img src="../images/food/<?php echo htmlentities($food_fetch["id"]);?>/<?php echo htmlentities($food_fetch["image"]);?>"
                                        width="150" height="150" class="border rounded preview-image"
                                        alt="<?php echo htmlentities($food_fetch["name"]);?>" loading="lazy">
                                    <?php
                                    }
                                    ?>
                                    <h5 class="text-muted"><label for="image" class="pointer-event">Upload Food Photo
                                            (jpg / jpeg)
                                            <br> click here... <i class="fa-solid fa-file-arrow-up link"></i></label>
                                    </h5>
                                    <input type="hidden" name="oldimage"
                                        value="<?php echo htmlentities($food_fetch["image"]);?>">
                                    <input type="hidden" name="foodid"
                                        value="<?php echo htmlentities($food_fetch["id"]);?>">
                                    <input type="file" class="imageupload" id="image" name="image"
                                        class="mt-2 border border-primary px-3 py-2" accept=".jpg,.jpeg">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="name">Food Name</label></h5>
                                    <input type="text" name="name" id="name"
                                        value="<?php echo htmlentities($food_fetch["name"]);?>" required
                                        placeholder="Enter food name"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="about">Food About</label></h5>
                                    <input required value="<?php echo htmlentities($food_fetch["about"]);?>"
                                        placeholder="Enter food about" name="about" type="text" id="about"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="price">Food Price BDT</label>
                                    </h5>
                                    <input value="<?php echo htmlentities($food_fetch["price"]);?>" type="number"
                                        name="price" id="price" required placeholder="Enter food price"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="status">Food Visibility Status</label>
                                    </h5>
                                    <select class="border border-primary form-control px-3 py-2" name="status" required id="status" placeholder="Select food visibility status">
                                        <option value="active"<?php if($food_fetch["status"]=="active"){ echo "selected"; } ?>>Active</option>
                                        <option value="inactive"<?php if($food_fetch["status"]=="inactive"){ echo "selected"; } ?>>Inactive</option>
                                    </select>                                  
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field text-center">
                                    <button class="btn px-5 btn-outline-warning text-dark bg-warning" id="editfooditem"
                                        type="submit">Edit Food Item</button>
                                </div>
                            </div>
                        </div>
                </form>

            </div>
        </div>

    </main>
    <!-- main end  -->


    <?php
            }else{
                echo '
                <script>
                window.location.href="404";
                </script>
                ';
            }
        }
    }
    ?>
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
        // updating account php ajax code start
        $("#editfooditem-form").on('submit', function(e) {
            e.preventDefault();
            let editfooditemForm = new FormData(this);

            $.ajax({
                url: "fooditemedited.php",
                type: "POST",
                data: editfooditemForm,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data == 5) {
                        Swal.fire({
                            title: "Server Down",
                            text: "Please try again later",
                            icon: "error"
                        });
                    } else if (data == 9) {
                        Swal.fire({
                            title: "Query Problem",
                            text: "Can not run query",
                            icon: "error"
                        });
                    } else if (data == 8) {
                        Swal.fire({
                            title: "You cant upload a file here",
                            text: "Please try again later",
                            icon: "error"
                        });
                    } else if (data == 7) {
                        Swal.fire({
                            title: "There was an error uploading your file",
                            text: "Please try again later",
                            icon: "error"
                        });
                    } else if (data == 6) {
                        Swal.fire({
                            title: "Your file is too big",
                            text: "Upload file less than 10mb",
                            icon: "error"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Food Item Edited Successfully",
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