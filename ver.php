<?php
require 'config/conexao.php';
require 'includes/funcoes.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$post = false;

if ($id) {
    $stmt = $pdo->prepare('SELECT id, titulo, conteudo, data_publicacao FROM posts WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $post = $stmt->fetch();
}

if (!$post) {
    http_response_code(404);
}

$titulo_pagina = $post ? $post['titulo'] . ' - Blog PHP' : 'Post não encontrado';
include 'includes/header.php';
?>

<?php if (!$post): ?>
    <div class="alert alert-warning">Post não encontrado.</div>
    <a href="index.php" class="btn btn-secondary">Voltar para a lista</a>
<?php else: ?>
    <article>
        <h1 class="text-break"><?= htmlspecialchars($post['titulo']) ?></h1>
        <p class="text-muted">Publicado em <?= formatarData($post['data_publicacao']) ?></p>

        <div class="mb-4 text-break">
            <?= nl2br(htmlspecialchars($post['conteudo'])) ?>
        </div>

        <div class="d-flex gap-2">
            <a href="index.php" class="btn btn-secondary">Voltar</a>
            <a href="editar.php?id=<?= (int) $post['id'] ?>" class="btn btn-outline-primary">Editar</a>

            <form method="POST" action="excluir.php" class="form-excluir">
                <input type="hidden" name="id" value="<?= (int) $post['id'] ?>">
                <button type="submit" class="btn btn-outline-danger">Excluir</button>
            </form>
        </div>
    </article>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>