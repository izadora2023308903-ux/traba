<?php
require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
if (!isset($_GET['id'])) { echo 'ID não informado.'; exit; }
$id = $_GET['id'];
$old = $pdo->prepare('SELECT imagem FROM pets WHERE id = :id');
$old->execute(['id'=>$id]);
$row = $old->fetch();
if ($row && !empty($row['imagem']) && file_exists(__DIR__.'/uploads/'.$row['imagem'])) {
    @unlink(__DIR__.'/uploads/'.$row['imagem']);
}
$stmt = $pdo->prepare('DELETE FROM pets WHERE id = :id');
$stmt->execute(['id'=>$id]);
header('Location: lista_editar.php');
exit;
?>