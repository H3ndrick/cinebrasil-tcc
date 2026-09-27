function deleteComunidade(idComunidade){
    let formData = new FormData();
    formData.append('idComunidade', idComunidade); 

    fetch(`${baseUrl}comunidade/wsDeleteComunidade.php`, {
        'method' : 'POST', 
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível excluir a comunidade.')
        }
        return response.json(); 
    })
    .then(data => {
        window.location.href = `comunidades.php`;    
        return;
    }).catch(error => {
        return;
    });
}