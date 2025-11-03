const baseUrl = window.location.origin + '/ws/';
const btnEditar = document.getElementById('btnEditar');

const fotoInput = document.getElementById('foto');
const btnCancelarFoto = document.getElementById('btnCancelarFoto');

function validaUsername(username) {
    let erroUsername = document.getElementById("usernameError");
    if (username.trim() === "") {
        erroUsername.textContent = "É necessário escrever o Username.";
        return false;
    }
    if (username.trim().length < 3) {
        erroUsername.textContent = "Seu Username deve ter no mínimo 3 caracteres.";
        return false;
    }
    if (username.trim().length > 20) {
        erroUsername.textContent = "Seu Username deve ter no máximo 20 caracteres.";
        return false;
    }
    erroUsername.textContent = "";
    return true;
}

function validaBio(bio) {
    let erroBio = document.getElementById("bioError");
    if (bio.trim().length > 20) {
        erroBio.textContent = "Sua bio deve ter no máximo 20 caracteres.";
        return false;
    }
    erroBio.textContent = "";
    return true;
}

function validaFoto() {
    let fotoError = document.getElementById('fotoError');
    let files = Array.from(fotoInput.files);

    if (files.length === 0) {
        fotoError.textContent = '';
        return true; 
    }

    for (let file of files) {
        const validExt = /\.(jpe?g|png|webp|gif|bmp|tiff)$/i.test(file.name);
        if (!validExt) {
            fotoError.textContent = `Arquivo inválido: ${file.name}. Apenas arquivos de imagem são permitidos.`;
            fotoInput.value = '';
            return false;
        }
    }
    fotoError.textContent = '';
    return true;
}

fotoInput.addEventListener('change', () => {
    const files = Array.from(fotoInput.files);

    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = file.name;
            img.width = 100;
            img.classList.add('rounded');
        };
        reader.readAsDataURL(file);
    });
});

btnCancelarFoto.addEventListener('click', () => {
    fotoInput.value = '';
    document.getElementById('fotoError').textContent = '';
});

btnEditar.addEventListener('click', (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const bio = document.getElementById("bio").value;
    const isUsernameValid = validaUsername(username);
    const isBioValid = validaBio(bio);
    const isFotoValid = validaFoto();

    if (isUsernameValid && isBioValid && isFotoValid) {
        atualizar();
    }
});

function atualizar(){
    let form = document.getElementById('formEditarPerfil');
    let formData = new FormData(form);

    fetch(`${baseUrl}usuario/wsUpdateUsuario.php`, {
        method: 'POST',
        body: formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível editar o perfil.');
        }
        return response.json();
    })
    .then(data => {
        if(data.sucess){
            window.location.href = 'perfil.php';
        } else{
            document.getElementById('erroCadastro').innerText = data.mensagem;
        }
    }).catch(error => {
    });
}