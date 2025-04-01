<?php
include 'auth.php';
include 'conexao.php';

// Função para verificar se o utilizador já participou de um evento
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
        $utilizador_id = $row['id_utilizador'];

        // Verifica se o utilizador já está registrado no evento
        $sql_check = "SELECT * FROM evento_participantes WHERE id_evento = ? AND id_utilizador = ?";
        $stmt_check = mysqli_prepare($liga, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "ii", $evento_id, $utilizador_id);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);
        
        if (mysqli_num_rows($result_check) > 0) {
            return true; // utilizador já registrado
        }
    }
    return false; // utilizador não registrado
}

// Função para obter a graduação do utilizador atual
function obterGraduacaoUtilizador() {
    global $liga;
    $email = getemail();
    
    if (!$email) return null;
    
    // Obtém a graduação do utilizador
    $sql = "SELECT graduacao FROM utilizador WHERE email = ?";
    $stmt = mysqli_prepare($liga, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['graduacao'];
    }
    
    return null;
}

// Lista ordenada de cintos
$cintos = [
    'branco',
    'amarelo',
    'laranja',
    'purpura',
    'azul',
    'verde',
    'castanho1',
    'castanho2',
    'castanho3',
    'negro'
];

// Nome de exibição para cada cinto
$cintosNomes = [
    'branco' => 'Cinto Branco',
    'amarelo' => 'Cinto Amarelo',
    'laranja' => 'Cinto Laranja',
    'purpura' => 'Cinto Púrpura',
    'azul' => 'Cinto Azul',
    'verde' => 'Cinto Verde',
    'castanho1' => 'Cinto Castanho (1º Kyu)',
    'castanho2' => 'Cinto Castanho (2º Kyu)',
    'castanho3' => 'Cinto Castanho (3º Kyu)',
    'negro' => 'Cinto Negro'
];

// Obter a graduação atual do utilizador
$graduacaoAtual = obterGraduacaoUtilizador();

// Determinar quais cintos o utilizador pode ver (graduação atual e anteriores)
$cintosVisiveis = [];
if ($graduacaoAtual) {
    $encontrou = false;
    foreach ($cintos as $cinto) {
        $cintosVisiveis[] = $cinto;
        if ($cinto == $graduacaoAtual) {
            $encontrou = true;
            break;
        }
    }
    
    // Se a graduação não for encontrada na lista, mostra apenas o branco
    if (!$encontrou) {
        $cintosVisiveis = ['branco'];
    }
} else {
    // Se não tiver graduação, mostra apenas o branco
    $cintosVisiveis = ['branco'];
}

// procura os eventos e verifica se o utilizador está registrado em cada um
$sql = "SELECT id_evento, titulo, data_inicio, data_fim FROM evento";
$stmt = mysqli_prepare($liga, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// armazena os eventos com a informação de participação
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
    <link rel='stylesheet' type='text/css' media='screen' href='sidebar.css'>
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
    <button id="toggleSidebar" class="toggle-sidebar">☰</button>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        
        
        <!-- Seção de Programa Técnico -->
        <div class="sidebar-section">
            <div class="sidebar-section-header" id="programaHeader">
                <span>Programa Técnico</span>
                <span class="dropdown-icon">▼</span>
            </div>
            <div class="sidebar-dropdown" id="programaDropdown">
                <?php foreach ($cintosVisiveis as $cinto): ?>
                    <div class="cinto-item <?php echo ($graduacaoAtual == $cinto) ? 'atual' : ''; ?>">
                        <div class="cinto-cor cinto-<?php echo $cinto; ?>"></div>
                        <span><?php echo $cintosNomes[$cinto]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Outras seções da sidebar podem ser adicionadas aqui -->
        <div class="sidebar-section">
            <div class="sidebar-section-header">
                <span>Meus Eventos</span>
            </div>
        </div>
        
        
    </div>
<?php else: ?>
    <h1>Bem-vindo ao portal
        <div class="loginbutton">
        <a href="login.php">Entrar</a>
        <a href="register.php">Registar</a>
        </div>
    </h1>
<?php endif; ?>

<!-- Conteúdo principal -->
<div class="main-content" id="mainContent">
    <div id="calendar"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar o calendário
    let calendarEl = document.getElementById('calendar');
    let events = <?php echo json_encode($eventos); ?>;

    let calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt',
        initialView: 'dayGridMonth',
        events: events.map(function(event) {
            return {
                id: event.id,
                title: event.title,
                start: event.start,
                end: event.end,
                backgroundColor: event.participado ? 'green' : '',
                borderColor: event.participado ? 'green' : '',
            };
        }),
        eventClick: function(info) {
            window.location.href = "evento.php?id=" + info.event.id;
        }
    });

    calendar.render();
    
    // Sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleBtn = document.getElementById('toggleSidebar');
    
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const isSidebarClosed = sidebar.classList.toggle('closed');
            mainContent.classList.toggle('full');
            
            // Corrigir o comportamento do botão toggle
            if (isSidebarClosed) {
                this.classList.add('closed');
            } else {
                this.classList.remove('closed');
            }
        });
    }
    
    // Dropdown toggle para o Programa Técnico
    const programaHeader = document.getElementById('programaHeader');
    const programaDropdown = document.getElementById('programaDropdown');
    
    if (programaHeader && programaDropdown) {
        programaHeader.addEventListener('click', function() {
            programaDropdown.classList.toggle('active');
            const icon = this.querySelector('.dropdown-icon');
            icon.textContent = programaDropdown.classList.contains('active') ? '▲' : '▼';
        });
        
        // Abrir o dropdown por padrão se o utilizador tiver uma graduação
        <?php if ($graduacaoAtual): ?>
        programaDropdown.classList.add('active');
        programaHeader.querySelector('.dropdown-icon').textContent = '▲';
        <?php endif; ?>
    }
    
    // Click nos itens de cinto
    const cintoItems = document.querySelectorAll('.cinto-item');
    cintoItems.forEach(item => {
        item.addEventListener('click', function() {
            // Aqui você pode adicionar uma ação quando um cinto é clicado
            const cintoNome = this.querySelector('span').textContent;
            // Redirecionar para a página de técnicas deste cinto
            window.location.href = 'tecnicas.php?cinto=' + 
                encodeURIComponent(this.querySelector('.cinto-cor').className.split(' ')[1].replace('cinto-', ''));
        });
    });
});
</script>

</body>
</html>