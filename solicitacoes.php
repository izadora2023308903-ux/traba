<?php
require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// BUSCA TODAS AS SOLICITAÇÕES
$stmt = $pdo->query("
    SELECT 
        pedidos.id,
        pedidos.status,
        pedidos.criado_em AS data_solicitacao,
        pets.nome AS pet_nome,
        usuarios.nome AS usuario_nome,
        usuarios.email AS usuario_email
    FROM pedidos
    LEFT JOIN pets ON pets.id = pedidos.pet_id
    LEFT JOIN usuarios ON usuarios.id = pedidos.usuario_id
    ORDER BY pedidos.criado_em DESC
");

$dados = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Solicitações</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body>

<div class="container">
    <div class="card">

        <h2>Solicitações de Adoção</h2>

        <p class="small">
            Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?> |
            <a class="button ghost" href="lista_editar.php">Voltar</a>
        </p>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Pet</th>
                <th>Solicitante</th>
                <th>Email</th>
                <th>Data</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($dados as $d): ?>
            <tr>
                <td><?= $d['id'] ?></td>
                <td><?= htmlspecialchars($d['pet_nome']) ?></td>
                <td><?= htmlspecialchars($d['usuario_nome']) ?></td>
                <td><?= htmlspecialchars($d['usuario_email']) ?></td>
                <td><?= $d['data_solicitacao'] ?></td>
                <td><?= htmlspecialchars($d['status']) ?></td>

                <td>
                    <?php if (strtolower($d['status']) === 'pendente'): ?>
                        <a class="button" href="process_aprovacao.php?action=aprovar&id=<?= $d['id'] ?>">Aprovar</a>
                        <a class="button ghost" href="process_aprovacao.php?action=recusar&id=<?= $d['id'] ?>">Recusar</a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>

        </table>

    </div>
</div>

</body>
</html>
