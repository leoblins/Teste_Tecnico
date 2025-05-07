<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';

$id = $codigo = $nome = $descricao = $valor = $quantidade = $status = "";
$editando = false;

if (isset($_GET['id'])) {
    $editando = true;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $produto = $res->fetch_assoc();
        extract($produto); // preenche tudo
    } else {
        die("Produto não encontrado.");
    }
}


//{  Debug temporario porque estava com erro e não sabia aonde
//if (!$conn) {
//    die(" Erro na conexão com o banco.");
//}
$erro = '';
$sucesso = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $codigo = trim($_POST['codigo']);
    $nome = trim($_POST['nome']);
    $descricao = trim($_POST['descricao']);
    $valor = $_POST['valor'] !== "" ? floatval($_POST['valor']) : 0.00;
    $quantidade = intval($_POST['quantidade']);
    $status = $_POST['status'];

    if ($id) {
        // Edição
        $stmt = $conn->prepare("UPDATE produtos SET nome=?, descricao=?, valor=?, quantidade=?, status=? WHERE id=?");
        $stmt->bind_param("ssdisi", $nome, $descricao, $valor, $quantidade, $status, $id);
        $stmt->execute();
        $sucesso = "✅ Produto atualizado com sucesso!";
    } else {
        // Cadastro novo
        $stmt = $conn->prepare("SELECT id FROM produtos WHERE codigo = ?");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $erro = "⚠️ Código já existente.";
        } else {
            $stmt = $conn->prepare("INSERT INTO produtos (codigo, nome, descricao, valor, quantidade, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdis", $codigo, $nome, $descricao, $valor, $quantidade, $status);
            $stmt->execute();
            $sucesso = "✅ Produto cadastrado com sucesso!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editando ? "Editar Produto" : "Cadastrar Produto"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script>
    // Função para validar o formulário
    function validarFormulario() {
        var codigo = document.getElementsByName("codigo")[0].value;
        var nome = document.getElementsByName("nome")[0].value;
        var status = document.getElementsByName("status")[0].value;

        // Validar campo "Código"
        if (codigo.trim() == "") {
            alert("O código do produto é obrigatório!");
            return false;
        }

        // Validar campo "Nome"
        if (nome.trim() == "") {
            alert("O nome do produto é obrigatório!");
            return false;
        }

        // Validar campo "Status"
        if (status == "") {
            alert("O status do produto é obrigatório!");
            return false;
        }

        return true; 
    }
</script>

<body class="bg-light">
<div class="container mt-4">
    <h3><?php echo $editando ? "Editar Produto" : "Cadastrar Produto"; ?></h3>

    <?php if ($erro): ?>
        <div class="alert alert-danger"><?php echo $erro; ?></div>
    <?php endif; ?>
    <?php if ($sucesso): ?>
        <div class="alert alert-success"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <form method="post" onsubmit="return validarFormulario()">
        <?php if ($editando): ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="codigo" class="form-label">Código *</label>
            <input type="text" name="codigo" class="form-control"
                   value="<?php echo $codigo; ?>" <?php echo $editando ? 'readonly' : 'required'; ?>>
        </div>

        <div class="mb-3">
            <label for="nome" class="form-label">Nome *</label>
            <input type="text" name="nome" class="form-control"
                   value="<?php echo $nome; ?>" required>
        </div>

        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control"><?php echo $descricao; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="valor" class="form-label">Valor (R$)</label>
            <input type="number" step="0.01" name="valor" class="form-control"
                   value="<?php echo $valor; ?>">
        </div>

        <div class="mb-3">
            <label for="quantidade" class="form-label">Quantidade</label>
            <input type="number" name="quantidade" class="form-control"
                   value="<?php echo $quantidade; ?>">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status *</label>
            <select name="status" class="form-select" required>
                <option value="">Selecione</option>
                <option value="ativo" <?php if ($status === 'ativo') echo 'selected'; ?>>Ativo</option>
                <option value="inativo" <?php if ($status === 'inativo') echo 'selected'; ?>>Inativo</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <?php echo $editando ? "Atualizar" : "Salvar"; ?>
        </button>
        <a href="dashboard.php" class="btn btn-secondary">Voltar</a>
    </form>
</div>
</body>
</html>
