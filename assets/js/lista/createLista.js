const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnCriarLista').addEventListener('click', (e) => {
    e.preventDefault();
    
    console.log(document.getElementById('titulo').value);
    console.log(validaTitulo(document.getElementById('titulo').value));
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

    fetch(`${baseUrl}lista/wsCreateLista.php`, {
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
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}