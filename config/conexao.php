<?php
// Dados de acesso ao banco
$host    = 'localhost';
$banco   = 'blog';
$usuario = 'root';
$senha   = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );

    // Se der erro numa consulta, o PHP lança uma excecao, facilitando achar o problema
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Os resultados virao como array associativo: $post['titulo']
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Não foi possível conectar ao banco de dados.');
}