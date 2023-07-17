<?php
include "../../included/session.php";
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../css/signupcss.css">
  </head>
  <body>
      <div class="flex_container">
        <div class="sign_frm">
          <div class="signuptxt"><h1>Sign up here</h1></div>
          <form class="" action="../../process/addnewaccount.php" method="post"><br>
            <h3>Personal Details</h3>
            <input type="text" class="fname" name="fname" value="" placeholder="first name"><br>
            <input type="text" class="lname" name="lname" value="" placeholder="last name"><br>
            <input type="text" class="contact_num" name="contact_num" value="" placeholder="phone number"><br>
            <input type="email" class="email" name="email" value="" placeholder="email"><br>

            <h3>Account Details</h3>
            <input type="text" class="uname" name="username" value="" placeholder="username"><br>
            <input type="password" class="pword" name="password" value="" placeholder="password"><br>

            <h3>Address</h3>
            <input type="text" class="street" name="street" value="" placeholder="street"><br>
            <input type="text" class="city" name="city" value="" placeholder="city"><br>
            <input type="text" class="province" name="province" value="" placeholder="province"><br>
            <input type="text" class="postal_code" name="postal_code" value="" placeholder="postal code"><br>

            <div class="signupbtn"><input type="submit" class="signup" name="signup" value="Sign up"></div>

          </form>
          <p class="signupvalidation">
            <?php
            if(isset($_SESSION["error"])){
              $error = $_SESSION["error"];
              echo $error;
              unset( $_SESSION["error"]);
            }
             ?>
          </p>
        </div>
      </div>
  </body>
</html>
