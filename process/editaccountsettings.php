<?php
include_once "../included/session.php";
include_once "../included/db_connection.php";

//IF ADDRESS IS EDITED
if(isset($_POST['street']) && isset($_POST['city']) && isset($_POST['province']) && isset($_POST['postal_code'])){

  $street = $_POST['street'];
  $city = $_POST['city'];
  $province = $_POST['province'];
  $postal_code = $_POST['postal_code'];
  $userid = $_POST['userid'];

  $address = $street.", ".$city.", ".$province." ".$postal_code;

  //IF ADDRESS FORM IS INCOMPLETE
  if(empty($street) || empty($city) || empty($province) || empty($postal_code) || empty($userid)) {
    echo "FILL IN THE MISSING FIELDS";
  }

  //IF FORM IS COMPLETE
  else {
    //INSERT ADDRESS OF USER
    $sql = "UPDATE `user` SET `address`='$address' WHERE userid = '$userid'";
    $res = mysqli_query($conn, $sql);

  }
}

//IF PASSWORD IS EDITED
elseif (isset($_POST['current_pword']) && isset($_POST['new_pword'])) {

  $current_pword = $_POST['current_pword'];
  $new_pword = $_POST['new_pword'];
  $userid = $_POST['userid'];

  //GET CURRENT PASSWORD OF USER
  $sql = "SELECT * FROM user where userid = '$userid'";
  $res =mysqli_query($conn, $sql);

  if(mysqli_num_rows($res) > 0){
    while ($user = mysqli_fetch_assoc($res)) {
      $pword = $user['password'];
    }
  }

  //IF FORM IS INCOMPLETE
  if (empty($current_pword) || empty($new_pword)) {
    echo "FILL IN THE MISSING FIELDS";
  }

  //IF FORM IS COMPLETE
  else {

    //IF FETCHED PASSWORD IS EQUAL TO INPUTTED CURRENT PASSWORD
    if ($pword == $current_pword) {
      $sql = "UPDATE `user` SET `password`='$new_pword' WHERE userid = '$userid'";
      $res =mysqli_query($conn, $sql);
    }

    //IF FETCHED PASSWORD DOES NOT MATCH TO WITH INPUTTED PASSWORD
    else {
      echo "PASSWORD DOES NOT MATCH. TRY AGAIN.";
    }
  }
}

/*else {
  echo "error";
}*/
 ?>
