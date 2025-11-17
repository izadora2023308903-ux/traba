<?php
require_once 'config.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email && $senha) {
        // Tenta autenticar admin
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin && password_verify($senha, $admin['senha_hash'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_nome'] = $admin['nome'];
            header('Location: lista_editar.php');
            exit;
        }

        // Tenta autenticar usuario
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($senha, $user['senha_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nome'] = $user['nome'];
            header('Location: index.php');
            exit;
        }

        $erro = 'Credenciais inválidas. Verifique email e senha.';
    } else {
        $erro = 'Preencha email e senha.';
    }
}
?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Login</title><link rel='stylesheet' href='style.css'></head><body>
<div class="container">
  <div class="card form">
    <h2>Entrar</h2>
    <?php if ($erro): ?><div class="alert"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
    <form method="POST">
      <label>Email:</label>
      <input type="email" name="email" required>
      <label>Senha:</label>
      <input type="password" name="senha" required>
      <div style="display:flex;gap:8px;align-items:center;">
        <button class="button" type="submit">Entrar</button>
        <a class="button ghost" href="cadastro.php">Criar conta</a>
      </div>
    </form>
  </div>
</div>
</body></html>