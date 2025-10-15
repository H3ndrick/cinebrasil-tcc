const baseUrl = window.location.origin + '/ws/';

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

    erroSenha.textContent = '';
    return true;
}

document.getElementById('btnLogin').addEventListener('click', (e) => {
    e.preventDefault();
    
    const email = document.getElementById("email").value;
    const senha = document.getElementById("password").value;
   
    document.getElementById('mensagemErro').textContent = '';
 
    if (validaEmail(email) && validaSenha(senha)) {
        login();
    }
});

function login() {
    let form = document.getElementById('loginForm');
    let formData = new FormData(form);

    fetch(`${baseUrl}login/wsLogin.php`, {
        method: 'POST',
        body: formData
    }).then(response => {
        if (!response.ok) {
            throw new Error('Erro ao tentar logar');
        }
        return response.json(); // Trata a resposta como JSON
    })
    .then(data => {
        console.log(data); // Verifica a resposta no console

        if (data.success) {
            // Redireciona para a página inicial em caso de sucesso
            window.location.href = 'index.php';
        } else {
            // Exibe a mensagem de erro caso o login não tenha sido bem-sucedido
            document.getElementById('mensagemErro').textContent = data.mensagem;
        }
    }).catch(error => {
        console.log(error); // Exibe o erro no console caso ocorra algum problema
    });
}