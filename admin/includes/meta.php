<!-- websiteinfo start  -->
<?php include("includes/websiteinfo.php") ?>
<!-- websiteinfo end  -->

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- meta tag for seo purpose  -->
<meta name="description" content="<?php if($website_description==""){ echo "write description about your website";} else{ echo $website_description;}?>">
<meta name="keywords" content="<?php if($website_keywords==""){ echo "write keywords about your website";} else{ echo $website_keywords;}?>">
<meta name="author" content="<?php if($website_author==""){ echo "Md. Arafat Akash";} else{ echo $website_author;}?>">
<meta name="robots" content="index, follow">