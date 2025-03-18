<?php
include 'auth.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Inicio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="icon" type="image/x-icon" href="media/favicon.ico">
</head>
<body>
<?php if (estadosessao()): ?>
    <h1>Bem vindos ao portal</h1>
        <p>Olá, <?php echo htmlspecialchars(buscaremail()); ?>! Sessão iniciada com sucesso.</p>
        <?php if (isAdmin()): ?>
            <p><a href="admin.php">Painel de Administração</a></p>
        <?php endif; ?>
        <a href="logout.php">Terminar Sessão</a>
    <?php else: ?>
        <h1>Bem vindos ao portal</h1>
        <a href="login.php">Entrar</a>
        <a href="register.php">Registar</a>
    <?php endif; ?>

</body>
</html>