<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "includes/functions.php";
include "includes/head.php";
include "includes/header.php";

?>

<main class="d-flex align-items-center justify-content-center">
    <div class="container-fluid pt-4 mt-4 container-grid-posters">
        <div id="filmes-lista" class="d-flex align-items-center justify-content-center gap-3 flex-wrap">
            
        </div>
        
        <div class="pagination-controls mt-4 d-flex align-items-center justify-content-center gap-3 <?= isset($_GET["query"]) ? 'hidden' : '' ?>">
            <button id="prevPage" class="btn btn-secondary btn-paginacao-filmes" disabled>Anterior</button>
            <span id="paginaAtual">1</span>
            <button id="nextPage" class="btn btn-secondary btn-paginacao-filmes">Próximo</button>
        </div>
    </div>
</main>

<?php
    include ('includes/footer.php'); 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/filme/createFilme.js"></script>
<script>
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    let paginaAtual = 1;

    async function carregarFilmes(pagina, query = '') {
        let url;
        if (query) {
            url = `filmes_search.php?query=${encodeURIComponent(query)}&page=${pagina}`;
        } else {
            url = `filmes_pagination.php?page=${pagina}`;
        }

        const resposta = await fetch(url);
        const dados = await resposta.json();

        const container = document.getElementById('filmes-lista');
        container.innerHTML = '';
        console.log(dados);
        if(dados.total_results > 0){
            dados.results.forEach(filme => {
                const div = document.createElement('div');
                div.classList.add('poster-container');
                div.innerHTML = `
                    <img src="https://image.tmdb.org/t/p/w200${filme.poster_path}" alt="${filme.title}" id="capaFilme-${filme.id}" />
                    <div class="overlay" data-id="${filme.id}">
                        <h3 id="tituloFilme-${filme.id}" data-id="${filme.id}">${filme.title}</h3>
                    </div>
                    <p class="hidden" id="sinopseFilme-${filme.id}">${filme.overview}</p>
                    <p class="hidden" id="dataLancamentoFilme-${filme.id}">${filme.release_date}</p>
                    <img class="hidden" src="https://image.tmdb.org/t/p/w200${filme.backdrop_path}" alt="${filme.title}" id="bannerFilme-${filme.id}" />
                `;
                container.appendChild(div);
            });

            document.getElementById('paginaAtual').textContent = `${dados.page} / ${dados.total_pages}`;
            document.getElementById('prevPage').disabled = dados.page === 1;
            document.getElementById('nextPage').disabled = dados.page === dados.total_pages;
            paginaAtual = dados.page;
        } else{
            container.innerHTML = `<h3>Nenhum filme com nome ${query} encontrado.</h3>`;
        }

        document.querySelectorAll('.poster-container .overlay').forEach(img => {
            img.addEventListener('click', (e) => {
                const idFilme = e.target.getAttribute('data-id');
                const titulo = document.getElementById(`tituloFilme-${idFilme}`).textContent;
                const sinopse = document.getElementById(`sinopseFilme-${idFilme}`).textContent;
                const dataLancamento = document.getElementById(`dataLancamentoFilme-${idFilme}`).textContent;
                const capa = document.getElementById(`capaFilme-${idFilme}`).src;
                const banner = document.getElementById(`bannerFilme-${idFilme}`).src;

                cadastrarFilme(idFilme, titulo, dataLancamento, sinopse, capa, banner);
            });
        });
    }

    document.getElementById('prevPage').addEventListener('click', () => {
        const query = getQueryParam('query') || '';
        if (paginaAtual > 1) carregarFilmes(paginaAtual - 1, query);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
        window.scrollTo({ top: 0, behavior: 'smooth' });

    });

    document.getElementById('nextPage').addEventListener('click', () => {
        const query = getQueryParam('query') || '';
        carregarFilmes(paginaAtual + 1, query);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
        window.scrollTo({ top: 0, behavior: 'smooth' });

    });

    const termoBusca = getQueryParam('query') || '';
    carregarFilmes(1, termoBusca);
</script>