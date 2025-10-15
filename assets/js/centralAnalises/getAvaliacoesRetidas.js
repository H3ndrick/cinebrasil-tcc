const baseUrl = window.location.origin + '/ws/';

document.addEventListener('DOMContentLoaded', () => {
    getAvaliacoesRetidas();
});

function getAvaliacoesRetidas(){
    fetch(`${baseUrl}filme/wsGetAvaliacoesRetidas.php`)
    .then(response => {
        if(!response.ok){
            throw new Error(response.mensagem);
        }

        return response.json();
    })
    .then(data => {
        document.getElementById('containerAvaliacoesRetidas').innerHTML = '';

        if(!data.success){
            document.getElementById('containerAvaliacoesRetidas').innerHTML = '<h3>Não há nenhuma avaliação retida.</h3>';
            return console.log(data);
        }

        exibirAvaliacoesRetidas(data.avaliacoes, data.usuarios);

        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function exibirAvaliacoesRetidas(avaliacoes, usuarios){
    for (let i = 0; i < avaliacoes.length; i++) {
        const avaliacao = avaliacoes[i];
        const usuario = usuarios[i];

        document.getElementById('containerAvaliacoesRetidas').innerHTML += `
            <div class="d-flex flex-column gap-3 p-3 bg-gradient-dark mt-4 card-acao" style="max-width:100%;">
                <p class="text-white-50 w-100">Avaliação:</p>
                <div class="d-flex flex-column gap-3 flex-wrap w-100">
                    <div class="d-flex gap-3">
                        <img src="${usuario.foto}" alt="foto de perfil de ${usuario.username}" class="" style="height: 60px; min-width:60px;">
                        <div class="d-flex flex-column">
                            <span class="text-white-50 w-100"><a href="perfil.php?id=''" style="width: max-content" class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover mb-1">@${usuario.username}</a></span>
                            <p class="AvaliacaoUsuario">
                                ${gerarEstrelas(avaliacao.nota)}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p>${avaliacao.comentario}</p>
                    </div>

                    <div class="botoes-acao-central-acoes d-flex gap-3">
                        <form method="post" id="formPermitirAvaliacaoRetida-${avaliacao.id_filme}-${avaliacao.id_usuario}">
                            <input type="hidden" name="idFilme" value="${avaliacao.id_filme}">
                            <input type="hidden" name="idUsuario" value="${avaliacao.id_usuario}">
                            <button type="button" class="btn bg-dark rounded-0 border-0 text-white-50" onclick="permitirAvaliacao(${avaliacao.id_filme}, ${avaliacao.id_usuario})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"></path>
                                </svg>
                                <span class="ms-2">Permitir avaliação</span>
                            </button>
                        </form>

                        <form method="post" id="formExcluirAvaliacaoRetida-${avaliacao.id_filme}-${avaliacao.id_usuario}">
                            <input type="hidden" name="idFilme" value="${avaliacao.id_filme}">
                            <input type="hidden" name="idUsuario" value="${avaliacao.id_usuario}">
                            <button type="button" class="btn bg-dark rounded-0 border-0 text-white-50" onclick="excluirAvaliacao(${avaliacao.id_filme}, ${avaliacao.id_usuario})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                                </svg>
                                <span class="ms-2">Excluir avaliação</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
    }
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