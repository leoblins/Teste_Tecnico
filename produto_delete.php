<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

require_once 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Buscar o produto
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $produto = $res->fetch_assoc();

        if ($produto['status'] === 'ativo') {
            header("Location: produto_list.php?msg=❌ Produto ativo não pode ser excluído.");
            exit;
        }

        if ($produto['quantidade'] > 0) {
            header("Location: produto_list.php?msg=❌ Produto com quantidade maior que 0 não pode ser excluído.");
            exit;
        }

        // Pode excluir
        $del = $conn->prepare("DELETE FROM produtos WHERE id = ?");
        $del->bind_param("i", $id);
        $del->execute();

        header("Location: produto_list.php?msg=✅ Produto excluído com sucesso.");
        exit;
    }
}

header("Location: produto_list.php?msg=❌ Produto não encontrado.");
exit;
