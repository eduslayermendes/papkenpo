<?php
include 'auth.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($liga, $_POST['nome']);
    $email = mysqli_real_escape_string($liga, $_POST['email']);
    $telefone = mysqli_real_escape_string($liga, $_POST['telefone']);
    $graduacao = mysqli_real_escape_string($liga, $_POST['graduacao']);

    $sql = "INSERT INTO alunos (Nome, email, telefone, graduacao) 
            VALUES ('$nome', '$email', '$telefone', '$graduacao')";

    if (mysqli_query($liga, $sql)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Erro ao adicionar aluno: " . mysqli_error($liga);
    }
}

mysqli_close($liga);
?>