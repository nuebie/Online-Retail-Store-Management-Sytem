<?php
include "../included/db_connection.php";
include "../included/session.php";
$userid =  $_SESSION['userid'];

//IF CALLED BY MANAGE PRODUCT PAGE
if ($_POST['manage'] == "products") {

  $prod_name = $_POST['input'];
  $strlength = $_POST['stringlen'];

  echo '  <table>
      <tr>
        <th>Product Name</th>
        <th>Product Image</th>
        <th>Unit Cost</th>
        <th>Markup(%)</th>
        <th>Selling Price</th>
        <th>Product Description</th>
        <th>Category</th>
        <th>Subcategory</th>
      </tr>';

    if ($strlength > 0) {
      $sql = "SELECT * FROM `product` WHERE prod_name LIKE '$prod_name%'";
      $res = mysqli_query($conn,$sql);

      if(mysqli_num_rows($res) > 0){

        while($product = mysqli_fetch_assoc($res)){
          //PRODUCT DETAILS
          $prodid = $product['prodid'];
          $prod_name = $product['prod_name'];
          $prod_image = $product['prod_image'];
          $unit_cost = $product['unit_cost'];
          $prod_markup = $product['prod_markup'];
          $prod_price = $product['prod_price'];
          $prod_description = $product['prod_description'];
          $catid = $product['catid'];
          $subcatid = $product['subcatid'];

          //CONVERT MARKUP FROM DECIMAL TO PERCENT
          $convertedmarkup = ($prod_markup * 100);

          //SHORTENED PRODUCT DESCRIPTION
          $substring = substr($prod_description,0,15);
          $shortdescription = $substring."...";

          //GET CATEGORY
          $sql = "SELECT * FROM category WHERE catid = '$catid'";
          $getcat_name = mysqli_query($conn,$sql);
          if(mysqli_num_rows($getcat_name) > 0){
            while($category = mysqli_fetch_assoc($getcat_name)){
              $cat_name = $category['cat_name'];
          }
        }

        //GET SUBCATEGORY
        $sql = "SELECT * FROM subcategory WHERE subcatid = '$subcatid'";
        $getsubcat_name = mysqli_query($conn,$sql);
        if(mysqli_num_rows($getsubcat_name) > 0){
          while($subcategory = mysqli_fetch_assoc($getsubcat_name)){
            $subcat_name = $subcategory['subcat_name'];
        }
      }
      else {
        $subcat_name = NULL;
      }

          echo '<tr>';
          echo '<td>'.$prod_name.'</td>';
          echo '<td>'.$prod_image.'</td>';
          echo '<td>'.$unit_cost.'</td>';
          echo '<td>'.$convertedmarkup.'%</td>';
          echo '<td>'.$prod_price.'</td>';
          echo '<td>'.$shortdescription.'</td>';
          echo '<td>'.$cat_name.'</td>';
          echo '<td>'.$subcat_name.'</td>';
          echo '<td class="td_btn">
            <form class="editfrm" action="index.html" method="post">
              <input type="hidden" name="frmname" value="editfrm">
              <input type="hidden" name="prodid" value="'.$prodid.'">
              <input type="hidden" name="prodname" value="'.$prod_name.'">
              <input type="hidden" name="img_file" value="'.$prod_image.'">
              <input type="hidden" name="unitcost" value="'.$unit_cost.'">
              <input type="hidden" name="markup" value="'.$convertedmarkup.'">
              <input type="hidden" name="proddesc" value="'.$prod_description.'">
              <input type="hidden" name="catid" value="'.$catid.'">
              <input type="hidden" name="catname" value="'.$cat_name.'">
              <input type="hidden" name="subcatid" value="'.$subcatid.'">
              <input type="hidden" name="subcatname" value="'.$subcat_name.'">
              <input type="submit" class="editbtn" name="" value="Edit">
            </form>
            <input type="button" value="Remove" id="deletebtn'.$prodid.'" name="'.$prodid.'" class="deletebtn">
            </td>';
          echo '</tr>';

      }
    }
    }

    else{
      $sql = "SELECT * FROM `product`";
      $res = mysqli_query($conn,$sql);

      if(mysqli_num_rows($res) > 0){

        while($product = mysqli_fetch_assoc($res)){
          //PRODUCT DETAILS
          $prodid = $product['prodid'];
          $prod_name = $product['prod_name'];
          $prod_image = $product['prod_image'];
          $unit_cost = $product['unit_cost'];
          $prod_markup = $product['prod_markup'];
          $prod_price = $product['prod_price'];
          $prod_description = $product['prod_description'];
          $catid = $product['catid'];
          $subcatid = $product['subcatid'];

          //CONVERT MARKUP FROM DECIMAL TO PERCENT
          $convertedmarkup = ($prod_markup * 100);

          //SHORTENED PRODUCT DESCRIPTION
          $substring = substr($prod_description,0,15);
          $shortdescription = $substring."...";

          //GET CATEGORY
          $sql = "SELECT * FROM category WHERE catid = '$catid'";
          $getcat_name = mysqli_query($conn,$sql);
          if(mysqli_num_rows($getcat_name) > 0){
            while($category = mysqli_fetch_assoc($getcat_name)){
              $cat_name = $category['cat_name'];
          }
        }

        //GET SUBCATEGORY
        $sql = "SELECT * FROM subcategory WHERE subcatid = '$subcatid'";
        $getsubcat_name = mysqli_query($conn,$sql);
        if(mysqli_num_rows($getsubcat_name) > 0){
          while($subcategory = mysqli_fetch_assoc($getsubcat_name)){
            $subcat_name = $subcategory['subcat_name'];
        }
      }

          echo '<tr>';
          echo '<td>'.$prod_name.'</td>';
          echo '<td>'.$prod_image.'</td>';
          echo '<td>'.$unit_cost.'</td>';
          echo '<td>'.$convertedmarkup.'%</td>';
          echo '<td>'.$prod_price.'</td>';
          echo '<td>'.$shortdescription.'</td>';
          echo '<td>'.$cat_name.'</td>';
          echo '<td>'.$subcat_name.'</td>';
          echo '<td class="td_btn">
            <form class="editfrm" action="index.html" method="post">
              <input type="hidden" name="frmname" value="editfrm">
              <input type="hidden" name="prodid" value="'.$prodid.'">
              <input type="hidden" name="prodname" value="'.$prod_name.'">
              <input type="hidden" name="img_file" value="'.$prod_image.'">
              <input type="hidden" name="unitcost" value="'.$unit_cost.'">
              <input type="hidden" name="markup" value="'.$convertedmarkup.'">
              <input type="hidden" name="proddesc" value="'.$prod_description.'">
              <input type="hidden" name="catid" value="'.$catid.'">
              <input type="hidden" name="catname" value="'.$cat_name.'">
              <input type="hidden" name="subcatid" value="'.$subcatid.'">
              <input type="hidden" name="subcatname" value="'.$subcat_name.'">
              <input type="submit" class="editbtn" name="" value="Edit">
            </form>
            <input type="button" value="Remove" id="deletebtn'.$prodid.'" name="'.$prodid.'" class="deletebtn">
            </td>';
          echo '</tr>';

      }
    }
    }

}

