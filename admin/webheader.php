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
    <title>Website Configuration Header - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>
<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->

    <!-- main start  -->
    <main class="bg-light">
        <div class="d-flex flex-column align-items-center justify-content-center py-2">
            <div class="bg-light px-2">
                <?php
                    $ret = mysqli_query($con, "SELECT * from `website_info` WHERE `id`='1'");
                    $row = mysqli_fetch_array($ret);
                    if ($row) {
                    ?>
                <h2 class="text-muted text-center pt-2">Update Website Header Info</h2>
                <form autocomplete="off" id="webheader-form">
                    <div class="row gap-2 d-flex justify-content-center">

                        <div class="col-12 text-center d-flex align-items-center justify-content-center">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <?php
                                            if ($row['logo'] == '') {
                                            ?>
                                    <img src="../images/default/logo.png" width="150" height="150"
                                        class="border rounded-circle preview-image" alt="No Image" loading="lazy">
                                    <?php
                                            } else {
                                            ?>
                                    <img src="../images/logo/<?php echo htmlentities($row["logo"]); ?>"
                                        width="150" height="150" class="border rounded-circle preview-image"
                                        alt="<?php echo htmlentities($row["name"]); ?>" loading="lazy">
                                    <?php
                                            }
                                            ?>
                                    <h5 class="text-muted"><label for="image" class="pointer-event">Upload Website PNG Logo <br> click here... <i
                                                class="fa-solid fa-file-arrow-up link"></i></label></h5>
                                    <input type="hidden" name="oldimage"
                                        value="<?php echo htmlentities($row["logo"]); ?>">
                                    <input type="file" class="imageupload" id="image" name="updateimage"
                                        class="mt-2 border border-primary px-3 py-2" accept=".png">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="name">Website Title (Name)</label></h5>
                                    <input type="text" name="name" id="name" value="<?php
                                                                                        echo htmlentities($row["name"]);
                                                                                        ?>"
                                        placeholder="Enter website title or name"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="email">Website Email</label></h5>
                                    <input placeholder="Enter website email" name="email" type="text" id="email" value="<?php echo htmlentities($row["email"]); ?>"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="phone">Website Phone (Bangladesh Digit 11)</label>
                                    </h5>
                                    <input type="text" maxlength="11" name="phone" id="phone" value="<?php
                                                                                        echo htmlentities($row["phone"]);
                                                                                        ?>"
                                        placeholder="Enter website phone no"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="about">Website About</label></h5>
                                    <input type="text" id="about" name="about" placeholder="Enter about your website" value="<?php
                                        echo htmlentities($row["about"]);
                                        ?>" class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field text-center">
                                    <button class="btn px-5 btn-outline-warning text-dark bg-warning" id="webheaderinfo"
                                        type="submit">Update Website Header</button>
                                </div>
                            </div>
                        </div>
                </form>
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
    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <!-- internal script start  -->
    <script>
    // jquery ready start 
    $(document).ready(function() {
        // updating account php ajax code start
        $("#webheader-form").on('submit', function(e) {
            e.preventDefault();
            let webheaderInfoForm = new FormData(this);

            $.ajax({
                url: "webheaderupdate.php",
                type: "POST",
                data: webheaderInfoForm,
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
                            title: "Website Header info updated",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "webheader";
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