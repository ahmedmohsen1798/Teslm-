<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];

$user_name = $obj['user_name'];

$kitchen_id = $obj['kitchen_id'];

$rate_no = $obj['rate_no'];
$review_text = $obj['review_text'];
// $user_id = 1;

// $user_name ='Elshahawy';

// $kitchen_id = 1;

// $rate_no = 5;
// $review_text = "just test";


if(!$rate_no){
    $rate_no=0;
}
if ($user_id && $user_name && $kitchen_id && $rate_no!=="" )
{

   
        $sql = mysqli_query($con, "INSERT INTO `rating_reviews` ( `user_name`, `user_id`, `kitchen_id`, `rate_no`, `review_text`, `date`) VALUES ( '$user_name', '$user_id', '$kitchen_id', '$rate_no', '$review_text', DATE_ADD(now(),interval 2 hour))");
        if ($sql && mysqli_affected_rows($con) > 0)
        {
            $address_id = mysqli_insert_id($con);

            echo "success";
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
