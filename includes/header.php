<!DOCTYPE html>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($titulo_pagina ?? 'Blog PHP') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container"> 
        <a class="navbar-brand" href="index.php">Meu Blog</a>
        <a class="btn btn-success" href="criar.php">Novo Post</a>
    </div>
</nav>

<main class="container">