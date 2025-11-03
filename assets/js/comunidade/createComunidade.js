const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnCadastrarComunidade').addEventListener('click', (e) => {
    e.preventDefault();
    
    if(validaTitulo(document.getElementById('titulo').value)){
        cadastrarComunidade();
    }
    
});

function validaTitulo(titulo){
    const erroTitulo = document.getElementById('tituloError');
    if(titulo.trim() === ''){
        erroTitulo.textContent = "O título não pode ser vazio";
        return false;
    }

    return true;
}

function cadastrarComunidade(){
    let form = document.getElementById('formCadastroComunidade');
    let formData = new FormData(form);

    fetch(`${baseUrl}comunidade/wsCreateComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível cadastrar a comunidade.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = `comunidade.php?id=${data.idComunidade}`;
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}