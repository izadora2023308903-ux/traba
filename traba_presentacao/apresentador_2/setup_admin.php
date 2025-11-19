<?php
/*
  Arquivo: setup_admin.php
  Atribuído para: codigo 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

// setup_admin.php - RODAR UMA ÚNICA VEZ para criar/atualizar o admin com a senha desejada.
// Depois de usar, REMOVA este arquivo por segurança.
require_once 'config.php';
$email = 'admin@petshop.com';
$nome = 'Administrador';
$senha = '789634512aB!';
$hash = password_hash($senha, PASSWORD_DEFAULT);

try {
    // cria tabela admins se não existir
    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
      id INT AUTO_INCREMENT PRIMARY KEY,
      nome VARCHAR(100) NOT NULL,
      email VARCHAR(150) NOT NULL UNIQUE,
      senha_hash VARCHAR(255) NOT NULL,
      criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // atualiza ou insere admin
    $stmt = $pdo->prepare('SELECT id FROM admins WHERE email = :email');
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        $u = $pdo->prepare('UPDATE admins SET nome = :nome, senha_hash = :hash WHERE email = :email');
        $u->execute(['nome' => $nome, 'hash' => $hash, 'email' => $email]);
        echo 'Admin atualizado com sucesso.';
    } else {
        $i = $pdo->prepare('INSERT INTO admins (nome, email, senha_hash) VALUES (:nome, :email, :hash)');
        $i->execute(['nome' => $nome, 'email' => $email, 'hash' => $hash]);
        echo 'Admin criado com sucesso.';
    }
    echo "\nEmail: $email\nSenha: 789634512aB!\n";
} catch (Exception $e) {
    echo 'Erro: ' . $e->getMessage();
}
?>
