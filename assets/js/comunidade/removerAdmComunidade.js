function removerAdmComunidade(idComunidade, idUsuario, isDono){
    let formData = new FormData();
    formData.append('idComunidade', idComunidade);
    formData.append('idUsuario', idUsuario);

    fetch(`${baseUrl}comunidade/wsRemoverAdmComunidade.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível remover o ADM do usuário.');
        }

        return response.json();
    })
    .then(data => {;

        if(data.sucess){
            document.getElementById(`role-usuario-${idUsuario}`).innerHTML = `
                <span class="badge rounded-pill tag-usuario">usuario</span>
            `;

            let gerenciar = `<div class="d-flex gap-4"><a href="#" class="" onclick="tornarAdmComunidade(${idComunidade}, ${idUsuario}, ${isDono})">Tornar ADM</a> <a href="#" class="" onclick="removerUsuarioComunidade(${idComunidade}, ${idUsuario})">Remover usuario</a>`;
            
            if(isDono){
                gerenciar += `<a href="#" class="" onclick="passarPosse(${idComunidade}, ${idUsuario})">Passar posse</a></div>`;
            } else{
                gerenciar += `</div>`;
            }
            document.getElementById(`gerenciar-usuario-${idUsuario}`).innerHTML = gerenciar;
        }
    }).catch(error => {
        return;
    });
}