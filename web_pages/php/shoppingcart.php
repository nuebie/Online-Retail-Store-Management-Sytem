<?php
include_once "../../included/db_connection.php";
include_once "navbar.php";
$userid =  $_SESSION['userid'];
?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/cssshoppingcart.css">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        $("#editshippingaddressdiv").hide();

        //CHANGE SHIPPING ADDRESS BTN IS CLICKED
        $(document).on("click",'#changeshippingaddressbtn',function(){
            $("#editshippingaddressdiv").show();
        });

        //CONFIRM THE EDITED SHIPPING ADDRESS
        $(document).on("click",'#confirmbtn',function(){
            event.preventDefault();
            var street = $("#street").val();
            var city = $("#city").val();
            var province = $("#province").val();
            var postal_code = $("#postal_code").val();

            if(street == '' || city == '' || province == '' || postal_code == ''){
                $("#addressvalidation").empty().append("INCOMPLETE FORM. FILL IN REQUIRED FIELDS");
            }

            else{
              //alert("COMPLETE FORM");
              var address = street+", "+city+", "+province+", "+postal_code;
              $("#addresstxt").empty().append(address);
              $("#address").val(address);
              $("#addressvalidation").empty();
              $('#editshippingaddressfrm')[0].reset();
              $("#editshippingaddressdiv").hide();
            }

        });

        $(document).on("click",'#cancelbtn',function(){
            location.reload();
        });

      });
    </script>
  </head>
  <body>

    <div class="editshippingaddressdiv" id="editshippingaddressdiv">
      <div class="editshippingaddressdiv2">
        <form class="editshippingaddressfrm" id="editshippingaddressfrm" action="index.html" method="post">
        SHIPPING ADDRESS<br>
          <input class="addressinput" id="street" type="text" name="" value="" placeholder="Street"><br>
          <input class="addressinput" id="city" type="text" name="" value="" placeholder="City"><br>
          <input class="addressinput" id="province" type="text" name="" value="" placeholder="Province"><br>
          <input class="addressinput" id="postal_code" type="text" name="" value="" placeholder="Postal Code"><br>
          <input class="confirmbtn" id="confirmbtn" type="button" name="" value="Confirm">
          <input class="cancelbtn" id="cancelbtn" type="button" value="Cancel">
          <p class="addressvalidation" id="addressvalidation"></p>
        </form>
      </div>
    </div>

    <h1>Shopping Cart</h1>
    <div class="shippingaddressdiv">
      <div class="shippingaddress">
        <span class="location_icon"><ion-icon name="location-sharp"></ion-icon></span>
        <a class="shippingaddresstxt">SHIPPING ADDRESS</a> <br>
        <?php
        //RETRIEVE THE ADDRESS OF THE USER
        $sql = "SELECT * FROM user WHERE userid = '$userid'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0){
          while ($user = mysqli_fetch_assoc($res)) {
            $address = $user['address'];
          }
          echo '<span id="addresstxt">'.$address.'</span>';
        }
         ?>
        <button type="button" class="editshippingaddressbtn" name="button" id="changeshippingaddressbtn">Change</button>
        <form class="" action="../../process/orderplaced.php" id="shippingaddressfrm" method="post">
          <input type="hidden" name="address" id="address" value="<?= $address ?>">
        </form>
      </div>
    </div>
    <div class="flexbox1">
      <div class="products">

        <?php

        //FIND THE SHOPPING CART ID OF THE USER AND TOTAL OF SHOPPING CART
        $sql = "SELECT * FROM shopping_cart WHERE userid = '$userid'";
        $res = mysqli_query($conn, $sql);

        if(mysqli_num_rows($res) > 0){
          while ($shoppingcart = mysqli_fetch_assoc($res)) {
            $cartid = $shoppingcart['cartid'];
            $total = $shoppingcart['total'];
          }
        }

        //GET THE PRODUCT ID OF THE PRODUCTS INSIDE THE SHOPPING CART
        $sql = "SELECT * FROM included_cart_item WHERE cartid = '$cartid'";
        $getshoppingcartitem = mysqli_query($conn, $sql);

        if(mysqli_num_rows($getshoppingcartitem) > 0){
          while ($product = mysqli_fetch_assoc($getshoppingcartitem)) {
              $prodid = $product['prodid'];
              $subtotal = $product['subtotal'];

              // GET THE PRODUCT INFO OF THE PRODUCTS IN THE SHOPPING CART
              $sql = "SELECT * FROM product WHERE prodid = '$prodid'";
              $getprodinfo = mysqli_query($conn, $sql);

              if(mysqli_num_rows($getprodinfo) > 0){
                while ($prodinfo = mysqli_fetch_assoc($getprodinfo)) {
                  $prodid = $prodinfo['prodid'];
                  $prod_image = $prodinfo['prod_image'];
                  $prod_name = $prodinfo['prod_name'];
                  $catid = $prodinfo['catid'];

                  //FETCH CATEGORY OF THE PRODUCT
                  $sql = "SELECT * FROM category WHERE catid = '$catid'";
                  $getprodcat = mysqli_query($conn, $sql);

                  if(mysqli_num_rows($getprodcat) > 0){
                    while ($prodcat = mysqli_fetch_assoc($getprodcat)){
                      $cat_name = $prodcat['cat_name'];
                    }}
         ?>

        <div class="prod_card">
          <div class="prod_icon">
            <img src="../../product_images/<?=$prod_image?>" alt="">
          </div>
          <div class="prod_details">
            <span class="prod_name"><?= $prod_name?></span><br>
             <?= $cat_name?><br>
            Quantity: <?= $product['quantity']?>
          </div>
          <div class="prod_price">
            PHP <?= $subtotal?>
          </div>
        </div>
        <a class="removeitem" onclick="editcartfrm('<?=$prodid?>')">Remove</a>

        <form class="" action="../../process/editcartitem.php" method="post" id = "<?="frm".$prodid;?>">
          <input type="hidden" name="cartid" value="<?=$cartid?>">
          <input type="hidden" name="prodid" value="<?=$prodid?>">
          <input type="hidden" name="subtotal" value="<?=$subtotal?>">
          <input type="hidden" name="total" value="<?=$total?>">
          <input type="hidden" name="quantity" value="<?=$product['quantity']?>">
        </form>

      <?php }}
    } }?>

      </div>

      <div class="price_details">
        <h3>Product Details</h3>
        Products (n items): <?=$total?> <br>
        Delivery Charges: free <br>
        <hr>
        Total Amount: <span class="total_amount">PHP <?=$total?></span>
        <div id="paypal_btn" class="paypal_btn">

        </div>
      </div>
    </div>

    <script src="https://www.paypal.com/sdk/js?client-id=AUan2coOLZVeEw_opw8VyuygPdWZCSD27nI5dv84a7Jd7tfGJtij7zVZe5r6VCivrxZbZdq2r60izC4I&currency=PHP"></script>
    <!--<script src="paypal_btn.js"></script>-->
    <script>
    paypal.Buttons({
      style:{
        shape:"pill"
      },

      createOrder: function (data, actions) {
             return actions.order.create({
                 purchase_units : [{
                     amount: {
                         value: '<?=$total?>',
                         currency: 'PHP'
                     }
                 }]
             });
         },
      onApprove: function(data, actions) {
         // This function captures the funds from the transaction.
         return actions.order.capture().then(function(details) {
          //window.location.replace("../../process/orderplaced.php");
          document.getElementById("shippingaddressfrm").submit()
         });
       }

    }).render('#paypal_btn');
    </script>

    <script>
      function editcartfrm(prodid){
        let str = "frm";
        document.getElementById(str.concat(prodid)).submit();
      }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
