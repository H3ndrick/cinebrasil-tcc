document.addEventListener('DOMContentLoaded', () => {
    const baseUrl = window.location.origin + '/ws/';
    const btnCadastrar = document.getElementById('btnCadastrar');
    const btnCancelarFoto = document.getElementById('btnCancelarFoto');
    const fotoInput = document.getElementById('foto');

    btnCancelarFoto.addEventListener('click', () => {
        fotoInput.value = '';
        document.getElementById('fotoError').textContent = '';
    });

    function validaUsername(username) {
        const erroUsername = document.getElementById("usernameError");
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
        const erroEmail = document.getElementById("emailError");
        if (email.trim() === "") {
            erroEmail.textContent = "O e-mail não pode ser vazio.";
            return false;
        }
        if (!email.includes('@')) {
            erroEmail.textContent = "Digite um formato válido para o e-mail.";
            return false;
        }
        const partes = email.split('@');
        if (partes[0].length === 0 || partes[1].length === 0) {
            erroEmail.textContent = "Digite um e-mail válido antes e após o @.";
            return false;
        }
        if (!partes[1].includes('.')) {
            erroEmail.textContent = "Digite um domínio válido.";
            return false;
        }
        erroEmail.textContent = "";
        return true;
    }

    function validaSenha(senha) {
        const erroSenha = document.getElementById('passwordError');
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

    function validaConfirmarSenha(senha, confirmaSenha) {
        const erroConfirmaSenha = document.getElementById('confirmPasswordError');
        if (confirmaSenha.trim() === '') {
            erroConfirmaSenha.textContent = 'A confirmação de senha não pode estar vazia.';
            return false;
        }
        if (confirmaSenha !== senha) {
            erroConfirmaSenha.textContent = 'As senhas não podem ser diferentes.';
            return false;
        }
        erroConfirmaSenha.textContent = '';
        return true;
    }

    function validaFoto() {
        const erroFoto = document.getElementById('fotoError');
        const file = fotoInput.files[0];

        if (!file) { 
            erroFoto.textContent = '';
            return true;
        }

        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
        if (!tiposPermitidos.includes(file.type)) {
            erroFoto.textContent = 'O arquivo selecionado não é uma imagem válida (png, jpg, jpeg, webp, gif).';
            return false;
        }

        erroFoto.textContent = '';
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
        const isFotoValid = validaFoto();

        if (isUsernameValid && isEmailValid && isSenhaValid && isConfirmaSenhaValid && isFotoValid) {
            cadastrar();
        } else {
            console.log('Erro na validação.');
        }
    });

    function cadastrar() {
        const form = document.getElementById('formCadastro');
        const formData = new FormData(form);

        fetch(`${baseUrl}usuario/wsCreateUsuario.php`, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) throw new Error('Não foi possível criar a conta.');
            return response.json();
        })
        .then(data => {
            if (data.sucess) {
                window.location.href = 'sucessoCadastro.php';
            } else {
                document.getElementById('erroCadastro').textContent = data.mensagem;
            }
        })
        .catch(error => console.error(error));
    }
});
