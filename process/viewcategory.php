<?php
include "../included/db_connection.php";

$catid = $_POST['catid'];
$subcatnum = 1;

//GET THE CATEGORY ID OF THE NEW CATEGORY
$sql = "SELECT * FROM `category` WHERE catid = '$catid'";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0){
  while ($category = mysqli_fetch_assoc($res)) {
    $catid = $category['catid'];
    $cat_name = $category['cat_name'];
  }
}

echo '<div class="catdetails">
      Category:<input type="text" class="categoryname" name="" id="catinput" value="'.$cat_name.'">
      <button type="button" id="savecatbtn" name="'.$catid.'">Save</button>';


//GET THE SUBCATEGORIES OF THE CATEGORY
  $sql = "SELECT * FROM `subcategory` WHERE catid = '$catid'";
  $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
      while ($subcategory = mysqli_fetch_assoc($res)) {
        $subcatid = $subcategory['subcatid'];
        $subcat_name = $subcategory['subcat_name'];

        echo '
              <div id="existingsubcategorydiv'.$subcatnum.'">Subcategory '.$subcatnum.':<input type="text" class="subcategoryname" id="subcatinput'.$subcatnum.'" name="subcatinput'.$subcatnum.'" value="'.$subcat_name.'">
              <button type="button" class="removesubcatbtn" id="deletesubcatbtn'.$subcatnum.'" name="'.$subcatid.'"><span class="removesubcat_icon"><ion-icon name="close-circle-outline"></ion-icon></span>
              </button>
              <button type="button" id="savesubcatbtn'.$subcatnum.'" name="'.$subcatid.'">Save</button>
              <br>
              </div>';

        $subcatnum++;
        }
      }

      echo '<form id="newsubcatfrm" name="'.$catid.'">

            </form>';

    echo '<div class="viewcategorybuttonsdiv">

          <button type="button" name="button" class="addsubcatbtn"  id="addnewsubcat">
          <span class="addsubcat_txt">Add Subcategory</span>
          <span class="addsubcat_icon"><ion-icon name="add-circle-outline"></ion-icon></span>
          </button><br>

          <button type="button" class="confirmnewcatbtn" id="confirmedit">Confirm</button>
          <button type="button" class="cancelnewcatbtn" id="cancelcatbtn">Cancel</button>
      </div>';


    echo '</div>';
    ?>

    <script type="text/javascript">
        $("[id^=savesubcatbtn]").hide();
        $("[id^=savecatbtn]").hide();
    </script>
