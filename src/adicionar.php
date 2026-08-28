<?php
require_once 'conexao.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeBusca = strtolower(trim($_POST['nome']));
    
    if (!empty($nomeBusca)) {
        $url = "https://pokeapi.co/api/v2/pokemon/" . $nomeBusca;
        $options = ["http" => ["header" => "User-Agent: Mozilla/5.0"]];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        
        if ($response) {
            $data = json_decode($response, true);
            $poke_id = $data['id'];
            $nome = $data['name'];
            $tipo = $data['types'][0]['type']['name'];
            $sprite = $data['sprites']['front_default'];
            $apelido = trim($_POST['apelido']);
            
            $stmt = $pdo->prepare("INSERT INTO meus_pokemons (poke_id, nome, tipo, sprite, apelido) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$poke_id, $nome, $tipo, $sprite, $apelido]);
            
            header("Location: index.php");
            exit;
        } else {
            $erro = "Pokémon não encontrado!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Pokémon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="pokedex">
        <div class="top-bar">
            <h2>Capturar</h2>
        </div>

        <div class="pokedex-screen">
            <?php if($erro): ?> <div class="error"><?= $erro ?></div> <?php endif; ?>
            <form method="POST">
                <label>Nome ou ID (ex: 25, pikachu):</label>
                <input type="text" name="nome" required>
                
                <label>Apelido (Opcional):</label>
                <input type="text" name="apelido">
                
                <button type="submit">Salvar na Pokédex</button>
            </form>
            <a href="index.php" class="back-link">Voltar</a>
        </div>
    </div>
</body>
</html>