-- Banco de dados
CREATE DATABASE IF NOT EXISTS projeto_estagio;

USE projeto_estagio;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Inserir usuário de teste (admin / 1234)
INSERT INTO usuarios (usuario, senha)
VALUES ('admin', SHA2('1234', 256));

-- Inserir usuário Geraldo (geraldo / abc)
INSERT INTO Geraldo (usuario, senha)
VALUES ('admin', SHA2('abc', 256));

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20) UNIQUE NOT NULL,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10,2) DEFAULT 0.00,
    quantidade INT DEFAULT 0,
    status ENUM('ativo', 'inativo') NOT NULL
);