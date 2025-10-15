const baseUrl = window.location.origin + '/ws/';

function cadastrarFilme(idFilme, titulo, dataLancamento, sinopse, capa, banner){
    let formData = new FormData();
    formData.append('id', idFilme);
    formData.append('titulo', titulo);
    formData.append('dataLancamento', dataLancamento);
    formData.append('sinopse', sinopse);
    formData.append('capa', capa);
    formData.append('banner', banner);


    fetch(`${baseUrl}filme/wsCreateFilme.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível cadastrar o filme.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = `filme.php?id=${data.idFilme}`;
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}