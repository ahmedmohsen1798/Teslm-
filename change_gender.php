<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$gender = $obj['gender'];
// $user_id ='1';
// $name ="test name";

if ($user_id != "" && $gender != "")
{

    $sql = mysqli_query($con, "UPDATE `users` SET `gender`='$gender'  WHERE `user_id`='$user_id'");

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
