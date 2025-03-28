<?php
include 'auth.php';

// Verifica se o utilizador está autenticado e é administrador
if (!sessionstatus() || !isAdmin()) {
    header("Location: index.php"); // Redireciona para a página inicial se não for admin
    exit();
}
$sql = "SELECT * FROM alunos";
$result = mysqli_query($liga, $sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="icon" type="image/x-icon" href="media/favicon.ico">
</head>
<body>
    <h1>Painel de Administração
    <div class="loginbutton">
            <a href="perfil.php"><?php echo htmlspecialchars(getnome()); ?></a>
</div>
    </h1>
    <p>Bem-vindo, administrador!</p>
    <p><a href="index.php">Voltar para a página inicial</a></p>
    <p><a href="admin_calendario.php">gestão de eventos</a></p>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>id_aluno</th><th>Nome</th><th>email</th><th>telefone</th><th>graduacao</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["id_aluno"] . "</td>";
            echo "<td>" . $row["Nome"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["telefone"] . "</td>";
            echo "<td>" . $row["graduacao"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Sem resultados.";
    }
    ?>
    <h2>Adicionar Novo Aluno</h2>
    <form action="adicionaraluno.php" method="post">
        Nome: <input type="text" name="nome" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Telefone: <input type="text" name="telefone" required><br><br>
        Graduação: 
        <select name="graduacao">
            <option value="branco">branco</option>
            <option value="amarelo">amarelo</option>
            <option value="laranja">Laranja</option>
            <option value="purpura">purpura</option>
            <option value="azul">azil</option>
            <option value="verde">verde</option>
            <option value="castanho 3º Kyu">castanho3</option>
            <option value="castanho 2º Kyu">castanho2</option>
            <option value="castanho 1º Kyu">castanho1</option>
            <option value="negro">negro</option>
        </select>
        <br><br>
        <input type="submit" value="Adicionar Aluno">
    </form>


</body>
</html>
