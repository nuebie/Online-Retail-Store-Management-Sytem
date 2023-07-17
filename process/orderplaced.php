<?php
include_once "../included/session.php";
include_once "../included/db_connection.php";

$userid =  $_SESSION['userid'];

//FIND THE SHOPPING CART ID OF THE USER
$sql = "SELECT * FROM shopping_cart WHERE userid = '$userid'";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0){
  while ($shoppingcart = mysqli_fetch_assoc($res)) {
    $cartid = $shoppingcart['cartid'];
    $total = $shoppingcart['total'];
  }
}

/*
//FIND THE ADDRESS OF THE USER TO BE USED AS THE DEFAULT SHIPPING ADDRESS
$sql = "SELECT * FROM user WHERE userid = '$userid'";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0){
  while ($user = mysqli_fetch_assoc($res)) {
    $address = $user['address'];
  }
}*/
$address = $_POST['address'];


 //INSERT NEW ORDER
 $orderid = uniqid('ordr');
 $sql = "INSERT INTO `order`(`orderid`, `customer`, `shipping_address`, `order_date`, `total`) VALUES ('$orderid','$userid','$address',Now(),'$total')";
 $insorder = mysqli_query($conn, $sql);

 //INSERT ORDER FULFILLMENT STATUS
 $sql = "INSERT INTO `order_status`(`orderid`) VALUES ('$orderid')";
 $insorderfulfillment = mysqli_query($conn, $sql);

 //COPY THE ITEMS IN THE SHOPPINGCART_ITEM INTO THE ORDER_ITEM
 $sql = "SELECT * FROM included_cart_item WHERE cartid = '$cartid'";
 $getshoppingcartitem = mysqli_query($conn, $sql);

  if(mysqli_num_rows($getshoppingcartitem) > 0){
    while ($shoppingcart = mysqli_fetch_assoc($getshoppingcartitem)) {
      $prodid = $shoppingcart['prodid'];
      $quantity = $shoppingcart['quantity'];
      $subtotal = $shoppingcart['subtotal'];

      $sql = "INSERT INTO `line_item`(`orderid`, `prodid`, `quantity`, `subtotal`) VALUES ('$orderid','$prodid','$quantity','$subtotal')";
      $insorderitem = mysqli_query($conn, $sql);

      //UPDATE THE QUANTITY OF THE ITEM
      $sql = "SELECT * FROM product WHERE prodid = '$prodid'";
      $updatequantity = mysqli_query($conn, $sql);
      if(mysqli_num_rows($updatequantity) > 0){
        while ($product = mysqli_fetch_assoc($updatequantity)) {
          $available_qty = $product['available_qty'];
          $reserved_qty = $product['reserved_qty'];

          $available_qty -= $quantity;
          $reserved_qty += $quantity;

          echo($available_qty." ".$reserved_qty);

          $sql = "UPDATE `product` SET `available_qty`='$available_qty',`reserved_qty`='$reserved_qty' WHERE prodid = '$prodid'";
          $newquantity = mysqli_query($conn, $sql);
        }
      }

    }
  }

  //DELETE THE ITEMS FROM THE SHOPPING CART AFTER PLACING ORDER
  $sql = "DELETE FROM `included_cart_item` WHERE cartid = $cartid";
  $deleteshoppingcartitem = mysqli_query($conn, $sql);

  //UPDATE SHOPPING CART TOTAL TO 0.00
  $sql = "UPDATE `shopping_cart` SET `total`='0.00' WHERE cartid = '$cartid'";
  $updatehoppingcart = mysqli_query($conn, $sql);

  header("location: ../web_pages/php/orderhistory.php");

 ?>
