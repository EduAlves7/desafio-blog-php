const TEMPO_MENSAGEM = 5000;

const mensagem = document.getElementById('mensagem-sucesso');

if (mensagem) {
    setTimeout(() => {
        bootstrap.Alert.getOrCreateInstance(mensagem).close();
    }, TEMPO_MENSAGEM);

    const url = new URL(window.location);
    url.searchParams.delete('msg');
    history.replaceState(null, '', url);
}

document.querySelectorAll('.form-excluir').forEach((formulario) => {
    formulario.addEventListener('submit', (evento) => {
        const confirmou = confirm('Tem certeza que deseja excluir este post? Esta ação não pode ser desfeita.');

        if (!confirmou) {
            evento.preventDefault();
        }
    });
});

const formPost = document.getElementById('form-post');

if (formPost) {
    const validadores = {
        titulo: (valor) => (valor === '' ? 'O título é obrigatório.' : ''),
        conteudo: (valor) => (valor === '' ? 'O conteúdo é obrigatório.' : ''),
        data_publicacao: (valor, campo) => {
            if (valor === '') return 'Informe uma data de publicação válida.';
            if (campo.validity.rangeUnderflow) return 'A data de publicação não pode ser anterior a 01/01/2000.';
            if (campo.validity.rangeOverflow) return 'A data de publicação não pode ser futura.';
            return '';
        },
    };

    const campos = Object.keys(validadores).map((nome) => formPost.elements[nome]);

    const validarCampo = (campo) => {
        const erro = validadores[campo.name](campo.value.trim(), campo);

        campo.classList.toggle('is-invalid', erro !== '');
        campo.nextElementSibling.textContent = erro;

        return erro === '';
    };

    formPost.addEventListener('submit', (evento) => {
        const resultados = campos.map(validarCampo);

        if (resultados.includes(false)) {
            evento.preventDefault();
            campos[resultados.indexOf(false)].focus();
        }
    });

    campos.forEach((campo) => {
        campo.addEventListener('input', () => {
            if (campo.classList.contains('is-invalid')) {
                validarCampo(campo);
            }
        });
    });
}