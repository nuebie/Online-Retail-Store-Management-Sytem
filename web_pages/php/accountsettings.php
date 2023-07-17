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
    <link rel="stylesheet" href="../css/cssaccountsettings.css">
    <link rel="stylesheet" href="../css/cssmanagecategory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){

        //IF USER CLICKS "SAVE" OF ADDRESS
        $(document).on("click",'#addressbtn',function(){
          event.preventDefault();
          var street = $("#street").val();
          var city = $("#city").val();
          var province = $("#province").val();
          var postal_code = $("#postal_code").val();
          var userid = $("#userid").val();

          $.ajax({
          url:"../../process/editaccountsettings.php",
          method:"POST",
          data:{street:street, city: city, province: province, postal_code: postal_code, userid: userid},
          success:function(data)
            {
              if (data == "FILL IN THE MISSING FIELDS") {
                $("#addressvalidation").empty().append(""+data+"");
              }

              else{
                location.reload();
              }
            }
          });
        });

        //IF USER CLICKS "SAVE" OF PASSWORD
        $(document).on("click",'#passwordbtn',function(){
          event.preventDefault();
          var current_pword = $("#current_pword").val();
          var new_pword = $("#new_pword").val();
          var userid = $("#userid").val();


          $.ajax({
          url:"../../process/editaccountsettings.php",
          method:"POST",
          data:{current_pword: current_pword, new_pword: new_pword, userid: userid},
          success:function(data)
            {
              if (data == "FILL IN THE MISSING FIELDS" || data == "PASSWORD DOES NOT MATCH. TRY AGAIN.") {
                $("#passwordvalidation").empty().append(""+data+"");
              }

              else{
                location.reload();
              }
            }
          });
        });

        });

  </script>
  </head>

  <body>
    <h1>Account Settings</h1>

    <div class="flexcontainer">

    <?php

    $street = NULL;
    $city = NULL;
    $province = NULL;
    $postal_code = NULL;

    //FETCH ADDRESS
    $sql = "SELECT * FROM user where userid = '$userid'";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
      while ($user = mysqli_fetch_assoc($res)){
          $address = $user['address'];
          $arr = explode(", ",$address);
          $street = $arr[0];
          $city = $arr[1];
          $separatestr = $arr[2];

          $x=0;
          $y=0;
          $postal_code = array();
          $province = array();
          for ($i=0; $i <strlen($separatestr) ; $i++) {
            if (is_numeric($separatestr[$i])) {
                $postal_code[$x] = $separatestr[$i];
                $x++;
            }
            else {
              $province[$y] = $separatestr[$i];
              $y++;
            }
          }
          $strprovince = implode("",$province);
          $strpostal_code = implode("",$postal_code);
      }
    }
     ?>

    <div class="address">
      <h3>Address</h3>
      <form class="addressfrm" action="../../process/editaccountsettings.php" method="post">
        <input type="hidden" name="userid" id="userid" value="<?=$userid?>">
        Street <input type="text" class="street" id="street" name="street" value="<?=$street?>"><br>
        City <input type="text" class="city" id="city" name="city" value="<?=$city?>"><br>
        Province <input type="text" class="province" id="province" name="province" value="<?=$strprovince?>"><br>
        Postal Code <input type="text" class="postal_code" id="postal_code" name="postal_code" value="<?=$strpostal_code?>"><br>
        <div class="submitbtn">
          <input type="button" class="save" id="addressbtn" name="addressbtn" value="Save">
        </div>
      </form>
      <p class="addressvalidation" id="addressvalidation"></p>
    </div>

    <div class="password">
        <h3>Password</h3>
        <form class="passwordfrm" method="post">
          Password <input type="password" class="current_pword" id="current_pword" name="" value=""><br>
          New Password <input type="password" class="new_pword" id="new_pword" name="" value=""><br>
          <div class="submitbtn">
            <input type="button" class="save" id="passwordbtn" name="passwordbtn" value="Save">
          </div>
        </form>
        <p class="passwordvalidation" id="passwordvalidation"></p>
      </div>

    </div>
  </body>
</html>
