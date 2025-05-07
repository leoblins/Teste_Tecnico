<?php
session_start();
session_destroy();  // Destrói todas as variáveis da sessão
header("Location: index.php");  // Redireciona para a página de login
exit;
