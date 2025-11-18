<?php
/*
  Arquivo: solicitar_adocao.php
  Atribuído para: Apresentador 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
if (!isset($_REQUEST['pet_id'])) { echo 'Pet não informado.'; exit; }
$pet_id = intval($_REQUEST['pet_id']);
$stmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id');
$stmt->execute(['id'=>$pet_id]);
$pet = $stmt->fetch();
if (!$pet) { echo 'Pet não encontrado.'; exit; }
?><?php require_once 'config.php'; ?>
<!doctype html><html><head><meta charset='utf-8'><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Solicitar Adoção</title><link rel="stylesheet" href="style.css"></head><body>
<div class="container">
  <div class="card form">
    <h2>Solicitar adoção - <?= htmlspecialchars($pet['nome']) ?></h2>
    <form method="POST" action="process_solicitacao.php">
      <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
      <label>Nome completo</label><input type="text" name="nome" required>
      <label>Endereço</label><input type="text" name="endereco" required>
      <label>Telefone</label><input type="text" name="telefone" required>
      <div style="display:flex;gap:8px;margin-top:8px;">
        <button class="button" type="submit">Enviar solicitação</button>
        <a class="button ghost" href="index.php">Cancelar</a>
      </div>
    </form>
  </div>
  <div class="footer card small">Voltar | PetShop</div>
</div></body></html>