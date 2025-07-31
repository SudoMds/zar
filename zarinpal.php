<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $merchant_id = 'YOUR_MERCHANT_ID'; // Replace with your Zarinpal merchant ID
    $amount = intval($_POST['amount']);
    $description = $_POST['description'];
    $callback_url = 'https://yourdomain.com/zarinpal_verify.php'; // Adjust as needed

    $data = [
        'merchant_id' => $merchant_id,
        'amount' => $amount,
        'description' => $description,
        'callback_url' => $callback_url,
        'metadata' => [
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile']
        ]
    ];

    $json_data = json_encode($data);
    $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
    curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $result = curl_exec($ch);
    $response = json_decode($result, true);

    if (isset($response['data']['code']) && $response['data']['code'] == 100) {
        header('Location: https://www.zarinpal.com/pg/StartPay/' . $response['data']['authority']);
        exit;
    } else {
        echo 'Error: ' . $response['errors']['message'];
    }
}
?>
