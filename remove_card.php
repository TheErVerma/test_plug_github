<?php 
include 'db.php';

$unique_id = (isset($_REQUEST['unique_id'])) ? $_REQUEST['unique_id'] : "";

$select_sql = "SELECT * FROM `entries` WHERE u_id = '$unique_id'";
$select_result = mysqli_query($con, $select_sql);
$row_num = mysqli_num_rows($select_result);

if($row_num > 0){
    $delete_sql = "DELETE FROM `entries` WHERE u_id = '$unique_id'";
    if(mysqli_query($con, $delete_sql)){
        echo "ok";
    }else{
        echo "not deleted";
    }
}else{
    echo "ok_front";
}
