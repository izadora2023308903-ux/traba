<?php
require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$stmt = $pdo->query('SELECT * FROM pets ORDER BY id DESC');
$dados = $stmt->fetchAll();
?>
<?php require_once 'config.php'; ?>
<!doctype html><html><head><meta charset='utf-8'><meta name="viewport" content="width=device-width,initial-scale=1">
<title>PetShop</title>
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head><body>
<div class="container">
  <div class="header">
    <div class="brand"><div class="logo">PS</div><div><h1 class="site-title">PetShop - Adoção Consciente</h1><div class="small">Encontre seu novo melhor amigo</div></div></div>
    <div class="nav">
      <?php if(isset($_SESSION['user_id'])): ?>
        <div class="small">Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?></div><a class="button ghost" href="logout.php">Sair</a>
      <?php elseif(isset($_SESSION['admin_id'])): ?>
        <div class="small">Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?></div><a class="button ghost" href="logout.php">Sair</a>
      <?php else: ?>
        <a class="button ghost" href="login.php">Entrar</a><a class="button" href="cadastro.php">Cadastrar</a>
      <?php endif; ?>
    </div>
  </div>

<div class="card">
  <h2>Gerenciar Pets</h2>
  <p class="small">Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?> | <a class="button ghost" href="logout.php">Sair</a></p>
  <p><a class="button" href="formulario.php">Adicionar novo pet</a> <a class="button ghost" href="solicitacoes.php">Ver Solicitações</a></p>
  <table class="table">
    <tr><th>ID</th><th>Imagem</th><th>Nome</th><th>Animal</th><th>Raça</th><th>Ações</th></tr>
    <?php foreach($dados as $pet): ?>
      <tr>
        <td><?= $pet['id'] ?></td>
        <td><?php if(!empty($pet['imagem']) && file_exists(__DIR__.'/uploads/'.$pet['imagem'])): ?><img src="uploads/<?= htmlspecialchars($pet['imagem']) ?>" style="height:60px"><?php else: ?>—<?php endif; ?></td>
        <td><?= htmlspecialchars($pet['nome']) ?></td>
        <td><?= htmlspecialchars($pet['animal']) ?></td>
        <td><?= htmlspecialchars($pet['raca']) ?></td>
        <td><a class="button ghost" href="editar.php?id=<?= $pet['id'] ?>">Editar</a> <a class="button ghost" href="deletar.php?id=<?= $pet['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

  <div class="footer card small">Desenvolvido com ❤️ — sistema de adoção</div>
</div></body></html>
