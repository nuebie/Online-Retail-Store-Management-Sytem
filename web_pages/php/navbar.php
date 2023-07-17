<?php
include_once "../../included/db_connection.php";
include_once "../../included/session.php";


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/navbarcss.css">
  </head>
  <body>
  <nav class="wrapper">

    <div class="logo">
      <a  class="logotxt" href="index.php">CYBER</a>
    </div>

    <ul>

      <li><a href="index.php">HOME</a></li>

      <?php
      //FETCH CATEGORIES
      $sql = "SELECT * FROM category";
      $getcat = mysqli_query($conn, $sql);

      if(mysqli_num_rows($getcat) > 0){
        while ($category = mysqli_fetch_assoc($getcat)){
          $catid = $category['catid'];
          $cat_name = $category['cat_name']; ?>
          <li><a onclick="catfrm('<?=$cat_name?>')"><?php echo $cat_name?></a> <!--DISPLAYS THE CATEGORIES -->

          <form class="frmcat_name" action="prodgrid.php" method="get" id="<?="frm".$cat_name;?>">
            <input type="hidden" name="catid" value="<?=$catid?>">
            <input type="hidden" name="cat_name" value="<?=$cat_name?>">
          </form>
            <?php

            //FETCH THE SUBCATEGORIES OF A CATEGORY
            $sql = "SELECT * FROM subcategory where catid = '$catid' ";
            $getsubcat = mysqli_query($conn, $sql);

            if(mysqli_num_rows($getsubcat) >= 1){ ?>
              <ul>
              <?php while ($subcategory = mysqli_fetch_assoc($getsubcat)) {
                      $subcat_name = $subcategory['subcat_name'];
                      $subcatid = $subcategory['subcatid'];?>

                <!-- DISPLAYS THE SUB - CATEGORY -->
                <li>
                  <form class="frm_subcatname" action="prodgrid.php" method="get" id="<?="frm".$subcat_name;?>">
                  <input type="hidden" name="subcatid" value="<?=$subcatid?>">
                  <input type="hidden" name="subcat_name" value="<?=$subcat_name?>">
                  <a onclick="subcatfrm('<?=$subcat_name?>')"><?php echo $subcat_name ?></a>
                </form>
                </li>

              <?php } ?>
                  </ul>
              <?php  }?>




          </li>

            <?php }
          }?>

        </ul>


      <div class="account">
        <?php

        //IF USER IS NOT LOGGED IN
        if (!isset($_SESSION['userid'])) {
          echo '
          <ul>
          <li><a href="login.php">Login</a></li>
          </ul>';
        }

        //IF USER IS LOGGED IN
        else {
          $userid = $_SESSION['userid'];

          //CHECK IF USER TYPE/ROLE
          $sql = "SELECT * FROM user where userid = '$userid' and role = 'admin_user'";
          $res = mysqli_query($conn, $sql);

          //IF USER IS AN ADMIN
          if(mysqli_num_rows($res) != 0){
            echo '
            <ul>
              <li><a href="#">Account</a>
                <ul>
                  <li><a href="shoppingcart.php">Shopping Cart</a></li>
                  <li><a href="orderhistory.php">Orders</a></li>
                  <li><a href="admindashboard.php">Admin Dashboard</a></li>
                  <li><a href="accountsettings.php">Account Settings</a></li>
                  <form class="frmlogout" action="../../included/session.php" method="post" id="logoutfrm">
                    <input type="hidden" name="logout" value="logout">
                    <li><a onclick="frmsubmit()">Logout</a></li>
                  </form>
                </ul>
              </li>
            </ul>
            ';
          }

          //IF USER IS AN REGULAR USER
          else {
            echo '
            <ul>
              <li><a href="#">Account</a>
                <ul>
                  <li><a href="shoppingcart.php">Shopping Cart</a></li>
                  <li><a href="orderhistory.php">Orders</a></li>
                  <li><a href="accountsettings.php">Account Settings</a></li>
                  <form class="frmlogout" action="../../included/session.php" method="post" id="logoutfrm">
                    <input type="hidden" name="logout" value="logout">
                    <li><a onclick="frmsubmit()">Logout</a></li>
                  </form>
                </ul>
              </li>
            </ul>
            ';
          }


        }
         ?>
      </div>
  </nav>

  </body>
</html>

<script>
  function frmsubmit(){
    document.getElementById("logoutfrm").submit();
  }

  function subcatfrm(subcattype){
    let str = "frm";
    document.getElementById(str.concat(subcattype)).submit();
  }

  function catfrm(cattype){
    let str = "frm";
    document.getElementById(str.concat(cattype)).submit();
  }
</script>
