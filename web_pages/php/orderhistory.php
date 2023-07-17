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
    <link rel="stylesheet" href="../css/cssorderhistory.css">
  </head>
  <body>
    <h1>Order History</h1>

    <div class="flexcontainer">

      <table>
        <tr>
          <th>Order</th>
          <th>Date</th>
          <th>Status</th>
          <th>Tracking</th>
          <th>Total</th>
        </tr>

        <?php

        //GET ALL PLACED ORDERS OF THE USER
        $sql = "SELECT * FROM `order` WHERE customer = '$userid' ORDER BY orderid DESC";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0){
          while ($order = mysqli_fetch_assoc($res)) {
            $orderid = $order['orderid'];


            //GET ORDER STATUS AND TRACKING
            $sql = "SELECT * FROM `order_status` WHERE orderid = '$orderid'";
            $getorderfulfillment = mysqli_query($conn, $sql);

            if(mysqli_num_rows($getorderfulfillment) > 0){
              while ($orderfulfillment = mysqli_fetch_assoc($getorderfulfillment)) {
                $status = $orderfulfillment['status'];

                //IF NO TRACKING NUMBER IS SET IN THE ORDER
                if(is_null($orderfulfillment['tracking_num']))
                    $tracking_num = NULL;

                //IF TRACKING NUMBER IS SET
                else
                    $tracking_num = $orderfulfillment['tracking_num'];
              }}

         ?>
        <tr>
          <form class="" action="orderdetail.php" method="post" id="<?="frm".$order['orderid'];?>">
              <input type="hidden" name="orderid" value="<?= $order['orderid']?>">
              <input type="hidden" name="total" value="<?= $order['total']?>">
              <td><a class="orderid" onclick="orderidfrm('<?=$order['orderid']?>')"><?= $order['orderid']?></a></td>
          </form>

          <td><?=$order['order_date']?></td>
          <td><?=$status?></td>
          <td><?=$tracking_num?></td>
          <td><?= $order['total']?></td>
        </tr>

      <?php }
    } ?>



    </table>

   </div>
  </body>
</html>

<script>
  function orderidfrm(orderid){
    let str = "frm";
    document.getElementById(str.concat(orderid)).submit();
  }
</script>
