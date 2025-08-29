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
])['sandbox_secret'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Retorno Pagamento</title>
  <link rel="shortcut icon" href="https://eventos.tbr.com.br/coruja-crpp2025/favicon.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://js.stripe.com/v3/"></script>
  <script src="complete.js" defer></script>
  <style>
    body{
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    footer{
      margin-top: auto;
      background-color: #06652e;
    }
     #status-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin: 0 auto 15px auto;
      display: flex;
      align-items: center;
      justify-content: center;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary shadow sticky-top">
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
            <a class="btn btn-success rounded-pill text-light px-5" aria-current="page"
              href="https://eventos.tbr.com.br/coruja-crpp2025">Voltar ao site</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-9 col-lg-auto">
        <div class="p-1 rounded shadow">
          <div class="p-3 m-3 rounded border border-5">
          <div id="status-icon" class="rounded-pill"></div>
          <div id="status-text" class="text-center fs-5 mb-3">Loading...</div>
          <table id="details-table" class="py-5 fs-5">
            <tr>
              <td><strong>Intent ID:</strong></td>
              <td id="intent-id"></td>
            </tr>
            <tr>
              <td><strong>Status:</strong></td>
              <td id="intent-status"></td>
            </tr>
          </table>

          <p class="text-center pt-3">
            <a id="view-details" href="#" target="_blank" class="btn btn-success rounded-pill">Veja no Dashboard Stripe</a>
          </p>
          <input type="hidden" id="sk" value="<?= $stripeSecretKey ?>">
        </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="container-fluid bg-footer">
        <div class="row shadow">
            <div class="col">
                <div class="container">
                    <div class="row py-4">
                        <div class="col-md-3">
                            <img src="https://eventos.tbr.com.br/coruja-crpp2025/assets/logo_branco-DFCcEGsl.png" alt="Logo branco" class="w-75 d-block mx-auto py-3">
                        </div>
                        <div class="col">
                            <p class="fs-5 text-light fw-semibold">
                                Entre em contato
                            </p>
                            <ul class="list-unstyled">
                                <li>
                                    <a href="tel:+5511947990277" class="text-decoration-none text-light">
                                        <font-awesome-icon icon="fa-solid fa-phone" /> (11) 9 4799-0277
                                    </a>
                                </li>
                                <li>
                                    <a href="mailto:email@corujamentoria.com" class="text-decoration-none text-light">
                                        <font-awesome-icon icon="fa-regular fa-envelope" /> email@corujamentoria.com
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" :href="instagram" class="text-decoration-none text-light">
                                        <font-awesome-icon icon="fa-brands fa-instagram" /> @coruja_mentoria
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="container">
                    <div class="row">
                        <div class="col-auto mx-auto">
                            <p class="mb-0 text-light fs-6 py-3">
                                Copyright &copy; 2025 - Todos os direitos reservados - <a href="https://tbr.com.br/"
                                    target="_blank" class="fw-bold text-light text-decoration-none">TBR Produções</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
</body>

</html>