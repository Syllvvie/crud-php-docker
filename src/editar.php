<?php
require_once 'conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apelido = trim($_POST['apelido']);
    $stmt = $pdo->prepare("UPDATE meus_pokemons SET apelido = ? WHERE id = ?");
    $stmt->execute([$apelido, $id]);
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM meus_pokemons WHERE id = ?");
$stmt->execute([$id]);
$pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pokemon) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Pokémon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="pokedex">
        <div class="top-bar">
            <h2>Editar</h2>
        </div>

        <div class="pokedex-screen">
            <img src="<?= htmlspecialchars($pokemon['sprite']) ?>" alt="" style="width:70px; height:70px;">
            <h3><?= ucfirst(htmlspecialchars($pokemon['nome'])) ?></h3>
            <form method="POST">
                <label>Novo Apelido:</label>
                <input type="text" name="apelido" value="<?= htmlspecialchars($pokemon['apelido']) ?>">
                <button type="submit">Salvar Alterações</button>
            </form>
            <a href="index.php" class="back-link">Voltar</a>
        </div>
    </div>
</body>
</html>