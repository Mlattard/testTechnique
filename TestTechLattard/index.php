<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Technique Lattard</title>
    <script src="client/public/utilitaires/jquery-3.6.3.min.js"></script>
    <script src="client/public/utilitaires/bootstrap-5.3.0-alpha1-dist/js/bootstrap.min.js"></script>
    <!-- <script src="client/public/js/global.js"></script> -->
    <script src="client/index/requetesIndex.js"></script>
    <script src="client/index/vuesIndex.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="client/public/utilitaires/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="client/public/css/styles.css">
  </head>

  <body>
    <nav id="navbarCountries"class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Test Technique Lattard</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="remplirBd();">Remplir BD</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" onclick="afficherCountries();">Afficher données</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tri par région
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#">Europe</a>
              <a class="dropdown-item" href="#">Afrique</a>
              <a class="dropdown-item" href="#">Océanie</a>
              <a class="dropdown-item" href="#">Asie</a>
              <a class="dropdown-item" href="#">Amérique</a>
            </div>
          </li>
        </ul>
      </div>
    </nav>

    <main>
      <div id="texteAccueil"></div>
      <div id="vueCountries"></div>
    </main>
    
  </body>

  <script>
    $(document).ready(function() {
      $('#tableauCountries').DataTable({
        "columnDefs": [
          { "orderable": true, "targets": [1] }
        ]
      });
    });
  </script>
</html>