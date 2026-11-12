<?php
declare(strict_types=1);

$host = '127.0.0.1';
$banco = 'oficina_motos';
$config = require __DIR__ . '/config.local.php';
$usuario = $config['db_usuario'];
$senha = $config['db_senha'];

try {
    $conexao = new PDO(
        "mysql:host={$host};dbname={$banco};charset=utf8mb4",
        $usuario,
        $senha,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $erro) {
    http_response_code(500);
    exit('Não foi possível conectar ao banco de dados. Verifique as configurações em conexao.php.');
}
