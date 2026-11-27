<?php
require 'config/conexao.php';
require 'includes/funcoes.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$post = buscarPost($pdo, $id);

if (!$post) {
    http_response_code(404);
}

$erros = [];
$titulo = $post['titulo'] ?? '';
$conteudo = $post['conteudo'] ?? '';
$data_publicacao = $post['data_publicacao'] ?? '';

if ($post && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $conteudo = trim($_POST['conteudo'] ?? '');
    $data_publicacao = $_POST['data_publicacao'] ?? '';

    $erros = validarPost($titulo, $conteudo, $data_publicacao);

    if (empty($erros)) {
        $sql = 'UPDATE posts
                SET titulo = :titulo, conteudo = :conteudo, data_publicacao = :data_publicacao
                WHERE id = :id';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':conteudo' => $conteudo,
            ':data_publicacao' => $data_publicacao,
            ':id' => $post['id'],
        ]);

        header('Location: index.php?msg=editado');
        exit;
    }
}

$titulo_pagina = $post ? 'Editar post - Blog PHP' : 'Post não encontrado';
include 'includes/header.php';
?>

<?php if (!$post): ?>
    <div class="alert alert-warning">Post não encontrado.</div>
    <a href="index.php" class="btn btn-secondary">Voltar para a lista</a>
<?php else: ?>
    <h1 class="mb-4">Editar post</h1>

    <?php include 'includes/formulario.php'; ?>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>