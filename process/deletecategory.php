<?php
include "../included/db_connection.php";

//IF USER WANTS TO DELETE EXISTING CATEGORY
if(isset($_POST['delcat']) && isset($_POST['catid'])){
  $catid = $_POST['catid'];

  $sql = "DELETE FROM `category` WHERE catid = '$catid'";
  $res = mysqli_query($conn, $sql);

  //CHECK IF CATEGORY RECORD HAS BEEN DELETED
  echo mysqli_affected_rows($conn);
}
