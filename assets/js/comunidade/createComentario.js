const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnCriarPublicacao').addEventListener('click', (e) => {
    e.preventDefault();
    
    criarComentario();
});

function criarComentario(){
    let form = document.getElementById('formComentario');
    let formData = new FormData(form);

    fetch(`${baseUrl}comunidade/wsCreateComentario.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a publicação.');
        }
        return response.json();
    })
    .then(data => {
        //window.location.reload();
        if(data.sucess == false){
            document.getElementById('comentarioError').textContent = data.mensagem;
        } else{
            window.location.reload();
        }
        return;
    }).catch(error => {
        return;
    });
}