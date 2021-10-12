<?php
include "db_con.php";
$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = $obj['user_id'];

$card_no = $obj['card_no'];

$expire_month = $obj['expire_month'];

$expire_year = $obj['expire_year'];
$cvc = $obj['cvc'];
$holder_name=$obj['holder_name'];

// $user_id = '1';

// $card_no = '378734493671000';

// $expire_month ='02';

// $expire_year = '23';
// $cvc = '236';
// $holder_name="ahmed elshahawy";
if ($user_id && $card_no && $expire_month && $expire_year && $cvc&&$holder_name)
{
   $sqlDel = mysqli_query($con, "DELETE FROM `payment_cards`  WHERE `user_id`='$user_id'");
      
   
        $sql = mysqli_query($con, "INSERT INTO `payment_cards` ( `user_id`, `card_no`, `expire_month`, `expire_year`, `cvc`, `holder_name`) VALUES ( '$user_id', '$card_no', '$expire_month', '$expire_year', '$cvc', '$holder_name')");
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
