<?php

// Limites e regras do post
define('LIMITE_TITULO', 255);
define('LIMITE_CONTEUDO', 10000);
define('DATA_MINIMA', '2000-01-01');

// Valida os dados de um post e devolve a lista de erros

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
