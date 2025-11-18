<?php
require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
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

<div class="card form">
  <h2>Adicionar Pet</h2>
  <form action="Inserir.php" method="POST" enctype="multipart/form-data">
    <label>Animal</label><input type="text" name="animal" required>
    <label>Nome</label><input type="text" name="nome" required>
    <label>Raça</label><input type="text" name="raca">
    <label>Porte</label><input type="text" name="porte">
    <label>Sexo</label><input type="text" name="sexo">
    <label>Idade</label><input type="number" name="idade">
    <label>Castrado</label><select name="castrado"><option value="sim">Sim</option><option value="não">Não</option></select>
    <label>Observação</label><textarea name="observacao"></textarea>
    <label>Imagem</label><input type="file" name="imagem" accept="image/*">
    <div style="display:flex;gap:8px;margin-top:8px;"><button class="button" type="submit">Cadastrar</button><a class="button ghost" href="lista_editar.php">Voltar</a></div>
  </form>
</div>

  <div class="footer card small">Desenvolvido por Iza, Lilo e Maria — sistema de adoção</div>
</div></body></html>
