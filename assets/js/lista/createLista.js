const baseUrl = window.location.origin + '/src/';

document.getElementById('btnCriarLista').addEventListener('click', (e) => {
    e.preventDefault();

    if(validaTitulo(document.getElementById('titulo').value)){
        createLista();
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

function createLista(){
    let form = document.getElementById('formCriarLista');
    let formData = new FormData(form);

    fetch(`${baseUrl}api/lista/criar.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a lista.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = `lista.php?id=${data.idLista}`;
        return;
    }).catch(error => {
        return;
    });
}