<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$name = $obj['name'];
// $user_id ='1';
// $name ="test name";

if ($user_id != "" && $name != "")
{

    $sql = mysqli_query($con, "UPDATE `users` SET `name`='$name'  WHERE `user_id`='$user_id'");

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
