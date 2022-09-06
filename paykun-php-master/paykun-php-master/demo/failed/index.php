<?php 

require '../../src/Payment.php';
require '../../src/Crypto.php';
require '../../src/Validator.php';

require_once('../config.php');

$obj = new \Paykun\Checkout\Payment($merchantId, $accessToken, $encryptionKey, false, true);
$response = $obj->getTransactionInfo($_REQUEST['payment-id']);

// echo "<pre>";
// var_dump($response);

    $status = $response['data']['transaction']['status'];
    $payment_id = $response['data']['transaction']['payment_id'];
    $payment_mode = $response['data']['transaction']['payment_mode'];
    $order_id = $response['data']['transaction']['order']['order_id'];
    $gross_amount = $response['data']['transaction']['order']['gross_amount'];
    $cus_name = $response['data']['transaction']['customer']['name'];
    $cus_email = $response['data']['transaction']['customer']['email_id'];
    $today = date("d-m-y");

    // echo '<br/>'.$status.'<br/>'.$payment_id.'<br/>'.$payment_mode.'<br/>'.$order_id.'<br/>'.$gross_amount.'<br/>'.$cus_name.'<br/>'.$cus_email.'<br/>'.$today.'<br/>';
    require_once('../../../../all_utils/connection.php');

    $sql="INSERT INTO transaction_details(cus_name,email,date_of_transaction,gross_amount,order_id,payment_mode,payment_id,trans_status) VALUES ('$cus_name','$cus_email','$today','$gross_amount','$order_id','$payment_mode','$payment_id','$status')";
    // if(mysqli_query($conn,$sql))
    // {
    //     echo "successfully inserted transaction details<br/>";
    // }
    // else
    // {
    //     echo "not inserted transaction details<br/>";
    // }

if(is_array($response) && !empty($response)) {
    if($response['status'] && $response['data']['transaction']['status'] == "Failed") {
        echo '<h2 style="text-align: center;">Transaction failed</h2>';
        echo '<h2 style="text-align: center;">Transaction Id : '.$payment_id.'</h2>';
    }
    echo '<h4 style="text-align: center;"><a href="../../../../login.php">Go back</a></h4>';

}

?>