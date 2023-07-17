<?php
include "../included/db_connection.php";

$prodid = $_POST['prodid'];
$prod_name = $_POST['prod_name'];
$unit_cost = $_POST['unit_cost'];
$prod_markup = $_POST['prod_markup'];
$prod_description = $_POST['prod_description'];
$catid = $_POST['catid'];
$subcatid = $_POST['subcatid'];

//ERROR HANDLING VARIABLES
$x=0;


//IF FORM IS INCOMPLETE
if (empty($prod_name) || $catid == "0" || $unit_cost == "" || $prod_markup == "" || empty($prod_description)) {
  //echo "FILL IN ALL REQUIRED FIELDS";
  $x=0;
}

//IF FORM IS COMPLETE
else {

  //IF INPUTS OF UNIT COST, PRODUCT MARK UP AND STOCK QUANTITY ARE CORRECT
  if ($unit_cost > 0 && $prod_markup > 0) {
    $prod_markup /= 100;
    $prod_price = ($unit_cost * $prod_markup) + $unit_cost;

    //UPDATE PRODUCT DETAILS

    //IF PRODUCT WILL HAVE A SUBCATEGORY
    if ($subcatid != 0) {
      $sql = "UPDATE `product` SET `prod_name`='$prod_name', `unit_cost`='$unit_cost', `prod_markup`='$prod_markup', `prod_price`='$prod_price', `prod_description`='$prod_description', `catid`='$catid', `subcatid`='$subcatid'  WHERE prodid='$prodid'";
    }

    //IF PRODUCT WILL NOT HAVE A SUBCATEGORY
    elseif ($subcatid == 0) {
      $sql = "UPDATE `product` SET `prod_name`='$prod_name', `unit_cost`='$unit_cost', `prod_markup`='$prod_markup', `prod_price`='$prod_price', `prod_description`='$prod_description', `catid`='$catid', `subcatid`= NULL WHERE prodid='$prodid'";
    }

    $res = mysqli_query($conn,$sql);
    //echo "SUCCESS";
    $x=1;
  }

  else{
    //echo "INVALID INPUT. MAKE SURE ALL INPUTS ARE VALID";
    $x=0;
  }


}






//IF NEW IMAGE FILE IS UPLOADED
if(is_uploaded_file($_FILES['prod_image']['tmp_name']) && $x == 1){
  //REQUIRED ATTRIBUTES OF IMAGE FILE
  $img_name = $_FILES['prod_image']['name'];
  $img_size = $_FILES['prod_image']['size'];
  $tmp_name = $_FILES['prod_image']['tmp_name'];
  $error = $_FILES['prod_image']['error'];

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

      //DELETE THE PREVIOUS IMAGE OF THE PRODUCT FROM THE PRODUCT IMAGE FOLDER
      $filename = $_POST['filename'];
      $path = "../product_images/$filename";
      unlink($path);

      //INSERT INTO PRODUCT TABLE
      $sql = "UPDATE `product` SET `prod_image`='$new_img_name' WHERE prodid = '$prodid'";
      mysqli_query($conn, $sql);
      //echo "UPLOADED NEW IMAGE";
      $x = 1;
    }

    else {
      //echo "FILE TYPE NOT SUPPORTED. UPLOAD ANOTHER FILE.";
      $x = 2;
    }
  }

}

if ($x == 0) {
  echo "INCOMPLETE OR INVALID INPUT. TRY AGAIN.";
}

if ($x == 1) {
  echo "SUCCESS";
}

if ($x == 2) {
  echo "INVALID FILE TYPE";
}




 ?>
