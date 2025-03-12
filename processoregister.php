<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Verificar se o email existe na tabela de alunos e obter o id_aluno
    $checkStmt = $liga->prepare("SELECT id_aluno FROM alunos WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->bind_result($idaluno);
    $checkStmt->fetch();
    $checkStmt->close(); //FECHAR SEMPRE ANTES DE FAZER OUTRA CONSULTA!!

    // Verificar se o email já está registado na tabela de utilizador
    $checkUserStmt = $liga->prepare("SELECT id_utilizador FROM utilizador WHERE email = ?");
    $checkUserStmt->bind_param("s", $email);
    $checkUserStmt->execute();
    $checkUserStmt->store_result();
    
    if ($checkUserStmt->num_rows > 0) {
        echo "O email já está registado. <a href='register.php'>Voltar</a> ou <a href='login.php'> Login</a> ";
    } else {
        // Se o email não existir na tabela de utilizador, fazer a inserção
        if ($idaluno) {
            $stmt = $liga->prepare("INSERT INTO utilizador (idaluno, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $idaluno, $email, $password);

            if ($stmt->execute()) {
                echo "Registo efetuado com sucesso! <a href='login.php'>Login</a>";
            } else {
                echo "Erro ao registar. <a href='register.php'>Voltar</a>";
            }

            $stmt->close();
        } else {
            echo "O email não está registado como aluno. <a href='register.php'>Voltar</a>";
        }
    }

    $checkUserStmt->close();
}
?>
<html>
    
        <head>
        <link rel="icon" type="image/x-icon" href="media/favicon.ico">

</head>
<body>
</body>
</html>

