<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'projeto_estagio';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Erro de conexão com o banco: " . $conn->connect_error);
}

// Conexão bem-sucedida, pode usar $conn nas queries
?>
