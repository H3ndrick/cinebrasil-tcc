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

document.getElementById('seguidores-perfil').addEventListener('click', () => {
  if(seguidores.classList.contains('hidden')){
    seguidores.classList.remove('hidden');

    if(!linhaDoTempo.classList.contains('hidden')){
      linhaDoTempo.classList.add('hidden');
    } else if(!listas.classList.contains('hidden')){
      listas.classList.add('hidden');
    }else if(!comunidades.classList.contains('hidden')){
      comunidades.classList.add('hidden');
    }else if(!seguindo.classList.contains('hidden')){
      seguindo.classList.add('hidden');
    }
  }
});

document.getElementById('seguindo-perfil').addEventListener('click', () => {
  if(seguindo.classList.contains('hidden')){
    seguindo.classList.remove('hidden');

    if(!linhaDoTempo.classList.contains('hidden')){
      linhaDoTempo.classList.add('hidden');
    } else if(!listas.classList.contains('hidden')){
      listas.classList.add('hidden');
    }else if(!seguidores.classList.contains('hidden')){
      seguidores.classList.add('hidden');
    }else if(!comunidades.classList.contains('hidden')){
      comunidades.classList.add('hidden');
    }
  }
});

function goToLista(id){
  window.location = `lista.php?id=${id}`;
}