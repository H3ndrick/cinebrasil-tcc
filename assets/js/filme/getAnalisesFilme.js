document.addEventListener("DOMContentLoaded", (e) => {
    getAnalisesFilme();
});

function getAnalisesFilme(){
    let formData = new FormData();
    formData.append('idFilme', document.getElementById('inputIdFilme').value)

    fetch(`${baseUrl}filme/wsGetAnalisesFilme.php`, {
        'method' : 'POST',
        'body' : formData
    }).then(response => {
        if(!response.ok){
            throw new Error('Não foi possível listar as análises do filme.');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById('container-avaliacoes-filme').innerHTML = '';
        qntAvaliacoes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        if(data.analises.length == 0){
            document.getElementById('container-avaliacoes-filme').innerHTML = '<h3>Nenhuma análise sobre esse filme foi feita ainda.</h3>';
            document.getElementById('mediaAvaliacoes').innerText = 0.0;
            montarGrafico(qntAvaliacoes);
        }else{
            document.getElementById('qntAnalises').innerText = data.analises.length > 1 ? `${data.analises.length} análises` : `${data.analises.length} análise`;
            
            posicaoAvaliacao = {
                "0.5" : 0,
                "1.0" : 1,
                "1.5" : 2,
                "2.0" : 3,
                "2.5" : 4,
                "3.0" : 5,
                "3.5" : 6,
                "4.0" : 7,
                "4.5" : 8,
                "5.0" : 9
            }

            mediaAvaliacoes = 0;

            for (let i = 0; i < data.analises.length; i++) {
                const analise = data.analises[i];
                const usuario = data.usuarios[i];
                
                mediaAvaliacoes += parseFloat(analise.nota);
                qntAvaliacoes[posicaoAvaliacao[analise.nota]] += 1;

                if(document.getElementById('isAdmInput').value){
                    let idUsuarioLogado = document.getElementById('idUsuarioLogado').value
                    
                    if(idUsuarioLogado != usuario.id){
                        document.getElementById('container-avaliacoes-filme').innerHTML += `
                            <div class="analise d-flex gap-3" id="avaliacao-${analise.id_filme}-${usuario.id}">
                                <div class="divFotoPerfil">
                                    <img src="${usuario.foto}" alt="foto de perfil de ${usuario.username}" class="foto-perfil">
                                </div>
                                <div class="comentario">
                                    <div class="infosUsuario">
                                        <span class="nomeUsuario"><a href="perfil.php?id=${usuario.id}" class="link-secondary">${usuario.username}</a></span>
                                        <p class="AvaliacaoUsuario">
                                            ${gerarEstrelas(analise.nota)}
                                        </p>
                                    </div>

                                    <div class="infosAnalise">
                                        <p>${analise.comentario}</p>
                                    </div>

                                    <button class="btn-adm bg-gradient-dark p-2 mb-2" onclick="reterAvaliacao(${analise.id_filme}, ${usuario.id});")>
                                        Reter Avaliação
                                    </button>
                                </div>
                            </div>
                        `;
                    } else{

                        document.getElementById('container-avaliacoes-filme').innerHTML += `
                            <div class="analise d-flex gap-3" id="avaliacao-${analise.id_filme}-${usuario.id}">
                                <div class="divFotoPerfil">
                                    <img src="${usuario.foto}" alt="foto de perfil de ${usuario.username}" class="foto-perfil">
                                </div>
                                <div class="comentario">
                                    <div class="infosUsuario">
                                        <span class="nomeUsuario"><a href="perfil.php?id=${usuario.id}" class="link-secondary">${usuario.username}</a></span>
                                        <p class="AvaliacaoUsuario" id="minha-avaliacao-2">
                                            ${gerarEstrelas(analise.nota)}
                                        </p>
                                    </div>

                                    <div class="infosAnalise">
                                        <p id="texto-minha-analise-dois">${analise.comentario}</p>
                                    </div>

                                    <button class="btn-adm bg-gradient-dark p-2 mb-2" onclick="reterAvaliacao(${analise.id_filme}, ${usuario.id});")>
                                        Reter Avaliação
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                } else{
                    let idUsuarioLogado = document.getElementById('idUsuarioLogado').value
                    if(idUsuarioLogado != usuario.id){
                        document.getElementById('container-avaliacoes-filme').innerHTML += `
                            <div class="analise d-flex gap-3" id="avaliacao-${analise.id_filme}-${usuario.id}">
                                <div class="divFotoPerfil">
                                    <img src="${usuario.foto}" alt="foto de perfil de ${usuario.username}" class="foto-perfil">
                                </div>
                                <div class="comentario">
                                    <div class="infosUsuario">
                                        <span class="nomeUsuario"><a href="perfil.php?id=${usuario.id}" class="link-secondary">${usuario.username}</a></span>
                                        <p class="AvaliacaoUsuario">
                                            ${gerarEstrelas(analise.nota)}
                                        </p>
                                    </div>

                                    <div class="infosAnalise">
                                        <p>${analise.comentario}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }else{
                        document.getElementById('container-avaliacoes-filme').innerHTML += `
                            <div class="analise d-flex gap-3" id="avaliacao-${analise.id_filme}-${usuario.id}">
                                <div class="divFotoPerfil">
                                    <img src="${usuario.foto}" alt="foto de perfil de ${usuario.username}" class="foto-perfil">
                                </div>
                                <div class="comentario">
                                    <div class="infosUsuario">
                                        <span class="nomeUsuario"><a href="perfil.php?id=${usuario.id}" class="link-secondary">${usuario.username}</a></span>
                                        <p class="AvaliacaoUsuario" id="minha-avaliacao-2">
                                            ${gerarEstrelas(analise.nota)}
                                        </p>
                                    </div>

                                    <div class="infosAnalise">
                                        <p id="texto-minha-analise-dois">${analise.comentario}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                    
                }
            }
            
            mediaAvaliacoes = mediaAvaliacoes / data.analises.length;
            mediaAvaliacoes = mediaAvaliacoes.toFixed(2);
            document.getElementById('mediaAvaliacoes').innerText = mediaAvaliacoes;

            montarGrafico(qntAvaliacoes);
        }

        return;
    }).catch(error => {
        return;
    });
}

function montarGrafico(qntAvaliacoes){
    const ctx = document.getElementById('graficoMediaAvaliacoes');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['0.5★', '', '', '', '', '', '', '', '', '5★'],
            datasets: [{
            label: '★',
            data: qntAvaliacoes,
            backgroundColor: [
                '#5d58ed'
            ],
            hoverOffset: 1,
            borderRadius: 4,
            borderSkipped: false
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                },
            },
            scales: {
                y: {
                    display: false
                },
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid:{
                        display: false    
                    }
                }
            }
        }
    });
}