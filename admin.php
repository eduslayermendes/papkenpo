<?php
include 'auth.php';

// Verifica se o utilizador está autenticado e é administrador
if (!estadosessao() || !isAdmin()) {
    header("Location: index.php"); // Redireciona para a página inicial se não for admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
</head>
<body>
    <h1>Painel de Administração</h1>
    <p>Bem-vindo, administrador!</p>
    <p><a href="index.php">Voltar para a página inicial</a></p>
    <p><a href="logout.php">Terminar Sessão</a></p>
</body>
</html>
