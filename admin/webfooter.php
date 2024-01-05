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
    <title>Website Configuration Footer - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
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
                <h2 class="text-muted text-center pt-2">Update Website Footer Info</h2>
                <form autocomplete="off" id="webfooterinfo-form">
                    <div class="row gap-2 d-flex justify-content-center">

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="facebook">Website Facebook</label></h5>
                                    <input type="text" name="facebook" id="facebook" value="<?php
                                                                                        echo htmlentities($row["facebook"]);
                                                                                        ?>"
                                        placeholder="Enter website facebook"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="instagram">Website Instagram</label></h5>
                                    <input placeholder="Enter website instagram" type="text" name="instagram" id="instagram" value="<?php echo htmlentities($row["instagram"]); ?>"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="twitter">Website Twitter</label>
                                    </h5>
                                    <input type="text" name="twitter" id="twitter" value="<?php
                                                                                        echo htmlentities($row["twitter"]);
                                                                                        ?>"
                                        placeholder="Enter website twitter"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="youtube">Website Youtube</label></h5>
                                    <input type="text" id="youtube" name="youtube" placeholder="Enter website youtube" value="<?php
                                        echo htmlentities($row["youtube"]);
                                        ?>" class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field text-center">
                                    <h6 class="text-center">Year <span class="update-year"></span> is auto updated. No need to worry about.</h6>
                                    <button class="btn px-5 btn-outline-warning text-dark bg-warning" id="webfooterinfo"
                                        type="submit">Update Website Footer</button>
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
        $("#webfooterinfo-form").on('submit', function(e) {
            e.preventDefault();
            let webfooterInfoForm = new FormData(this);

            $.ajax({
                url: "webfooterupdate.php",
                type: "POST",
                data: webfooterInfoForm,
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
                    } else if (data == 4) {
                        Swal.fire({
                            position: "top-center",
                            icon: "success",
                            title: "Website Footer info updated",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "webfooter";
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