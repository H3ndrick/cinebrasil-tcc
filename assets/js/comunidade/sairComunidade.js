if(document.getElementById('btnSair')){
    document.getElementById('btnSair').addEventListener('click', (e) => {
        e.preventDefault();
        
        sairDaComunidade();
    });
}

function sairDaComunidade(){
    let formData = new FormData();
    formData.append('idComunidade', document.getElementById('inputIdComunidade').value);

    fetch(`${baseUrl}comunidade/wsSairComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível siar da comunidade.');
        }
        return response.json();
    })
    .then(data => {
        window.location.reload(false);
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}