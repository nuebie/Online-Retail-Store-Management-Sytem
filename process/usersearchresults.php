<?php
include "../included/db_connection.php";

$uname = $_POST['input'];
$strlength = $_POST['stringlen'];
$opprole;

echo '<table>
  <tr>
    <th>username</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Role</th>
    <th>Address</th>
    <th>Contact</th>
  </tr>
';

if ($strlength > 0) {
  $sql = "SELECT * FROM user WHERE username LIKE '$uname%'";
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
          <input type="submit" class="removebtn" name="" value="Remove">
        </form>
          </td>';
      echo '</tr>';

    }
  }
}

else {
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
          <input type="submit" class="removebtn" name="" value="Remove">
         </form>
        </td>';
       echo '</tr>';

    }
  }
}


echo '</table>';

?>
