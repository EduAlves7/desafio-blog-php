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