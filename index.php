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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            background-color: #333;
            color: #fff;
            padding: 10px;
            margin: 0;
            display: flex;
            justify-content: space-between ;
            align-items: center;
        }
        .loginbutton
        {
            display: flex;
            gap: 10px;
        }
        .loginbutton a
        {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border: 1px solid #333;
        }
        .loginbutton a:hover
        {
            background-color: #fff;
            color: #333;
        }
        
        </style>
</head>
<body>
<?php if (sessionstatus()): ?>
    <h1>Bem vindos ao portal
        <div class="loginbutton">
            <a href="perfil.php"><?php echo htmlspecialchars(getnome()); ?></a>
</div>
</h1>
        <?php if (isAdmin()): ?>
            <p><a href="admin.php">Painel de Administração</a></p>
        <?php endif; ?>
        <a href="logout.php">Terminar Sessão</a>
    <?php else: ?>
        <h1>Bem vindos ao portal
        <div class="loginbutton">
        <a href="login.php">Entrar</a>
        <a href="register.php">Registar</a>
        </div>
        </h1>
    <?php endif; ?>

</body>
</html>