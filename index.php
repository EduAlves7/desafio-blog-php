<?php
require 'config/conexao.php';
require 'includes/funcoes.php';

// Busca todos os posts, do mais recente para o mais antigo
$stmt = $pdo->query('SELECT id, titulo, conteudo, data_publicacao
                     FROM posts
                     ORDER BY data_publicacao DESC, id DESC');
$posts = $stmt->fetchAll();

// Mensagens de sucesso: só aceita valores conhecidos
$mensagens = [
    'criado'   => 'Post criado com sucesso!',
    'editado'  => 'Post atualizado com sucesso!',
    'excluido' => 'Post excluído com sucesso!',
];
$msg = $_GET['msg'] ?? '';

$titulo_pagina = 'Blog PHP';
include 'includes/header.php';
?>

<h1 class="mb-4">Meus posts</h1>

<?php if (isset($mensagens[$msg])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensagens[$msg]) ?>
    </div>
<?php endif; ?>

<?php if (empty($posts)): ?>
    <div class="alert alert-info">Nenhum post cadastrado ainda.</div>
<?php endif; ?>

<?php foreach ($posts as $post): ?>
    <article class="card mb-3">
        <div class="card-body">
            <h2 class="h4 card-title">
                <a href="ver.php?id=<?= (int) $post['id'] ?>" class="text-decoration-none">
                    <?= htmlspecialchars($post['titulo']) ?>
                </a>
            </h2>

            <p class="text-muted small mb-2">
                Publicado em <?= formatarData($post['data_publicacao']) ?>
            </p>

            <p class="card-text">
                <?= nl2br(htmlspecialchars(resumir($post['conteudo']))) ?>
            </p>

            <div class="d-flex gap-2">
                <a href="editar.php?id=<?= (int) $post['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>

                <form method="POST" action="excluir.php" class="form-excluir">
                    <input type="hidden" name="id" value="<?= (int) $post['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                </form>
            </div>
        </div>
    </article>
<?php endforeach; ?>

<?php include 'includes/footer.php';

