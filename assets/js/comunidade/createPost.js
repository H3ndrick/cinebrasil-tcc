const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnCriarPublicacao').addEventListener('click', (e) => {
    e.preventDefault();
    
    criarPost();
});

function criarPost(){
    let form = document.getElementById('formPost');
    let formData = new FormData(form);

    let editor = document.getElementById('editor');
    formData.append('conteudo', editor.firstChild.innerHTML);

    fetch(`${baseUrl}comunidade/wsCreatePost.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a publicação.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = `comunidade.php?id=${data.idComunidade}`;
        //window.location.reload(false);
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}