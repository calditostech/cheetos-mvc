<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="content">
        <div class="gear left"></div>
        <div class="gear right"></div>
        <div class="logo"></div>
        <h1>Bem-vindo, <?= htmlspecialchars($nome) ?></h1>
        <p>&copy; <?= date("Y") ?> Cheetos MVC</p>
    </div>
</body>
</html>
