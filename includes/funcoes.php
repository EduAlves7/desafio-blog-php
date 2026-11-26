<?php

// Valida os dados de um post e devolve a lista de erros

function validarPost($titulo, $conteudo, $data_publicacao) {
    $erros = [];
    
    if ($titulo === ''){
        $erros[] = 'O título é obrigatório.';
    } elseif (mb_strlen($titulo) > 255) {
        $erros[] = 'O título pode ter  no máximo 255 caracteres.';
    }

    if ($conteudo === '') {
        $erros[] = 'O conteúdo é obrigatório.';
    }

    // Nessa parte confere se a data existe de verdade
    $data = DateTime::createFromFormat('Y-m-d', $data_publicacao);
    if (!$data || $data->format('Y-m-d') !== $data_publicacao) {
        $erros[] = 'Informe uma data de publicação válida.';
    }

    return $erros;
}
