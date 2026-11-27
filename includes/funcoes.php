<?php

// Limites e regras do post
define('LIMITE_TITULO', 255);
define('LIMITE_CONTEUDO', 10000);
define('DATA_MINIMA', '2000-01-01');


function validarPost($titulo, $conteudo, $data_publicacao)
{
    $erros = [];

    if ($titulo === '') {
        $erros[] = 'O título é obrigatório.';
    } elseif (mb_strlen($titulo) > LIMITE_TITULO) {
        $erros[] = 'O título pode ter no máximo ' . LIMITE_TITULO . ' caracteres.';
    }

    if ($conteudo === '') {
        $erros[] = 'O conteúdo é obrigatório.';
    } elseif (mb_strlen($conteudo) > LIMITE_CONTEUDO) {
        $erros[] = 'O conteúdo pode ter no máximo ' . number_format(LIMITE_CONTEUDO, 0, ',', '.') . ' caracteres.';
    }

    // Confere se a data existe de verdade
    $data = DateTime::createFromFormat('Y-m-d', $data_publicacao);
    if (!$data || $data->format('Y-m-d') !== $data_publicacao) {
        $erros[] = 'Informe uma data de publicação válida.';
    } elseif ($data_publicacao < DATA_MINIMA) {
        $erros[] = 'A data de publicação não pode ser anterior a 01/01/2000.';
    } elseif ($data_publicacao > date('Y-m-d')) {
        $erros[] = 'A data de publicação não pode ser futura.';
    }

    return $erros;
}

// Converte a data para um formato mais amigável
function formatarData($data)
{
    $objeto = DateTime::createFromFormat('Y-m-d', $data);
    return $objeto ? $objeto->format('d/m/Y') : $data;
}

// Devolve só o começo do texto, sem cortar a palavra no meio
function resumir($texto, $limite = 150)
{
    if (mb_strlen($texto) <= $limite) {
        return $texto;
    }

    $corte = mb_substr($texto, 0, $limite);
    $ultimoEspaco = mb_strrpos($corte, ' ');

    if ($ultimoEspaco !== false) {
        $corte = mb_substr($corte, 0, $ultimoEspaco);
    }

    return $corte . '...';
}

function buscarPost($pdo, $id)
{
    if (!$id) {
        return false;
    }

    $stmt = $pdo->prepare('SELECT id, titulo, conteudo, data_publicacao FROM posts WHERE id = :id');
    $stmt->execute([':id' => $id]);

    return $stmt->fetch();
}

function parametroTexto($nome, $limite = 100)
{
    $valor = $_GET[$nome] ?? '';

    return is_string($valor) ? mb_substr(trim($valor), 0, $limite) : '';
}

function escaparLike($texto)
{
    return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $texto);
}

function buscarPosts($pdo, $busca = '')
{
    $ordem = 'ORDER BY data_publicacao DESC, id DESC';

    if ($busca === '') {
        return $pdo->query("SELECT id, titulo, conteudo, data_publicacao FROM posts $ordem")->fetchAll();
    }

    $termo = '%' . escaparLike($busca) . '%';

    $stmt = $pdo->prepare(
        "SELECT id, titulo, conteudo, data_publicacao
         FROM posts
         WHERE titulo LIKE :titulo OR conteudo LIKE :conteudo
         $ordem"
    );
    $stmt->execute([':titulo' => $termo, ':conteudo' => $termo]);

    return $stmt->fetchAll();
}