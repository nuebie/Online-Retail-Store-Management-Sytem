<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/cssmanageorders.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title></title>
    <script type="text/javascript">
        $(document).ready(function(){
          var orderid;
          $("#orderdetaildiv").hide();

          $(document).on("submit",'form',function(){
          event.preventDefault();
           orderid = $("input[name='orderid']",this).val();
           var frmname = $("input[name='frmname']",this).val();
           var status = $("input[name='status']",this).val();
           var admin = $("input[name='admin_username']",this).val();

           //IF ADMIN CONFIRMS AN ORDER
           if(frmname == "confirm"){

             $("#ordersection").load("../../process/updateorderstatus.php", {
               order: orderid,
               orderstatus : status,
               admin_username : admin
             });
             $("#trackingdiv").show();
           }

           //IF ADMIN CANCELS AN ORDER
           if (frmname == "cancel") {
             status = "cancelled order";
             $("#ordersection").load("../../process/updateorderstatus.php", {
               order: orderid,
               orderstatus : status,
               admin_username: admin
             });
           }

           //IF ADMIN EDITS THE TRACKING NUMBER OF A CONFIRMED ORDER
           if (frmname == "edittracking") {
             $("#trackingdiv").show();
           }

          });

         //IF ADMIN WANTS TO INPUT NEW TRACKING NUMBER OF ORDER
         $("#trackingconfirm").click(function(){
           var trackingnum = $("#trackingnum").val();

           $("#ordersection").load("../../process/inserttracking.php", {
             order: orderid,
             tracking: trackingnum
           });
           $("#trackingnum").val("");
          $("#filterstatus")[0].selectedIndex = 0;
           $("#trackingdiv").hide();
         });

         //IF ADMIN DOES NOT WANT TO INPUT TRACKING NUMBER TO ORDER
         $("#trackingcancel").click(function(){
           var trackingnum = $("#trackingnum").val();
           $("#trackingnum").val("");
           $("#trackingdiv").hide();
         });

          //IF ADMIN WANTS TO VIEW ORDER BY STATUS
          $("#filterstatus").change(function(){
            var filterstatus = $(this).val();
            $("#ordersection").load("../../process/displayorderbystatus.php", {
            status: filterstatus
            });
          });

          //IF ADMIN WANTS TO SEARCH FOR ORDER USING ORDER ID
          $("#search").on("input", function(){
            var ordrid = $(this).val();
            var strlength = $(this).val().length;
            $("#filterstatus")[0].selectedIndex = 0;
            $("#ordersection").load("../../process/ordersearchresults.php", {
              input: ordrid,
              stringlen : strlength
              });
            });

          $(document).on("click",'#orderid',function(){
            event.preventDefault();
            var orderid = $(this).attr("name");

            $("#orderdetailbox").load("../../process/vieworderdetails.php", {
              orderid: orderid
              });

            $("#orderdetaildiv").show();

          });

          $(document).on("click",'#closeorderdetailbtn',function(){
            event.preventDefault();
            $("#orderdetailbox").empty();
            $("#orderdetaildiv").hide();
          });

        });
    </script>
  </head>
  <body>

    <div class="orderdetaildiv" id="orderdetaildiv">
      <div class="bgcolordiv">
        <div class="orderdetailbox" id="orderdetailbox">



        </div>
      </div>
    </div>

    <form class="" action="index.html" method="post">
      <input type="text" name="" id="search" value="" placeholder="Search Order by Order ID">
    </form>

    <div class="trackingdiv" id="trackingdiv">
      <form class="" action="index.html" method="post" class="trackingfrm">
        <input type="text" name="" value="" class="trackingnum" placeholder="INPUT TRACKING NUMBER" id="trackingnum"><br>
        <button type="button" class="trackingconfirm" name="button" id="trackingconfirm">CONFIRM</button>
        <button type="button" class="trackingcancel" name="button" id="trackingcancel">CANCEL</button>
      </form>
    </div>

    <div class="flexbox">
      <div class="flexcontent">
        <select class="" name="" id="filterstatus">
        <option value="Select">Select</option>
        <option>Fulfilled Orders</option>
        <option>Unfulfilled Orders</option>
        <option>Cancelled Orders</option>
        </select>
      </div>
    </div>

    <div class="ordersection" id="ordersection">
      <table>
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

        <?php
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
         ?>

      </table>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
