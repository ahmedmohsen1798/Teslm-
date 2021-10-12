<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$notification = $obj['notification'];
// $user_id ='1';
// $notification ='0';

if($user_id && $notification!=="" ){

    $sql = mysqli_query($con, "UPDATE `users` SET `notification`='$notification'  WHERE `user_id`='$user_id'");

    if ($sql && mysqli_affected_rows($con) > 0)
    {
        echo "success";
    }
    else
    {
        echo "error";
    }
}else{
    echo "error";
}

?>
