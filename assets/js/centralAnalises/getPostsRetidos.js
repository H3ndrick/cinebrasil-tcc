const baseUrl = window.location.origin + '/ws/';

document.addEventListener('DOMContentLoaded', () => {
    getPublicacoesRetidas();
});

function getPublicacoesRetidas(){
    fetch(`${baseUrl}comunidade/wsGetPublicacoesRetidas.php`)
    .then(response => {
        if(!response.ok){
            throw new Error(response.mensagem);
        }

        return response.json();
    })
    .then(data => {
        document.getElementById('containerPostsRetidos').innerHTML = '';

        if(!data.success){
            document.getElementById('containerPostsRetidos').innerHTML = '<h3>Não há nenhum post retido.</h3>';
            return console.log(data);
        }

        exibirPostsRetidos(data.posts, data.usuarios);

        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function exibirPostsRetidos(posts, usuarios){
    for (let i = 0; i < posts.length; i++) {
        const post = posts[i];
        const usuario = usuarios[i];

        document.getElementById('containerPostsRetidos').innerHTML += `
            <div class="d-flex flex-column gap-3 p-3 bg-gradient-dark mt-4 card-acao" style="max-width:100%;">
                <p class="text-white-50 w-100">Publicação:</p>
                <div class="d-flex flex-column gap-3 flex-wrap w-100">
                    <div class="d-flex gap-3">
                        <img src="${usuario.foto}" alt="foto de perfil de ${usuario.username}" class="" style="width: 8%; min-width:60px;">
                        <p class="text-white-50 w-100"><a href="perfil.php?id=''" style="width: max-content" class="link-secondary link-offset-2 link-underline-opacity-0 link-underline-opacity-100-hover mb-1">@${usuario.username}</a></p>
                    </div>

                    <div>
                        <p>${post.comentario}</p>
                    </div>

                    <div class="botoes-acao-central-acoes d-flex gap-3">
                        <form method="post" id="formPermitirPostRetido-${post.id}">
                            <input type="hidden" name="idPost" value="${post.id}">
                            <button type="button" class="btn bg-dark rounded-0 border-0 text-white-50" onclick="permitirPost(${post.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"></path>
                                </svg>
                                <span class="ms-2">Permitir publicação</span>
                            </button>
                        </form>

                        <form method="post">
                            <input type="hidden" name="idPost" value="${post.id}">
                            <button class="btn bg-dark rounded-0 border-0 text-white-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"></path>
                                </svg>
                                <span class="ms-2">Excluir publicação</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        `;
        
    }
}
