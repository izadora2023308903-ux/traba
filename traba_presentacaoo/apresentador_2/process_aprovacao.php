<?php
/*
  Arquivo: process_aprovacao.php
  Atribuído para: Apresentador 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);
if (!$id) { header('Location: solicitacoes.php'); exit; }
if ($action == 'aprovar') {
    $stmt = $pdo->prepare('UPDATE pedidos SET status = :s WHERE id = :id');
    $stmt->execute(['s'=>'aprovado','id'=>$id]);
} elseif ($action == 'recusar') {
    $stmt = $pdo->prepare('UPDATE pedidos SET status = :s WHERE id = :id');
    $stmt->execute(['s'=>'recusado','id'=>$id]);
}
header('Location: solicitacoes.php');
exit; ?>