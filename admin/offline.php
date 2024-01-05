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
    <title>Internet Connection Offline -
        <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>

<body>

    <!-- main start  -->
    <main>
        <div class="d-flex flex-column gap-4 align-items-center justify-content-center text-center error-pages">
            <h1>Internet Connection Offline</h1>
            <h3>We will be back soon once your connection is restored</h3>
            <p>Thank you for your patience</p>
        </div>
    </main>
    <!-- main end  -->

    <!-- script start  -->
    <?php include("includes/script.php") ?>
    <!-- script end  -->
    <script>
    window.ononline = () => {
        window.location.href = "index";
    }
    </script>
</body>

</html>