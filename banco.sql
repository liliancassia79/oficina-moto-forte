CREATE DATABASE IF NOT EXISTS oficina_motos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE oficina_motos;

CREATE TABLE IF NOT EXISTS cliente (
    id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(120) NOT NULL, telefone VARCHAR(25) NOT NULL,
    email VARCHAR(120), cpf VARCHAR(20), criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS motocicleta (
    id INT AUTO_INCREMENT PRIMARY KEY, cliente_id INT NOT NULL, marca VARCHAR(60) NOT NULL,
    modelo VARCHAR(80) NOT NULL, ano SMALLINT NOT NULL, placa VARCHAR(10) NOT NULL,
    quilometragem INT DEFAULT 0, FOREIGN KEY (cliente_id) REFERENCES cliente(id)
);
CREATE TABLE IF NOT EXISTS mecanico (
    id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(120) NOT NULL, especialidade VARCHAR(100) NOT NULL,
    telefone VARCHAR(25)
);
CREATE TABLE IF NOT EXISTS fornecedor (
    id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(120) NOT NULL, telefone VARCHAR(25) NOT NULL,
    email VARCHAR(120), cnpj VARCHAR(25)
);
CREATE TABLE IF NOT EXISTS servico (
    id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(120) NOT NULL, descricao TEXT,
    preco DECIMAL(10,2) NOT NULL, tempo_estimado DECIMAL(5,2)
);
CREATE TABLE IF NOT EXISTS peca (
    id INT AUTO_INCREMENT PRIMARY KEY, fornecedor_id INT, nome VARCHAR(120) NOT NULL,
    codigo VARCHAR(40) NOT NULL, prateleira VARCHAR(30) NOT NULL, preco_custo DECIMAL(10,2) NOT NULL, preco_venda DECIMAL(10,2) NOT NULL,
    estoque_atual INT NOT NULL DEFAULT 0, estoque_minimo INT DEFAULT 2,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedor(id)
);
CREATE TABLE IF NOT EXISTS ordem_servico (
    id INT AUTO_INCREMENT PRIMARY KEY, motocicleta_id INT NOT NULL, mecanico_id INT,
    descricao TEXT NOT NULL, status ENUM('Aberta','Em andamento','Aguardando peça','Concluída','Cancelada') NOT NULL DEFAULT 'Aberta',
    valor_total DECIMAL(10,2) DEFAULT 0, data_abertura TIMESTAMP DEFAULT CURRENT_TIMESTAMP, data_entrega DATE,
    FOREIGN KEY (motocicleta_id) REFERENCES motocicleta(id), FOREIGN KEY (mecanico_id) REFERENCES mecanico(id)
);
