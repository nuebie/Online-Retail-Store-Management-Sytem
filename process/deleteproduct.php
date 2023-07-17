<?php
include "../included/db_connection.php";

//IF USER WANTS TO DELETE EXISTING PRODUCT
if(isset($_POST['delprod']) && isset($_POST['prodid'])){
  $prodid = $_POST['prodid'];

 //GET PRODUCT IMAGE FOR DELETION
  $sql = "SELECT * FROM product WHERE prodid='$prodid'";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){

    while($product = mysqli_fetch_assoc($res)){
      $prod_image = $product['prod_image'];
    }
  }

  $sql = "DELETE FROM `product` WHERE prodid = '$prodid'";
  $res = mysqli_query($conn, $sql);

  //CHECK IF PRODUCT RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);

  //REMOVE IMAGE FROM THE FOLDER
  if(mysqli_affected_rows($conn) == 1){
    $path = "../product_images/$prod_image";
    unlink($path);
  }
}
