const baseUrl = window.location.origin + '/ws/';

const btnCadastrar = document.getElementById('btnCadastrarComunidade');
const form = document.getElementById('formCadastroComunidade');

const capaInput = document.getElementById('capa');
const bannerInput = document.getElementById('banner');
const btnCancelarCapa = document.getElementById('btnCancelarCapa');
const btnCancelarBanner = document.getElementById('btnCancelarBanner');

const capaError = document.getElementById('capaError');
const bannerError = document.getElementById('bannerError');
const erroCadastro = document.getElementById('erroCadastro');

// ===== Função para validar arquivo de imagem =====
function validarImagem(input, errorDiv) {
    const file = input.files[0];
    if (!file) {
        errorDiv.textContent = '';
        return true;
    }

    const formatosPermitidos = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif', 'image/bmp', 'image/tiff'];
    if (!formatosPermitidos.includes(file.type)) {
        errorDiv.textContent = 'Formato inválido. Envie uma imagem JPG, PNG ou WEBP.';
        input.value = '';
        return false;
    }

    errorDiv.textContent = '';
    return true;
}

// ===== Botões de cancelar (mantêm botão visível) =====
btnCancelarCapa.addEventListener('click', () => {
    capaInput.value = '';
    capaError.textContent = '';
});

btnCancelarBanner.addEventListener('click', () => {
    bannerInput.value = '';
    bannerError.textContent = '';
});

// ===== Envio do formulário =====
btnCadastrar.addEventListener('click', (e) => {
    e.preventDefault();
    erroCadastro.textContent = '';

    const titulo = form.titulo.value.trim();
    const descricao = form.descricao.value.trim();

    if (!titulo || !descricao) {
        erroCadastro.textContent = 'Preencha todos os campos obrigatórios.';
        return;
    }

    if (!validarImagem(capaInput, capaError) || !validarImagem(bannerInput, bannerError)) {
        erroCadastro.textContent = 'Corrija os erros de imagem antes de continuar.';
        return;
    }

    const formData = new FormData(form);

    fetch(`${baseUrl}comunidade/wsCreateComunidade.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Não foi possível cadastrar a comunidade.');
        return response.json();
    })
    .then(data => {
        if (data.sucess) {
            window.location.href = `comunidade.php?id=${data.idComunidade}`;
        } else {
            erroCadastro.textContent = data.mensagem || 'Erro ao criar comunidade.';
        }
    })
    .catch(error => {
        console.error(error);
        erroCadastro.textContent = 'Erro no envio do formulário.';
    });
});
