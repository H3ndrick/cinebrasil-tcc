if(document.getElementById('btnEntrarComunidade')){
    document.getElementById('btnEntrarComunidade').addEventListener('click', (e) => {
        e.preventDefault();
        
        entrarNaComunidade();
    });
}

function entrarNaComunidade(){
    let formData = new FormData();
    formData.append('idComunidade', document.getElementById('inputIdComunidade').value);

    fetch(`${baseUrl}comunidade/wsEntrarComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível entrar na comunidade.');
        }
        return response.json();
    })
    .then(data => {
        window.location.reload(false);
        return;
    }).catch(error => {
        return;
    });
}