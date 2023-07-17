<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/cssdetail.css">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        //IF BUY NOW BUTTON IS CLICKED
        $(document).on("click",'#buybtn',function(){
            event.preventDefault();
            var quantity = $("#quantity").val();
            var prodid = $("#prodid").val();
            var prodprice = $("#prodprice").val();
            var buy = $(this).attr("name");


            $.ajax({
            url:"../../process/buyitem.php",
            method:"POST",
            data:{quantity:quantity, prodid: prodid, prodprice: prodprice, buy: buy},
            success:function(data)
              {
                if (data == "INVALID QUANTITY. INPUT NEW QUANTITY") {
                    $("#quantityvalidation").empty().append(""+data+"");
                }
                else {
                  window.location = "shoppingcart.php"
                }
              }
            });

        });

        //IF BUY ADD TO CART IS CLICKED
        $(document).on("click",'#addtocartbtn',function(){
            event.preventDefault();
            var quantity = $("#quantity").val();
            var prodid = $("#prodid").val();
            var prodprice = $("#prodprice").val();
            var add_to_cart = $(this).attr("name");


            $.ajax({
            url:"../../process/additemtocart.php",
            method:"POST",
            data:{quantity:quantity, prodid: prodid, prodprice: prodprice, add_to_cart: add_to_cart},
            success:function(data)
              {
                if (data == "INVALID QUANTITY. INPUT NEW QUANTITY") {
                    $("#quantityvalidation").empty().append(""+data+"");
                }
                else {
                  location.reload();
                }

              }
            });

        });

      });
    </script>
  </head>
  <body>

    <div class="flex_container">

      <?php

      $prodid = $_GET['prodid'];
      $prod_image = $_GET['prod_image'];

      //FETCH PRODUCT DETAILS FROM PRODUCT
      $sql = "SELECT * FROM product WHERE prodid = '$prodid'";
      $res = mysqli_query($conn, $sql);

      if(mysqli_num_rows($res) > 0){
        while ($product = mysqli_fetch_assoc($res)) {
       ?>

      <div class="prod_img">
          <img src="../../product_images/<?= $prod_image?>" alt="">
      </div>

      <div class="prod_details">
        <h1><?=$product['prod_name']?></h1>
        <h2>PHP <?=$product['prod_price']?></h2>

        <form class="" action="../../process/additemtocart.php" method="post">
            Quantity:<input class="quantity" type="number" min = 1 max = <?=$product['available_qty']?> id="quantity" name="quantity" value="1"><br>
            Stock: <?=$product['available_qty']?><br>
            <p class="quantityvalidation" id="quantityvalidation"></p><br>
            <input type="hidden" name="prodid" id="prodid" value="<?=$product['prodid']?>">
            <input type="hidden" name="prodprice" id="prodprice" value="<?=$product['prod_price']?>">
            <input class="btn" type="submit" id="buybtn" name="buy" value="BUY">
            <input class="btn" type="submit" id="addtocartbtn" name="add_to_cart" value="ADD TO CART">
        </form>

        Product details: <br>
       <?=$product['prod_description']?>
      </div>

    <?php }
  } ?>

    </div>

  </body>
</html>
