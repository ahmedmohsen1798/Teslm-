<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];

$title = $obj['title'];

$address = $obj['address'];

$lat = $obj['lat'];
$lng = $obj['lng'];
// $user_id=1;
// $title='test';
// $address="test address test ,then test and test" ;
// $lat='30.23635';
// $lng='32.22214';
if ($user_id && $title && $address && $lat && $lng)
{

   
        $sql = mysqli_query($con, "INSERT INTO `users_addresses` ( `user_id`, `title`, `address`, `lat`, `lng`) VALUES ( '$user_id', '$title', '$address', '$lat', '$lng')");
        if ($sql && mysqli_affected_rows($con) > 0)
        {
            $address_id = mysqli_insert_id($con);

            echo $address_id;
}else
{
    echo "error";
}
       
    
}
else
{
    echo "error";
}
?>
