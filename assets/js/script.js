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