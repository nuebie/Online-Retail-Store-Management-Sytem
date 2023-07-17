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
    <link rel="stylesheet" href="../css/cssmanageinventory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $("#editinventorydiv").hide();
          var prodid;

          //SEARCH FOR PRODUCT USING PRODUCT NAME
          $("#search").on("input", function(){
            var prodname = $(this).val();
            var strlength = $(this).val().length;

            $("#inventorysection").load("../../process/productsearchresults.php", {
              input: prodname,
              stringlen : strlength,
              manage : "inventory"
              });
            });

          //IF ADD QUANTITY BUTTON IS CLICKED
          $(document).on("click",'#addquantitybtn',function(){
            var id = $(this).attr("name");
            prodid = id;
            $("#editinventorydiv").show();
          });

          //CONFIRM QUANTITY
          $(document).on("click",'#confirm',function(){
            event.preventDefault();
            var quantity = $("#quantity").val();
          
            $("#editinventorydiv").load("../../process/editinventory.php", {
                id : prodid,
                newquantity : quantity
              });

           location.reload();
          });

          //IF CANCEL BUTTON IS CLICKED
          $(document).on("click",'#cancel',function(){
             location.reload();
          });

        });
    </script>
  </head>
  <body>

    <div class="editinventorydiv" id="editinventorydiv">
      <form class="" action="index.html" method="post" class="trackingfrm">
        <input type="number" name="" value="" class="quantity" placeholder="ADD QUANTITY" id="quantity"><br>
        <button type="button" class="confirm" name="button" id="confirm">CONFIRM</button>
        <button type="button" class="cancel" name="button" id="cancel">CANCEL</button>
      </form>
    </div>

    <form class="productsearchfrm" action="index.html" method="post">
      <input type="text" name="" value="" id="search" placeholder="Search Product by Product Name">
    </form>

    <div class="inventorysection" id="inventorysection">
      <table>
        <tr>
          <th>Product Name</th>
          <th>Stock</th>
          <th>Available Quantity</th>
          <th>Reserved Quantity</th>
        </tr>

        <?php
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
                <input type="button" class="editbtn" id="addquantitybtn" name="'.$prodid.'" value="Add Quantity">
              </form>
              </td>';
            echo '</tr>';

          }
        }
         ?>
    </div>

  </body>
</html>
