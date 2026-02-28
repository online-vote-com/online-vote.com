<?php
/**
 * Configuration Mesomb Production
 */


define('MESOMB_API_KEY', '7b13ea2f688e8bc4ad6783e424dcfccaabd6be4b');
define('MESOMB_SECRET', 'fd4ee29c-9193-4b8b-a201-ebc03306aac8');
define('MESOMB_BASE_URL', 'https://api.mesomb.com');
define('MESOMB_CALLBACK_URL', 'https://online-vote.com/api/notify.php');


/**
 * Générer signature HMAC
 */
function generateSignature($method, $endpoint, $body, $date, $nonce)
{
    $message = $method . "\n" .
               $endpoint . "\n" .
               $body . "\n" .
               $date . "\n" .
               $nonce;

    return hash_hmac('sha256', $message, MESOMB_SECRET);
}

/**
 * Générer signature HMAC
 */
function generateSignature($method, $endpoint, $body, $date, $nonce)
{
    $message = $method . "\n" .
               $endpoint . "\n" .
               $body . "\n" .
               $date . "\n" .
               $nonce;

    return hash_hmac('sha256', $message, MESOMB_SECRET);
}

/**
 * Appel API MeSomb
 */
function callMesomb($phone, $amount, $transaction_id, $operator)
{
    // Nettoyage numéro
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (strlen($phone) === 9) {
        $phone = "237" . $phone;
    }

    $endpoint = "/payment/mobilemoney";
    $url = MESOMB_BASE_URL . $endpoint;

    $payload = [
        "amount" => (int)$amount,
        "service" => strtoupper($operator), // ORANGE ou MTN
        "payer" => $phone,
        "externalReference" => $transaction_id,
        "callbackUrl" => MESOMB_CALLBACK_URL
    ];

    $body = json_encode($payload);

    $date = gmdate('D, d M Y H:i:s') . ' GMT';
    $nonce = uniqid();

    $signature = generateSignature(
        "POST",
        $endpoint,
        $body,
        $date,
        $nonce
    );

    $headers = [
        "Content-Type: application/json",
        "X-MeSomb-Date: $date",
        "X-MeSomb-Nonce: $nonce",
        "X-MeSomb-ApiKey: " . MESOMB_API_KEY,
        "X-MeSomb-Signature: $signature"
    ];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return [
            "success" => false,
            "message" => curl_error($ch)
        ];
    }

    curl_close($ch);

    $decoded = json_decode($response, true);

    if (!$decoded) {
        return [
            "success" => false,
            "message" => $response
        ];
    }

    return $decoded;
}
?>