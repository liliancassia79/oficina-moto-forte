# Relatório do Projeto Oficina Moto Forte

## 1. Identificação do projeto

**Nome do sistema:** Oficina Moto Forte  
**Tipo:** Sistema web para gerenciamento de oficina de motocicletas  
**Tecnologias principais:** PHP, MySQL, PDO, HTML5, CSS3 e Apache  
**Ambiente de execução:** XAMPP, para uso local  
**Repositório:** https://github.com/liliancassia79/oficina-moto-forte

## 2. Resumo

O Oficina Moto Forte é um sistema web desenvolvido para auxiliar no controle das atividades administrativas e operacionais de uma oficina de motocicletas.

O sistema centraliza informações de clientes, motocicletas, mecânicos, fornecedores, serviços, peças e ordens de serviço. Dessa forma, a oficina pode registrar os atendimentos, acompanhar o andamento dos serviços, controlar o estoque de peças e imprimir ordens de serviço.

O projeto foi desenvolvido a partir da ideia de um sistema de gerenciamento de depósito, adaptando seus conceitos para as necessidades específicas de uma oficina de motos.

## 3. Problema abordado

Oficinas que controlam seus registros manualmente podem enfrentar problemas como:

- Perda de informações de clientes.
- Dificuldade para localizar o histórico de uma motocicleta.
- Falta de controle sobre peças e quantidade em estoque.
- Dificuldade para acompanhar ordens de serviço.
- Erros no registro de preços e serviços.
- Falta de padronização nos documentos entregues aos clientes.

O sistema foi criado para reduzir esses problemas por meio de uma aplicação centralizada, organizada e de fácil utilização.

## 4. Objetivos

### 4.1 Objetivo geral

Desenvolver um sistema web simples e seguro para gerenciar os principais processos de uma oficina de motocicletas.

### 4.2 Objetivos específicos

- Cadastrar e consultar clientes.
- Associar motocicletas aos seus respectivos proprietários.
- Registrar mecânicos e suas especialidades.
- Cadastrar fornecedores.
- Cadastrar serviços realizados pela oficina.
- Controlar peças, preços, estoque e localização por prateleira.
- Criar ordens de serviço.
- Acompanhar o status de cada ordem.
- Imprimir ordens de serviço ou salvá-las em PDF.
- Restringir o acesso ao sistema por meio de autenticação.

## 5. Funcionalidades

### 5.1 Painel principal

O painel inicial apresenta os módulos disponíveis e indicadores resumidos, como:

- Quantidade de clientes.
- Quantidade de motocicletas.
- Quantidade de ordens de serviço.
- Quantidade de peças cadastradas.
- Quantidade de ordens de serviço em aberto.

### 5.2 Clientes

Permite cadastrar:

- Nome.
- Telefone.
- E-mail.
- CPF.

O CPF é armazenado no banco de dados, mas não é exibido na listagem geral para reduzir a exposição de dados pessoais.

### 5.3 Motocicletas

Permite registrar:

- Cliente responsável.
- Marca.
- Modelo.
- Ano.
- Placa.
- Quilometragem.

Cada motocicleta é relacionada a um cliente por meio de uma chave estrangeira.

### 5.4 Mecânicos

Permite cadastrar:

- Nome.
- Especialidade.
- Telefone.

Um mecânico pode ser associado a uma ordem de serviço.

### 5.5 Fornecedores

Permite registrar:

- Nome ou razão social.
- Telefone.
- E-mail.
- CNPJ.

Os fornecedores podem ser associados às peças utilizadas pela oficina.

### 5.6 Serviços

Permite cadastrar:

- Nome do serviço.
- Descrição.
- Preço.
- Tempo estimado.

### 5.7 Peças e estoque

Permite cadastrar:

- Fornecedor.
- Nome da peça.
- Código.
- Prateleira ou local de armazenamento.
- Preço de custo.
- Preço de venda.
- Estoque atual.
- Estoque mínimo.

