<?php
require_once 'config.php';

// Inicia sessão apenas se ainda não existir
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    die("Você precisa estar logado para solicitar adoção.");
}

// Verifica envio do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $usuario_id = $_SESSION['user_id'];
    $pet_id = $_POST['pet_id'];

    $nome = $_POST['nome'] ?? $_SESSION['user_nome'];
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';

    try {
        // INSERE NOVA SOLICITAÇÃO
        $stmt = $pdo->prepare("
            INSERT INTO pedidos (usuario_id, pet_id, nome, telefone, endereco, status, criado_em)
            VALUES (:usuario_id, :pet_id, :nome, :telefone, :endereco, 'pendente', NOW())
        ");

        $stmt->execute([
            'usuario_id' => $usuario_id,
            'pet_id' => $pet_id,
            'nome' => $nome,
            'telefone' => $telefone,
            'endereco' => $endereco
        ]);

        echo "Solicitação enviada com sucesso!";
        exit;

    } catch (PDOException $e) {
        die("Erro ao salvar solicitação (DB): " . $e->getMessage());
    }
}
?>
