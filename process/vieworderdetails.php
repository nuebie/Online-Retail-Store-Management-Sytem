<?php
include "../included/db_connection.php";

$orderid = $_POST['orderid'];

echo '<button type="button" name="button" class="closebtn" id="closeorderdetailbtn">
  <span class="close_icon"><ion-icon name="close"></ion-icon></span>
</button>';


// GET THE LINE ITEMS OF A SPECIFIC ORDER
$sql = "SELECT * FROM `order` WHERE orderid = '$orderid'";
$gettotal = mysqli_query($conn, $sql);

if(mysqli_num_rows($gettotal) > 0){
  while ($order = mysqli_fetch_assoc($gettotal)) {
    $total = $order['total'];
  }
}

// GET THE LINE ITEMS OF A SPECIFIC ORDER
$sql = "SELECT * FROM `line_item` WHERE orderid = '$orderid'";
$getorderitem = mysqli_query($conn, $sql);

if(mysqli_num_rows($getorderitem) > 0){
  while ($order = mysqli_fetch_assoc($getorderitem)) {
    $prodid = $order['prodid'];

    //GET PRODUCT DETAILS
    $sql = "SELECT * FROM `product` WHERE prodid = '$prodid'";
    $getprod = mysqli_query($conn, $sql);

    if(mysqli_num_rows($getprod) > 0){
      while ($prod = mysqli_fetch_assoc($getprod)) {
        $prod_image = $prod['prod_image'];
        $prod_name = $prod['prod_name'];
        $prod_price = $prod['prod_price'];
        $catid = $prod['catid'];

        //GET PRODUCT CATEGORY
        $sql = "SELECT * FROM category WHERE catid = '$catid'";
        $getprodcat = mysqli_query($conn, $sql);

        if(mysqli_num_rows($getprodcat) > 0){
          while ($prodcat = mysqli_fetch_assoc($getprodcat)){
            $cat_name = $prodcat['cat_name'];
          }}
 ?>

<div class="prod_card">
  <div class="prod_icon">
    <img src="../../product_images/<?=$prod_image?>" alt="">
  </div>
  <div class="prod_details">
    <span class="prod_name"><?=$prod_name?></span><br>
    <?= $cat_name?><br>
    Quantity: <?=$order['quantity']?>
  </div>
  <div class="prod_price">
    PHP <?=$order['subtotal']?>
  </div>
</div>

<?php }}
}} ?>

<h4>TOTAL: PHP <?=$total?></h4>
