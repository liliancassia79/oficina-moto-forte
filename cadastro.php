<?php
require_once 'conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_bebida = $_POST['nome'];
    $preco_bebida = $_POST['preco'];

    try {
        // Agora usamos preco_venda normalmente, sem precisar de crases!
        $sql = "INSERT INTO produto (id_fornecedor, nome, descricao, tipo, marca, volume_ml, volume_medida, preco_custo, preco_venda, estoque_atual, estoque_minimo, ativo) 
                VALUES (:id_fornecedor, :nome, :descricao, :tipo, :marca, :volume_ml, :volume_medida, :preco_custo, :preco_venda, :estoque_atual, :estoque_minimo, :ativo)";
        
        $stmt = $conexao->prepare($sql);

        // Vincula os dados vindos do formulário
        $stmt->bindValue(':nome', $nome_bebida);
        $stmt->bindValue(':preco_venda', $preco_bebida);

        // Preenche temporariamente as outras colunas obrigatórias com dados de teste
        $stmt->bindValue(':id_fornecedor', 1);
        $stmt->bindValue(':descricao', 'Produto cadastrado via sistema');
        $stmt->bindValue(':tipo', 'Bebida');
        $stmt->bindValue(':marca', 'Genérica');
        $stmt->bindValue(':volume_ml', 350);
        $stmt->bindValue(':volume_medida', 'ml');
        $stmt->bindValue(':preco_custo', 0.00);
        $stmt->bindValue(':estoque_atual', 10);
        $stmt->bindValue(':estoque_minimo', 2);
        $stmt->bindValue(':ativo', 1);

        $stmt->execute();
        $mensagem = "<p style='color: green; font-weight: bold;'>Produto cadastrado com sucesso!</p>";
    } catch (PDOException $erro) {
        $mensagem = "<p style='color: red; font-weight: bold;'>Erro ao cadastrar: " . $erro->getMessage() . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produtos</title>
</head>
<body>

    <h2>Cadastrar Novo Produto</h2>
    
    <?php echo $mensagem; ?>

    <form action="cadastro.php" method="POST">
        <label>Nome do Produto:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Preço de Venda:</label><br>
        <input type="number" step="0.01" name="preco" required><br><br>

        <button type="submit">Salvar no Banco</button>
    </form>

</body>
</html>
