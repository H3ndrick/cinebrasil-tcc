function passarPosse(idComunidade, idUsuario){
    let formData = new FormData();
    formData.append('idComunidade', idComunidade);
    formData.append('idUsuario', idUsuario);

    fetch(`${baseUrl}comunidade/wsPassarPosseComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível paasar a posse da comunidade.');
        }

        return response.json();
    })
    .then(data => {

        if(data.sucess){
            return data.sucess;
        }
    }).catch(error => {
        return;
    });
}