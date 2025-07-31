<?php
if ($_GET['Status'] == 'OK') {
    $merchant_id = 'YOUR_MERCHANT_ID'; // Same merchant ID
    $authority = $_GET['Authority'];
    $amount = 1000; // You should store the actual amount in session or DB when creating the request

    $data = [
        'merchant_id' => $merchant_id,
        'amount' => $amount,
        'authority' => $authority
    ];

    $json_data = json_encode($data);
    $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $result = curl_exec($ch);
    $response = json_decode($result, true);

    if (isset($response['data']['code']) && $response['data']['code'] == 100) {
        echo 'Payment successful. RefID: ' . $response['data']['ref_id'];
    } else {
        echo 'Payment failed: ' . $response['errors']['message'];
    }
} else {
    echo 'Payment was canceled by the user.';
}
?>
