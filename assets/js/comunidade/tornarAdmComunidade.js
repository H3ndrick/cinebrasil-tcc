const baseUrl = window.location.origin + '/ws/';

function tornarAdmComunidade(idComunidade, idUsuario, isDono){
    let formData = new FormData();
    formData.append('idComunidade', idComunidade);
    formData.append('idUsuario', idUsuario);

    fetch(`${baseUrl}comunidade/wsTornarAdmComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível transformar o usuário em ADM da comunidade.');
        }

        return response.json();
    })
    .then(data => {
        console.log(data);

        if(data.sucess){
            document.getElementById(`role-usuario-${idUsuario}`).innerHTML = `
                <span class="badge rounded-pill tag-adm">ADM</span>
            `;
            document.getElementById(`gerenciar-usuario-${idUsuario}`).innerHTML = `<a href="#" class="" onclick="removerAdmComunidade(${idComunidade}, ${idUsuario}, ${isDono})">Remover ADM</a>`;
        }
    }).catch(error => {
        return console.log(error);
    });
}
