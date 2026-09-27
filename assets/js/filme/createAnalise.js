const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnEnviarAnalise').addEventListener('click', (e) => {
    e.preventDefault();
    
    criarAnalise();
});

function criarAnalise(){
    let form = document.getElementById('formAvaliarFilme');
    let formData = new FormData(form);

    /* let editor = document.getElementById('editor');
    formData.append('conteudo', editor.firstChild.innerHTML); */

    fetch(`${baseUrl}filme/wsCreateAnalise.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a análise.');
        }
        return response.json();
    })
    .then(data => {
        //window.location.href = `comunidade.php?id=${data.idComunidade}`;
        //window.location.reload(false);
        const modalElement = document.getElementById('modalAvaliarFilme');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
        }

        document.getElementById('containerAvaliacaoUsuario').innerHTML = `
            <div class="bg-gradient-dark px-3" id="containerMinhaAnalise">
                <h3>Minha análise:</h3>
                <div class="analise d-flex gap-3 align-items-center justify-content-center pt-2">
                    <div class="divFotoPerfil">
                        <img src="${data.usuario.foto}" alt="foto de perfil de disk água SJ" class="foto-perfil">
                    </div>
                    <div class="comentario">
                        <div class="infosUsuario">
                            <span class="nomeUsuario"><a href="perfil.php" class="link-secondary">${data.usuario.username}</a></span>
                            <p class="AvaliacaoUsuario">${gerarEstrelas(data.nota)}</p>
                        </div>

                        <div class="infosAnalise">
                            <p class="texto-minha-analise">${data.conteudo}</p>
                        </div>
                    </div>
                </div>
                <div class="py-2 d-flex align-items-center justify-content-start gap-3">
                    <button class="btn btn-2 btn-excluir btn-primary" onclick="mostrarConfirmarExluir()">Excluir</button>
                    <button class="btn btn-editar btn-primary" onclick="mostrarEditar(${data.idFilme})">Editar</button>
                </div>
            </div>

            <div id="confirmacaoExcluirAnalise" class="bg-dark p-3 rounded-3">
                <h3 class="text-center">Tem certeza que deseja excluir essa análise?</h3>
                <div class="d-flex gap-3 pt-3">
                    <button class="btn btn-2 btn-primary w-50" id="btnConfirmarExcluirAnalise" onclick="deleteAnalise();">Excluir</button>
                    <button class="btn btn-primary w-50" onclick="esconderConfirmarExluir();">Cancelar</button>
                    <form action="" method="post" id="formExcluirAnalise">
                        <input type="hidden" name="idFilme" value="${data.idFilme}">
                        <input type="hidden" name="idUsuario" value="${data.usuario.id}">
                    </form>
                </div>
            </div>
        `;
        
        getAnalisesFilme();

        return;
    }).catch(error => {
        return;
    });
}


function gerarEstrelas(nota){
    let estrelas = '';

    for (let i = 1; i <= 5; i++) {
        if(nota >= i){
            estrelas += `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill estrela" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>`;
        } else if(nota == i - 0.5){
            estrelas += `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half meia-estrela" viewBox="0 0 16 16">
                                <path d="M5.354 5.119 7.538.792A.52.52 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.54.54 0 0 1 16 6.32a.55.55 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.5.5 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.6.6 0 0 1 .085-.302.51.51 0 0 1 .37-.245zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.56.56 0 0 1 .162-.505l2.907-2.77-4.052-.576a.53.53 0 0 1-.393-.288L8.001 2.223 8 2.226z"/>
                            </svg>`;
        } else{
            estrelas += `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#5f66f8" class="bi bi-star estrela-vazia" viewBox="0 0 16 16">
                            <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                        </svg>`;
        }
    }

    return estrelas;
}

function mostrarConfirmarExluir(){
    document.getElementById('confirmacaoExcluirAnalise').style.scale = 1;
}

function esconderConfirmarExluir(){
    document.getElementById('confirmacaoExcluirAnalise').style.scale = 0;
}