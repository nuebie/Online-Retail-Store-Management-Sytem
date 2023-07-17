<?php
include "../included/db_connection.php";

//CONVERT ARRAY TO STRING
parse_str($_POST['form1'], $form);

$catid = $_POST['catid1'];


//INSERT SUBCATEGORIES OF THE NEWLY ADDED CATEGORY
for($i = 1; $i <= count($form); $i++){
$str1= "newsubcategoryname";
$str2 = $i;
$str3 = $str1 . $str2;

if($form[$str3] != ""){
$sql = "INSERT INTO `subcategory`(`catid`, `subcat_name`) VALUES ('$catid','$form[$str3]')";
 $res = mysqli_query($conn,$sql);
}
}

?>
