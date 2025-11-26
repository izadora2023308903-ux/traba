<?php
// Importa o arquivo de configuração, que normalmente inicia a sessão
// e faz a conexão com o banco de dados.
require_once 'config.php';

// Verifica se o administrador está logado.
// Se não estiver, redireciona para a página de login.
if (!isset($_SESSION['admin_id'])) { 
    header('Location: login.php'); 
    exit; 
}

// Executa uma consulta no banco para buscar todos os pets cadastrados,
// ordenados do mais recente (ID maior) para o mais antigo.
$stmt = $pdo->query('SELECT * FROM pets ORDER BY id DESC');

// Armazena todos os resultados da consulta em um array.
$dados = $stmt->fetchAll();
?>
<?php require_once 'config.php'; ?>
<!doctype html>
<html>
<head>
<meta charset='utf-8'>
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>PetShop</title>

<!-- Importa o CSS do site -->
<link rel="stylesheet" href="style.css">

<!-- Importa a biblioteca jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
<div class="container">

  <!-- Cabeçalho do site -->
  <div class="header">
    <div class="brand">
      <div class="logo">PS</div>
      <div>
        <h1 class="site-title">PetShop - Adoção Consciente</h1>
        <div class="small">Encontre seu novo melhor amigo</div>
      </div>
    </div>

    <!-- Área de navegação (menus de login, logout, etc.) -->
    <div class="nav">

      <!-- Se um usuário comum estiver logado, mostra seu nome + botão sair -->
      <?php if(isset($_SESSION['user_id'])): ?>
        <div class="small">Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?></div>
        <a class="button ghost" href="logout.php">Sair</a>

      <!-- Se o admin estiver logado, mostra o nome do admin + botão sair -->
      <?php elseif(isset($_SESSION['admin_id'])): ?>
        <div class="small">Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?></div>
        <a class="button ghost" href="logout.php">Sair</a>

      <!-- Se ninguém estiver logado, mostra botões para login/cadastro -->
      <?php else: ?>
        <a class="button ghost" href="login.php">Entrar</a>
        <a class="button" href="cadastro.php">Cadastrar</a>
      <?php endif; ?>

    </div>
  </div>

<!-- Card com a área de gerenciamento dos pets -->
<div class="card">
  <h2>Gerenciar Pets</h2>

  <!-- Mostra o nome do administrador logado -->
  <p class="small">
    Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?> | 
    <a class="button ghost" href="logout.php">Sair</a>
  </p>

  <!-- Botões de adicionar pet e visualizar solicitações -->
  <p>
    <a class="button" href="formulario.php">Adicionar novo pet</a>
    <a class="button ghost" href="solicitacoes.php">Ver Solicitações</a>
  </p>

  <!-- Tabela que lista todos os pets cadastrados -->
  <table class="table">
    <tr>
      <th>ID</th>
      <th>Imagem</th>
      <th>Nome</th>
      <th>Animal</th>
      <th>Raça</th>
      <th>Ações</th>
    </tr>

    <!-- Percorre todos os pets trazidos do banco de dados -->
    <?php foreach($dados as $pet): ?>
      <tr>

        <!-- Exibe o ID do pet -->
        <td><?= $pet['id'] ?></td>

        <!-- Exibe a imagem se existir e se o arquivo estiver na pasta uploads -->
        <td>
          <?php if(!empty($pet['imagem']) && file_exists(__DIR__.'/uploads/'.$pet['imagem'])): ?>
            <img src="uploads/<?= htmlspecialchars($pet['imagem']) ?>" style="height:60px">
          <?php else: ?>
            — <!-- Se não existir imagem, mostra um traço -->
          <?php endif; ?>
        </td>

        <!-- Exibe os dados do pet, usando htmlspecialchars para evitar XSS -->
        <td><?= htmlspecialchars($pet['nome']) ?></td>
        <td><?= htmlspecialchars($pet['animal']) ?></td>
        <td><?= htmlspecialchars($pet['raca']) ?></td>

        <!-- Botões de editar e excluir -->
        <td>
          <a class="button ghost" href="editar.php?id=<?= $pet['id'] ?>">Editar</a>
          
          <!-- Confirmação JavaScript antes de excluir -->
          <a class="button ghost" 
             href="deletar.php?id=<?= $pet['id'] ?>" 
             onclick="return confirm('Excluir?')">
             Excluir
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

  <!-- Rodapé do site -->
  <div class="footer card small">
    Desenvolvido por Iza, Lilo e Maria — sistema de adoção
  </div>

</div>
</body>
</html>
