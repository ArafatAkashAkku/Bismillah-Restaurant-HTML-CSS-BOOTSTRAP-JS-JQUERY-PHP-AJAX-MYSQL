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
    <title>Website Configuration Seo - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
    </title>
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
                <h2 class="text-muted text-center pt-2">Update Website Seo Info</h2>
                <form autocomplete="off" id="webseoinfo-form">
                    <div class="row gap-2 d-flex justify-content-center">

                        <div class="col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="description">Website Description</label></h5>
                                    <textarea name="description" id="description" cols="30" rows="10"
                                        placeholder="Enter website description"
                                        class="border border-primary form-control px-3 py-2"><?php echo htmlentities($row["description"]); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="keywords">Website Keywords</label></h5>
                                    <textarea name="keywords" id="keywords" cols="30" rows="10"
                                        placeholder="Enter website keywords"
                                        class="border border-primary form-control px-3 py-2"><?php echo htmlentities($row["keywords"]); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="author">Website Author</label></h5>
                                    <input type="text" name="author" id="author" value="<?php
                                                                                        echo htmlentities($row["author"]);
                                                                                        ?>"
                                        placeholder="Enter website author"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="favicon">Website Favicon (.ico)</label></h5>
                                    <?php
                                            if ($row['favicon'] == '') {
                                            ?>
                                    <img src="../images/default/favicon.ico" width="80" height="80"
                                        class="img-fluid preview-image" alt="No Image" loading="lazy">
                                    <?php
                                            } else {
                                            ?>
                                    <img src="../images/favicon/<?php echo htmlentities($row["favicon"]); ?>" width="80"
                                        height="80" class="img-fluid preview-image"
                                        alt="<?php echo htmlentities($row["name"]); ?>" loading="lazy">
                                    <?php
                                            }
                                            ?>
                                    <h5 class="text-muted"><label for="favicon" class="pointer-event">Choose ico file...
                                            <i class="fa-solid fa-file-arrow-up link"></i></label></h5>
                                    <input type="hidden" name="oldimage"
                                        value="<?php echo htmlentities($row["favicon"]); ?>">
                                    <input type="file" class="imageupload" id="favicon" name="updateimage"
                                        class="mt-2 border border-primary px-3 py-2" accept=".ico">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field text-center">
                                    <button class="btn px-5 btn-outline-warning text-dark bg-warning" id="webfooterinfo"
                                        type="submit">Update Website Seo</button>
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
        $("#webseoinfo-form").on('submit', function(e) {
            e.preventDefault();
            let webseoInfoForm = new FormData(this);

            $.ajax({
                url: "webseoupdate.php",
                type: "POST",
                data: webseoInfoForm,
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
                            text: "Upload file less than 100kb",
                            icon: "error"
                        });
                    } else if (data == 4) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Website Seo info updated",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "webseo";
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