<?php
$websitequery = "SELECT * from `website_info` WHERE `id`='1'";
$result = mysqli_query($con, $websitequery);
$website_fetch = mysqli_fetch_assoc($result);
$website_name= $website_fetch['name'];
$website_logo= $website_fetch['logo'];
$website_favicon= $website_fetch['favicon'];
$website_email= $website_fetch['email'];
$website_phone= $website_fetch['phone'];
$website_facebook= $website_fetch['facebook'];
$website_instagram= $website_fetch['instagram'];
$website_twitter= $website_fetch['twitter'];
$website_youtube= $website_fetch['youtube'];
$website_description= $website_fetch['description'];
$website_keywords= $website_fetch['keywords'];
$website_author= $website_fetch['author'];
$website_about= $website_fetch['about'];
$website_maintainance= $website_fetch['maintainance'];
?>