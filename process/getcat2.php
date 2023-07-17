<?php
include_once "../included/session.php";
include_once "../included/db_connection.php";

//GET CATEGORY
if (isset($_POST['cat_id'])) {
  $catid = $_POST['cat_id'];
  $cat_name = $_POST['cat_name'];

  echo '<option value = "'.$catid.'">'.$cat_name.'</option>';

  $sql = "SELECT * FROM category WHERE NOT catid= '$catid'";
  $result = mysqli_query($conn,$sql);

  while($category = mysqli_fetch_array($result) ){
    $catid = $category['catid'];
    $cat_name = $category['cat_name'];

    echo '<option value = "'.$catid.'">'.$cat_name.'</option>';
  }
}

//GET SUBCATEGORY
if (isset($_POST['subcat_id'])) {
  $subcatid = $_POST['subcat_id'];
  $subcat_name = $_POST['subcat_name'];
  $catid = $_POST['catid'];

  //IF SUBCATEGORY IS NULL
  if (empty($subcatid)) {
   echo '<option value = "0">- Select -</option>';
   $sql = "SELECT * FROM subcategory WHERE catid= '$catid'";
  }

 //IF SUBCATEGORY IS NOT NULL
  else {
    echo '<option value = "'.$subcatid.'">'.$subcat_name.'</option>';
    $sql = "SELECT * FROM subcategory WHERE NOT subcatid= '$subcatid' AND catid= '$catid'";
  }


  $result = mysqli_query($conn,$sql);

  while($subcategory = mysqli_fetch_array($result) ){
    $subcatid = $subcategory['subcatid'];
    $subcat_name = $subcategory['subcat_name'];

    echo '<option value = "'.$subcatid.'">'.$subcat_name.'</option>';
  }
}

 ?>
