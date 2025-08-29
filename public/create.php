<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
require_once '../secrets.php';
require_once '../session.php';
require_once '../sql.php';

$stripeSecretKey = sql([
    "statement" => "SELECT * FROM pagamentos.empresas WHERE id = ?",
    "types" => "i",
    "parameters" => [
        $contaPagamento
    ],
    "only_first_row" => "1"
])['producao_secret'];

$stripe = new \Stripe\StripeClient($stripeSecretKey);

function calculateOrderAmount($item): int
{

    $busca = sql([
        "statement" => "SELECT * FROM pagamentos.temp WHERE controle = ? AND usuario = ? AND evento = ?",
        "types" => "sii",
        "parameters" => [
            $item['control'],
            $item['usuario'],
            $item['evento']
        ],
        "only_first_row" => "1"
    ]);

    return intval($busca['valor'] * 100);
}

header('Content-Type: application/json');

try {
    // retrieve JSON from POST body
    $jsonStr = file_get_contents('php://input');
    $jsonObj = json_decode($jsonStr, true);
    $valorTotal = calculateOrderAmount($jsonObj);

    // Create a PaymentIntent with amount and currency
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => $valorTotal,
        'currency' => 'eur',
        'description' => 'Pagamento da taxa de inscrição do Curso Revisão Pré-Prova',
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
    ]);

    sql([
        "statement" => "INSERT INTO pagamentos.pedidos_stripe SET empresa=?, controle=?, valor=?, payment_intent=?, estado=?",
        "types" => "isiss",
        "parameters" => [
            $contaPagamento,
            $jsonObj['control'],
            $valorTotal,
            $paymentIntent->client_secret,
            "aguardando"
        ]
    ]);

    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);
} catch (Error $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}