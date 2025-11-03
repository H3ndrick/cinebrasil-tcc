const btnDeletar = document.getElementById('btnDeletarLista');

btnDeletar.addEventListener('click', () =>{
    deleteLista();
});

function deleteLista(){
    let form = document.getElementById('formExluirLista');
    let formData = new FormData(form);

    fetch(`${baseUrl}lista/wsDeleteLista.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível excluir a lista.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = 'listas.php';
        return;
    }).catch(error => {
        return;
    });
}