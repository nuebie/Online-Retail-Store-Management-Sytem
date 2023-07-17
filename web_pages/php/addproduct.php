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
    <link rel="stylesheet" href="../css/cssaddproduct.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

     <script type="text/javascript">
         $(document).ready(function(){

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

             //IF ADMIN CLICKS "ADD NEW PRODUCT"
             $(document).on("click",'#addprodbtn',function(){
               event.preventDefault();
               var form = $('#newprodfrm')[0];
               var fd = new FormData(form);

               $.ajax({
                 type: "POST",
                 enctype: 'multipart/form-data',
                 url: "../../process/storenewproduct.php",
                 data: fd,
                 processData: false,
                 contentType: false,
                 cache: false,
                 timeout: 800000,
                 success: function (data) {

                   if(data == "PRODUCT SUCCESSFULLY UPLOADED"){
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

    <div class="flexbox">

    <form class="newprodform" action="../../process/storenewproduct.php" id="newprodfrm" method="post" enctype="multipart/form-data">
      Product Name: <input type="text" name="prod_name" id="prod_name" value=""> <br>

      Product Image: <input type="file" id="file" name="prod_image" value=""> <br>


      Category: <select class="" name="cat" id="sel_cat">
        <option value="0">- Select -</option>
        <?php
        //FETCH CATEGORY
        $sql_category = "SELECT * FROM category";
        $category_data = mysqli_query($conn,$sql_category);

        if(mysqli_num_rows($category_data) > 0){
          while($category = mysqli_fetch_assoc($category_data) ){
            $cat_name = $category['cat_name'];
            $catid = $category['catid'];

           // OPTION
           echo "<option value='".$catid."' >".$cat_name."</option>";
        }
      }
      else {
        echo "NO ROWS";
      }
         ?>
      </select>


      Subcategory: <select class="" name="subcat" id="sel_subcat">
         <option value="0">- Select -</option>
      </select> <br>


      Unit Cost: <input type="number" step="0.01" min=0 name="unit_cost" id="unit_cost" value=""> <br>

      Markup: <input type="number" step="0.1" min=0 name="prod_markup" id="prod_markup" value="">% <br>

      Stock Quantity: <input type="number" min=0 name="stock_qty" id="stock_qty" value=""><br>

      Product Description: <br>

      <textarea name="prod_description"  id="prod_description" rows="8" cols="80"></textarea> <br>

      <input type="button" id="addprodbtn" name="addprodbtn" class="addprod" value="ADD NEW PRODUCT">
      <input type="reset" name="" value="CLEAR">

        <p class="productvalidation" id="productvalidation"></p>
    </form>
    </div>

  </body>
</html>
