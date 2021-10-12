<?php
include 'db_con.php';

$json = file_get_contents('php://input');
$obj = json_decode($json, true);
 $code= $obj['code'];
// $code="CAMP_CODING";
// $user_id = 1;
if($code){
$sqlData = mysqli_query($con, "SELECT * FROM `promo_codes` WHERE `code`= '$code' ");
// echo json_encode(mysqli_fetch_object($sqlData));
if ($sqlData&&mysqli_num_rows($sqlData)>0)
{

 $promoData = mysqli_fetch_object($sqlData);
    // echo json_encode ($promoData);
    if($promoData->status=="1"&&($promoData->used_count)<($promoData->used_limit) ){
        echo $promoData->discount;
    }else{
        echo "not_valid";
    }
    
}
else
{
    echo "not_valid";
}

}
else
{
    echo "error";
}

?>
