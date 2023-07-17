<?php
include "../included/db_connection.php";
include "../included/session.php";
$userid =  $_SESSION['userid'];

$orderid = $_POST['input'];
$strlength = $_POST['stringlen'];

echo '<table>
  <tr>
  <th>Order ID</th>
  <th>Order Date</th>
  <th>Customer</th>
  <th>Shipping Address</th>
  <th>Order Status</th>
  <th>Fulfilled By</th>
  <th>Tracking</th>
  <th>Total</th>
  </tr>
';

if ($strlength > 0) {
  $sql = "SELECT * FROM `order` WHERE orderid LIKE '$orderid%'";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){

    while($order = mysqli_fetch_assoc($res)){
      $orderid = $order['orderid'];
      $order_date = $order['order_date'];
      $customer = $order['customer'];
      $shipping_address = $order['shipping_address'];
      $status;
      $admin = NULL;
      $tracking_num = NULL;
      $total = $order['total'];

      //GET STATUS OF ORDER AND OTHER DETAILS
      $sql = "SELECT * FROM `order_status` where orderid = '$orderid'";
      $getstatus = mysqli_query($conn,$sql);

      while($currentstatus = mysqli_fetch_assoc($getstatus)){
          $status = $currentstatus['status'];
          $tracking_num = $currentstatus['tracking_num'];
          $admin = $currentstatus['admin'];
        }

      echo '<tr>';
      echo '<td><a href="#" class="orderid" id="orderid" name="'.$orderid.'">'.$orderid.'</a></td>';
      echo '<td>'.$order_date.'</td>';
      echo '<td>'.$customer.'</td>';
      echo '<td>'.$shipping_address.'</td>';
      echo '<td>'.$status.'</td>';
      echo '<td>'.$admin.'</td>';
      echo '<td>'.$tracking_num.'</td>';
      echo '<td>'.$total.'</td>';

      //IF STATUS IS UNFULFILLED
      if ($status == "unfulfilled") {
        echo '<td class="td_btn">
          <form class="statusfrm">
            <input type="hidden" name="frmname" value="confirm">
            <input type="hidden" name="orderid" value="'.$orderid.'">
            <input type="hidden" name="status" value="'.$status.'">
            <input type="hidden" name="admin_username" value="'.$userid.'">

          <input type="submit" class="confirmbtn" name="confirmorder" value="Confirm Order" id="submitcon">
         </form>
         <form class="statusfrm">
           <input type="hidden" name="frmname" value="cancel">
           <input type="hidden" name="orderid" value="'.$orderid.'">
           <input type="hidden" name="status" value="'.$status.'">
           <input type="hidden" name="admin_username" value="'.$userid.'">
           <input type="submit" class="cancelbtn" name="cancelorder" value="Cancel Order" id="submitcan">
         </form>
        </td>';
      }

      //IF STATUS IS FULFILLED/CONFIRMED
      elseif ($status == "fulfilled") {
        echo '<td class="td_btn">
          <form class="statusfrm">
            <input type="hidden" name="frmname" value="edittracking">
            <input type="hidden" name="orderid" value="'.$orderid.'">
            <input type="hidden" name="status" value="'.$status.'">
            <input type="hidden" name="admin_username" value="'.$userid.'">

          <input type="submit" class="confirmbtn" name="confirmorder" value="Edit Tracking" id="submitcon">
         </form>
         </td>';
      }
      echo '</tr>';

    }
  }
}

else {
  $sql = "SELECT * FROM `order` ORDER BY orderid DESC";
  $res = mysqli_query($conn,$sql);

  if(mysqli_num_rows($res) > 0){

    while($order = mysqli_fetch_assoc($res)){
      $orderid = $order['orderid'];
      $order_date = $order['order_date'];
      $customer = $order['customer'];
      $shipping_address = $order['shipping_address'];
      $status;
      $admin = NULL;
      $tracking_num = NULL;
      $total = $order['total'];

      //GET STATUS OF ORDER AND OTHER DETAILS
      $sql = "SELECT * FROM `order_status` where orderid = '$orderid'";
      $getstatus = mysqli_query($conn,$sql);

      while($currentstatus = mysqli_fetch_assoc($getstatus)){
          $status = $currentstatus['status'];
          $tracking_num = $currentstatus['tracking_num'];
          $admin = $currentstatus['admin'];
        }

      echo '<tr>';
      echo '<td><a href="#" class="orderid" id="orderid" name="'.$orderid.'">'.$orderid.'</a></td>';
      echo '<td>'.$order_date.'</td>';
      echo '<td>'.$customer.'</td>';
      echo '<td>'.$shipping_address.'</td>';
      echo '<td>'.$status.'</td>';
      echo '<td>'.$admin.'</td>';
      echo '<td>'.$tracking_num.'</td>';
      echo '<td>'.$total.'</td>';

      //IF STATUS IS UNFULFILLED
      if ($status == "unfulfilled") {
        echo '<td class="td_btn">
          <form class="statusfrm">
            <input type="hidden" name="frmname" value="confirm">
            <input type="hidden" name="orderid" value="'.$orderid.'">
            <input type="hidden" name="status" value="'.$status.'">
            <input type="hidden" name="admin_username" value="'.$userid.'">

          <input type="submit" class="confirmbtn" name="confirmorder" value="Confirm Order" id="submitcon">
         </form>
         <form class="statusfrm">
           <input type="hidden" name="frmname" value="cancel">
           <input type="hidden" name="orderid" value="'.$orderid.'">
           <input type="hidden" name="status" value="'.$status.'">
           <input type="hidden" name="admin_username" value="'.$userid.'">
           <input type="submit" class="cancelbtn" name="cancelorder" value="Cancel Order" id="submitcan">
         </form>
        </td>';
      }

      //IF STATUS IS FULFILLED/CONFIRMED
      elseif ($status == "fulfilled") {
        echo '<td class="td_btn">
          <form class="statusfrm">
            <input type="hidden" name="frmname" value="edittracking">
            <input type="hidden" name="orderid" value="'.$orderid.'">
            <input type="hidden" name="status" value="'.$status.'">
            <input type="hidden" name="admin_username" value="'.$userid.'">

          <input type="submit" class="confirmbtn" name="confirmorder" value="Edit Tracking" id="submitcon">
         </form>
         </td>';
      }
      echo '</tr>';

    }
  }
}
