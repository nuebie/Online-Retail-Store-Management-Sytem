<?php
include "../included/db_connection.php";

//IF USER WANTS TO RENAME AN EXISTING CATEGORY
if (isset( $_POST['new_subcat_name'])) {
  $subcatid = $_POST['subcatid'];
  $newsubcat_name = $_POST['new_subcat_name'];

  $sql = "UPDATE `subcategory` SET `subcat_name`='$newsubcat_name' WHERE subcatid = '$subcatid'";
  $res = mysqli_query($conn, $sql);
}

//IF USER WANTS TO DELETE A EXISTING SUBCATEGORY
elseif ( $_POST['subcat_name']) {
  $subcatid = $_POST['subcatid'];
  $subcat_name = $_POST['subcat_name'];

  $sql = "DELETE FROM `subcategory` WHERE subcatid = '$subcatid'";
  $res = mysqli_query($conn, $sql);

  //CHECK IF SUBCATEGORY RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);
}

//IF USER RENAMES CATEGORY
if (isset( $_POST['catid'])) {
  $catid = $_POST['catid'];
  $newcat_name = $_POST['new_cat_name'];

  $sql = "UPDATE `category` SET `cat_name`='$newcat_name' WHERE catid = '$catid'";
  $res = mysqli_query($conn, $sql);
}
