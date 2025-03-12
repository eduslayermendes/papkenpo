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
    $checkStmt->close(); // <-- FECHAR O STATEMENT ANTES DE INICIAR OUTRA CONSULTA


    if ($idaluno) {
        // Inserir o utilizador com o id do aluno
        $stmt = $liga->prepare("INSERT INTO utilizador (idaluno, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $idaluno, $email, $password);

        if ($stmt->execute()) {
            echo "Registo efetuado com sucesso! <a href='login.html'>Login</a>";
        } else {
            echo "Erro ao registar.";
        }

        $stmt->close();
    } else {
        echo "O email não está registado como aluno.";
    }

}
?>
