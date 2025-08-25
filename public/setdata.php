<?php

require_once "../secrets.php";
require_once "../sql.php";
require_once "../session.php";

header('Content-Type: application/json');
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Origin: *");

$empresa = $contaPagamento;
$jsonStr = file_get_contents('php://input');
$jsonObj = json_decode($jsonStr);

//$_SESSION[SESSION_NAME]['items'] = $jsonObj;

#email
#evento
#empresa
#descrição
#urlretorno

#=================
#retornar a hash de controle do pagamento. não é a controlhash do usuário, apenas uma hash para encontrar o pagamento na temp.