<?php
include_once "../included/session.php";
include_once "../included/db_connection.php";

$catid = 0;

if(isset($_POST['category'])){
   $catid = mysqli_real_escape_string($conn,$_POST['category']); // CATEGORY ID
}

$subcat_arr = array();

if($catid > 0){
    $sql = "SELECT * FROM subcategory WHERE catid= '$catid'";

    $result = mysqli_query($conn,$sql);

    while( $subcategory = mysqli_fetch_array($result) ){
        $subcatid = $subcategory['subcatid'];
        $subcat_name = $subcategory['subcat_name'];

        $subcat_arr[] = array("subcatid" => $subcatid, "subcat" => $subcat_name);
    }
}

// encoding array to json format
echo json_encode($subcat_arr);
