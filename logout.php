<?php
session_start();
session_destroy();  // Exclui todas as variaveis da sessão
header("Location: index.php"); 
exit;
