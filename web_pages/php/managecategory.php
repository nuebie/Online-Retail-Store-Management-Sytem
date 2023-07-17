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
    <link rel="stylesheet" href="../css/cssmanagecategory.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var i=0;
        $("#inputnewcatdiv").hide();
        $("#viewcatdiv").hide();

        //ADD NEW CATEGORY IS CLICKED
        $(document).on("click",'#addcatbtn',function(){
            $("#inputnewcatdiv").show();
        });

        //ADD SUBCATEGORY TO NEW CATEGORY
        $(document).on("click",'#addsubcatbtn',function(){
          i++;
        //  $("#inputnewcattable").append('<tr id="row'+i+'"><td><input type="text" id="subcategory'+i+'" name="subcategory'+i+'" value=""></td><td><input type="button" name="'+i+'" id="removesubcatbtn" value="X"></td></tr>');
        $("#subcategories").append('<div id="subcategory'+i+'">Subcategory '+i+':<input type="text" class="subcategoryname" id="subcategoryname'+i+'" name="subcategoryname'+i+'" value=""><button type="button" class="removesubcatbtn" id="removesubcatbtn'+i+'" name="button"><span class="removesubcat_icon"><ion-icon name="close-circle-outline"></ion-icon></span></button><br></div>');
        });

        //REMOVE A SUBCATEGORY FIELD IN THE NEW CATEGORY
        $(document).on("click",'[id^=removesubcatbtn]',function(){
          var subcat=$(this).attr("id");
          var substr= subcat.substring(15);
          $("#subcategoryname"+substr+"").val('');
          $("#subcategory"+substr+"").hide();
        });

        //SUBMIT NEW CATEGORY
        $(document).on("click",'#confirmnewcatbtn',function(){
          event.preventDefault();
          var serform= $("#newcatfrm").serialize();
        //  alert(serform);
          $("#categories").load("../../process/addnewcategory.php", {
              form: serform
              });
        /*  $("#inputnewcatdiv").hide();
          $('#newcatfrm').trigger("reset");
          $("[id^=subcategory]").remove();
          i=0;*/
          location.reload();
        });

        //CANCEL/EXIT OUT OF THE CATEGORY DETAILS
        $(document).on("click",'#cancelnewcatbtn',function(){
          location.reload();
        });

        //DELETE EXISTING CATEGORY
        $(document).on("click","[id^=delcatbtn]",function(){
          event.preventDefault();
          var id = $(this).attr("name");

            $.ajax({
              url:"../../process/deletecategory.php",
              method:"POST",
              data:{catid:id, delcat:"deletecat"},
              success:function(data)
              {
                if (data == 1) {
                  location.reload();
                }
                else {
                  alert("CANNOT DELETE THIS CATEGORY");
                }
              }
            });
        });

        //CLICK ON A SPECIFIC CATEGORY TO VIEW OR EDIT
        $(document).on("click",'#catid',function(){
          event.preventDefault();
          var id = $(this).attr("name");
          $("#viewcatdiv").load("../../process/viewcategory.php", {
              catid: id
              });
          $("#viewcatdiv").show();
        });

        //IF CATEGORY NAME HAS BEEN EDITED
        $(document).on("input","#catinput",function(){
          $("#savecatbtn").show();
        });

        //IF SUBCATEGORY NAME HAS BEEN EDITED
        $(document).on("input","[id^=subcatinput]",function(){
          var getid = $(this).attr("id");
          var substr = getid.substring(11);
          $("#savesubcatbtn"+substr+"").show();
          $("#deletesubcatbtn"+substr+"").hide();
        });

        //UPDATE CATEGORY NAME
        $(document).on("click","#savecatbtn",function(){
            event.preventDefault();
            var newcatname = $("#catinput").val();
            var id = $(this).attr("name");

            $.ajax({
        			url:"../../process/editcategory.php",
        			method:"POST",
        			data:{catid:id, new_cat_name: newcatname},
        			success:function(data)
        			{

        			}
        		});
            $("#savecatbtn").hide();
        });

        //UPDATE SUBCATEGORY NAME
        $(document).on("click","[id^=savesubcatbtn]",function(){
          event.preventDefault();
          var getid = $(this).attr("id");
          var substr = getid.substring(13);
          var newsubcatname = $("#subcatinput"+substr+"").val();
          var id = $(this).attr("name");

            $.ajax({
        			url:"../../process/editcategory.php",
        			method:"POST",
        			data:{subcatid:id, new_subcat_name: newsubcatname},
        			success:function(data)
        			{

        			}
        		});
            $("#savesubcatbtn"+substr+"").hide();
            $("#deletesubcatbtn"+substr+"").show();
        });


        //DELETE EXISTING SUBCATEGORY FROM CATEGORY
        $(document).on("click","[id^=deletesubcatbtn]",function(){
          event.preventDefault();
          var getid = $(this).attr("id");
          var substr = getid.substring(15);
          var subcatname = $("#subcatinput"+substr+"").val();
          var id = $(this).attr("name");

            $.ajax({
              url:"../../process/editcategory.php",
              method:"POST",
              data:{subcatid:id, subcat_name: subcatname},
              success:function(data)
              {
                if (data == 1) {
                  $("#savesubcatfrm"+substr+"").hide();
                  $("#deletesubcatfrm"+substr+"").show();
                  $("#existingsubcategorydiv"+substr+"").remove();
                }
                else {
                  alert("CANNOT DELETE THIS SUBCATEGORY");
                }
              }
            });
        });

        //ADD NEW SUBCATEGORY TO EXISTING CATEGORY
        $(document).on("click",'#addnewsubcat',function(){
          i++;
          $("#newsubcatfrm").append('<div id="newsubcategorydiv'+i+'">Subcategory '+i+':<input type="text" class="subcategoryname" id="newsubcategoryname'+i+'" name="newsubcategoryname'+i+'" value=""><button type="button" class="removesubcatbtn" id="removenewsubcatbtn'+i+'" name="button"><span class="removesubcat_icon"><ion-icon name="close-circle-outline"></ion-icon></span></button><br></div>');
        });

        //REMOVE A SUBCATEGORY FIELD IN THE EXISTING CATEGORY
        $(document).on("click",'[id^=removenewsubcatbtn]',function(){
          var subcat=$(this).attr("id");
          var substr= subcat.substring(18);
          $("#newsubcategoryname"+substr+"").val('');
          $("#newsubcategorydiv"+substr+"").hide();
        });

        //CONFIRM UPDATED CATEGORY
        $(document).on("click",'#confirmedit',function(){
          event.preventDefault();
          var serform= $( "#newsubcatfrm" ).serialize();
          var id = $("#newsubcatfrm").attr("name");
          //alert(serform+" "+id);
        /*  $("#categorysection").load("../../process/addsubcategory.php", {
              form1: serform,
              catid1: id
            });*/
            $.ajax({
        			url:"../../process/addsubcategory.php",
        			method:"POST",
        			data:{form1: serform, catid1: id},
        			success:function(data)
        			{
              location.reload()
        			}
        		});
        });

        //CANCEL/EXIT OUT OF THE CATEGORY DETAILS
        $(document).on("click",'#cancelcatbtn',function(){
          location.reload();
        });

      });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </head>
  <body>
    <div class="inputnewcatdiv" id="inputnewcatdiv">
      <form class="newcatfrm" action="index.html" id="newcatfrm" method="post">
        Category:<input type="text" class="categoryname" name="categoryname" value="">
        <button type="button" name="button" class="addsubcatbtn"  id="addsubcatbtn">
          <span class="addsubcat_txt">Add Subcategory</span>
          <span class="addsubcat_icon"><ion-icon name="add-circle-outline"></ion-icon></span>
        </button>
        <br>

        <div class="subcategories" id="subcategories">

        </div>

        <div class="newcatbuttonsdiv">
          <button type="button" class="confirmnewcatbtn" id="confirmnewcatbtn">Confirm</button>
          <button type="button" class="cancelnewcatbtn" id="cancelnewcatbtn">Cancel</button>
        </div>

      </form>
    </div>

    <div class="viewcatdiv" id="viewcatdiv">

    </div>

      <h1>Manage Categories & Subcategories</h1>

    <div class="addcatbtndiv">
    <button type="button" class="addnewcatbtn" id="addcatbtn" name="button">
    <span class="addnewcat_txt">Add New Category</span>
    <span class="addnewcat_icon"><ion-icon name="add-circle-outline"></ion-icon></span>
    </button>
    </div>

    <div id="categories" class="categorysection">
      <table class="displaycategory">
        <tr>
          <th>Categories</th>
        </tr>

        <?php

        //GET ALL CATEGORIES
        $sql = "SELECT * FROM `category`";
        $res = mysqli_query($conn, $sql);
        //FOR THE CSS STYLING
        $lastrow = 1;

        if(mysqli_num_rows($res) > 0){
          while ($category = mysqli_fetch_assoc($res)) {
            $catid = $category['catid'];
            $cat_name = $category['cat_name'];

            echo '<tr>';
            if($lastrow != mysqli_num_rows($res))
              echo '<td class="cat_name_td"><a href="#" id="catid" class="cat_name" name="'.$catid.'">'.$cat_name.'</a></td>';
            else
              echo '<td class="cat_name_td_last"><a href="#" id="catid" class="cat_name" name="'.$catid.'">'.$cat_name.'</a></td>';

            echo '<td class="delcatbtn_td"><input type="button" id="delcatbtn'.$catid.'" name="'.$catid.'" class="delcatbtn" value="Delete"></td>';
            echo '</tr>';

            $lastrow++;
          }
        }
         ?>
      </table>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  </body>
</html>
