<?php
declare(strict_types=1);
require_once 'auth.php';
$config = require 'config.local.php';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_csrf();
    $usuario = trim((string) ($_POST['usuario'] ?? ''));
    $senha = (string) ($_POST['senha'] ?? '');
    if (hash_equals($config['admin_usuario'], $usuario) && password_verify($senha, $config['admin_senha_hash'])) {
        session_regenerate_id(true);
        $_SESSION['usuario_autenticado'] = $usuario;
        header('Location: index.php');
        exit;
    }
    $erro = 'Usuário ou senha inválidos.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Acesso - Moto Forte</title><link rel="stylesheet" href="style.css"></head>
<body class="tela-login">
<main class="cartao-login">
    <p class="eyebrow">MOTO FORTE</p><h1>Acesso ao sistema</h1>
    <?php if ($erro): ?><div class="alerta alerta-erro"><?= escapar($erro) ?></div><?php endif; ?>
    <form method="post" class="formulario formulario-login">
        <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
        <label>Usuário<input name="usuario" autocomplete="username" required></label>
        <label>Senha<input type="password" name="senha" autocomplete="current-password" required></label>
        <button class="botao botao-principal" type="submit">Entrar</button>
    </form>
</main>
</body>
</html>
