<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$phone = $obj['phone'];
// $user_id ='1';
// $name ="test name";

if ($user_id != "" && $phone != "")
{

    $sql = mysqli_query($con, "UPDATE `users` SET `phone`='$phone'  WHERE `user_id`='$user_id'");

    if ($sql && mysqli_affected_rows($con) > 0)
    {
        echo "success";
    }
    else
    {
        echo "error";
    }
}
else
{
    echo "error";
}
?>
