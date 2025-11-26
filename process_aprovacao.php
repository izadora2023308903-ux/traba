<?php
require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica login do admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$action = $_GET['action'] ?? '';
$id = intval($_GET['id'] ?? 0);

// Sem ID → volta
if (!$id) {
    header('Location: solicitacoes.php');
    exit;
}

if ($action === 'aprovar') {

    // MUDA PARA APROVADO
    $stmt = $pdo->prepare("
        UPDATE pedidos SET status = 'aprovado'
        WHERE id = :id
    ");
    $stmt->execute(['id' => $id]);

} elseif ($action === 'recusar') {

    // MUDA PARA RECUSADO
    $stmt = $pdo->prepare("
        UPDATE pedidos SET status = 'recusado'
        WHERE id = :id
    ");
    $stmt->execute(['id' => $id]);
}

header('Location: solicitacoes.php');
exit;
?>
