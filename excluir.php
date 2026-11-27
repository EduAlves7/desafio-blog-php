<?php
require 'config/conexao.php';
require 'includes/funcoes.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$post = buscarPost($pdo, $id);

if (!$post) {
    http_response_code(404);
    $titulo_pagina = 'Post não encontrado';
    include 'includes/header.php';
    ?>
    <div class="alert alert-warning">Post não encontrado.</div>
    <a href="index.php" class="btn btn-secondary">Voltar para a lista</a>
    <?php
    include 'includes/footer.php';
    exit;
}

$stmt = $pdo->prepare('DELETE FROM posts WHERE id = :id');
$stmt->execute([':id' => $post['id']]);

header('Location: index.php?msg=excluido');
exit;