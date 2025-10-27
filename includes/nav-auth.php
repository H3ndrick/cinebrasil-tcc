<header class="header d-flex align-items-start justify-content-between">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="assets/css/style.css">

  <div class="w-100 conteudo">
    <div class="container d-flex align-items-center justify-content-between">
      <nav class="navbar navbar-expand-lg d-flex align-items-center justify-content-center w-100" role="navigation">
        <div class="logo h-25">
          <a href="index.php">
            <img src="assets/img/logo.png" alt="Logo" class="img-fluid" style="width: 50px;">
          </a>
        </div>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
          aria-controls="navbarResponsive" aria-expanded="false" aria-label="Alternar navegação">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="filmes.php">Filmes</a></li>
            <li class="nav-item"><a class="nav-link" href="comunidades.php">Comunidades</a></li>
            <li class="nav-item"><a class="nav-link" href="listas.php">Listas</a></li>
            

            
          </ul>
          <form class="d-flex ms-auto" action="filmes.php" method="GET" id="searchForm">
            <input class="form-control me-2" type="search" name="query" placeholder="Buscar filmes brasileiros" aria-label="Buscar filmes" required class="barraPesquisa p-1">
            <button class="btn btn-primary w-50" type="submit" id="pesquisar">
              
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
</svg>

          </button>
          </form>
          
          <li class="nav-item" style="margin-left:15px;" id="icone-perfil"><a class="nav-link" href="perfil.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
  <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
</svg>
          </a></li>

          <li class="nav-item" style="margin-left:15px;" id="icone-logout">
              <a class="nav-link" href="proc/procLogout.php">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right white" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                  <path stroke="white">
                </svg>

              </a>
            </li>
        </div>
      </nav>
      
      


    </div>
  </div>
</header>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const currentPath = window.location.pathname.split("/").pop(); // obtém o nome do arquivo da URL atual, ex: 'index.php'
    const navLinks = document.querySelectorAll('#navbarResponsive .nav-link');

    navLinks.forEach(link => {
      // obtém o href do link, só o arquivo (sem domínio)
      const linkPath = link.getAttribute('href').split("/").pop();
      // compara com a página atual
      if (linkPath === currentPath) {
        link.classList.add('active');
        link.setAttribute('aria-current', 'page');
      } else {
        link.classList.remove('active');
        link.removeAttribute('aria-current');
      }
    });
  });
</script>