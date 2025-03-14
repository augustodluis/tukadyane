<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUKADYANE - Exemplo de Mapa</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mapa de <?= htmlspecialchars($result->getAddress()) ?></h1>
        <?= $map ?>
    </div>
</body>
</html> 