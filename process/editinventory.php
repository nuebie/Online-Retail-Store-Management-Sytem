<?php
include "../included/db_connection.php";


$quantity = $_POST['newquantity'];
$prodid = $_POST['id'];


//GET STOCK QUANTITY AND AVAILABLE QUANTITY OF PRODUCT
$sql = "SELECT * FROM `product` WHERE prodid = '$prodid' ";
$res = mysqli_query($conn,$sql);

if(mysqli_num_rows($res) > 0){
    while($product = mysqli_fetch_assoc($res)){
      $stock_qty = $product['stock_qty'];
      $available_qty = $product['available_qty'];
    }
  }

//ADD OR SUBTRACT STOCK AND AVAILABLE QTY
$stock_qty += $quantity;
$available_qty += $quantity;

echo $stock_qty." ".$available_qty;

$sql = "UPDATE `product` SET `available_qty`='$available_qty',`stock_qty`='$stock_qty' WHERE prodid ='$prodid' ";
$res = mysqli_query($conn,$sql);

 ?>