A informação de prateleira facilita a localização física da peça dentro da oficina.

### 5.8 Ordens de serviço

Permite registrar:

- Motocicleta atendida.
- Mecânico responsável.
- Problema ou serviço solicitado.
- Status da ordem.
- Valor total.
- Previsão de entrega.

Os status disponíveis são:

- Aberta.
- Em andamento.
- Aguardando peça.
- Concluída.
- Cancelada.

### 5.9 Impressão da ordem de serviço

Cada ordem de serviço pode ser aberta em uma página própria para impressão.

O documento apresenta:

- Número da ordem.
- Data de abertura.
- Status.
- Dados do cliente.
- Dados da motocicleta.
- Descrição do serviço.
- Mecânico responsável.
- Previsão de entrega.
- Valor total.
- Espaços para assinatura do cliente e do responsável pela oficina.

O navegador permite imprimir o documento ou salvá-lo como arquivo PDF.

## 6. Tecnologias utilizadas

### PHP

É a linguagem responsável pelo processamento das páginas no servidor. Foi utilizada para:

- Receber dados dos formulários.
- Validar requisições.
- Consultar o banco.
- Inserir registros.
- Controlar sessões.
- Gerar páginas HTML dinamicamente.

### MySQL

É o sistema gerenciador de banco de dados utilizado para armazenar as informações da oficina.

### PDO

O PDO é utilizado para a comunicação entre o PHP e o MySQL. A aplicação utiliza consultas preparadas para reduzir o risco de SQL injection.

### HTML5 e CSS3

O HTML organiza o conteúdo das páginas e o CSS define o layout, as cores, os formulários, as tabelas e a adaptação para telas menores.

### Apache e XAMPP

O Apache executa as páginas PHP localmente. O XAMPP fornece o ambiente integrado com Apache, PHP, MySQL e phpMyAdmin.

### Git e GitHub

O Git é utilizado para controlar as versões do projeto. O GitHub armazena o repositório remoto e permite acompanhar o histórico das alterações.

## 7. Estrutura do banco de dados

O banco de dados utilizado é `oficina_motos`.

As principais tabelas são:

| Tabela | Finalidade |
|---|---|
| `cliente` | Armazena os clientes da oficina |
| `motocicleta` | Armazena as motocicletas e seus proprietários |
| `mecanico` | Armazena os profissionais da oficina |
| `fornecedor` | Armazena os fornecedores |
| `servico` | Armazena os serviços oferecidos |
| `peca` | Armazena peças, preços, estoque e prateleiras |
| `ordem_servico` | Armazena os atendimentos e serviços em execução |

### Relacionamentos principais

- Um cliente pode possuir várias motocicletas.
- Uma motocicleta pertence a um cliente.
- Uma motocicleta pode possuir várias ordens de serviço.
- Um mecânico pode ser associado a várias ordens de serviço.
- Um fornecedor pode fornecer várias peças.

Esses relacionamentos são garantidos por chaves estrangeiras no banco de dados.

## 8. Arquitetura e funcionamento

O sistema utiliza uma arquitetura simples baseada em páginas PHP:

1. O usuário acessa o sistema pelo navegador.
2. O Apache direciona a requisição para o arquivo PHP correspondente.
3. O PHP verifica a sessão do usuário.
4. A aplicação consulta ou altera o banco usando PDO.
5. O PHP gera a resposta HTML.
6. O navegador apresenta a página ao usuário.

O arquivo `auth.php` concentra recursos comuns de segurança, como:

- Inicialização da sessão.
- Verificação de login.
- Geração de token CSRF.
- Validação de token CSRF.
- Cabeçalhos de segurança.

## 9. Segurança implementada

Embora o projeto tenha sido planejado para uso local, foram aplicadas medidas de segurança importantes:

