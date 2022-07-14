<?php 
include 'db.php';

$unique_id = (isset($_REQUEST['unique_id'])) ? $_REQUEST['unique_id'] : "";
$fname = (isset($_REQUEST['fname'])) ? $_REQUEST['fname'] : "";
$lname = (isset($_REQUEST['lname'])) ? $_REQUEST['lname'] : "";
$order_num = (isset($_REQUEST['order_num'])) ? $_REQUEST['order_num'] : "";

$select_sql = "SELECT * FROM `entries` WHERE u_id = '$unique_id'";
$select_result = mysqli_query($con, $select_sql);
$row_num = mysqli_num_rows($select_result);

if($row_num <= 0){
    $insert_sql = "INSERT INTO `entries` (fname, lname, u_id, order_number) VALUES ('$fname', '$lname', '$unique_id', '$order_num')";
    if(mysqli_query($con, $insert_sql)){
        echo "ok";
    }else{
        echo "Card not Created";
    }
}else{
    $update_sql = "UPDATE `entries` SET `fname`='$fname',`lname`='$lname', `order_number`= '$order_num' WHERE u_id = '$unique_id'";
    if(mysqli_query($con, $update_sql)){
        echo "ok";
    }else{
        echo "Card not Updated";
    }
}

?>