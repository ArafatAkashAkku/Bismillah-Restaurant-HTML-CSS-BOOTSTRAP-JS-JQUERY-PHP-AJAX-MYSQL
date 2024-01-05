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
    <title>About - <?php if($website_name==""){ echo "Website Title";} else{ echo $website_name;} ?></title>
</head>
<!-- search bar display none  -->
<style>
#search {
    display: none;
}
</style>

<body>
    <!-- header start  -->
    <?php include("includes/header.php") ?>
    <!-- header end  -->
    <!-- main start  -->
    <main class="px-2 py-3">
        <h1 class="text-center">About Us</h1>
        <div class="d-flex flex-column align-items-center flex-lg-row justify-content-between gap-3 mt-3">
            <div>
                <img width="490" height="490"
                    src="<?php if($website_logo==""){ echo "images/default/logo.png";} else{ echo "images/logo/".$website_logo;}?>"
                    alt="<?php if($website_name==""){ echo "Edit name in admin";} else{ echo $website_name;}?>"
                    loading="lazy" class="border border-warning">
            </div>

            <div class="align-self-start">
                <p> <?php if($website_about==""){ echo 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ex maxime, harum non enim a aperiam totam dolores repellat eveniet perspiciatis officia praesentium hic itaque quae voluptates aspernatur adipisci? Non magni inventore dolorem nesciunt, ea distinctio quae repellendus tempore quidem ut maxime dicta nostrum, expedita maiores, officia dolores! Fugit, eligendi  consequuntur! Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero ex eum reprehenderit excepturi molestiae itaque consequuntur voluptatum libero assumenda, debitis quis  est provident facilis? Sapiente, laudantium. Nam quasi eligendi sapiente suscipit aliquid minus  odit eveniet vero aperiam aut velit inventore unde impedit, ex, provident, commodi assumenda  ducimus. Impedit, vero architecto? <br> <br> Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa ullam harum ex facere? Nobis, unde totam. Expedita eveniet, quos obcaecati accusantium provident ipsam blanditiis totam reiciendis deleniti explicabo dolore, iste inventore. Nostrum culpa adipisci harum, saepe debitis tempora commodi dolores molestiae optio assumenda illo quos pariatur rem, maiores aperiam. Pariatur officia odit quo corrupti in. Nobis voluptate delectus accusantiumcupiditate aperiam. Provident repellat dolor harum. Aperiam minus magni rem fugiat.';} else{ echo $website_about;} ?>
                </p>
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
</body>

</html>