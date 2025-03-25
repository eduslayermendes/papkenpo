<?php
include 'auth.php';

// Verifica se o utilizador está autenticado
if (!sessionstatus()) {
    header("Location: login.php");
    exit();
}

$nome = htmlspecialchars(getnome());
$email = htmlspecialchars(getemail()); // Supondo que haja uma função getemail()
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>Perfil</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="icon" type="image/x-icon" href="media/favicon.ico">
    <style>
       body {
        font-family: Arial, sans-serif;}
        h1 {
            background-color: #333;
            color: #fff;
            padding: 15px;
            margin: 0 0 20px;
        }
        .profile-info {
            text-align: left;
            padding: 10px;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 5px;
            background-color: #d9534f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    
        <h1>Perfil do Utilizador</h1>
        
            <p><strong>Nome:</strong> <?php echo $nome; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
        
        <a class="logout" href="logout.php">Terminar Sessão</a>
    
</body>
</html>
