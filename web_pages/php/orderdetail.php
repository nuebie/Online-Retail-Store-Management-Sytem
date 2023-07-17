<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/cssorderdetail.css">
  </head>
  <body>
    <h1>Order Detail</h1>

    <div class="flexbox1">

    <div class="flexbox2">

      <?php
        $orderid = $_POST['orderid'];
        $total = $_POST['total'];


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


    </div>

    </div>
  </body>
</html>
