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
    <link rel="stylesheet" href="../css/cssmanageproducts.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script type="text/javascript">
          $(document).ready(function(){
            $("#editproductdiv").hide();
            var prodid;

            $(document).on("submit",'form',function(){
            prodid = $("input[name='prodid']",this).val();
            var prodname = $("input[name='prodname']",this).val();
            var frmname = $("input[name='frmname']",this).val();
            var img_file = $("input[name='img_file']",this).val();
            var unitcost = $("input[name='unitcost']",this).val();
            var markup = $("input[name='markup']",this).val();
            var proddesc = $("input[name='proddesc']",this).val();
            var catid = $("input[name='catid']",this).val();
            var catname = $("input[name='catname']",this).val();
            var subcatid = $("input[name='subcatid']",this).val();
            var subcatname = $("input[name='subcatname']",this).val();

            if(frmname == "editfrm")
              event.preventDefault();

            //alert(img_file + " " + catid + " " + catname);

            if(frmname == "editfrm"){
              $("#prodid").attr("value", prodid);
              $("#prod_name").attr("value", prodname);
              $("#prod_image").attr("value", img_file);
              $("#unit_cost").attr("value", unitcost);
              $("#prod_markup").attr("value", markup);
              $("#filename").attr("value", img_file);
              $('#prod_description').val($('#prod_description').val()+ proddesc);

              //GET CATEGORY
              $("#sel_cat").load("../../process/getcat2.php", {
                cat_id: catid,
                cat_name: catname
              });

              //GET SUBCATEGORY
              $("#sel_subcat").load("../../process/getcat2.php", {
                subcat_id: subcatid,
                catid: catid,
                subcat_name: subcatname
              });

              $("#editproductdiv").show();
            }

          });

          $("#sel_cat").change(function(){
              var catid = $(this).val();

              $.ajax({
                  url: '../../process/getsubcat.php',
                  type: 'post',
                  data: {category:catid},
                  dataType: 'json',
                  success:function(response){

                      var len = response.length;

                      $("#sel_subcat").empty();
                      $("#sel_subcat").append("<option value='0'>- Select -</option>");

                      for( var i = 0; i<len; i++){
                          var subcat_name = response[i]['subcat'];
                          var subcatid = response[i]['subcatid'];

                          $("#sel_subcat").append("<option value='"+subcatid+"'>"+subcat_name+"</option>");

                      }
                  }
              });
          });

          //SEARCH FOR PRODUCT USING PRODUCT NAME
          $("#search").on("input", function(){
            var prodname = $(this).val();
            var strlength = $(this).val().length;

            $("#productsection").load("../../process/productsearchresults.php", {
              input: prodname,
              stringlen : strlength,
              manage: "products"
              });
            });

          //CLICK CANCEL EDIT
          $("#cancelbtn").on("click", function(){
            location.reload();
            });

          //DELETE EXISTING PRODUCT
          $(document).on("click","[id^=deletebtn]",function(){
            event.preventDefault();
            var id = $(this).attr("name");

              $.ajax({
                url:"../../process/deleteproduct.php",
                method:"POST",
                data:{prodid:id, delprod:"deleteproduct"},
                success:function(data)
                {

                  if (data == 1) {
                   location.reload();
                  }

                  else{
                    alert("CANNOT DELETE THIS PRODUCT");
                  }

                }
              });
            });

          //UPDATE PRODUCT DETAILS
          $(document).on("click",'#updatebtn',function(){
            event.preventDefault();
            var form = $('#prodfrm')[0];
            var fd = new FormData(form);

            $.ajax({
              type: "POST",
              enctype: 'multipart/form-data',
              url: "../../process/updateproduct.php",
              data: fd,
              processData: false,
              contentType: false,
              cache: false,
              timeout: 800000,
              success: function (data) {
                if (data == "SUCCESS") {
                  location.reload();
                }

                else{
                   $("#productvalidation").empty().append(""+data+"");
                }
              }
            });
          });

        });
      </script>
  </head>
  <body>

    <form class="productsearchfrm" action="index.html" method="post">
      <input type="text" name="" value="" id="search" placeholder="Search Product by Product Name">
    </form>

    <div class="editproductdiv" id="editproductdiv">

      <form class="editproductfrm" id="prodfrm" action="../../process/updateproduct.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="frmname" value="editproductfrm">
        <input type="hidden" name="prodid" id="prodid" value="">
        <input type="hidden" name="filename" id="filename" value="">
        Product Name:<input type="text" class="editproductinput" id="prod_name" name="prod_name" value=""><br>
        Product Image: <input type="file" name="prod_image"> <br>
        Unit Cost:<input type="number" class="editproductinput" id="unit_cost" name="unit_cost" value=""><br>
        Markup(%):<input type="number" class="editproductinput" id="prod_markup" name="prod_markup" value=""><br>

        Category:<select class="" name="catid" id="sel_cat">
        </select>

        Subcategory:<select class="" name="subcatid" id="sel_subcat">
        </select><br>

        Product Description: <br>
        <textarea name="prod_description" rows="8" cols="80" id="prod_description" value="fffff"></textarea> <br>
        <input type="button" name="" id="updatebtn" value="Update">
        <input type="button" id="cancelbtn" name="" value="Cancel">
          <p id="productvalidation"></p>
      </form>
    </div>

    <div class="productsection" id="productsection">
      <table>
        <tr>
          <th>Product Name</th>
          <th>Product Image</th>
          <th>Unit Cost</th>
          <th>Markup(%)</th>
          <th>Selling Price</th>
          <th>Product Description</th>
          <th>Category</th>
          <th>Subcategory</th>
        </tr>
        <?php

        //GET PRODUCT INFORMATION
        $sql = "SELECT * FROM product";
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
          if($subcatid != NULL){
            $sql = "SELECT * FROM subcategory WHERE subcatid = '$subcatid'";
            $getsubcat_name = mysqli_query($conn,$sql);
            if(mysqli_num_rows($getsubcat_name) > 0){
              while($subcategory = mysqli_fetch_assoc($getsubcat_name)){
                $subcat_name = $subcategory['subcat_name'];
              }
            }
          }
          else {
            $subcat_name = "";
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
         ?>
      </table>
    </div>

  </body>
</html>
