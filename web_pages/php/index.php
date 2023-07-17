<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <link rel="stylesheet" href="../css/cssindex.css">
  <body>

    <?php
    //FETCH CATEGORIES
    $sql = "SELECT * FROM category LIMIT 5";
    $getcat = mysqli_query($conn, $sql);

    if(mysqli_num_rows($getcat) > 0){
      while ($category = mysqli_fetch_assoc($getcat)){
        $catid = $category['catid'];
        $cat_name = $category['cat_name'];

     ?>

    <h1><?= $cat_name?></h1>

    <div class="container2">

      <?php
      //FETCH PRODUCT BASE ON CATEGORY
      $sqlprod = "SELECT * FROM product where catid = '$catid' LIMIT 7";
      $getprod = mysqli_query($conn, $sqlprod);

      if(mysqli_num_rows($getprod) > 0){
        while ($product = mysqli_fetch_assoc($getprod)){
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
         <?=$prod_name?><br>
          PHP <?= $prod_price?>

          <form action="proddetail.php" method="get">
            <input type="hidden" name="prodid" value="<?=$prodid?>">
            <input type="hidden" name="prod_image" value="<?=$prod_image?>">
            <input class="btn" type="submit" name="" value="BUY">
          </form>
        </div>
      </div>

    <?php
    }}?>

    </div>


    <h3><a onclick="catfrm('<?=$cat_name?>')">View more</a></h3>

    <form action="prodgrid.php" method="get" id="<?="frm".$cat_name;?>">
      <input type="hidden" name="cat_name" value="<?=$cat_name?>">
    </form>

  <?php }
} ?>

  </body>
</html>

<script>

function catfrm(cattype){
  let str = "frm";
  document.getElementById(str.concat(cattype)).submit();
}

</script>
