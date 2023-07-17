<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/cssgrid.css">
    <title></title>
  </head>
  <body>

      <?php
      //DISPLAY SUBCATEGORY NAME IN UPPER LEFT
      if(isset($_GET['subcat_name'])){
          $subcat_name = $_GET['subcat_name'];
          echo '<h1>'.$subcat_name.'</h1>';
      }

      //DISPLAY CATEGORY NAME IN UPPER LEFT
      if(isset($_GET['cat_name'])){
        $cat_name = $_GET['cat_name'];
        echo '<h1>'.$cat_name.'</h1>';
      }

       ?>
      <div class="flex_container">

        <?php

        //FETCH PRODUCT USING SUBCATEGORY
        if(isset($_GET['subcatid'])){
          $subcatid = $_GET['subcatid'];
          $sqlprod = "SELECT * FROM product WHERE subcatid = '$subcatid'";
        }

        //FETCH PRODUCT USING CATEGORY
        if(isset($_GET['catid'])){
          $catid = $_GET['catid'];
          $sqlprod = "SELECT * FROM product WHERE catid = '$catid'";
          }

        $getprod = mysqli_query($conn, $sqlprod);

        if(mysqli_num_rows($getprod) > 0){
          while ($product = mysqli_fetch_assoc($getprod)) {
            $prodid = $product['prodid'];
            $prod_image = $product['prod_image'];
            $prod_name = $product['prod_name'];
            $prod_price = $product['prod_price'];
         ?>

        <div class="prod">
          <div class="prod_img">
            <img src="../../product_images/<?= $prod_image?>" alt="">
          </div>
          <div class="desc">
            <?php echo $prod_name ?><br>
            <?php echo "PHP ".$prod_price?>

            <form action="proddetail.php" method="get">
              <input type="hidden" name="prodid" value="<?=$prodid?>">
              <input type="hidden" name="prod_image" value="<?=$prod_image?>">
              <input class="btn" type="submit" name="" value="BUY">
            </form>

          </div>
        </div>

      <?php
    }} ?>

      </div>

  </body>
</html>
