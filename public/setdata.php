<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../secrets.php";
require_once "../sql.php";

$empresa = $contaPagamento;
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr, true);

sql([
    "statement" => "UPDATE pagamentos.pedidos_stripe SET estado=?, retorno_completo=? WHERE payment_intent=?",
    "types" => "sss",
    "parameters" => [
        "pago",
        $jsonStr,
        $jsonObj['client_secret']
    ]
]);

$busca = sql([
    "statement" => "SELECT * FROM pagamentos.pedidos_stripe s LEFT JOIN tbrevent.registration r ON r.control_hash = s.controle WHERE payment_intent = ?",
    "types" => "s",
    "parameters" => [
        $jsonObj['client_secret']
    ],
    "only_first_row" => "1"
]);

sql([
    "statement" => "INSERT INTO tbrevent.purchase SET   `event`=?, 
                                                        register=?, 
                                                        `value`=?,
                                                        currency=?,
                                                        `date`=now(),
                                                        date_update=now(),
                                                        `status`='2',
                                                        payment_ref_code=?,
                                                        payment_status='Pago',
                                                        account='stripe',
                                                        control_hash=?",
    "types" => "iidsss",
    "parameters" => [
        $busca['event'],
        $busca['id'],
        floatVal($busca['valor'] / 100),
        $jsonObj['currency'],
        $busca['payment_intent'],
        $busca['controle']
    ]
]);

sql([
    "statement" => "UPDATE tbrevent.registration SET `enable`=1 WHERE control_hash=?",
    "types" => "s",
    "parameters" => [
        $busca['controle']
    ]
]);