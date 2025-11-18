<?php
/*
  Arquivo: editar.php
  Atribuído para: Apresentador 1
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
if (!isset($_GET['id'])) { echo 'ID não informado.'; exit; }
$id = $_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM pets WHERE id = :id');
$stmt->execute(['id'=>$id]);
$pet = $stmt->fetch();
if (!$pet) { echo 'Pet não encontrado.'; exit; }
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
  <h2>Editar Pet #<?= $pet['id'] ?></h2>
  <form action="atualizar.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $pet['id'] ?>">
    <label>Animal</label><input type="text" name="animal" value="<?= htmlspecialchars($pet['animal']) ?>">
    <label>Nome</label><input type="text" name="nome" value="<?= htmlspecialchars($pet['nome']) ?>">
    <label>Raça</label><input type="text" name="raca" value="<?= htmlspecialchars($pet['raca']) ?>">
    <label>Porte</label><input type="text" name="porte" value="<?= htmlspecialchars($pet['porte']) ?>">
    <label>Sexo</label><input type="text" name="sexo" value="<?= htmlspecialchars($pet['sexo']) ?>">
    <label>Idade</label><input type="number" name="idade" value="<?= htmlspecialchars($pet['idade']) ?>">
    <label>Castrado</label><select name="castrado"><option value="sim" <?= $pet['castrado']=='sim'?'selected':'' ?>>Sim</option><option value="não" <?= $pet['castrado']=='não'?'selected':'' ?>>Não</option></select>
    <label>Observação</label><textarea name="observacao"><?= htmlspecialchars($pet['observacao']) ?></textarea>
    <label>Imagem atual</label>
    <?php if(!empty($pet['imagem']) && file_exists(__DIR__.'/uploads/'.$pet['imagem'])): ?><img src="uploads/<?= htmlspecialchars($pet['imagem']) ?>" style="height:80px;display:block;margin-bottom:8px"><?php else: ?><div class="small">Sem imagem</div><?php endif; ?>
    <label>Nova imagem</label><input type="file" name="imagem" accept="image/*">
    <div style="display:flex;gap:8px;margin-top:8px;"><button class="button" type="submit">Salvar</button><a class="button ghost" href="lista_editar.php">Voltar</a></div>
  </form>
</div>

  <div class="footer card small">Desenvolvido com ❤️ — sistema de adoção</div>
</div></body></html>
