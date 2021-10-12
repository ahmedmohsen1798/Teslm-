<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$order_id = $obj['order_id'];
// $order_id="65";

if ($order_id != "" )
{
//SELECT * FROM `orders`

    $sqlCheck = mysqli_query($con, "SELECT * FROM `orders`  WHERE `order_id`='$order_id'");
    $order = mysqli_fetch_object($sqlCheck);
    if($order->status==0){
    $sql = mysqli_query($con, "UPDATE `orders` SET `status`='-1'  WHERE `order_id`='$order_id'");

    if ($sql && mysqli_affected_rows($con) > 0)
    {
        
        echo "success";
        
     
     
     
     $sqlOrdersItems = mysqli_query($con, "SELECT * FROM `order_items` WHERE  `order_id`=$order_id  ");
if ($sqlOrdersItems)
{
    
    while ($rowOrder_item = mysqli_fetch_object($sqlOrdersItems))
    {
      $item_id=$rowOrder_item->food_item_id;
      $item_count=$rowOrder_item->count;
       $sqlUpdate_hotDeals = mysqli_query($con, "UPDATE `food_items` SET `available_count`=`available_count`+'$item_count' WHERE `food_item_id`='$item_id' AND `category_id`='0' ");
                    
     
    }
}
     
     
     
     
     
     
     
     
     
        
    }
    else
    {
        echo "error";
    }
    }else{
        echo "denaid";
    }
}
else
{
    echo "error";
}
?>
