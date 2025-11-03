function removerAdm(id){
    let formData = new FormData();
    formData.append('idUsuario', id);

    fetch(`${baseUrl}usuario/wsRemoverAdm.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível remover o ADM do usuário.');
        }

        return response.json();
    })
    .then(data => {
        if(data.sucess){
            document.getElementById(`role-usuario-${id}`).innerHTML = `
                <span class="badge rounded-pill tag-usuario">usuario</span>
            `;
            document.getElementById(`gerenciar-usuario-${id}`).innerHTML = `<a href="#" class="" onclick="tornarAdm(${id})">Tornar ADM</a>`;
        }
    }).catch(error => {
        return;
    });
}