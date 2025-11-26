<?php
require_once 'config.php'; // Conexão e configurações do sistema

// Apenas administradores podem inserir novos pets
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Permite apenas envio via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método inválido.';
    exit;
}

// Recebe os dados enviados pelo formulário
$animal      = $_POST['animal']      ?? '';
$nome        = $_POST['nome']        ?? '';
$idade       = $_POST['idade']       ?? 0;
$porte       = $_POST['porte']       ?? '';
$raca        = $_POST['raca']        ?? '';
$observacao  = $_POST['observacao']  ?? '';
$castrado    = $_POST['castrado']    ?? 'não';
$sexo        = $_POST['sexo']        ?? '';

$imagem_nome = null;

// Verifica se o usuário enviou uma imagem
if (!empty($_FILES['imagem']['name'])) {

    $uploadDir = __DIR__ . '/uploads/';

    // Cria a pasta de uploads caso não exista
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Obtém a extensão da imagem
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);

    // Extensões permitidas
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    // Valida a extensão da imagem
    if (!in_array(strtolower($ext), $allowed)) {
        die('Formato de imagem não permitido.');
    }

    // Gera um nome único para a imagem
    $imagem_nome = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;

    // Caminho final onde o arquivo será salvo
    $dest = $uploadDir . $imagem_nome;

    // Move o arquivo enviado para a pasta de uploads
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $dest)) {
        die('Erro no upload da imagem.');
    }
}

// Prepara o INSERT no banco de dados
$stmt = $pdo->prepare('
    INSERT INTO pets 
    (animal, nome, idade, porte, raca, observacao, castrado, sexo, imagem) 
    VALUES 
    (:animal, :nome, :idade, :porte, :raca, :observacao, :castrado, :sexo, :imagem)
');

// Executa o INSERT
$ok = $stmt->execute([
    'animal'      => $animal,
    'nome'        => $nome,
    'idade'       => $idade,
    'porte'       => $porte,
    'raca'        => $raca,
    'observacao'  => $observacao,
    'castrado'    => $castrado,
    'sexo'        => $sexo,
    'imagem'      => $imagem_nome
]);

// Redireciona caso dê certo
if ($ok) {
    header('Location: lista_editar.php');
    exit;
} else {
    echo 'Erro ao cadastrar pet.';
}
?>
