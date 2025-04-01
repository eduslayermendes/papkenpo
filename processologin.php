<?php
include 'conexao.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    
    $email = $_POST["email"];
    $password = $_POST["password"];
    //stmt = statement
    $stmt = $liga->prepare("SELECT password FROM utilizador WHERE email = ?");
    $stmt->bind_param("s", $email);   
    $stmt->execute();   
    $stmt->store_result();    
    if ($stmt->num_rows > 0) {       
        $stmt->bind_result($hash);        
        $stmt->fetch();       
        if (password_verify($password, $hash)) {          
            $_SESSION["email"] = $email;                
            header("Location: index.php");
            exit();         
        } else {
            echo "Email ou palavra-passe incorretos.";
        }     
    } else {
        echo "Email ou palavra-passe incorretos.";
    }  
    $stmt->close();
}
?>
<html>   
        <head>
        <link rel="icon" type="image/x-icon" href="media/favicon.ico">
</head>
<body>
</body>
</html>