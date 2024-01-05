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
    <title>Admin Profile - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
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
                    $ret = mysqli_query($con, "SELECT * from `admin_info` WHERE `email`='$email' AND `id`='$id' AND `v_code`='$token'");
                    $row = mysqli_fetch_array($ret);
                    if ($row) {
                    ?>
                <h2 class="text-muted text-center pt-2">Update account info</h2>
                <form autocomplete="off" id="accountinfo-form">
                    <div class="row gap-2 d-flex justify-content-center">

                        <div class="col-12 text-center d-flex align-items-center justify-content-center">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <?php
                                            if ($row['image'] == '') {
                                            ?>
                                    <img src="../images/default/user.jpg" width="150" height="150"
                                        class="border rounded-circle preview-image" alt="No Image" loading="lazy">
                                    <?php
                                            } else {
                                            ?>
                                    <img src="../images/admins/<?php echo htmlentities($row["id"]); ?>/<?php echo htmlentities($row["image"]); ?>"
                                        width="150" height="150" class="border rounded-circle preview-image"
                                        alt="<?php echo htmlentities($row["name"]); ?>" loading="lazy">
                                    <?php
                                            }
                                            ?>
                                    <h5 class="text-muted"><label for="image" class="pointer-event">Upload Profile
                                            Picture <br> click here... <i
                                                class="fa-solid fa-file-arrow-up link"></i></label></h5>
                                    <input type="hidden" name="oldimage"
                                        value="<?php echo htmlentities($row["image"]); ?>">
                                    <input type="file" class="imageupload" id="image" name="updateimage"
                                        class="mt-2 border border-primary px-3 py-2" accept=".jpg,.jpeg">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="email">Email</label></h5>
                                    <input type="text" id="email" required readonly
                                        value="<?php echo htmlentities($row["email"]); ?>"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="name">Full Name</label></h5>
                                    <input type="text" name="name" id="name" required value="<?php
                                                                                        echo htmlentities($row["name"]);
                                                                                        ?>"
                                        placeholder="Enter your full name"
                                        class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="phone">Phone Number (Bangladesh Digit 11)</label>
                                    </h5>
                                    <input type="text" maxlength="11" name="phone" id="phone" value="<?php
                                                                                        echo htmlentities($row["phone"]);
                                                                                        ?>"
                                        placeholder="Enter your phone no"
                                        class="border border-primary form-control px-3 py-2" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="dob">Date of Birth</label></h5>
                                    <input type="date" id="dob" required name="dob" placeholder="Enter your date of birth" value="<?php
                                        echo htmlentities($row["dob"]);
                                        ?>" class="border border-primary form-control px-3 py-2">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="gender">Gender</label></h5>
                                    <select name="gender" id="gender" required
                                        class="border border-primary form-control px-3 py-2">
                                        <option value="" <?php if ($row["gender"] == '') {
                                                                        echo "selected";
                                                                    } ?>>Select</option>
                                        <option value="male" <?php if ($row["gender"] == 'male') {
                                                                            echo "selected";
                                                                        } ?>>Male</option>
                                        <option value="female" <?php if ($row["gender"] == 'female') {
                                                                            echo "selected";
                                                                        } ?>>Female</option>
                                        <option value="other" <?php if ($row["gender"] == 'other') {
                                                                            echo "selected";
                                                                        } ?>>Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-12">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <h5 class="text-muted"><label for="blood">Blood Group</label></h5>
                                    <select name="blood" id="blood" required
                                        class="border border-primary form-control px-3 py-2">
                                        <option value="" <?php if ($row["blood"] == '') {
                                                                        echo "selected";
                                                                    } ?>>Select</option>
                                        <option value="A+" <?php if ($row["blood"] == 'A+') {
                                                                        echo "selected";
                                                                    } ?>>A+</option>
                                        <option value="A-" <?php if ($row["blood"] == 'A-') {
                                                                        echo "selected";
                                                                    } ?>>A-</option>
                                        <option value="B+" <?php if ($row["blood"] == 'B+') {
                                                                        echo "selected";
                                                                    } ?>>B+</option>
                                        <option value="B-" <?php if ($row["blood"] == 'B-') {
                                                                        echo "selected";
                                                                    } ?>>B-</option>
                                        <option value="O+" <?php if ($row["blood"] == 'O+') {
                                                                        echo "selected";
                                                                    } ?>>O+</option>
                                        <option value="O-" <?php if ($row["blood"] == 'O-') {
                                                                        echo "selected";
                                                                    } ?>>O-</option>
                                        <option value="AB+" <?php if ($row["blood"] == 'AB+') {
                                                                        echo "selected";
                                                                    } ?>>AB+</option>
                                        <option value="AB-" <?php if ($row["blood"] == 'AB-') {
                                                                        echo "selected";
                                                                    } ?>>AB-</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center align-items-center">
                            <div class="form-group py-2">
                                <div class="input-field">
                                    <button class="btn px-5 btn-outline-warning text-dark bg-warning" id="accountinfo"
                                        type="submit">Update Information</button>
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
        $("#accountinfo-form").on('submit', function(e) {
            e.preventDefault();
            let accountInfoForm = new FormData(this);

            $.ajax({
                url: "accountprofileupdate.php",
                type: "POST",
                data: accountInfoForm,
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
                    } else if (data == 1) {
                        Swal.fire({
                            title: "Name or Phone should not be empty",
                            text: "Please try again",
                            icon: "error"
                        });
                    } else if (data == 2) {
                        Swal.fire({
                            title: "Provide full details of Name or Phone",
                            text: "Name > 5 -- Phone == 11",
                            icon: "error"
                        });
                    } else if (data == 3) {
                        Swal.fire({
                            title: "Phone number should be numeric values only",
                            text: "Please try again",
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
                            title: "Account info updated",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            window.location.href = "account";
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