//IF CALLED BY MANAGE INVENTORY PAGE
if ($_POST['manage'] == "inventory") {
  $prod_name = $_POST['input'];
  $strlength = $_POST['stringlen'];

  echo '  <table>
      <tr>
        <th>Product Name</th>
        <th>Stock</th>
        <th>Available Quantity</th>
        <th>Reserved Quantity</th>
      </tr>';

    if ($strlength > 0){

      $sql = "SELECT * FROM `product` WHERE prod_name LIKE '$prod_name%'";
      $res = mysqli_query($conn,$sql);

      if(mysqli_num_rows($res) > 0){

        while($product = mysqli_fetch_assoc($res)){
          $prodid = $product['prodid'];
          $prod_name = $product['prod_name'];
          $stock_qty = $product['stock_qty'];
          $available_qty = $product['available_qty'];
          $reserved_qty = $product['reserved_qty'];

          echo '<tr>';
          echo '<td>'.$prod_name.'</td>';
          echo '<td>'.$stock_qty.'</td>';
          echo '<td>'.$available_qty.'</td>';
          echo '<td>'.$reserved_qty.'</td>';
          echo '<td class="td_btn">
            <form class="editfrm" action="index.html" method="post">
              <input type="hidden" name="frmname" value="editfrm">
              <input type="hidden" name="prodid" value="'.$prodid.'">
              <input type="submit" class="editbtn" name="" value="Add Quantity">
            </form>
            </td>';
          echo '</tr>';

        }
      }
    }

  else{
    $sql = "SELECT * FROM `product`";
    $res = mysqli_query($conn,$sql);

    if(mysqli_num_rows($res) > 0){

      while($product = mysqli_fetch_assoc($res)){
        $prodid = $product['prodid'];
        $prod_name = $product['prod_name'];
        $stock_qty = $product['stock_qty'];
        $available_qty = $product['available_qty'];
        $reserved_qty = $product['reserved_qty'];

        echo '<tr>';
        echo '<td>'.$prod_name.'</td>';
        echo '<td>'.$stock_qty.'</td>';
        echo '<td>'.$available_qty.'</td>';
        echo '<td>'.$reserved_qty.'</td>';
        echo '<td class="td_btn">
          <form class="editfrm" action="index.html" method="post">
            <input type="hidden" name="frmname" value="editfrm">
            <input type="hidden" name="prodid" value="'.$prodid.'">
            <input type="submit" class="editbtn" name="" value="Add Quantity">
          </form>
          </td>';
        echo '</tr>';
  }
}
}
}


 ?>
