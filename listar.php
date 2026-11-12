<?php
declare(strict_types=1);
require_once 'auth.php';
exigir_login();
require_once 'conexao.php';

$configuracoes = [
    'cliente' => ['Clientes', ['id', 'nome', 'telefone', 'email']],
    'motocicleta' => ['Motocicletas', ['id', 'cliente_id', 'marca', 'modelo', 'ano', 'placa', 'quilometragem']],
    'mecanico' => ['Mecânicos', ['id', 'nome', 'especialidade', 'telefone']],
    'fornecedor' => ['Fornecedores', ['id', 'nome', 'telefone', 'email', 'cnpj']],
    'servico' => ['Serviços', ['id', 'nome', 'descricao', 'preco', 'tempo_estimado']],
    'peca' => ['Peças', ['id', 'nome', 'codigo', 'prateleira', 'preco_venda', 'estoque_atual', 'estoque_minimo']],
    'ordem_servico' => ['Ordens de serviço', ['id', 'motocicleta_id', 'mecanico_id', 'descricao', 'status', 'valor_total', 'data_entrega']],
];
$tabela = $_GET['tabela'] ?? 'cliente';
if (!isset($configuracoes[$tabela])) {
    http_response_code(404);
    exit('Módulo não encontrado.');
}
[$titulo, $colunas] = $configuracoes[$tabela];
$registros = $conexao->query("SELECT * FROM `{$tabela}` ORDER BY id DESC LIMIT 100")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title><?= htmlspecialchars($titulo) ?> - Moto Forte</title><link rel="stylesheet" href="style.css"></head>
<body>
<header class="topo"><a class="marca" href="index.php">MOTO FORTE</a><a href="index.php" class="link-voltar">← Painel</a></header>
<main class="conteudo">
    <div class="titulo-linha"><div><p class="eyebrow">GERENCIAMENTO</p><h1><?= htmlspecialchars($titulo) ?></h1></div><a class="botao botao-principal" href="cadastro.php?tipo=<?= $tabela ?>">+ Novo registro</a></div>
    <div class="tabela-wrap">
        <table><thead><tr><?php foreach ($colunas as $coluna): ?><th><?= htmlspecialchars(ucwords(str_replace('_', ' ', $coluna))) ?></th><?php endforeach; ?><?php if ($tabela === 'ordem_servico'): ?><th>Ações</th><?php endif; ?></tr></thead>
        <tbody>
        <?php if (!$registros): ?><tr><td colspan="<?= count($colunas) + ($tabela === 'ordem_servico' ? 1 : 0) ?>" class="vazio">Nenhum registro cadastrado.</td></tr>
        <?php else: foreach ($registros as $registro): ?><tr><?php foreach ($colunas as $coluna): ?><td><?= htmlspecialchars((string) ($registro[$coluna] ?? '-')) ?></td><?php endforeach; ?><?php if ($tabela === 'ordem_servico'): ?><td><a class="botao botao-secundario botao-pequeno" href="imprimir_os.php?id=<?= (int) $registro['id'] ?>" target="_blank">Imprimir</a></td><?php endif; ?></tr><?php endforeach; endif; ?>
        </tbody></table>
    </div>
</main>
</body>
</html>
