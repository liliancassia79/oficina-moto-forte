<?php
declare(strict_types=1);
require_once 'auth.php';
exigir_login();
require_once 'conexao.php';

$modulos = [
    'cliente' => ['Clientes', '👤', 'clientes'],
    'motocicleta' => ['Motocicletas', '🏍️', 'motocicletas'],
    'ordem_servico' => ['Ordens de serviço', '🧰', 'ordens'],
    'servico' => ['Serviços', '🔧', 'servicos'],
    'peca' => ['Peças e estoque', '⚙️', 'pecas'],
    'mecanico' => ['Mecânicos', '👨‍🔧', 'mecanicos'],
    'fornecedor' => ['Fornecedores', '📦', 'fornecedores'],
];

$indicadores = [];
foreach (['cliente', 'motocicleta', 'ordem_servico', 'peca'] as $tabela) {
    $indicadores[$tabela] = (int) $conexao->query("SELECT COUNT(*) FROM `{$tabela}`")->fetchColumn();
}
$ordensAbertas = (int) $conexao->query(
    "SELECT COUNT(*) FROM ordem_servico WHERE status IN ('Aberta', 'Em andamento', 'Aguardando peça')"
)->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oficina Moto Forte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topo">
    <div>
        <span class="marca">MOTO FORTE</span>
        <span class="submarca">Gestão de oficina</span>
    </div>
    <div><a class="botao botao-claro" href="cadastro.php">+ Novo cadastro</a> <a class="link-sair" href="logout.php">Sair</a></div>
</header>

<main class="conteudo">
    <section class="boas-vindas">
        <div>
            <p class="eyebrow">PAINEL DE CONTROLE</p>
            <h1>Bem-vindo à Moto Forte</h1>
            <p>Administre clientes, motos, serviços, peças e ordens de serviço em um só lugar.</p>
        </div>
        <div class="resumo-destaque">
            <strong><?= $ordensAbertas ?></strong>
            <span>ordens em aberto</span>
        </div>
    </section>

    <section class="metricas">
        <div class="metrica"><span>Clientes</span><strong><?= $indicadores['cliente'] ?></strong></div>
        <div class="metrica"><span>Motocicletas</span><strong><?= $indicadores['motocicleta'] ?></strong></div>
        <div class="metrica"><span>Ordens cadastradas</span><strong><?= $indicadores['ordem_servico'] ?></strong></div>
        <div class="metrica"><span>Itens no estoque</span><strong><?= $indicadores['peca'] ?></strong></div>
    </section>

    <h2>Módulos do sistema</h2>
    <section class="grade-cards">
        <?php foreach ($modulos as $tabela => [$titulo, $icone, $rota]): ?>
            <a class="card-modulo" href="listar.php?tabela=<?= urlencode($tabela) ?>">
                <span class="icone"><?= $icone ?></span>
                <span><?= htmlspecialchars($titulo) ?></span>
                <small>Gerenciar dados →</small>
            </a>
        <?php endforeach; ?>
    </section>

    <section class="atalhos">
        <a href="cadastro.php?tipo=ordem_servico" class="botao botao-principal">Abrir ordem de serviço</a>
        <a href="cadastro.php?tipo=cliente" class="botao botao-secundario">Cadastrar cliente</a>
    </section>
</main>
</body>
</html>
