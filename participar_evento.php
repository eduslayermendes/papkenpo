<?php
include 'auth.php';
include 'conexao.php';

// Verifica se o usuário está logado
if (!sessionstatus()) {
    header("Location: index.php"); // Redireciona para a página de login caso não esteja logado
    exit();
}

// Verifica se o ID do evento foi passado pelo formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['evento_id'])) {
    $evento_id = $_POST['evento_id'];
    $email = getemail(); // Obtém o email do utilizador logado

    // Obtém o ID do utilizador a partir do email
    $sql = "SELECT id_utilizador FROM utilizador WHERE email = ?";
    $stmt = mysqli_prepare($liga, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $usuario_id = $row['id_utilizador'];  // Recupera o ID do usuário
        
        // Verifica se o usuário já está registrado para o evento
        $sql_check = "SELECT * FROM evento_participantes WHERE id_evento = ? AND id_utilizador = ?";
        $stmt_check = mysqli_prepare($liga, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ii", $evento_id, $usuario_id);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            echo "Você já está registrado para este evento.";
        } else {
            // Insere a participação do usuário no evento
            $sql = "INSERT INTO evento_participantes (id_evento, id_utilizador) VALUES (?, ?)";
            $stmt = mysqli_prepare($liga, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $evento_id, $usuario_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "Você se registrou para participar do evento!";
            } else {
                echo "Erro ao registrar participação.";
            }
        }
    } else {
        echo "Usuário não encontrado.";
    }
} else {
    echo "Dados inválidos.";
}
?>
