<?php

include("includes/require.php");

if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true) {

$item = $_POST['item'];
$result = mysqli_query($con, "SELECT * FROM `food_info` WHERE `itemno`='$item'");
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
$price = $row['price'];
$item = $row['itemno'];
$image = $row['image'];
$id = $row['id'];

$cartArray = array(
$item => array(
'name' => $name,
'price' => $price,
'quantity' => 1,
'item' => $item,
'image' => $image,
'id' => $id
)
);

if (empty($_SESSION["shopping_cart"])) {
$_SESSION["shopping_cart"] = $cartArray;
// echo "Food is added to your cart";
echo 1;
} else {
$array_keys = array_keys($_SESSION["shopping_cart"]);
if (in_array($item, $array_keys)) {
// echo "Food is already added to your cart";
echo 2;
} else {
$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"], $cartArray);
// echo "Food is added to your cart";
echo 1;
}
}
}else{
    header("Location: index");
}
?>