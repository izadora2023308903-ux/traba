<?php
/*
  Arquivo: solicitar_adocao.php
  Atribuído para: Apresentador 2
  Descrição geral: Página onde um usuário logado pode preencher o formulário
  para solicitar a adoção de um determinado pet.
*/

require_once 'config.php'; // Importa conexão com o banco e inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); // Redireciona para login se não estiver autenticado
    exit;
}

// Verifica se o pet_id foi enviado na URL ou formulário
if (!isset($_REQUEST['pet_id'])) { 
    echo 'Pet não informado.'; 
    exit; 
}

// Converte pet_id para inteiro
$pet_id = intval($_REQUEST['pet_id']);

// Busca dados do pet no banco de dados
$stmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id');
$stmt->execute(['id' => $pet_id]);
$pet = $stmt->fetch();

// Se o pet não existir, interrompe o processo
if (!$pet) { 
    echo 'Pet não encontrado.'; 
    exit; 
}
?>

<?php require_once 'config.php'; ?> <!-- Incluído no código original, mas redundante -->

<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Solicitar Adoção</title>

    <!-- Estilos do site -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">

  <div class="card form">
    <!-- Título com nome do pet -->
    <h2>Solicitar adoção - <?= htmlspecialchars($pet['nome']) ?></h2>

    <!-- Formulário que envia os dados para process_solicitacao.php -->
    <form method="POST" action="process_solicitacao.php">

      <!-- Envia o ID do pet escondido -->
      <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">

      <!-- Campo Nome -->
      <label>Nome completo</label>
      <input type="text" name="nome" required>

      <!-- Campo Endereço -->
      <label>Endereço</label>
      <input type="text" name="endereco" required>

      <!-- Campo Telefone -->
      <label>Telefone</label>
      <input type="text" name="telefone" required>

      <!-- Botões -->
      <div style="display:flex;gap:8px;margin-top:8px;">
        <button class="button" type="submit">Enviar solicitação</button>
        <a class="button ghost" href="index.php">Cancelar</a>
      </div>

    </form>
  </div>

  <!-- Rodapé simples -->
  <div class="footer card small">Voltar | PetShop</div>

</div>
</body>
</html>
