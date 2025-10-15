const baseUrl = window.location.origin + '/ws/';

const btnUpVote = document.getElementById('btnUpVote');

document.addEventListener("DOMContentLoaded", () => {
    postList = document.querySelector('.col-8.d-flex.flex-column.gap-3');

    postList.addEventListener('click', (event) => {
        const voteBtn = event.target.closest('[data-action]');

        if(voteBtn){
            const postDiv = voteBtn.closest('.post');
            const postId = postDiv.getAttribute('data-post-id');
            const action = voteBtn.getAttribute('data-action');

            if(action === 'upvote'){
                upVote(postId);
            } else if(action === 'downvote'){
                downVote(postId);
            } else if(action === 'reterPost'){
                reterPost(postId);
            }

            event.stopPropagation();
            return
        }

        const postDiv = event.target.closest('.post');

        if(postDiv && !event.target.closest('[data-action]')){
            const postId = postDiv.getAttribute('data-post-id');
            goToPost(postId);
        }
    });

});

document.querySelectorAll('.comentario-limitado').forEach(el => {
    if (el.scrollHeight > 300) {
    el.classList.add('fadeFim');
    }
});

function upVote(id){
    let formData = new FormData();

    formData.append('idPost', id);

    fetch(`${baseUrl}comunidade/wsUpVotePost.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível curtir a publicação.');
        }
        return response.json();
    })
    .then(data => {
        window.location.reload(false);
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function downVote(id){
    let formData = new FormData();

    formData.append('idPost', id);

    fetch(`${baseUrl}comunidade/wsDownVotePost.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível curtir a publicação.');
        }
        return response.json();
    })
    .then(data => {
        window.location.reload(false);
        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function reterPost(id){
    let formData = new FormData();

    formData.append('idPost', id);

    fetch(`${baseUrl}comunidade/wsReterPost.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível reter a publicação para análise.');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('post-list').removeChild(document.getElementById(`containerPost-${data.idPost}`));

        return console.log(data);
    }).catch(error => {
        return console.log(error);
    });
}

function goToPost(id){
    window.location.href = `post.php?idPost=${id}`;
}

function goToPublicarInComunidade(id){
    window.location.href = `publicarComunidade.php?idComunidade=${id}`;
}

const btnPublicar = document.getElementById('btnPublicar');

btnPublicar.addEventListener('click', () => {
    goToPublicarInComunidade(btnPublicar.getAttribute('idComunidade'));
});