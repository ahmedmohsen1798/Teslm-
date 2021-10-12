<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$password = $obj['new_password'];

//  $user_id = '1';
//  $password = 'test_123';


if ($user_id != "" && $password != "")
{

    $sql = mysqli_query($con, "UPDATE `users` SET `password`='$password'  WHERE `user_id`='$user_id'");

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
