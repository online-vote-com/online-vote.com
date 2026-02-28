<?php
/**
 * Configuration Mesomb Production
 */


define('MESOMB_API_KEY', '7b13ea2f688e8bc4ad6783e424dcfccaabd6be4b');
define('MESOMB_SECRET', 'fd4ee29c-9193-4b8b-a201-ebc03306aac8');
define('MESOMB_BASE_URL', 'https://api.mesomb.com');
define('MESOMB_CALLBACK_URL', 'https://online-vote.com/api/notify.php');


/**
 * Appel MeSomb sécurisé
 */
function callMesomb($phone, $amount, $transaction_id, $operator)
{
    // Nettoyage numéro
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (strlen($phone) === 9) {
        $phone = "237" . $phone; // Format Cameroun
    }

    try {

        $client = new MeSomb(
            MESOMB_API_KEY,
            MESOMB_SECRET
        );

        $response = $client->payment->makeCollect([
            "amount" => (int) $amount,
            "service" => strtoupper($operator), // ORANGE ou MTN
            "payer" => $phone,
            "externalReference" => $transaction_id,
            "callbackUrl" => MESOMB_CALLBACK_URL
        ]);

        return [
            "success" => true,
            "data" => $response
        ];

    } catch (Exception $e) {

        return [
            "success" => false,
            "message" => $e->getMessage()
        ];
    }
}
?>