<?php
require_once 'config.php'; // Inclui configuração e conexão com o banco

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Verifica se um ID foi informado via GET
if (!isset($_GET['id'])) {
    echo 'ID não informado.';
    exit;
}

$id = $_GET['id'];

// Busca a imagem atual do pet para removê-la do servidor
$old = $pdo->prepare('SELECT imagem FROM pets WHERE id = :id');
$old->execute(['id' => $id]);
$row = $old->fetch();

// Se houver imagem salva, remove o arquivo físico
if (
    $row &&
    !empty($row['imagem']) &&
    file_exists(__DIR__ . '/uploads/' . $row['imagem'])
) {
    @unlink(__DIR__ . '/uploads/' . $row['imagem']);
}

// Exclui o registro do pet no banco de dados
$stmt = $pdo->prepare('DELETE FROM pets WHERE id = :id');
$stmt->execute(['id' => $id]);

// Redireciona de volta para a lista
header('Location: lista_editar.php');
exit;
?>