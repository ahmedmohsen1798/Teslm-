<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$order_id = $obj['order_id'];

$rate_no = $obj['rate_no'];

$review_text = $obj['review_text'];

if ($order_id )
{

   
        $sql = mysqli_query($con, "UPDATE `orders` SET  `rate_no`='$rate_no',`review_text`='$review_text',`have_review`='1' WHERE `order_id`='$order_id'");
        if ($sql && mysqli_affected_rows($con) > 0)
        {
           

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
