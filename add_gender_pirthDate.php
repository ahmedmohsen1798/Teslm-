<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$gender = $obj['gender'];
$pirth_date=$obj['pirth_date'];
// $user_id ='1';
// $name ="test name";

if ($user_id != "" && $gender != ""&& $pirth_date)
{

    $sql = mysqli_query($con, "UPDATE `users` SET `gender`='$gender', `pirth_date`='$pirth_date'  WHERE `user_id`='$user_id'");

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
