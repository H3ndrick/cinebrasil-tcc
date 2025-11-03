function deletePost(idPost){
    let formData = new FormData();
    formData.append('idPost', idPost); 
    formData.append('idComunidade', document.getElementById('idComunidadeInput').value);  

    fetch(`${baseUrl}comunidade/wsDeletePost.php`, {
        'method' : 'POST', 
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível excluir o post.')
        }
        return response.json(); 
    })
    .then(data => {
        window.location.href = `comunidade.php?id=${data.idComunidade}`;    
        return;
    }).catch(error => {
        return;
    });
}