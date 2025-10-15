function reterAvaliacao(idFilme, idUsuario){
    let formData = new FormData();

    formData.append('idFilme', idFilme);
    formData.append('idUsuario', idUsuario);

    fetch(`${baseUrl}filme/wsReterAvaliacao.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível reter a avaliacao para análise.');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('container-avaliacoes-filme').removeChild(document.getElementById(`avaliacao-${data.idFilme}-${data.idUsuario}`));
        

        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function permitirAvaliacao(idFilme, idUsuario){
    let form = document.getElementById(`formPermitirAvaliacaoRetida-${idFilme}-${idUsuario}`);
    let formData = new FormData(form);

    fetch(`${baseUrl}filme/wsPermitirAvaliacaoRetida.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível permitir a avalição retida para análise.');
        }
        return response.json();
    })
    .then(data => {
        getAvaliacoesRetidas();
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function excluirAvaliacao(idFilme, idUsuario){
    let form = document.getElementById(`formExcluirAvaliacaoRetida-${idFilme}-${idUsuario}`);
    let formData = new FormData(form);

    permitirAvaliacao(idFilme, idUsuario);

    fetch(`${baseUrl}filme/wsDeleteAnalise.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível excluir a análise.');
        }
        return response.json();
    })
    .then(data => {
        getAvaliacoesRetidas();
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}