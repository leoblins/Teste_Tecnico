<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';

$msg = $_GET['msg'] ?? '';

// Filtros (extra)
$nome = $_GET['nome'] ?? '';
$status = $_GET['status'] ?? '';

// Paginação (extra)
$por_pagina = 3; 
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($pagina - 1) * $por_pagina;

// Monta SQL com filtros e LIMIT/OFFSET
$sql = "SELECT * FROM produtos WHERE 1=1";
$params = [];
$types = '';

if ($nome !== '') {
    $sql .= " AND nome LIKE ?";
    $params[] = "%$nome%";
    $types .= 's';
}

if ($status !== '') {
    $sql .= " AND status = ?";
    $params[] = $status;
    $types .= 's';
}

$sql .= " ORDER BY nome ASC LIMIT ? OFFSET ?";
$params[] = $por_pagina;
$params[] = $offset;
$types .= 'ii';

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Conta o total de registros para calcular as páginas
$count_sql = "SELECT COUNT(*) FROM produtos WHERE 1=1";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->execute();
$count_stmt->bind_result($total_registros);
$count_stmt->fetch();
$total_paginas = ceil($total_registros / $por_pagina);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Lista de Produtos</h3>

    <?php if ($msg): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <!-- Parte do filtro -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="nome" class="form-control" placeholder="Buscar por nome"
                   value="<?php echo htmlspecialchars($nome); ?>">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">Todos os status</option>
                <option value="ativo" <?php if ($status === 'ativo') echo 'selected'; ?>>Ativo</option>
                <option value="inativo" <?php if ($status === 'inativo') echo 'selected'; ?>>Inativo</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="produto_list.php" class="btn btn-secondary">Limpar</a>
        </div>
    </form>

    <!-- Tabelas -->
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
        <tr>
            <th>Código</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Valor (R$)</th>
            <th>Quantidade</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($p = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $p['codigo']; ?></td>
                <td><?php echo $p['nome']; ?></td>
                <td><?php echo $p['descricao']; ?></td>
                <td><?php echo number_format($p['valor'], 2, ',', '.'); ?></td>
                <td><?php echo $p['quantidade']; ?></td>
                <td><?php echo ucfirst($p['status']); ?></td>
                <td>
                    <a href="produto_form.php?id=<?php echo $p['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="produto_delete.php?id=<?php echo $p['id']; ?>"
                       onclick="return confirm('Deseja realmente excluir este produto?');"
                       class="btn btn-sm btn-danger">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Paginação -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <li class="page-item <?php echo ($i == $pagina) ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina=<?php echo $i; ?>&nome=<?php echo htmlspecialchars($nome); ?>&status=<?php echo $status; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <a href="dashboard.php" class="btn btn-secondary">Voltar</a>
</div>
</body>
</html>
