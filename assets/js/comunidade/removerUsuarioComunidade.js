function removerUsuarioComunidade(idComunidade, idUsuario){
    let formData = new FormData();
    formData.append('idComunidade', idComunidade);
    formData.append('idUsuario', idUsuario);

    fetch(`${baseUrl}comunidade/wsRemoverUsuarioComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível remover o usuário da comunidade.');
        }

        return response.json();
    })
    .then(data => {
        console.log(data);

        if(data.sucess){
            document.getElementById('tbody-usuarios-comunidade').removeChild(document.getElementById(`tr-usuario-${idUsuario}`));
        }
    }).catch(error => {
        return console.log(error);
    });
}