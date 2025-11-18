<?php
/*
  Arquivo: solicitacoes.php
  Atribuído para: Apresentador 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

require_once 'config.php';
if (!isset($_SESSION['admin_id'])) { header('Location: login.php'); exit; }
$stmt = $pdo->query("SELECT pedidos.*, pets.nome AS pet_nome FROM pedidos LEFT JOIN pets ON pets.id = pedidos.pet_id ORDER BY pedidos.criado_em DESC");
$dados = $stmt->fetchAll();
?>
<?php require_once 'config.php'; ?>
<!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width,initial-scale=1'><title>Solicitações</title><link rel='stylesheet' href='style.css'></head><body>
<div class="container"><div class="card"><h2>Solicitações de Adoção</h2>
<p class="small">Admin: <?= htmlspecialchars($_SESSION['admin_nome']) ?> | <a class="button ghost" href="lista_editar.php">Voltar</a></p>
<table class="table"><tr><th>ID</th><th>Pet</th><th>Solicitante</th><th>Contato</th><th>Endereço</th><th>Data</th><th>Status</th><th>Ações</th></tr>
<?php foreach($dados as $d): ?>
<tr>
<td><?= $d['id'] ?></td>
<td><?= htmlspecialchars($d['pet_nome']) ?></td>
<td><?= htmlspecialchars($d['nome'] ?? '—') ?></td>
<td><?= htmlspecialchars($d['telefone'] ?? '—') ?></td>
<td><?= htmlspecialchars($d['endereco'] ?? '—') ?></td>
<td><?= htmlspecialchars($d['criado_em']) ?></td>
<td><?= htmlspecialchars($d['status']) ?></td>
<td><?php if($d['status']=='pendente'): ?>
  <a class="button" href="process_aprovacao.php?action=aprovar&id=<?= $d['id'] ?>">Aprovar</a>
  <a class="button ghost" href="process_aprovacao.php?action=recusar&id=<?= $d['id'] ?>">Recusar</a>
<?php else: ?>—<?php endif; ?></td></tr>
<?php endforeach; ?>
</table></div></div></body></html>