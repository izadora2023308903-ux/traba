<?php
/*
  Arquivo: Inserir.php
  Atribuído para: Apresentador 1
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
// Só admin pode inserir pets
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método inválido.';
    exit;
}

$animal = $_POST['animal'] ?? '';
$nome = $_POST['nome'] ?? '';
$idade = $_POST['idade'] ?? 0;
$porte = $_POST['porte'] ?? '';
$raca = $_POST['raca'] ?? '';
$observacao = $_POST['observacao'] ?? '';
$castrado = $_POST['castrado'] ?? 'não';
$sexo = $_POST['sexo'] ?? '';

$imagem_nome = null;
if (!empty($_FILES['imagem']['name'])) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (!in_array(strtolower($ext), $allowed)) {
        die('Formato de imagem não permitido.');
    }
    $imagem_nome = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest = $uploadDir . $imagem_nome;
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $dest)) {
        die('Erro no upload da imagem.');
    }
}

$stmt = $pdo->prepare('INSERT INTO pets (animal, nome, idade, porte, raca, observacao, castrado, sexo, imagem) VALUES (:animal,:nome,:idade,:porte,:raca,:observacao,:castrado,:sexo,:imagem)');
$ok = $stmt->execute([
    'animal'=>$animal,'nome'=>$nome,'idade'=>$idade,'porte'=>$porte,'raca'=>$raca,'observacao'=>$observacao,'castrado'=>$castrado,'sexo'=>$sexo,'imagem'=>$imagem_nome
]);

if ($ok) {
    header('Location: lista_editar.php');
    exit;
} else {
    echo 'Erro ao cadastrar pet.';
}
?>