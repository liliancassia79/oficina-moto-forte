<?php
declare(strict_types=1);
require_once 'auth.php';
exigir_login();
require_once 'conexao.php';

$formularios = [
    'cliente' => ['Clientes', [
        'nome' => ['Nome completo', 'text', true],
        'telefone' => ['Telefone', 'text', true],
        'email' => ['E-mail', 'email', false],
        'cpf' => ['CPF', 'text', false],
    ]],
    'motocicleta' => ['Motocicletas', [
        'cliente_id' => ['ID do cliente', 'number', true],
        'marca' => ['Marca', 'text', true],
        'modelo' => ['Modelo', 'text', true],
        'ano' => ['Ano', 'number', true],
        'placa' => ['Placa', 'text', true],
        'quilometragem' => ['Quilometragem', 'number', false],
    ]],
    'mecanico' => ['Mecânicos', [
        'nome' => ['Nome completo', 'text', true],
        'especialidade' => ['Especialidade', 'text', true],
        'telefone' => ['Telefone', 'text', false],
    ]],
    'fornecedor' => ['Fornecedores', [
        'nome' => ['Nome/Razão social', 'text', true],
        'telefone' => ['Telefone', 'text', true],
        'email' => ['E-mail', 'email', false],
        'cnpj' => ['CNPJ', 'text', false],
    ]],
    'servico' => ['Serviços', [
        'nome' => ['Nome do serviço', 'text', true],
        'descricao' => ['Descrição', 'textarea', false],
        'preco' => ['Preço', 'number', true],
        'tempo_estimado' => ['Tempo estimado (horas)', 'number', false],
    ]],
    'peca' => ['Peças', [
        'fornecedor_id' => ['ID do fornecedor', 'number', false],
        'nome' => ['Nome da peça', 'text', true],
        'codigo' => ['Código', 'text', true],
        'prateleira' => ['Prateleira', 'text', true],
        'preco_custo' => ['Preço de custo', 'number', true],
        'preco_venda' => ['Preço de venda', 'number', true],
        'estoque_atual' => ['Estoque atual', 'number', true],
        'estoque_minimo' => ['Estoque mínimo', 'number', false],
    ]],
    'ordem_servico' => ['Ordens de serviço', [
        'motocicleta_id' => ['ID da motocicleta', 'number', true],
        'mecanico_id' => ['ID do mecânico', 'number', false],
        'descricao' => ['Problema/serviço solicitado', 'textarea', true],
        'status' => ['Status', 'select', true],
        'valor_total' => ['Valor total', 'number', false],
        'data_entrega' => ['Previsão de entrega', 'date', false],
    ]],
];

$tipo = $_GET['tipo'] ?? $_POST['tipo'] ?? 'cliente';
if (!isset($formularios[$tipo])) {
    $tipo = 'cliente';
}
[$titulo, $campos] = $formularios[$tipo];
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_csrf();
    $colunas = array_keys($campos);
    $valores = [];
    foreach ($colunas as $coluna) {
        $valor = trim((string) ($_POST[$coluna] ?? ''));
        $valores[$coluna] = $valor === '' ? null : $valor;
    }

    try {
        $nomes = implode(', ', array_map(static fn(string $campo): string => "`{$campo}`", $colunas));
        $marcadores = implode(', ', array_map(static fn(string $campo): string => ":{$campo}", $colunas));
        $stmt = $conexao->prepare("INSERT INTO `{$tipo}` ({$nomes}) VALUES ({$marcadores})");
        foreach ($valores as $coluna => $valor) {
            $stmt->bindValue(":{$coluna}", $valor);
        }
        $stmt->execute();
        $mensagem = 'Registro salvo com sucesso.';
    } catch (PDOException $erro) {
        $mensagem = 'Não foi possível salvar. Confira os IDs relacionados e os campos obrigatórios.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo cadastro - Moto Forte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topo"><a class="marca" href="index.php">MOTO FORTE</a><a href="index.php" class="link-voltar">← Painel</a></header>
<main class="conteudo estreito">
    <p class="eyebrow">CADASTRO</p>
    <h1>Novo registro</h1>
    <nav class="abas">
        <?php foreach ($formularios as $chave => [$nome]): ?>
            <a class="<?= $tipo === $chave ? 'ativa' : '' ?>" href="cadastro.php?tipo=<?= $chave ?>"><?= htmlspecialchars($nome) ?></a>
        <?php endforeach; ?>
    </nav>
    <?php if ($mensagem): ?><div class="alerta"><?= htmlspecialchars($mensagem) ?></div><?php endif; ?>
    <form method="post" class="formulario">
        <input type="hidden" name="tipo" value="<?= escapar($tipo) ?>">
        <input type="hidden" name="csrf" value="<?= escapar(token_csrf()) ?>">
        <?php foreach ($campos as $campo => [$rotulo, $tipoCampo, $obrigatorio]): ?>
            <label>
                <?= htmlspecialchars($rotulo) ?>
                <?php if ($tipoCampo === 'textarea'): ?>
                    <textarea name="<?= $campo ?>" <?= $obrigatorio ? 'required' : '' ?>></textarea>
                <?php elseif ($tipoCampo === 'select'): ?>
                    <select name="<?= $campo ?>" required>
                        <?php foreach (['Aberta', 'Em andamento', 'Aguardando peça', 'Concluída', 'Cancelada'] as $opcao): ?>
                            <option value="<?= $opcao ?>"><?= $opcao ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input type="<?= $tipoCampo ?>" name="<?= $campo ?>" <?= $obrigatorio ? 'required' : '' ?> <?= $tipoCampo === 'number' ? 'step="0.01"' : '' ?>>
                <?php endif; ?>
            </label>
        <?php endforeach; ?>
        <button class="botao botao-principal" type="submit">Salvar <?= strtolower($titulo) ?></button>
    </form>
</main>
</body>
</html>
