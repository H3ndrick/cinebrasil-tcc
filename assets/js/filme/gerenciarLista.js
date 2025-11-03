const modal = document.getElementById('modalAdicionarLista');
const listasContainer = document.getElementById('listasUsuarioContainer');
const btnSalvar = document.getElementById('btnSalvarListas');
const btnCriarLista = document.getElementById('btnCriarLista');
const novaListaTitulo = document.getElementById('novaListaTitulo');
const idFilme = document.getElementById('inputIdFilme').value;
const divErroTituloLista = document.getElementById('tituloNovaListaError');

document.addEventListener("DOMContentLoaded", (e) => {
    modal.addEventListener('show.bs.modal', getListas);
    btnCriarLista.addEventListener('click', createLista);
    btnSalvar.addEventListener('click', salvarAlteracoes);
});

function getListas(){
    //listasContainer.innerHTML = 'Carregando listas...';

    fetch(`${baseUrl}lista/wsGetLista.php`, {
        'method' : 'GET'
    }).then(response => {
        if(!response.ok){
            throw new Error('Erro ao carregar listas.');
        }
        return response.json();
    })
    .then(data => {
        if(data.listas.length == 0){
            listasContainer.innerHTML = '<p>Você ainda não tem listas criadas.</p>';
            return console.log(data);
        }
        const html = data.listas.map(lista => {
            const checked = lista.filmes.some(filme => filme.id_filme == parseInt(idFilme)) ? 'checked' : '';
            return `<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="${lista.id}" id="lista${lista.id}" ${checked}>
                        <label class="form-check-label" for="lista${lista.id}">${lista.titulo}</label>
                    </div>
            `;
        }).join('');

        listasContainer.innerHTML = html;

        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });

}

function createLista(){
    let titulo = novaListaTitulo.value.trim();

    if(titulo == ''){
        divErroTituloLista.innerText = "Digite um título para a nova lista";
        return;
    }

    let formData = new FormData();
    formData.append('titulo', novaListaTitulo.value);
    formData.append('descricao', '');

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
        novaListaTitulo.value = '';
        divErroTituloLista.innerText = '';
        getListas();
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function salvarAlteracoes(){
    const checkboxes = listasContainer.querySelectorAll('input[type=checkbox]');
    const listasSelecionadas = [];
    checkboxes.forEach(cb => {
      if(cb.checked) listasSelecionadas.push(parseInt(cb.value));
    });

    let formData = new FormData();
    formData.append('idFilme', parseInt(idFilme));
    formData.append('listas', listasSelecionadas);

    fetch(`${baseUrl}lista/wsUpdateListasFilme.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível atualizar a lista.');
        }
        return response.json();
    })
    .then(data => {
        bootstrap.Modal.getInstance(modal).hide();
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}