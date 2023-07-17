<?php
include "../included/db_connection.php";

$newrole = $_POST['newrole'];
$userid = $_POST['postuserid'];

$sql = "UPDATE `user` SET `role`='$newrole' where userid = '$userid'";
$res = mysqli_query($conn,$sql);

//IF NEW ROLE OF USER IS REGULAR USER
if ($newrole == "regular_user") {
  echo '<option>'.$newrole.'</option>';
  echo '<option>admin</option>';
}

//IF NEW ROLE OF USER IS ADMIN USER
else {
  echo '<option>'.$newrole.'</option>';
  echo '<option>regular user</option>';
}


 ?>
