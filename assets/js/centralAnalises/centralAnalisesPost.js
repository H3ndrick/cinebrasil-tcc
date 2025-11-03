function permitirPost(id){
    let form = document.getElementById(`formPermitirPostRetido-${id}`);
    let formData = new FormData(form);

    fetch(`${baseUrl}comunidade/wsPermitirPostRetido.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível permitir o post retido para análise.');
        }
        return response.json();
    })
    .then(data => {
        getPublicacoesRetidas();
        return;
    }).catch(error => {
        return;
    });
}

function deletePost(idPost){
    let formData = new FormData();
    formData.append('idPost', idPost); 
    formData.append('idComunidade', document.getElementById('idComunidadeInput').value);  

    fetch(`${baseUrl}comunidade/wsDeletePostRetido.php`, {
        'method' : 'POST', 
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível excluir o post.')
        }
        return response.json(); 
    })
    .then(data => {
        getPublicacoesRetidas(); 
        return;
    }).catch(error => {
        return;
    });
}