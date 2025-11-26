<?php
require_once 'config.php'; // Carrega configuração e conexão com o banco

// Verifica se o admin está logado
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Permite apenas requisições POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método inválido';
    exit;
}

// Recebe os dados do formulário
$id         = $_POST['id'];
$nome       = $_POST['nome'];
$sexo       = $_POST['sexo'];
$animal     = $_POST['animal'];
$raca       = $_POST['raca'];
$idade      = $_POST['idade'];
$porte      = $_POST['porte'];
$castrado   = $_POST['castrado'];
$observacao = $_POST['observacao'];

$imagem_nome = null;

// Verifica se foi enviada uma nova imagem
if (!empty($_FILES['imagem']['name'])) {

    $uploadDir = __DIR__ . '/uploads/';

    // Cria a pasta se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Obtém a extensão do arquivo enviado
    $ext     = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    // Valida extensão
    if (!in_array(strtolower($ext), $allowed)) {
        die('Formato de imagem não permitido.');
    }

    // Gera nome único para a imagem
    $imagem_nome = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest        = $uploadDir . $imagem_nome;

    // Move o arquivo para a pasta de uploads
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $dest)) {
        die('Erro no upload.');
    }

    // Busca a imagem antiga para removê-la
    $old = $pdo->prepare('SELECT imagem FROM pets WHERE id = :id');
    $old->execute(['id' => $id]);
    $row = $old->fetch();

    // Se houver imagem antiga, remove
    if (
        $row &&
        !empty($row['imagem']) &&
        file_exists(__DIR__ . '/uploads/' . $row['imagem'])
    ) {
        @unlink(__DIR__ . '/uploads/' . $row['imagem']);
    }

    // Atualiza registro incluindo nova imagem
    $stmt = $pdo->prepare('
        UPDATE pets 
        SET nome=:nome, sexo=:sexo, animal=:animal, raca=:raca, idade=:idade,
            porte=:porte, castrado=:castrado, observacao=:observacao, imagem=:imagem 
        WHERE id=:id
    ');

    $ok = $stmt->execute([
        'nome'       => $nome,
        'sexo'       => $sexo,
        'animal'     => $animal,
        'raca'       => $raca,
        'idade'      => $idade,
        'porte'      => $porte,
        'castrado'   => $castrado,
        'observacao' => $observacao,
        'imagem'     => $imagem_nome,
        'id'         => $id
    ]);

} else {

    // Atualiza registro sem alterar a imagem
    $stmt = $pdo->prepare('
        UPDATE pets 
        SET nome=:nome, sexo=:sexo, animal=:animal, raca=:raca, idade=:idade,
            porte=:porte, castrado=:castrado, observacao=:observacao 
        WHERE id=:id
    ');

    $ok = $stmt->execute([
        'nome'       => $nome,
        'sexo'       => $sexo,
        'animal'     => $animal,
        'raca'       => $raca,
        'idade'      => $idade,
        'porte'      => $porte,
        'castrado'   => $castrado,
        'observacao' => $observacao,
        'id'         => $id
    ]);
}

// Redireciona após atualização
if ($ok) {
    header('Location: lista_editar.php');
    exit;
} else {
    echo 'Erro ao atualizar.';
}
?>