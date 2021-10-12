<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];
$orders = $obj['orders'];
$address = $obj['address'];
$lat = $obj['lat'];
$lng = $obj['lng'];
$discount = $obj['discount'];
$payment_way = $obj['payment_way'];
$code= $obj['code'];
$itemsData=$obj['itemsData'];
$delivery_date=$obj['delivery_date'];
if ($user_id && $orders && $address && $lat && $lng && $payment_way  )
{
    


$kitchens_closed=array();
$closed=0;
foreach ($orders as $key=>$order) {


$kitchen_id = $order['kitchen_id'];


$sqlClosed = mysqli_query($con, "SELECT * FROM `kitchens` WHERE `kitchen_id`='$kitchen_id' AND `open`=0 ");

if(mysqli_num_rows($sqlClosed)==1){
    
    $kitchens_closed[]=$order['kitchen_name'];
   $closed=1;
    
}


}

// echo json_encode($kitchens_closed);
if($closed==0){


    $hotDealsAvailable="ok";
    
    
foreach ($itemsData as $item) {
    $item_id=$item->food_item_id;
    $itemCount=$item->count;
    
     $itemhotSql= mysqli_query($con, "SELECT * FROM `food_items` WHERE `end_date`> DATE_ADD(now(),interval 2 hour) AND `available_count`>'$itemCount' AND `category_id`='0'  AND `food_item_id`='$item_id' ");
    if(mysqli_num_rows($itemhotSql)==1){
    
    
    $itemCountSql= mysqli_query($con, "SELECT * FROM `food_items` WHERE `end_date`> DATE_ADD(now(),interval 2 hour) AND `available_count`>'$itemCount' AND `food_item_id`='$item_id' ");
    
    if(mysqli_num_rows($itemCountSql)==0){
    
    
         $hotDealsAvailable="no";                             
    
        
    }
    
    
    }
    
}
    
    
    
    
    
    
    
    if($hotDealsAvailable=="ok"){
if($code){
$sqlData = mysqli_query($con, "SELECT * FROM `promo_codes` WHERE `code`= '$code' ");
// echo json_encode(mysqli_fetch_object($sqlData));
if ($sqlData&&mysqli_num_rows($sqlData)>0)
{

 $promoData = mysqli_fetch_object($sqlData);
    // echo json_encode ($promoData);
    if($promoData->status=="1"&&($promoData->used_count)<($promoData->used_limit) ){
        //   $sql_code = mysqli_query($con, "UPDATE `promo_codes` SET `used_count` =`used_count`+1  WHERE `code`= '$code'");
      
    }else{
        $discount=0;
    }
    
}
else
{
    $discount=0;
}

}

foreach ($orders as $key=>$order) {


$kitchen_id = $order['kitchen_id'];
$delivery_fee = $order['delivery_fee'];
$items = $order['items'];

if ($kitchen_id  && $items )
{
    /*
    IINSERT INTO `order_items`(`food_name`, `count`, `total_price`, `discount`, `properties`, `note`, `order_id`, `food_item_id`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9])
    */


$sqlkitchen_teslm_commotion = mysqli_query($con, "SELECT `teslm_commotion`  FROM `kitchens` WHERE `kitchen_id`= '$kitchen_id' ");
// echo json_encode(mysqli_fetch_object($sqlData));
$teslm_commotion=0;
if ($sqlkitchen_teslm_commotion&&mysqli_num_rows($sqlkitchen_teslm_commotion)>0)
{

 $teslm_commotion = (mysqli_fetch_object($sqlkitchen_teslm_commotion))->teslm_commotion;
}
 

   
        $sql = mysqli_query($con, "INSERT INTO `orders`( `user_id`, `kitchen_id`, `date`, `address`, `lat`, `lng`, `discount`, `payment_way`, `delivery_fee`, `status`, `refuse_reason`,`delivery_date`,`teslm_commotion`) VALUES ( '$user_id', '$kitchen_id', DATE_ADD(now(),interval 2 hour) ,'$address', '$lat', '$lng', '$discount', '$payment_way', '$delivery_fee',0,'','$delivery_date','$teslm_commotion')");
        if ($sql && mysqli_affected_rows($con) > 0)
        {
            $order_id = mysqli_insert_id($con);
            
 $text="لديكم طلب اوردر جديد برقم  ".$order_id." يجب الاطلاع عليه الان";
 
             $sqlNotf = mysqli_query($con, "INSERT INTO `kitchen_notification` ( `kitchen_id`, `notification_text`, `notification_order_id`, `date`) VALUES ( '$kitchen_id','$text', '$order_id', DATE_ADD(now(),interval 2 hour ))");
             
             include './notifcations/send_notification.php';
            
            // echo mysqli_error($con);
            foreach($items as $key2=>$item){
                
                $food_name = $item['food_name'];
                $count = $item['count'];
                $total_price = $item['total_price'];
                $discount = $item['discount'];
                $special_request = $item['special_request'];
                $item_id = $item['item_id'];
                $properties = $item['properties'];
                
                 if(strlen($properties)>0){
                $x=$properties[0]['property_title'];
                 }else{
                    $x=""; 
                 }
                // echo "$x";
                // echo sizeof($properties);
                
                if ($food_name && $count && $item_id && $total_price  )
                {
               
               $props="";
                foreach($properties as $key3=>$pro){
                    if($key3!=0){
                        $props=$props."**camp**";
                    }
                    $x=$pro['property_title'];
                    $y=$pro['choice'];
                    $props=$props.$x."==camp==".$y;
                }

                $sql2 = mysqli_query($con, "INSERT INTO `order_items`(`food_name`, `count`, `total_price`, `discount`, `properties`, `note`, `order_id`, `food_item_id`) VALUES ( '$food_name', '$count', '$total_price' ,'$discount', '$props', '$special_request', '$order_id', '$item_id')");
                if ($sql2 && mysqli_affected_rows($con) > 0)
                {
                    $sqlUpdate_hotDeals = mysqli_query($con, "UPDATE `food_items` SET `available_count`=`available_count`-'$count' WHERE `food_item_id`='$item_id'");
                    
                    
                    if($key==sizeof($orders)-1&&$key2==sizeof($items)-1){
                        echo "success";
                         if($promoData->status=="1"&&($promoData->used_count)<($promoData->used_limit) ){
          $sql_code = mysqli_query($con, "UPDATE `promo_codes` SET `used_count` =`used_count`+1  WHERE `code`= '$code'");
      
    }
                    }
                }
                }else
                {
                    echo "error";
                }
                
                
            }

            
}else
{
    echo "error";
}
       
    
}
else
{
    echo "error";
}    
}


}else{
    echo "hot_deals_not_available";
}



}else{
    
echo json_encode($kitchens_closed);
}
}
else
{
    echo "error";
}  





?>
