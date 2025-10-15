const baseUrl = window.location.origin + '/ws/';


function tornarAdm(id){
    let formData = new FormData();
    formData.append('idUsuario', id);

    fetch(`${baseUrl}usuario/wsTornarAdm.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível transformar o usuário em ADM.');
        }

        return response.json();
    })
    .then(data => {
        console.log(data);

        if(data.sucess){
            document.getElementById(`role-usuario-${id}`).innerHTML = `
                <span class="badge rounded-pill tag-adm">ADM</span>
            `;
            document.getElementById(`gerenciar-usuario-${id}`).innerHTML = `<a href="#" class="" onclick="removerAdm(${id})">Remover ADM</a>`;
        }
    }).catch(error => {
        return console.log(error);
    });
}