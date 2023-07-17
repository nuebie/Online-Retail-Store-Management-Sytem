<?php
include "../included/db_connection.php";

if(isset($_POST['prod_name']) && isset($_POST['cat']) && isset($_POST['subcat']) && isset($_POST['unit_cost']) && isset($_POST['prod_markup']) && isset($_POST['stock_qty']) && isset($_POST['prod_description'])
){
  //REQUIRED ATTRIBUTES OF IMAGE FILE
  $img_name = $_FILES['prod_image']['name'];
  $img_size = $_FILES['prod_image']['size'];
  $tmp_name = $_FILES['prod_image']['tmp_name'];
  $error = $_FILES['prod_image']['error'];



  //PRODUCT DETAILS
  $prod_name =  strtoupper($_POST['prod_name']);
  $catid = $_POST['cat'];
  $subcatid = $_POST['subcat'];
  $unit_cost = $_POST['unit_cost'];
  $prod_markup = $_POST['prod_markup'];
  $stock_qty = $_POST['stock_qty'];
  $prod_description = $_POST['prod_description'];


  //IF FORM IS INCOMPLETE
  if (empty($prod_name) || $catid == "0" || $unit_cost == "" || $prod_markup == "" || empty($stock_qty) || empty($prod_description) || empty($_FILES['prod_image']['name'])) {
    echo "FILL IN ALL REQUIRED FIELDS";
  }

  //IF FORM IS COMPLETE
  else {

    //IF INPUTS OF UNIT COST, PRODUCT MARK UP AND STOCK QUANTITY ARE CORRECT
    if ($unit_cost > 0 && $prod_markup > 0 && $stock_qty >= 0) {
      $prod_markup = $prod_markup / 100;
      $prod_price = ($unit_cost * $prod_markup) + $unit_cost;

      //IF NO ERROR OR IMAGE IS SUCCESSFULLY UPLOADED
       if($error == 0){

        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION); //GET IMAGE EXTENSION
        $img_ex_lc = strtolower($img_ex); //CONVERT EXTENSION STRING TO LOWER CASE FOR UNITY

        $allowed_ex = array("jpg", "jpeg", "png"); //ALLOWED IMAGE EXTENSIONS

        //IF FILE TYPE IS OF ALLOWED EXTENSION
        if(in_array($img_ex_lc, $allowed_ex)){
          $new_img_name = uniqid("IMG-",true).'.'.$img_ex_lc; //NEW FILE NAME OF IMAGE
          $img_path = '../product_images/'.$new_img_name; //PATH FOR THE PRODUCT IMAGES
          move_uploaded_file($tmp_name,$img_path); //STORE THE UPLOADED FILE INTO THE PATH

          //INSERT INTO PRODUCT TABLE

          //IF PRODUCT HAS A SUBCATEGORY
          if ($subcatid != 0) {
            $sql = "INSERT INTO `product`(`prod_image`, `prod_name`, `unit_cost`, `prod_markup`, `prod_price`, `prod_description`, `catid`, `subcatid`, `available_qty`,`stock_qty`) VALUES ('$new_img_name','$prod_name','$unit_cost','$prod_markup','$prod_price','$prod_description',
              '$catid', '$subcatid','$stock_qty','$stock_qty')";
          }

          //IF PRODUCT HAS NO SUBCATEGORY
          else {
            $sql = "INSERT INTO `product`(`prod_image`, `prod_name`, `unit_cost`, `prod_markup`, `prod_price`, `prod_description`, `catid`, `available_qty`,`stock_qty`) VALUES ('$new_img_name','$prod_name','$unit_cost','$prod_markup','$prod_price','$prod_description',
              '$catid','$stock_qty','$stock_qty')";
          }


          mysqli_query($conn, $sql);
          echo "PRODUCT SUCCESSFULLY UPLOADED";
        }

        //IF FILE EXTENSION IS INVALID
        else {
          echo "FILE TYPE NOT SUPPORTED. UPLOAD ANOTHER FILE.";
        }


      }

    }

    else{
      echo "INVALID INPUT. MAKE SURE ALL INPUTS ARE VALID";
    }





    //header("Location: ../web_pages/php/addproduct.php");
  }



}


?>
