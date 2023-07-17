<?php
include "db_connection.php";
session_start();

//IF USER IS ATTEMPTING TO LOGIN
if(isset($_POST['uname']) && isset($_POST['pword'])){

  $uname = $_POST['uname'];
  $pword = $_POST['pword'];

  $sql = "SELECT * FROM user where username = '$uname' and password = '$pword'";
  $res = mysqli_query($conn, $sql);

  // IF AN ACCOUNT IS FOUND
  if(mysqli_num_rows($res) == 1){
      while ($user = mysqli_fetch_assoc($res)) {
        $userid = $user['userid'];
      }
    $_SESSION['userid'] = $userid;
    header("Location: ../web_pages/php/index.php"); //NOTE: MUST GO BACK TO PREVIOUS APGE
  }

  // IF NO ACCOUNT IS FOUND
  else {
    $error = "NO ACCOUNT FOUND. TRY AGAIN.";
    $_SESSION['error'] = $error;
    header("Location: ../web_pages/php/login.php");

  }

}

// IF USER LOGOUT OF THEIR ACCOUNT
if(isset($_POST['logout'])){
  unset($_SESSION['userid']);
  header("Location: ../web_pages/php/index.php");
}

?>
