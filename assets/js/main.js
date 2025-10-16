document.getElementById('criarLista').addEventListener('click', () => {
  window.location = 'criarLista.php'
});

document.getElementById('avaliacoes-perfil').addEventListener('click', () => {
  let linhaDoTempo = document.getElementById('linha-do-tempo');
  let listas = document.getElementById('minhas-listas');
  let comunidades = document.getElementById('minhas-comunidades');

  if(linhaDoTempo.classList.contains('hidden')){
    linhaDoTempo.classList.remove('hidden');
    
    if(!listas.classList.contains('hidden')){
      listas.classList.add('hidden');
    } else if(!comunidades.classList.contains('hidden')){
      comunidades.classList.add('hidden');
    }
  }
});

document.getElementById('listas-perfil').addEventListener('click', () => {
  let linhaDoTempo = document.getElementById('linha-do-tempo');
  let listas = document.getElementById('minhas-listas');
  let comunidades = document.getElementById('minhas-comunidades');

  if(listas.classList.contains('hidden')){
    listas.classList.remove('hidden');

    if(!linhaDoTempo.classList.contains('hidden')){
      linhaDoTempo.classList.add('hidden');
    } else if(!comunidades.classList.contains('hidden')){
      comunidades.classList.add('hidden');
    }
  }
});

document.getElementById('comunidades-perfil').addEventListener('click', () => {
  let linhaDoTempo = document.getElementById('linha-do-tempo');
  let listas = document.getElementById('minhas-listas');
  let comunidades = document.getElementById('minhas-comunidades');

  if(comunidades.classList.contains('hidden')){
    comunidades.classList.remove('hidden');

    if(!linhaDoTempo.classList.contains('hidden')){
      linhaDoTempo.classList.add('hidden');
    } else if(!listas.classList.contains('hidden')){
      listas.classList.add('hidden');
    }
  }
});

function goToLista(id){
  window.location = `lista.php?id=${id}`;
}