const baseUrl = window.location.origin + '/ws/';


const btnCadastrar = document.getElementById('btnCadastrar');

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

function validaEmail(email) {
    let erroEmail = document.getElementById("emailError");

    if (email.trim() === "") {
        erroEmail.textContent = "O e-mail não pode ser vazio.";
        return false;
    }
    if (!email.includes('@')) {
        erroEmail.textContent = "Digite um formato válido para o e-mail.";
        return false;
    }
    let chkEmail = email.split('@');
    if (chkEmail[0].length === 0 || chkEmail[1].length === 0) {
        erroEmail.textContent = "Digite um e-mail válido antes e após o @.";
        return false;
    }
    let chkDomainEmail = chkEmail[1].split('.');
    if (chkDomainEmail.length < 2) {
        erroEmail.textContent = "Digite um domínio válido.";
        return false;
    }

    erroEmail.textContent = "";
    return true;
}

function validaSenha(senha) {
    let erroSenha = document.getElementById('passwordError');
    if (senha.trim() === '') {
        erroSenha.textContent = 'Senha não pode estar vazia.';
        return false;
    }
    if (senha.trim().length < 8) {
        erroSenha.textContent = 'A senha deve ter no mínimo 8 caracteres.';
        return false;
    }

    erroSenha.textContent = '';
    return true;
}

function validaConfirmarSenha(senha, senhaConfirmacao) {
    let erroConfirmaSenha = document.getElementById('confirmPasswordError');
    if (senhaConfirmacao.trim() === '') {
        erroConfirmaSenha.textContent = 'A confirmação de senha não pode estar vazia.';
        return false;
    }
    if (senhaConfirmacao !== senha) {
        erroConfirmaSenha.textContent = 'As senhas não podem ser diferentes.';
        return false;
    }

    erroConfirmaSenha.textContent = '';
    return true;
}


btnCadastrar.addEventListener('click', (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const senha = document.getElementById("password").value;
    const confirmaSenha = document.getElementById("confirmPassword").value;

    const isUsernameValid = validaUsername(username);
    const isEmailValid = validaEmail(email);
    const isSenhaValid = validaSenha(senha);
    const isConfirmaSenhaValid = validaConfirmarSenha(senha, confirmaSenha);

    if (isUsernameValid && isEmailValid && isSenhaValid && isConfirmaSenhaValid) {
        cadastrar();
    }
});

function cadastrar(){
    let form = document.getElementById('formCadastro');
    let formData = new FormData(form);

    fetch(`${baseUrl}usuario/wsCreateUsuario.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a conta.');
        }

        return response.json();
    })
    .then(data => {
        console.log(data);

        if(data.sucess){
            window.location.href = 'sucessoCadastro.php';
        }

        document.getElementById('erroCadastro').textContent = data.mensagem;
    }).catch(error => {
        return console.log(error);
    });
}