<header class="header d-flex align-items-start justify-content-between">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="assets/css/style.css">

  <div class="w-100 conteudo">
    <div class="container d-flex align-items-center justify-content-between">

      <nav class="navbar navbar-expand-lg d-flex w-100" role="navigation">
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
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="margin-top:15px;">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="filmes.php">Filmes</a></li>
            <li class="nav-item"><a class="nav-link" href="comunidades.php">Comunidades</a></li>
            <li class="nav-item"><a class="nav-link" href="listas.php">Listas</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          </ul>
          <form class="d-flex ms-auto" action="filmes.php" method="GET" id="searchForm">
            <input class="form-control me-2" type="search" name="query" placeholder="Buscar filmes brasileiros" aria-label="Buscar filmes" required class="barraPesquisa p-1">
            <button class="btn btn-primary w-50" type="submit">Buscar</button>
          </form>
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