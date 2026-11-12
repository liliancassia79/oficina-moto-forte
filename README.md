# Oficina Moto Forte

Sistema web para gerenciamento de uma oficina de motos. O projeto foi desenvolvido em PHP com MySQL e PDO, utilizando uma estrutura simples para execução local com XAMPP.

## Funcionalidades

- Painel de controle da oficina.
- Cadastro de clientes.
- Cadastro de motocicletas.
- Cadastro de mecânicos.
- Cadastro de fornecedores.
- Cadastro de serviços.
- Cadastro de peças.
- Controle de estoque e localização por prateleira.
- Cadastro e acompanhamento de ordens de serviço.
- Impressão de ordens de serviço e salvamento em PDF.
- Login obrigatório para acessar o sistema.

## Requisitos

- Linux, Windows ou macOS.
- XAMPP com Apache, PHP e MySQL.
- PHP 8.0 ou superior.
- Extensão PDO para MySQL habilitada.
- Git, caso queira clonar o projeto.

## Instalação com XAMPP

1. Copie o projeto para a pasta `htdocs` do XAMPP.

   No XAMPP para Linux:

   ```text
   /opt/lampp/htdocs/meu-projeto
   ```

2. Inicie o Apache e o MySQL pelo painel do XAMPP ou pelo terminal:

   ```bash
   sudo /opt/lampp/lampp start
   ```

3. Crie o banco de dados e as tabelas. Pelo phpMyAdmin, importe o arquivo:

   ```text
   banco.sql
   ```

   Ou execute pelo terminal:

   ```bash
   /opt/lampp/bin/mysql -h127.0.0.1 -uroot < banco.sql
   ```

4. Crie o arquivo local de configuração:

   ```bash
   cp config.local.example.php config.local.php
   ```

5. Edite `config.local.php` e informe:

   - Usuário e hash do administrador.
   - Usuário do banco de dados.
   - Senha do usuário do banco de dados.

6. Abra o sistema no navegador:

   ```text
   http://localhost/meu-projeto/
   ```

## Configuração do banco de dados

O arquivo `conexao.php` usa o banco `oficina_motos` e o endereço local `127.0.0.1`.

Para produção ou para um ambiente compartilhado, não use o usuário `root`. Crie um usuário específico com permissões somente no banco da aplicação:

```sql
CREATE USER 'oficina_app'@'localhost' IDENTIFIED BY 'defina-uma-senha-forte';
GRANT SELECT, INSERT, UPDATE ON oficina_motos.* TO 'oficina_app'@'localhost';
FLUSH PRIVILEGES;
```

Depois, coloque os dados desse usuário em `config.local.php`.

## Acesso inicial

O arquivo local de configuração de exemplo usa os seguintes dados para o primeiro acesso:

```text
Usuário: admin
Senha: MotoForte@2026!
```

Altere a senha antes de usar o sistema em qualquer computador compartilhado. O arquivo `config.local.php` não deve ser enviado ao GitHub.

Para gerar um novo hash de senha:

```bash
php -r 'echo password_hash("SUA_NOVA_SENHA", PASSWORD_DEFAULT), PHP_EOL;'
```

Copie o resultado para o campo `admin_senha_hash` em `config.local.php`.

## Fluxo recomendado

Cadastre os dados na seguinte ordem:

1. Cliente.
2. Motocicleta, informando o ID do cliente.
3. Mecânico.
4. Fornecedor, se necessário.
5. Peça ou serviço.
6. Ordem de serviço, informando os IDs da motocicleta e do mecânico.

As ordens de serviço podem ser impressas pela tela de listagem de ordens. O navegador também permite salvar o documento como PDF.

## Estrutura dos arquivos

| Arquivo | Finalidade |
|---|---|
| `index.php` | Painel principal |
| `login.php` | Tela de autenticação |
| `logout.php` | Encerramento da sessão |
| `auth.php` | Sessão, autenticação, CSRF e cabeçalhos de segurança |
| `cadastro.php` | Formulários de cadastro |
| `listar.php` | Listagem dos módulos |
| `imprimir_os.php` | Visualização e impressão de ordens de serviço |
| `conexao.php` | Conexão PDO com o MySQL |
| `banco.sql` | Criação do banco e das tabelas |
| `style.css` | Estilos da aplicação |
| `.htaccess` | Restrições de acesso local e proteção de arquivos |
| `config.local.example.php` | Modelo de configuração local |

## Segurança

- As páginas principais exigem login.
- As senhas são verificadas com `password_verify`.
- O ID da sessão é regenerado após o login.
- Os formulários usam tokens CSRF.
- Os cookies de sessão usam `HttpOnly` e `SameSite=Strict`.
- O projeto envia cabeçalhos de segurança HTTP.
- O acesso pelo `.htaccess` é limitado ao computador local.
- Arquivos de configuração e SQL não são exibidos diretamente pelo Apache.
- A listagem de clientes não exibe o CPF.
- As consultas usam parâmetros preparados quando recebem valores externos.

Este projeto foi preparado para uso local. Não o publique na internet sem configurar HTTPS, autenticação adequada, backups, controle de permissões e revisão adicional da infraestrutura.

## Solução de problemas

### Erro de conexão com o banco

Confirme se o MySQL está em execução:

```bash
/opt/lampp/lampp status
```

Confirme também os dados em `config.local.php`.

### Página com erro 403

O projeto foi configurado para aceitar somente conexões locais. Acesse pelo próprio computador usando:

```text
http://localhost/meu-projeto/
```

### Tabelas não encontradas

Importe novamente o arquivo `banco.sql` no banco `oficina_motos`.
