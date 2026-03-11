<?php

/**
 * CONFIGURATION AANGARAA PAY
 * Fichier central pour les paiements
 */

// clé API fournie par Aangaraa
define('AANGARAA_API_KEY', 'O9GB-5168-OSAT-FS4F');

// endpoint officiel production
define('AANGARAA_API_URL', 'https://api-production.aangaraa-pay.com/api');

// webhook appelé par Aangaraa après paiement
define('AANGARAA_NOTIFY_URL', 'https://online-vote.com/api/notify.php');

// url de retour utilisateur (optionnel)
define('AANGARAA_RETURN_URL', 'https://online-vote.com/payment-return.php');

// devise utilisée
define('AANGARAA_CURRENCY', 'XAF');


/**
 * Fonction qui lance un paiement Mobile Money
 */
function callAangaraa($phone, $amount, $transaction_id, $operator)
{


    $payload = [
        "phone_number" => $phone,
        "amount" => (string)$amount,
        "description" => "Vote en ligne",
        "app_key" => AANGARAA_API_KEY,
        "transaction_id" => $transaction_id,
        "notify_url" => AANGARAA_NOTIFY_URL,
        "operator" => $operator,
        "devise_id" => AANGARAA_CURRENCY
    ];

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => AANGARAA_API_URL . "/v1/no_redirect/payment",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ],
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

    return json_decode($response, true);
}
?>