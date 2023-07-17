<?php
include "../included/db_connection.php";
include "../included/session.php";

//IF THE SIGN UP FORM IS COMPLETE
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['username']) && isset($_POST['email'])
    && isset($_POST['contact_num']) && isset($_POST['password']) && isset($_POST['street'])  && isset($_POST['city'])  && isset($_POST['province'])  && isset($_POST['postal_code'])){

      $fname = $_POST['fname'];
      $lname = $_POST['lname'];
      $uname = $_POST['username'];
      $email = $_POST['email'];
      $contact_num = $_POST['contact_num'];
      $pword = $_POST['password'];
      $street = $_POST['street'];
      $city = $_POST['city'];
      $province = $_POST['province'];
      $postal_code = $_POST['postal_code'];
      $address = $street.", ".$city.", ".$province." ".$postal_code;

      //IF FORM IS INCOMPLETE
      if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pword) || empty($street) || empty($city) || empty($province) || empty($postal_code) || empty($contact_num)) {
      $error = "FILL IN ALL FIELDS IN THE FORM";
      $_SESSION['error'] = $error;
      header("Location: ../web_pages/php/signup.php");
      }

      //IF FORM IS COMPLETE
      else {

        //CHECK IF SAME USERNAME EXIST
        $sql = "SELECT * FROM user where username='$uname'";
        $res = mysqli_query($conn, $sql);

        //IF THERE IS A DUPLICATE USERNAME
        if(mysqli_num_rows($res) > 0){
          $error = "USERNAME ALREADY EXISTS. CHOOSE ANOTHER USERNAME";
          $_SESSION['error'] = $error;
          header("Location: ../web_pages/php/signup.php");
        }

        //IF NO DUPLICATE USERNAME FOUND
        else {
          //INSERT ACCOUNT DETAILS OF NEWLY CREATED ACCOUNT INTO DATABASE
          $userid = uniqid('user');
          $sql = "INSERT INTO `user`(`userid`, `username`, `fname`, `lname`, `email`, `password`, `address`, `contact_num`) VALUES ('$userid','$uname','$fname','$lname','$email','$pword','$address','$contact_num')";
          $res = mysqli_query($conn, $sql);

          //ASSIGN A CARTID TO THE USER FOR THE SHOPPING CART
          $sql = "INSERT INTO `shopping_cart`(`userid`) VALUES ('$userid')";
          $res = mysqli_query($conn, $sql);
          header("location: ../web_pages/php/login.php");
        }
      }

    }




 ?>
