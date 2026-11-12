<?php
declare(strict_types=1);
require_once 'auth.php';
exigir_login();
require_once 'conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    http_response_code(400);
    exit('Ordem de serviço inválida.');
}

$stmt = $conexao->prepare(
    "SELECT os.*, c.nome AS cliente_nome, c.telefone AS cliente_telefone,
            m.marca, m.modelo, m.ano, m.placa, m.quilometragem,
            mec.nome AS mecanico_nome
     FROM ordem_servico os
     INNER JOIN motocicleta m ON m.id = os.motocicleta_id
     INNER JOIN cliente c ON c.id = m.cliente_id
     LEFT JOIN mecanico mec ON mec.id = os.mecanico_id
     WHERE os.id = :id"
);
$stmt->execute(['id' => $id]);
$ordem = $stmt->fetch();

if (!$ordem) {
    http_response_code(404);
    exit('Ordem de serviço não encontrada.');
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OS #<?= (int) $ordem['id'] ?> - Moto Forte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="pagina-impressao">
<main class="ordem-impressao">
    <header class="cabecalho-os">
        <div><strong>MOTO FORTE</strong><span>OFICINA DE MOTOS</span></div>
        <div class="numero-os">ORDEM DE SERVIÇO<br><b>#<?= (int) $ordem['id'] ?></b></div>
    </header>
    <div class="linha-os"><span><b>Data de abertura:</b> <?= escapar($ordem['data_abertura']) ?></span><span><b>Status:</b> <?= escapar($ordem['status']) ?></span></div>
    <h3>Cliente</h3>
    <p><b>Nome:</b> <?= escapar($ordem['cliente_nome']) ?> &nbsp; <b>Telefone:</b> <?= escapar($ordem['cliente_telefone']) ?></p>
    <h3>Motocicleta</h3>
    <p><b>Marca/Modelo:</b> <?= escapar($ordem['marca']) ?> <?= escapar($ordem['modelo']) ?> &nbsp; <b>Ano:</b> <?= escapar($ordem['ano']) ?></p>
    <p><b>Placa:</b> <?= escapar($ordem['placa']) ?> &nbsp; <b>Quilometragem:</b> <?= escapar($ordem['quilometragem']) ?> km</p>
    <h3>Serviço solicitado</h3>
    <div class="descricao-os"><?= nl2br(escapar($ordem['descricao'])) ?></div>
    <div class="dados-os"><span><b>Mecânico:</b> <?= escapar($ordem['mecanico_nome']) ?></span><span><b>Entrega prevista:</b> <?= escapar($ordem['data_entrega']) ?></span><span><b>Valor total:</b> R$ <?= number_format((float) $ordem['valor_total'], 2, ',', '.') ?></span></div>
    <div class="assinaturas"><span>________________________________<br>Responsável pela oficina</span><span>________________________________<br>Cliente</span></div>
    <div class="acoes-impressao"><button class="botao botao-principal" onclick="window.print()">Imprimir ordem</button><button class="botao botao-secundario" onclick="window.close()">Fechar</button></div>
</main>
</body>
</html>
