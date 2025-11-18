<?php
/*
  Arquivo: logout.php
  Atribuído para: Apresentador 1
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
session_unset();
session_destroy();
header("Location: login.php");
exit;
