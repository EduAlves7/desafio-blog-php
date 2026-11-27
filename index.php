<?php
require 'config/conexao.php';
require 'includes/funcoes.php';

$busca = parametroTexto('q');
$msg = parametroTexto('msg');
$posts = buscarPosts($pdo, $busca);

$mensagens = [
    'criado'   => 'Post criado com sucesso!',
    'editado'  => 'Post atualizado com sucesso!',
    'excluido' => 'Post excluído com sucesso!',
];

$titulo_pagina = 'Blog PHP';
include 'includes/header.php';
?>

<h1 class="mb-4">Meus posts</h1>

<?php if (isset($mensagens[$msg])): ?>
    <div class="alert alert-success alert-dismissible fade show" id="mensagem-sucesso" role="alert">
        <?= htmlspecialchars($mensagens[$msg]) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>

<form method="GET" action="index.php" class="row g-2 mb-4" role="search">
    <div class="col">
        <input type="search" name="q" class="form-control" maxlength="100"
               placeholder="Buscar por título ou conteúdo"
               value="<?= htmlspecialchars($busca) ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">Buscar</button>
        <?php if ($busca !== ''): ?>
            <a href="index.php" class="btn btn-outline-secondary">Limpar</a>
        <?php endif; ?>
    </div>
</form>

<?php if ($busca !== ''): ?>
    <p class="text-muted">
        <?= count($posts) ?> resultado(s) para “<?= htmlspecialchars($busca) ?>”
    </p>
<?php endif; ?>

<?php if (empty($posts)): ?>
    <div class="alert alert-info">
        <?= $busca !== '' ? 'Nenhum post encontrado para a sua busca.' : 'Nenhum post cadastrado ainda.' ?>
    </div>
<?php endif; ?>

<?php foreach ($posts as $post): ?>
    <article class="card mb-3">
        <div class="card-body">
            <h2 class="h4 card-title text-break">
                <a href="ver.php?id=<?= (int) $post['id'] ?>" class="text-decoration-none">
                    <?= htmlspecialchars($post['titulo']) ?>
                </a>
            </h2>

            <p class="text-muted small mb-2">
                Publicado em <?= formatarData($post['data_publicacao']) ?>
            </p>

            <p class="card-text text-break">
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

<?php include 'includes/footer.php'; ?>