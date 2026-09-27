const baseUrl = window.location.origin + '/ws/';

document.getElementById('btnCriarPublicacao').addEventListener('click', (e) => {
    e.preventDefault();
    
    if(validaTitulo(document.getElementById('titulo').value)){
        criarPost();
    }
    
});

function validaTitulo(titulo){
    const erroTitulo = document.getElementById('tituloError');
    erroTitulo.textContent = "";

    if(titulo.trim() === ''){
        erroTitulo.textContent = "O título não pode ser vazio";
        return false;
    }

    return true;
}

function criarPost(){
    document.getElementById('erroConteudo').innerText = "";

    let form = document.getElementById('formPost');
    let formData = new FormData(form);

    let editor = document.getElementById('editor');
    formData.append('conteudo', editor.firstChild.innerHTML);

    document.getElementById('erroConteudo').innerText = "";
    if(editor.firstChild.innerHTML.trim() === '<p><br></p>'){
        document.getElementById('erroConteudo').innerText = "Digite um conteudo no post";
        return false;
    }

    fetch(`${baseUrl}comunidade/wsCreatePost.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível criar a publicação.');
        }
        return response.json();
    })
    .then(data => {
        window.location.href = `comunidade.php?id=${data.idComunidade}`;
        return;
    }).catch(error => {
        return;
    });
}