<?php if (!empty($erros)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($erros as $erro): ?>
                <li><?= htmlspecialchars($erro) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" id="form-post">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo"
               maxlength="255" value="<?= htmlspecialchars($titulo) ?>">
    </div>

    <div class="mb-3">
        <label for="conteudo" class="form-label">Conteúdo</label>
        <textarea class="form-control" id="conteudo" name="conteudo"
                  rows="8"><?= htmlspecialchars($conteudo) ?></textarea>
    </div>

    <div class="mb-3">
        <label for="data_publicacao" class="form-label">Data de publicação</label>
        <input type="date" class="form-control" id="data_publicacao"
               name="data_publicacao" value="<?= htmlspecialchars($data_publicacao) ?>">
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>