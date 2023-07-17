<?php
include_once "../included/session.php";
include_once "../included/db_connection.php";

$cartid = $_POST['cartid'];
$prodid = $_POST['prodid'];
$subtotal = $_POST['subtotal'];
$total = $_POST['total'];
$quantity = $_POST['quantity'];
$newtotal = $total - $subtotal;

/*
//FETCH AVAILABLE QUANTITY AND RESERVE QUANTITY OF PRODUCT
$sql = "SELECT * FROM product WHERE prodid = '$prodid'";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0){
  while ($availablequantity = mysqli_fetch_assoc($res)) {
    $available_qty = $availablequantity['available_qty'];
    $reserved_qty =  $availablequantity['reserved_qty'];
  }
}

//UPDATE THE AVAILABLE QUANTITY AND RESERVE QUANTITY OF A PRODUCT
$new_available_qty = $available_qty + $quantity;
$new_reserved_qty = $reserved_qty - $quantity;
$sql = "UPDATE `product` SET `available_qty`='$new_available_qty',`reserved_qty`='$new_reserved_qty' WHERE prodid ='$prodid'";
$updateprodquantity = mysqli_query($conn, $sql);
*/

//REMOVE ITEM FROM STHE SHOPPING CART OF USER
$sql = "DELETE FROM included_cart_item WHERE cartid = '$cartid' and prodid = '$prodid'";
$res = mysqli_query($conn, $sql);

//UPDATE TOTAL OF THE SHOPPING CART
$sql = "UPDATE `shopping_cart` SET `total`='$newtotal' WHERE cartid = '$cartid'";
$res = mysqli_query($conn, $sql);

header("location: ../web_pages/php/shoppingcart.php");
 ?>
