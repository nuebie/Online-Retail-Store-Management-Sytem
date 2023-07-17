<?php
include "../included/db_connection.php";

//CONVERT ARRAY TO STRING
parse_str($_POST['form'], $form);

$cat_name = $form["categoryname"];

//INSERT NEW CATEGORY
$sql = "INSERT INTO `category`(`cat_name`) VALUES ('$cat_name')";
$res = mysqli_query($conn,$sql);

//GET THE CATEGORY ID OF THE NEW CATEGORY
$sql = "SELECT * FROM `category` WHERE cat_name = '$cat_name'";
$res = mysqli_query($conn, $sql);

if(mysqli_num_rows($res) > 0){
  while ($category = mysqli_fetch_assoc($res)) {
    $catid = $category['catid'];
  }
}

//INSERT SUBCATEGORIES OF THE NEWLY ADDED CATEGORY
for($i = 2; $i <= count($form); $i++){
$str1= "subcategoryname";
$str2 = $i-1;
$str3 = $str1 . $str2;

if($form[$str3] != ""){
$sql = "INSERT INTO `subcategory`(`catid`, `subcat_name`) VALUES ('$catid','$form[$str3]')";
 $res = mysqli_query($conn,$sql);
}
}

echo '<table class="displaycategory">
    <tr>
      <th>Categories</th>
    </tr>';


    //GET ALL CATEGORIES
    $sql = "SELECT * FROM `category`";
    $res = mysqli_query($conn, $sql);

    if(mysqli_num_rows($res) > 0){
      while ($category = mysqli_fetch_assoc($res)) {
        $catid = $category['catid'];
        $cat_name = $category['cat_name'];

        echo '<tr>';
        echo '<td><a href="#" id="catid" class="cat_name" name="'.$catid.'">'.$cat_name.'</a></td>';
        echo '</tr>';
      }
    }

echo '</table>';

?>
