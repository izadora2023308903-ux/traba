<?php
/*
  Arquivo: process_solicitacao.php
  Atribuído para: Apresentador 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método inválido.');
    }

    $usuario_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;
    $pet_id = intval($_POST['pet_id'] ?? 0);
    $nome = trim($_POST['nome'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    if (!$pet_id || !$nome || !$endereco || !$telefone) {
        throw new Exception('Preencha todos os campos obrigatórios.');
    }

    // Verifica se o pet existe
    $s = $pdo->prepare('SELECT id FROM pets WHERE id = :id');
    $s->execute(['id' => $pet_id]);
    if (!$s->fetch()) {
        throw new Exception('Pet não encontrado.');
    }

    // Se usuario_id estiver definido, verifica se usuário existe
    $usuario_existe = false;
    if ($usuario_id) {
        $c = $pdo->prepare('SELECT id FROM usuarios WHERE id = :id');
        $c->execute(['id' => $usuario_id]);
        $usuario_existe = $c->fetch() ? true : false;
    }

    if ($usuario_existe) {
        $stmt = $pdo->prepare('INSERT INTO pedidos (usuario_id, pet_id, status, nome, endereco, telefone, criado_em) VALUES (:u, :p, :s, :n, :e, :t, NOW())');
        $stmt->execute([
            'u' => $usuario_id,
            'p' => $pet_id,
            's' => 'pendente',
            'n' => $nome,
            'e' => $endereco,
            't' => $telefone
        ]);
    } else {
        // Insere sem usuario_id (usuario visitante)
        $stmt = $pdo->prepare('INSERT INTO pedidos (pet_id, status, nome, endereco, telefone, criado_em) VALUES (:p, :s, :n, :e, :t, NOW())');
        $stmt->execute([
            'p' => $pet_id,
            's' => 'pendente',
            'n' => $nome,
            'e' => $endereco,
            't' => $telefone
        ]);
    }

    header('Location: index.php?msg=solicitacao_ok');
    exit;
} catch (PDOException $ex) {
    error_log('DB Error in process_solicitacao.php: ' . $ex->getMessage());
    die('Erro ao salvar solicitação (DB).');
} catch (Exception $e) {
    die($e->getMessage());
}
?>