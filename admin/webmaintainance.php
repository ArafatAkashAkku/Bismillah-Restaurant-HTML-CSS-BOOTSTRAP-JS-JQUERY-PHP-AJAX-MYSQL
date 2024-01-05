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
    <title>Website Maintainance - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?>
    </title>
</head>

<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <?php
                    $ret = mysqli_query($con, "SELECT * from `website_info` WHERE `id`='1'");
                    $row = mysqli_fetch_array($ret);
                    if ($row) {
                    ?>
    <!-- main start  -->
    <main class="d-flex flex-column align-items-center justify-content-center bg-<?php 
                            if($row['maintainance']=='off'){ 
                                echo 'success';
                                }elseif($row['maintainance']=='on'){ echo 'danger';};
                                ?>">
        <div class="d-flex flex-column align-items-center justify-content-center py-2">
            <div class="px-2">
                <h2 class="text-light text-center pt-2">Maintainance Mood is <?php if($row['maintainance']=='off'){ echo 'off';}elseif($row['maintainance']=='on'){ echo 'on';};
                                ?> right now</h2>
                <form autocomplete="off" id="webmaintainancemood-form">
                    <div class="row gap-2 d-flex justify-content-center mt-5">
                        <input type="hidden" name="maintainance" value="<?php if($row['maintainance']=='off'){ echo 'on';}elseif($row['maintainance']=='on'){ echo 'off';};
                                ?>">
                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field text-center">
                                    <button class="btn px-5 btn-outline-<?php 
                            if($row['maintainance']=='off'){ 
                                echo 'danger';
                                }elseif($row['maintainance']=='on'){ echo 'success';};
                                ?> text-light bg-<?php 
                            if($row['maintainance']=='off'){ 
                                echo 'danger';
                                }elseif($row['maintainance']=='on'){ echo 'success';};
                                ?>" id="webmaintainance" type="submit">Maintainance Mood turn <?php if($row['maintainance']=='off'){ echo 'on';}elseif($row['maintainance']=='on'){ echo 'off';};
                                ?> ??</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

    </main>
    <?php
}
                    ?>
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
        $("#webmaintainance").on('click', function(e) {
            e.preventDefault();
            let webmaintainancemoodForm = $("#webmaintainancemood-form").serialize();
            Swal.fire({
                title: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, turn maintainance mood <?php if($row['maintainance']=='off'){ echo 'on';}elseif($row['maintainance']=='on'){ echo 'off';};
                                ?>"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "webmaintainancemood.php",
                        type: "POST",
                        data: webmaintainancemoodForm,
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
                                    text: "Try again later",
                                    icon: "error"
                                });
                            } else if (data == 1) {
                                Swal.fire({
                                    position: "top-center",
                                    icon: "success",
                                    title: "Website Maintainace Turned <?php if($row['maintainance']=='off'){ echo 'on';}elseif($row['maintainance']=='on'){ echo 'off';};
                                ?>",
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                                setTimeout(() => {
                                    window.location.href =
                                        "webmaintainance";
                                }, 2100);
                            }
                        }
                    });
                }
            });



        });

    });
    </script>
    <!-- internal script end  -->
</body>

</html>