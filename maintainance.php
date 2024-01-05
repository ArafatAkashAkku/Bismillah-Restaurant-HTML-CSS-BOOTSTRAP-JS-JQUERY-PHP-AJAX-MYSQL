<!-- require start  -->
<?php include("includes/require.php") ?>
<!-- require end  -->

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
    <title>Server Maintainance - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>
<!-- server maintainance start  -->
<?php
if ($website_maintainance=="off") {
    header("Location: index");
}
?>
<!-- server maintainance end  -->

<body>

    <!-- main start  -->
    <main>
        <div class="d-flex flex-column gap-4 align-items-center justify-content-center text-center error-pages">
            <i class="fa-solid fa-screwdriver-wrench"></i>
            <h1>Server is under maintainance</h1>
            <h3>We will be back soon</h3>
            <p>Sorry for the inconvenience. We're performing some maintenance at the moment. <br> If you need to you can
                always follow us on <a href="<?php
                    if($website_facebook==""){
                       echo "https://www.facebook.com/";
                    }else{
                        echo $website_facebook;
                    }
                    ?>" target="_blank" title="Facebook">Facebook</a> for updates, otherwise we'll be back up shortly!
                <br>
                The <?php echo $website_name ?> Team
            </p>
            <div class="d-inline">
                <a href="index" class="py-2 px-4 bg-warning border rounded-4 text-decoration-none text-dark">Go to
                    home</a>
            </div>
        </div>
    </main>
    <!-- main end  -->

    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <script>
        setInterval(() => {
            window.location.reload();
        }, 5000);
    </script>
</body>

</html>