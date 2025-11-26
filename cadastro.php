<?php
require_once 'config.php';
$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = $_POST['senha'];
  if (!$nome || !$email || !$senha) {
    $erro = 'Preencha todos os campos.';
  } else {
    // checar se email existe
    $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
      $erro = 'Email já cadastrado.';
    } else {
      $hash = password_hash($senha, PASSWORD_DEFAULT);
      $stmt = $pdo->prepare('INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha)');
      if ($stmt->execute(['nome' => $nome, 'email' => $email, 'senha' => $hash])) {
        header('Location: login.php');
        exit;
      } else {
        $erro = 'Erro ao cadastrar.';
      }
    }
  }
}
?>
<?php require_once 'config.php'; ?>
<!doctype html>
<html>

<head>
  <meta charset='utf-8'>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>PetShop</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="header">
      <div class="brand">
        <div class="logo">PS</div>
        <div>
          <h1 class="site-title">PetShop - Adoção Consciente</h1>
          <div class="small">Encontre seu novo melhor amigo</div>
        </div>
      </div>
      <div class="nav">
        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="small">Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?></div><a class="button ghost"
            href="logout.php">Sair</a>
        <?php elseif (isset($_SESSION['admin_id'])): ?>
          <div class="small">Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?></div><a class="button ghost"
            href="logout.php">Sair</a>
        <?php else: ?>
          <a class="button ghost" href="login.php">Entrar</a><a class="button" href="cadastro.php">Cadastrar</a>
        <?php endif; ?>
      </div>
    </div>

    <div class="card form">
      <h2>Criar conta</h2>
      <?php if ($erro): ?>
        <div class="alert"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
      <form method="POST">
        <label>Nome</label><input name="nome" type="text"required>
        <label>Email</label><input name="email" type="email" required>
        <label>Senha</label><input name="senha" type="password" required>
        <div style="display:flex;gap:8px;align-items:center;">
          <button class="button" type="submit">Cadastrar</button>
          <a class="button ghost" href="login.php">Voltar</a>
        </div>
      </form>
    </div>

    <div class="footer card small">Desenvolvido por Iza, Lilo e Maria — sistema de adoção</div>
  </div>
</body>

</html>