<!-- require start  -->
<?php include("includes/require.php") ?>
<!-- require end  -->

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta start  -->
    <?php include("includes/meta.php") ?>
    <meta http-equiv="refresh" content="10; url=index">
    <!-- meta end  -->
    <!-- link start  -->
    <?php include("includes/link.php") ?>
    <!-- link end  -->
    <!-- website title  -->
    <title>404 Error - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>

<body>

    <!-- main start  -->
    <main>
        <div class="d-flex flex-column gap-4 align-items-center justify-content-center text-center error-pages">
            <i class="fa-regular fa-face-sad-tear"></i>
            <h1>404</h1>
            <h3>Page Not Found</h3>
            <p>The page you are looking for doesn't exist. <br> So go back and choose a new direction.</p>
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
</body>

</html>