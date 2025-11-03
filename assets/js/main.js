document.getElementById('criarLista')?.addEventListener('click', () => {
    window.location = 'criarLista.php';
});

let linhaDoTempo = document.getElementById('linha-do-tempo');
let listas = document.getElementById('minhas-listas');
let comunidades = document.getElementById('minhas-comunidades');
let seguidores = document.getElementById('seguidores');
let seguindo = document.getElementById('seguindo');

document.getElementById('avaliacoes-perfil').addEventListener('click', () => {

  if(linhaDoTempo.classList.contains('hidden')){
    linhaDoTempo.classList.remove('hidden');
    
    if(!listas.classList.contains('hidden')){
      listas.classList.add('hidden');
    } else if(!comunidades.classList.contains('hidden')){
      comunidades.classList.add('hidden');
    }else if(!seguidores.classList.contains('hidden')){
      seguidores.classList.add('hidden');
    }else if(!seguindo.classList.contains('hidden')){
      seguindo.classList.add('hidden');
    }
  }
});

document.getElementById('listas-perfil').addEventListener('click', () => {

  if(listas.classList.contains('hidden')){
    listas.classList.remove('hidden');

    if(!linhaDoTempo.classList.contains('hidden')){
      linhaDoTempo.classList.add('hidden');
    } else if(!comunidades.classList.contains('hidden')){
      comunidades.classList.add('hidden');
    }else if(!seguidores.classList.contains('hidden')){
      seguidores.classList.add('hidden');
    }else if(!seguindo.classList.contains('hidden')){
      seguindo.classList.add('hidden');
    }
  }
});

document.getElementById('comunidades-perfil').addEventListener('click', () => {
  if(comunidades.classList.contains('hidden')){
    comunidades.classList.remove('hidden');

    if(!linhaDoTempo.classList.contains('hidden')){
      linhaDoTempo.classList.add('hidden');
    } else if(!listas.classList.contains('hidden')){
      listas.classList.add('hidden');
    }else if(!seguidores.classList.contains('hidden')){
      seguidores.classList.add('hidden');
    }else if(!seguindo.classList.contains('hidden')){
      seguindo.classList.add('hidden');
    }
  }
});

const seguidoresBtn = document.getElementById('seguidores-perfil');

function trocarParaSeguidores() {
  if(seguidores.classList.contains('hidden')){
    seguidores.classList.remove('hidden');
    linhaDoTempo.classList.add('hidden');
    listas.classList.add('hidden');
    comunidades.classList.add('hidden');
    seguindo.classList.add('hidden');
  }
}

seguidoresBtn.addEventListener('click', trocarParaSeguidores);
seguidoresBtn.addEventListener('touchstart', function(e) {
  e.preventDefault(); // evita 2x eventos click em alguns dispositivos
  trocarParaSeguidores();
});


const seguindoBtn = document.getElementById('seguindo-perfil');

function trocarParaSeguindo() {
  if (seguindo.classList.contains('hidden')) {
    seguindo.classList.remove('hidden');
    linhaDoTempo.classList.add('hidden');
    listas.classList.add('hidden');
    comunidades.classList.add('hidden');
    seguidores.classList.add('hidden');
  }
}

seguindoBtn.addEventListener('click', trocarParaSeguindo);
seguindoBtn.addEventListener('touchstart', function(e) {
  e.preventDefault(); // previne que o evento click duplo aconteça em alguns dispositivos móveis
  trocarParaSeguindo();
});


function goToLista(id){
  window.location = `lista.php?id=${id}`;
}

function goTo(url){
  window.location = url;
}