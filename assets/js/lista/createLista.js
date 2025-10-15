const baseUrl = window.location.origin + '/ws/';

filmesSelecionados = [];

function adicionarFilme(id){
    
    let filmeSelecionado = document.getElementById(`capaFilme-${id}`);

    if(!filmeSelecionado.classList.contains('filme-selecionado')){
        filmesSelecionados.push(id);
        filmeSelecionado.classList.add('filme-selecionado');
    } else{
        let index = filmesSelecionados.indexOf(id);
        if(index > -1) {
            filmesSelecionados.splice(index, 1);
        }

        filmeSelecionado.classList.remove('filme-selecionado');
    }

    console.log(filmesSelecionados);
}

document.getElementById('btnCriarLista').addEventListener('click', (e) => {
    e.preventDefault();
    
    createLista();
});

function createLista(){
    let form = document.getElementById('formCriarLista');
    let formData = new FormData(form);
    filmesSelecionados.forEach(idFilme => {
        formData.append('filmesAdicionados[]', idFilme);
    });

    console.log(formData);

    fetch(`${baseUrl}lista/wsCreateLista.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a lista.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = `perfil.php?categoria=listas`;
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}