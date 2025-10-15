const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnCadastrarComunidade').addEventListener('click', (e) => {
    e.preventDefault();
    
    cadastrarComunidade();
});

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