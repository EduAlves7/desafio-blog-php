# Blog de Postagens

Aplicação web para criar, listar, buscar, editar e excluir postagens, desenvolvida em PHP puro com MySQL (acesso via PDO).

## Demonstração

https://github.com/user-attachments/assets/2cc86357-2110-475f-9309-b6e9c00f94e9

## Funcionalidades

- Criar, editar e excluir postagens (título, conteúdo e data de publicação), com confirmação antes de excluir
- Listagem com título, data e trecho do conteúdo, e página da postagem completa ao clicar no título
- Busca por palavra-chave no título ou no conteúdo
- Validação no navegador (JavaScript) e no servidor (PHP)

## Tecnologias

PHP, MySQL, HTML, CSS, JavaScript e Bootstrap 5 (via CDN).

## Requisitos

- PHP 7.4 ou superior, com as extensões `pdo_mysql` e `mbstring`
- MySQL 5.7+ ou MariaDB 10.3+
- Servidor Apache (Laragon/XAMPP) ou servidor embutido do PHP
- Conexão com a internet, por causa do Bootstrap via CDN

## Como executar

1. **Clone o projeto** com o nome `blog` na pasta pública do seu servidor (ou em qualquer pasta, caso use o servidor embutido do PHP):
   ```bash
   git clone https://github.com/EduAlves7/desafio-blog-php.git blog
   ```
   - **Laragon (Windows):** `C:\laragon\www`
   - **XAMPP (Windows):** `C:\xampp\htdocs`
   - **Apache (Linux):** `/var/www/html`

As credenciais do banco ficam em `config/conexao.php` (padrão: usuário `root` e senha vazia). Se o seu MySQL usar outra senha, altere apenas esse arquivo.

### No Windows (Laragon ou XAMPP)

1. **Inicie os serviços:** no Laragon, clique em *Iniciar tudo*; no XAMPP, inicie *Apache* e *MySQL*.
2. **Importe o banco** (`database/banco.sql`):
   - **Laragon:** abra *Banco de dados* (HeidiSQL) > *Arquivo > Carregar arquivo SQL* e execute (`F9`).
   - **XAMPP:** acesse `http://localhost/phpmyadmin` > aba *Importar*, selecione o arquivo e execute.
3. **Acesse no navegador:** `http://localhost/blog`

### No Linux

1. **Entre na pasta do projeto:**
   ```bash
   cd blog
   ```
2. **Inicie o MySQL:**
   ```bash
   sudo systemctl start mysql
   ```
3. **Importe o banco** pelo terminal:
   ```bash
   mysql -u root < database/banco.sql
   ```
4. **Rode o projeto:**
   - **Jeito mais rápido (servidor embutido do PHP):**
     ```bash
     php -S localhost:8000
     ```
     Acesse `http://localhost:8000`.
   - **Usando Apache:** com o projeto em `/var/www/html/blog`, inicie o serviço (`sudo systemctl start apache2`) e acesse `http://localhost/blog`.

## Estrutura

```text
blog/
├── index.php          Listagem e busca
├── ver.php            Postagem completa
├── criar.php          Nova postagem
├── editar.php         Edição
├── excluir.php        Exclusão (apenas POST)
├── config/conexao.php Conexão com o banco
├── includes/          Cabeçalho, rodapé, formulário e funções reutilizáveis
├── assets/            CSS e JavaScript
└── database/banco.sql Criação do banco e da tabela
```

## Observações técnicas

- Consultas com *prepared statements* (PDO) e saída escapada com `htmlspecialchars`, contra SQL Injection e XSS.
- Exclusão apenas por POST, com confirmação em JavaScript.
- Validação nas duas camadas, com as mesmas regras: título obrigatório (até 255 caracteres), conteúdo obrigatório (até 10.000) e data válida entre 01/01/2000 e hoje.
- Criar, editar e excluir redirecionam para a listagem, para que recarregar a página não reenvie o formulário.
