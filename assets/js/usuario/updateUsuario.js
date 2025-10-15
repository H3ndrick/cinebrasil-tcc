const baseUrl = window.location.origin + '/ws/';


const btnEditar = document.getElementById('btnEditar');

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
        erroBio.textContent = "Sus bio deve ter no máximo 20 caracteres.";
        return false;
    }

    erroBio.textContent = "";
    return true;
}


btnEditar.addEventListener('click', (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const bio = document.getElementById("bio").value;

    const isUsernameValid = validaUsername(username);
    const isBioValid = validaBio(bio);

    if (isUsernameValid && isBioValid) {
        console.log('Validação bem-sucedida.');
        atualizar();
    } else {
        console.log('Erro na validação.');
    }
});

function atualizar(){
    let form = document.getElementById('formEditarPerfil');
    let formData = new FormData(form);

    fetch(`${baseUrl}usuario/wsUpdateUsuario.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível editar o perfil.');
        }

        return response.json();
    })
    .then(data => {
        console.log(data);

        if(data.sucess){
            window.location.href = 'perfil.php';
        } else{
            document.getElementById('erroCadastro').innerText = data.mensagem;
        }
    }).catch(error => {
        return console.log(error);
    });
}