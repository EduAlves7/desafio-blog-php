<?php
require 'config/conexao.php';
require 'includes/funcoes.php';

// Valores iniciais

$erros = [];
$titulo = '';
$conteudo = '';
$data_publicacao = date('Y-m-d');

// Só vai tentar salvar quando o formulário for enviado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');
    $data_publicacao = $_POST['data_publicacao'] ?? '';

    $erros = validarPost($titulo, $conteudo, $data_publicacao);

    if (empty($erros)) {
        $sql = 'INSERT INTO posts (titulo, conteudo, data_publicacao)
                VALUES (:titulo, :conteudo, :data_publicacao)';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':conteudo' => $conteudo,
            ':data_publicacao' => $data_publicacao,
        ]);

        header('Location: index.php?msg=criado');
        exit;
    }
}

$titulo_pagina = 'Novo post - Blog PHP';
include 'includes/header.php';
?>

<h1 class="mb-4">Novo post</h1>

<?php include 'includes/formulario.php'; ?>
<?php include 'includes/footer.php'; ?>

