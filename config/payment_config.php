<?php
/**
 * Configuration Mesomb Production
 */


define('MESOMB_API_KEY', '7b13ea2f688e8bc4ad6783e424dcfccaabd6be4b');
define('MESOMB_SECRET', 'fd4ee29c-9193-4b8b-a201-ebc03306aac8');
define('MESOMB_BASE_URL', 'https://api.mesomb.com');
define('MESOMB_CALLBACK_URL', 'https://online-vote.com/api/notify.php');



/**
 * Appel API MeSomb
 */
function callMesomb($phone, $amount, $transaction_id, $operator) {

    $url = MESOMB_BASE_URL . "/v1/payment/mobilemoney";

    $payload = [
        "amount" => (int) $amount,
        "phoneNumber" => $phone,
        "service" => $operator, // ORANGE ou MTN
        "externalReference" => $transaction_id,
        "callbackUrl" => MESOMB_CALLBACK_URL
    ];

    $headers = [
        "Content-Type: application/json",
        "X-MeSomb-ApiKey: " . MESOMB_API_KEY,
        "X-MeSomb-Secret: " . MESOMB_SECRET
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return ["status" => "error", "message" => curl_error($ch)];
    }

    curl_close($ch);

    return json_decode($response, true);
}
?>