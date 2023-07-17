<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/cssadmindashboard.css">
    <title></title>
  </head>
  <body>

    <div class="flexbox">
      <button type="button" name="button" class="managebtn"><a class="link" href="manageusers.php">Manage Users</a></button>
      <button type="button" name="button" class="managebtn"><a class="link" href="manageorders.php">Manage Orders</a></button>
      <button type="button" name="button" class="managebtn"><a class="link" href="addproduct.php">Add Products</a></button>
      <button type="button" name="button" class="managebtn"><a class="link" href="manageproducts.php">Manage Products</a></button>
      <button type="button" name="button" class="managebtn"><a class="link" href="manageinventory.php">Manage Inventory</a></button>
      <button type="button" name="button" class="managebtn"><a class="link" href="managecategory.php">Manage Categories</a></button>
    </div>

  </body>
</html>
