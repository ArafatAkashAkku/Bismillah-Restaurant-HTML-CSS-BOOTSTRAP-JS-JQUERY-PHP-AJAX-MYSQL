<?php

include("includes/require.php");
$food = $_POST['live'];

$query = "SELECT * FROM `food_info` WHERE `name` LIKE '%$food%' AND `status`='active' ORDER BY `id` DESC";
$result = mysqli_query($con, $query);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)){
            echo '<div class="card" style="width: 18rem;">
            <img width="100" height="250" src="'; 
            if($row['image']==""){
                echo 'images/default/noimage.jpg" class="card-img-top" alt="No Image Found"
                loading="lazy">';
            }else{
                echo 'images/food/'; echo $row['id']; echo '/'; echo $row['image']; echo '" class="card-img-top" alt="';
                echo $row["name"];
                 echo '" loading="lazy">';
            }
            echo '<div class="card-body text-center">
                <h5 class="card-title" style="height:7vh">'; echo substr($row['name'],0,30); echo '</h5><p class="card-text">'; echo substr($row["about"],0,30); echo '</p><p> BDT. '; 
            echo $row["price"]; echo '</p>';
            if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {
                echo '<button type="submit" class="btn btn-warning text-black addedtocart"';
                echo 'data-fooditem="'; echo $row['itemno']; echo '">Add to Cart</button>
                </div></div>';
            }else{
            echo '<a href="login"><button class="btn btn-warning text-black">Add to Cart</button></a>
            </div></div>';
            }
        } 
    } else {
        echo '
        <div class="card" style="width: 18rem;">
            <img src="images/default/noitem.jpg" class="card-img-top" alt="images/default/user.jpg"
                loading="lazy">
                <div class="card-body text-center">
                    <h5 class="card-title">No food item found</h5>
                    <p class="card-text">Please search again with appropriate item name</p>
                </div>
        </div>';
    }
} 

?>