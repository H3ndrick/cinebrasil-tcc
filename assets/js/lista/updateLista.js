const baseUrl = window.location.origin + '/ws/';
const btnEditar = document.getElementById('btnEditarLista');

btnEditar.addEventListener('click', () => {
    atualizar();
});

function atualizar(){
    let form = document.getElementById('formEditarLista');
    let formData = new FormData(form);

    fetch(`${baseUrl}lista/wsUpdateLista.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível editar a lista.');
        }

        return response.json();
    })
    .then(data => {

        if(data.sucess){
            window.location.href = `lista.php?id=${data.id}`;
        } else{
            document.getElementById('erroCadastro').innerText = data.mensagem;
        }
    }).catch(error => {
        return;
    });
}