<?php
/*
  Arquivo: index.php
  Atribuído para: Apresentador 1
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
$search = $_GET['q'] ?? '';
$q = "%$search%";
$stmt = $pdo->prepare("SELECT * FROM pets WHERE nome LIKE :q OR raca LIKE :q OR animal LIKE :q ORDER BY id DESC");
$stmt->execute(['q'=>$q]);
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
  <div class="row" style="align-items:center;">
    <div class="col">
      <form method="GET" class="search-box">
        <input name="q" placeholder="buscar por nome, raça, animal" value="<?= htmlspecialchars($search) ?>">
        <button class="button" type="submit">Buscar</button>
      </form>
    </div>
    <div class="col" style="text-align:right;">
      <?php if(isset($_SESSION['admin_id'])): ?>
        <a class="button" href="lista_editar.php">Gerenciar Pets</a>
      <?php endif; ?>
    </div>
  </div>
  <div class="pets-grid">
    <?php foreach($dados as $pet): ?>
      <div class="pet-card">
        <div class="pet-thumb">
          <?php if(!empty($pet['imagem']) && file_exists(__DIR__.'/uploads/'.$pet['imagem'])): ?>
             <img src="uploads/<?= htmlspecialchars($pet['imagem']) ?>">
          <?php else: ?>
             <div style="padding:12px;color:var(--muted)">Sem imagem</div>
          <?php endif; ?>
        </div>
        <div class="pet-body">
          <h3><?= htmlspecialchars($pet['nome']) ?></h3>
          <p><?= htmlspecialchars($pet['animal']) ?> — <?= htmlspecialchars($pet['raca']) ?></p>
          <p class="small">Idade: <?= htmlspecialchars($pet['idade']) ?> · Castrado: <?= htmlspecialchars($pet['castrado']) ?></p>
          <div class="actions">
            <?php if(isset($_SESSION['user_id'])): ?>
              <form method="POST" action="solicitar_adocao.php" style="margin:0">
                <input type="hidden" name="pet_id" value="<?= $pet['id'] ?>">
                <button class="button" type="submit">Solicitar adoção</button>
              </form>
            <?php else: ?>
              <a class="button ghost" href="login.php">Login para adotar</a>
            <?php endif; ?>
            <?php if(isset($_SESSION['admin_id'])): ?>
              <a class="button ghost" href="editar.php?id=<?= $pet['id'] ?>">Editar</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

  <div class="footer card small">Desenvolvido com ❤️ — sistema de adoção</div>
</div></body></html>
