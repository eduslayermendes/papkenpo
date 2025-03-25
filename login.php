<?php
include 'auth.php';

// Se a sessão já estiver iniciada, redireciona para a página principal
if (sessionstatus()) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>  

<head>
<link rel="icon" type="image/x-icon" href="media/favicon.ico">

<title>Login</title>
</head>
<body>
<form action="processologin.php" method="POST">
           email <input type="email" name="email" >     <br>                
            pass<input type="password" name="password" >    <br>       
            <button type="submit" name="login">Entrar</button>
            </form>
            <p>Não tem conta? <a href="register.php">Registar</a></p>
    </body>
</html>