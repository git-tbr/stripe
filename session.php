<?php
ini_set('session.gc_maxlifetime', 7200);
session_set_cookie_params(7200);
define("NOME_SESSAO", "session384");
session_name(NOME_SESSAO);
session_start();