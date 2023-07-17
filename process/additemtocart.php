<?php
include_once "../included/session.php";
include_once "../included/db_connection.php";


//USER IS AUTHENTICATED (CAN USE SHOPPING CART AND PLACE ORDER)
if (isset($_SESSION['userid'])) {

  $userid =  $_SESSION['userid'];
  $quantity = $_POST['quantity'];
  $prodid = $_POST['prodid'];
  $prodprice = $_POST['prodprice'];
  $subtotal = $prodprice * $quantity;


    //IF USER CLICKED "ADD TO CART"
    if (isset($_POST['add_to_cart'])) {


      //CHECK IF THERE'S STILL AVAILABLE STOCK/QUANTITY
      $sql = "SELECT * FROM product WHERE prodid = '$prodid'";
      $res = mysqli_query($conn, $sql);

      if(mysqli_num_rows($res) > 0){
        while ($availablequantity = mysqli_fetch_assoc($res)) {
          $available_qty = $availablequantity['available_qty'];
          $reserved_qty =  $availablequantity['reserved_qty'];
        }
      }

      //IF AVAILABLE STOCK/QUANTITY IS GREATHER THAN OR EQUAL TO ORDER QUANTITY
      if ($available_qty >= $quantity && $quantity >= 1) {

        //FIND THE SHOPPING CART ID OF THE USER
        $sql = "SELECT * FROM shopping_cart WHERE userid = '$userid'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0){
          while ($shoppingcart = mysqli_fetch_assoc($res)) {
            $cartid = $shoppingcart['cartid'];
          }
        }

        // CHECK IF THEIR IS A DUPLICATE OF THE NEWLY ADDED PRODUCT INSIDE THE SHOPPING CART OF THE USER
        $sql = "SELECT * FROM included_cart_item WHERE prodid = '$prodid' and cartid = '$cartid'";
        $checkduplicate = mysqli_query($conn, $sql);

        //NO EXISTING ITEM IN THE SHOPPING CART
        if(mysqli_num_rows($checkduplicate) == 0)
          $sql = "INSERT INTO `included_cart_item`(`cartid`, `prodid`, `quantity`, `subtotal`) VALUES ('$cartid','$prodid','$quantity','$subtotal')";

        // DUPLICATE ITEM FOUND IN USER'S CART
        else{

          //FETCH THE QUANTITY OF THE DUPLICATE ITEM FOUND
          while ($shoppingcart_item = mysqli_fetch_assoc($checkduplicate)) {
            $oldquantity = $shoppingcart_item['quantity'];
          }

          $quantity = $quantity + $oldquantity; //ADD THE NEW QUANTITY WITH THE FETCHED/OLD QUANTITY OF THE DUPLICATE ITEM
          $subtotal = $prodprice * $quantity; //NEW SUBTOTAL
          $sql = "UPDATE `included_cart_item` SET `quantity`='$quantity',`subtotal`='$subtotal' WHERE prodid = '$prodid'";
        }

        $inssql = mysqli_query($conn, $sql);

        //GET THE TOTAL OF USER'S CART TOTAL BY ADDING THE SUBTOTALS
        $sql = "SELECT * FROM included_cart_item WHERE cartid = '$cartid'";
        $gettotal = mysqli_query($conn, $sql);

        if(mysqli_num_rows($gettotal) > 0){
          while ($shoppingcart_item = mysqli_fetch_assoc($gettotal)) {
            $total += $shoppingcart_item['subtotal']; //ADD THE SUBTOTALS
          }
        }

        $sql = "UPDATE `shopping_cart` SET `total`='$total' WHERE cartid = '$cartid'";
        $updatetotal = mysqli_query($conn, $sql);

      }

      //IF INVALID QUANTITY
      else {
        echo "INVALID QUANTITY. INPUT NEW QUANTITY";
      }




    //  header("Location: ../web_pages/php/index.php"); //// NOTE: UNFINISHED
    }


}

// USER IS NOT AUTHENTICATED (NEEDS TO LOGIN FIRST BEFORE ADDING PRODUCTS TO CART OR PLACING ORDER)
else {
    header("Location: ../web_pages/php/login.php");
}

 ?>
