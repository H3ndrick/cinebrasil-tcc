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
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}