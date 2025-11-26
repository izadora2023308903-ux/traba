<?php
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/*
    CORREÇÃO IMPORTANTE:
    A coluna 'data_solicitacao' NÃO existe na tabela 'pedidos'.
    O nome correto no banco é 'criado_em'.
*/
$stmt = $pdo->prepare("
    SELECT pedidos.*, pets.nome AS pet_nome
    FROM pedidos
    LEFT JOIN pets ON pets.id = pedidos.pet_id
    WHERE pedidos.usuario_id = :uid
    ORDER BY pedidos.criado_em DESC
");
$stmt->execute(['uid' => $user_id]);
$solicitacoes = $stmt->fetchAll();
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Minhas Solicitações</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<div class="container">
    <div class="card">

        <h2>Minhas Solicitações de Adoção</h2>
        <p class="small">
            Olá, <?= htmlspecialchars($_SESSION['user_nome']) ?> |
            <a class="button ghost" href="index.php">Voltar</a>
        </p>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Pet</th>
                <th>Status</th>
                <th>Data</th>
            </tr>

            <?php foreach ($solicitacoes as $s): ?>
                <tr>
                    <td><?= $s['id'] ?></td>
                    <td><?= htmlspecialchars($s['pet_nome']) ?></td>

                    <td>
                        <?php if ($s['status'] === 'pendente'): ?>
                            <span style="color: orange;">Pendente</span>
                        <?php elseif ($s['status'] === 'aprovado'): ?>
                            <span style="color: green;">Aprovado</span>
                        <?php else: ?>
                            <span style="color: red;">Recusado</span>
                        <?php endif; ?>
                    </td>

                    <!-- AQUI TAMBÉM FOI CORRIGIDO: criado_em no lugar de data_solicitacao -->
                    <td><?= $s['criado_em'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
</div>
</body>
</html>
