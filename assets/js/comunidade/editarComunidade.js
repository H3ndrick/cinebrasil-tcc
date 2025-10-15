const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnEditarComunidade').addEventListener('click', (e) => {
    e.preventDefault();
    editarComunidade();
});

function editarComunidade(){
    let form = document.getElementById('formEditarComunidade');
    let formData = new FormData(form);

    fetch(`${baseUrl}comunidade/wsEditComunidade.php`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if(!response.ok){
            throw new Error('Erro ao editar comunidade.');
        }
        return response.json();
    })
    .then(data => {
        if(data.sucess){
            window.location.href = `comunidade.php?id=${data.idComunidade}`;
        } else {
            console(data.mensagem);
        }
    })
    .catch(error => {
        console.error(error);
    });
}
