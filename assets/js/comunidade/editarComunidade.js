const baseUrl = window.location.origin + '/ws/';

const btnEditar = document.getElementById('btnEditarComunidade');
const formEditarComunidade = document.getElementById('formEditarComunidade');

const capaInput = document.querySelector('input[name="capa"]');
const bannerInput = document.querySelector('input[name="banner"]');
const btnCancelarCapa = document.getElementById('btnCancelarCapa');
const btnCancelarBanner = document.getElementById('btnCancelarBanner');

const capaError = document.createElement('div');
const bannerError = document.createElement('div');
capaError.id = 'capaError';
bannerError.id = 'bannerError';
capaError.classList.add('text-danger', 'mt-1', 'small');
bannerError.classList.add('text-danger', 'mt-1', 'small');

capaInput.insertAdjacentElement('afterend', capaError);
bannerInput.insertAdjacentElement('afterend', bannerError);

function validarImagem(input, errorDiv) {
    errorDiv.textContent = '';
    const files = Array.from(input.files);
    if (files.length === 0) return true;

    for (let file of files) {
        const validExt = /\.(jpe?g|png|webp|gif|bmp|tiff)$/i.test(file.name);
        if (!validExt) {
            errorDiv.textContent = `Arquivo inválido: ${file.name}. Apenas arquivos de imagem são permitidos.`;
            input.value = '';
            return false;
        }
    }
    return true;
}

capaInput.addEventListener('change', () => validarImagem(capaInput, capaError));
bannerInput.addEventListener('change', () => validarImagem(bannerInput, bannerError));

btnCancelarCapa.addEventListener('click', () => {
    capaInput.value = '';
    capaError.textContent = '';
});

btnCancelarBanner.addEventListener('click', () => {
    bannerInput.value = '';
    bannerError.textContent = '';
});

btnEditar.addEventListener('click', e => {
    e.preventDefault();

    const titulo = document.querySelector('input[name="titulo"]').value.trim();
    const descricao = document.querySelector('textarea[name="descricao"]').value.trim();

    const capaValida = validarImagem(capaInput, capaError);
    const bannerValido = validarImagem(bannerInput, bannerError);

    if (!capaValida || !bannerValido) return;

    const formData = new FormData(formEditarComunidade);

    fetch(`${baseUrl}comunidade/wsEditComunidade.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Erro ao editar comunidade.');
        return response.json();
    })
    .then(data => {
        if (data.sucess) {
            window.location.href = `comunidade.php?id=${formData.get('idComunidade')}`;
        }
    })
    .catch(error => console.error(error));
});
