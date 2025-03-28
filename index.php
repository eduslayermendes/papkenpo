<?php
include 'auth.php';
include 'conexao.php';


// Função para verificar se o usuário já participou de um evento
function verificarParticipacao($evento_id) {
    global $liga;
    $email = getemail();

    // Obtém o ID do utilizador
    $sql = "SELECT id_utilizador FROM utilizador WHERE email = ?";
    $stmt = mysqli_prepare($liga, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $usuario_id = $row['id_utilizador'];

        // Verifica se o usuário já está registrado no evento
        $sql_check = "SELECT * FROM evento_participantes WHERE id_evento = ? AND id_utilizador = ?";
        $stmt_check = mysqli_prepare($liga, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ii", $evento_id, $usuario_id);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            return true; // Usuário já registrado
        }
    }
    return false; // Usuário não registrado
}

// Busca os eventos e verifica se o usuário está registrado em cada um
$sql = "SELECT id_evento, titulo, data_inicio, data_fim FROM evento";
$stmt = mysqli_prepare($liga, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Armazenar os eventos com a informação de participação
$eventos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $participado = verificarParticipacao($row['id_evento']);
    $eventos[] = [
        'id' => $row['id_evento'],
        'title' => $row['titulo'],
        'start' => $row['data_inicio'],
        'end' => $row['data_fim'],
        'participado' => $participado
    ];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset='utf-8'>
    <title>Inicio</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <link rel="icon" type="image/x-icon" href="media/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
</head>
<style>
        #calendar {
            max-width: 600px;
            margin: 0 auto;
            padding: 10px;
        }
        .fc-toolbar {
            margin-bottom: 20px;
        }
    </style>

<body>

<?php if (sessionstatus()): ?>
    <h1>Bem-vindo ao portal
        <div class="loginbutton">
        <?php if (isAdmin()): ?>
            <a href="admin.php">Painel de Administração</a>
        <?php endif; ?>
            <a href="perfil.php"><?php echo htmlspecialchars(getnome()); ?></a>
        </div>
    </h1>
    <a href="logout.php">Terminar Sessão</a>
<?php else: ?>
    <h1>Bem-vindo ao portal
        <div class="loginbutton">
        <a href="login.php">Entrar</a>
        <a href="register.php">Registar</a>
        </div>
    </h1>
<?php endif; ?>

<div id="calendar"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');

    let events = <?php echo json_encode($eventos); ?>; // Passa os eventos para o JavaScript

    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt',
        initialView: 'dayGridMonth',
        events: events.map(function(event) {
            return {
                id: event.id,
                title: event.title,
                start: event.start,
                end: event.end,
                backgroundColor: event.participado ? 'green' : '', // Altera a cor para verde se o usuário estiver inscrito
                borderColor: event.participado ? 'green' : '',
            };
        }),
        eventClick: function(info) {
            window.location.href = "evento.php?id=" + info.event.id; // Redireciona para a página de evento
        }
    });

    calendar.render();
});
</script>

</body>
</html>
