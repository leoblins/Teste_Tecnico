<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styles.css">
    <title>Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h3>
        <p><a href="produto_form.php" class="btn btn-success">Cadastrar Produto</a></p>
        <p><a href="produto_list.php" class="btn btn-primary">Listar Produtos</a></p>
        <p><a href="logout.php" class="btn btn-danger">Sair</a></p>
    </div>
</body>
</html>
