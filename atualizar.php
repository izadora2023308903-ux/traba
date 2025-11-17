<?php
require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { echo 'Método inválido'; exit; }

$id = $_POST['id'];
$nome = $_POST['nome'];
$sexo = $_POST['sexo'];
$animal = $_POST['animal'];
$raca = $_POST['raca'];
$idade = $_POST['idade'];
$porte = $_POST['porte'];
$castrado = $_POST['castrado'];
$observacao = $_POST['observacao'];

$imagem_nome = null;
if (!empty($_FILES['imagem']['name'])) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir,0755,true);
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','gif'];
    if (!in_array(strtolower($ext), $allowed)) { die('Formato de imagem não permitido.'); }
    $imagem_nome = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dest = $uploadDir . $imagem_nome;
    if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $dest)) { die('Erro no upload.'); }
    // remover imagem antiga opcionalmente
    $old = $pdo->prepare('SELECT imagem FROM pets WHERE id = :id');
    $old->execute(['id'=>$id]);
    $row = $old->fetch();
    if ($row && !empty($row['imagem']) && file_exists(__DIR__.'/uploads/'.$row['imagem'])) {
        @unlink(__DIR__.'/uploads/'.$row['imagem']);
    }
    $stmt = $pdo->prepare('UPDATE pets SET nome=:nome, sexo=:sexo, animal=:animal, raca=:raca, idade=:idade, porte=:porte, castrado=:castrado, observacao=:observacao, imagem=:imagem WHERE id=:id');
    $ok = $stmt->execute(['nome'=>$nome,'sexo'=>$sexo,'animal'=>$animal,'raca'=>$raca,'idade'=>$idade,'porte'=>$porte,'castrado'=>$castrado,'observacao'=>$observacao,'imagem'=>$imagem_nome,'id'=>$id]);
} else {
    $stmt = $pdo->prepare('UPDATE pets SET nome=:nome, sexo=:sexo, animal=:animal, raca=:raca, idade=:idade, porte=:porte, castrado=:castrado, observacao=:observacao WHERE id=:id');
    $ok = $stmt->execute(['nome'=>$nome,'sexo'=>$sexo,'animal'=>$animal,'raca'=>$raca,'idade'=>$idade,'porte'=>$porte,'castrado'=>$castrado,'observacao'=>$observacao,'id'=>$id]);
}

if ($ok) { header('Location: lista_editar.php'); exit; } else { echo 'Erro ao atualizar.'; }
?>