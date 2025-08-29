<?php
require_once '../secrets.php';
require_once '../sql.php';

$stripeSecretKey = sql([
    "statement" => "SELECT * FROM pagamentos.empresas WHERE id = ?",
    "types" => "i",
    "parameters" => [
        $contaPagamento
    ],
    "only_first_row" => "1"
])['producao_secret'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Pagamento</title>
  <link rel="shortcut icon" href="https://eventos.tbr.com.br/coruja-crpp2025/favicon.png" type="image/x-icon">
  <meta name="description" content="Página de pagamento via stripe" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="checkout.css" />
  <script src="https://js.stripe.com/basil/stripe.js"></script>
  <script src="checkout.js" defer></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary shadow">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="https://eventos.tbr.com.br/coruja-crpp2025/assets/logo-BWF5ejMX.png" alt="logo" height="50px">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="btn btn-success rounded-pill text-light px-3" aria-current="page" href="https://eventos.tbr.com.br/coruja-crpp2025">Voltar ao site</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <form id="payment-form" class="bg-light">
    <h3 class="text-center text-danger fs-semibold mb-3">Curso Revisão Pré-Prova</h3>
    <input type="text" id="email" placeholder="Seu email" />
    <div id="payment-element">
    </div>
    <button id="submit">
      <div class="spinner hidden" id="spinner"></div>
      <span id="button-text">Pay now</span>
    </button>
    <div id="payment-message" class="hidden"></div>
    <input type="hidden" id="sk" value="<?= $stripeSecretKey ?>">
  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>