- Login obrigatório para acessar o sistema.
- Senha armazenada em formato de hash.
- Regeneração do identificador da sessão após o login.
- Cookies de sessão com `HttpOnly`.
- Cookies de sessão com `SameSite=Strict`.
- Tokens CSRF nos formulários que alteram dados.
- Consultas preparadas com PDO.
- Lista permitida de tabelas para evitar nomes arbitrários em consultas.
- Escape de dados antes da exibição em HTML.
- Cabeçalho `X-Content-Type-Options`.
- Cabeçalho `X-Frame-Options`.
- Cabeçalho `Referrer-Policy`.
- Política de segurança de conteúdo.
- Limitação do acesso ao computador local pelo `.htaccess`.
- Bloqueio de arquivos de configuração e do script SQL.
- Uso de usuário específico do banco com permissões limitadas.

O arquivo `config.local.php` contém informações locais e não deve ser enviado ao GitHub. Por isso, ele está incluído no `.gitignore`.

## 10. Instalação e execução

1. Instalar o XAMPP.
2. Copiar o projeto para a pasta `htdocs`.
3. Iniciar o Apache e o MySQL.
4. Importar o arquivo `banco.sql` no MySQL.
5. Criar o arquivo `config.local.php` a partir de `config.local.example.php`.
6. Configurar o usuário do banco e o hash da senha de administrador.
7. Acessar:

   ```text
   http://localhost/meu-projeto/
   ```

8. Entrar com um usuário autorizado.

O arquivo `README.md` contém as instruções detalhadas de instalação e configuração.

## 11. Testes realizados

Durante o desenvolvimento foram realizados os seguintes testes:

- Verificação da sintaxe dos arquivos PHP.
- Teste de conexão com o MySQL.
- Criação das tabelas do banco.
- Teste do painel principal.
- Teste dos formulários de cadastro.
- Teste das listagens.
- Teste da impressão de ordem de serviço.
- Teste de redirecionamento para login sem sessão.
- Teste de login com sessão válida.
- Teste de bloqueio de arquivos sensíveis.
- Teste de proteção CSRF.
- Verificação de que as credenciais locais não são enviadas ao GitHub.

## 12. Limitações atuais

O sistema atende ao escopo inicial, mas ainda pode evoluir. Algumas limitações são:

- Os relacionamentos nos formulários utilizam IDs digitados manualmente.
- Ainda não há edição e exclusão de registros pela interface.
- O controle de estoque não registra movimentações detalhadas de entrada e saída.
- Não existe um histórico completo de alterações por usuário.
- O sistema possui apenas um perfil administrativo básico.
- Não há envio automático de mensagens para o cliente.
- Não há integração com emissão fiscal.
- Não há cópia de segurança automática do banco.

## 13. Melhorias futuras

Como trabalhos futuros, podem ser implementados:

- Campos de seleção para clientes, motos, fornecedores e mecânicos.
- Edição e exclusão com confirmação.
- Histórico de manutenção por motocicleta.
- Registro de peças utilizadas em cada ordem.
- Baixa automática de estoque.
- Relatórios financeiros.
- Relatórios de serviços mais realizados.
- Diferentes níveis de acesso.
- Alteração de senha pelo próprio usuário.
- Backup automático.
- Pesquisa e paginação nas listagens.
- Interface otimizada para celulares.
- Publicação segura em servidor com HTTPS.

## 14. Conclusão

O Oficina Moto Forte atende ao objetivo de criar uma solução web para organizar o funcionamento básico de uma oficina de motocicletas.

O sistema reúne cadastros, estoque, ordens de serviço e impressão de documentos em uma única aplicação. A utilização de PHP, MySQL e PDO permitiu construir uma solução compatível com um ambiente local simples, enquanto as medidas de autenticação e proteção de dados aumentaram a segurança do projeto.

Além de resolver problemas comuns de organização, o projeto apresenta uma base que pode ser ampliada com relatórios, controle financeiro, histórico de manutenção e diferentes níveis de acesso.
