const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnSalvarLista').addEventListener('click', () => {
    let id = document.getElementById('idLista').value
    salvarLista(id);
});

document.getElementById('btnRemoverListaSalva').addEventListener('click', () => {
    let id = document.getElementById('idLista').value;
    removerListaSalva(id);
});

function salvarLista(id){
    let formData = new FormData();
    formData.append('idLista', id);

    fetch(`${baseUrl}lista/wsSalvarLista.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível salvar a lista.');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('btnSalvarLista').classList.add('hidden');
        document.getElementById('btnRemoverListaSalva').classList.remove('hidden');
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function removerListaSalva(id){
    let formData = new FormData();
    formData.append('idLista', id);

    fetch(`${baseUrl}lista/wsRemoverListaSalva.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível remover a lista salva.');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('btnSalvarLista').classList.remove('hidden');
        document.getElementById('btnRemoverListaSalva').classList.add('hidden');
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}