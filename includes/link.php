<!-- websiteinfo start  -->
<?php include("includes/websiteinfo.php") ?>
<!-- websiteinfo end  -->

<!-- external css link  -->
<link rel="stylesheet" href="externals/css/style.css">
<!-- bootstrap css link  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- datatables net  -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- font awesome cdn 6.3.0 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
<!-- favicon link  -->
<link rel="shortcut icon" href="<?php if($website_favicon==""){ echo "images/default/favicon.ico";} else{ echo "images/favicon/".$website_favicon;}?>" type="image/x-icon">
<!-- manifest link  -->
<link rel="manifest" href="manifest.webmanifest">