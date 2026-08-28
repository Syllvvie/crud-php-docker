<?php
require_once 'conexao.php';

$stmt = $pdo->query("SELECT * FROM meus_pokemons ORDER BY id ASC");
$pokemons = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = count($pokemons);
$indice = isset($_GET['p']) ? (int)$_GET['p'] : 0;

if ($total > 0) {
    if ($indice < 0) $indice = $total - 1;
    if ($indice >= $total) $indice = 0;
    $p = $pokemons[$indice];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Pokédex - Visualização</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="pokedex">
        <div class="top-bar">
            <h2>Pokédex</h2>
        </div>

        <div class="pokedex-screen">
            <?php if ($total === 0): ?>
                <p>Nenhum Pokémon cadastrado!</p>
            <?php else: ?>
                <img src="<?= htmlspecialchars($p['sprite']) ?>" alt="<?= htmlspecialchars($p['nome']) ?>">
                <h3><?= ucfirst(htmlspecialchars($p['nome'])) ?></h3>
                <p>Tipo: <?= ucfirst(htmlspecialchars($p['tipo'])) ?></p>
                <p>Apelido: <?= htmlspecialchars($p['apelido'] ?? 'Nenhum') ?></p>
                <p style="font-size: 0.75rem; color: #555; margin-top: 10px;">Registro #<?= $indice + 1 ?> de <?= $total ?></p>
            <?php endif; ?>
        </div>

        <div class="controls-panel">
            <div class="dpad">
                <?php if ($total > 0): ?>
                    <a href="index.php?p=<?= $indice - 1 ?>" class="dpad-btn dpad-left">◀</a>
                    <a href="index.php?p=<?= $indice + 1 ?>" class="dpad-btn dpad-right">▶</a>
                <?php endif; ?>
                <div class="dpad-center"></div>
            </div>

            <div class="action-buttons">
                <?php if ($total > 0): ?>
                    <a href="editar.php?id=<?= $p['id'] ?>" class="action-btn">Editar</a>
                    <a href="deletar.php?id=<?= $p['id'] ?>" class="action-btn danger" onclick="return confirm('Excluir este Pokémon?')">Excluir</a>
                <?php endif; ?>
                <a href="adicionar.php" class="action-btn" style="background: #3b5ca8; color: white; box-shadow: 0 4px 0 #122143;">+ Novo</a>
            </div>
        </div>
    </div>
</body>
</html>