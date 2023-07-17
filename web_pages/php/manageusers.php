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
    <link rel="stylesheet" href="../css/cssmanageusers.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">


          $(document).ready(function(){

            //SEARCH FOR USER USING USERNAME
            $("#search").on("input", function(){
              var uname = $(this).val();
              var strlength = $(this).val().length;

              $("#usersection").load("../../process/usersearchresults.php", {
                input: uname,
                stringlen : strlength
                });
              });

          //CHANGE A USER'S ROLE
          $(document).on("change",'select',function(){
             var role = $(this).val();
             var userid = $(this).attr("id");

              $(this).load("../../process/changeuserrole.php", {
                newrole: role,
                postuserid: userid
                });
             });

           $(document).on("submit",'form',function(){
             event.preventDefault();
             var userid = $("input[name='userid']",this).val();

             $("#usersection").load("../../process/deleteuser.php", {
               user: userid
               });
            });



   });



  </script>
  </head>
  <body>
    <form class="usersearchfrm" action="index.html" method="post">
      <input type="text" name="" value="" id="search" placeholder="Search User by Username">
    </form>

    <div class="usersection" id = "usersection">

    <table>
      <tr>
        <th>username</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Role</th>
        <th>Address</th>
        <th>Contact</th>
      </tr>

      <?php
      //GET USER INFORMATION
      $sql = "SELECT * FROM user";
      $res = mysqli_query($conn,$sql);

      if(mysqli_num_rows($res) > 0){

        while($user = mysqli_fetch_assoc($res)){
          $userid = $user['userid'];
          $username = $user['username'];
          $pword = $user['password'];
          $fname = $user['fname'];
          $lname = $user['lname'];
          $role = $user['role'];
          $address = $user['address'];
          $contact_num = $user['contact_num'];

          echo '<tr>';
          echo '<td>'.$username.'</td>';
          echo '<td>'.$fname.'</td>';
          echo '<td>'.$lname.'</td>';

          //IF CURRENT ROLE OF USER IS REGULAR USER
          if ($role == "regular_user") {
            $opprole = "admin_user";
            echo '<td>
            <select id="'.$userid.'">
              <option>'.$role.'</option>
              <option>'.$opprole.'</option>
            </select>
           </td>';
            }

          //IF THE CURRENT ROLE OF USER IS ADMIN USER
          else {
            $opprole = "regular_user";
            echo '<td>
            <select id="'.$userid.'">
              <option>'.$role.'</option>
              <option>'.$opprole.'</option>
            </select>
            </td>';
            }


          echo '<td>'.$address.'</td>';
          echo '<td>'.$contact_num.'</td>';
          echo '<td class="td_btn">
            <form class="removefrm" action="index.html" method="post">
              <input type="hidden" name="userid" value="'.$userid.'">
              <input type="submit" class="removebtn" name="" value="Remove">
            </form>
            </td>';
          echo '</tr>';

        }
      }
       ?>
    </table>
    </div>
</html>
