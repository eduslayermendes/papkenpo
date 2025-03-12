<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "papkenpo";

$liga = new mysqli($host, $user, $password, $dbname);

if ($liga->connect_error) {
    die("Falha na conexão: " . $liga->connect_error);
}
?>