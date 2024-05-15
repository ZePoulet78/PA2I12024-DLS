<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  </head>
<body>
   <!--Main Navigation-->
<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <!-- Collapse 1 -->
          <a class="list-group-item list-group-item-action py-2 ripple" aria-current="true"
            data-mdb-toggle="collapse" href="#collapseExample1" aria-expanded="true"
            aria-controls="collapseExample1">
            <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Expanded menu</span>
          </a>
          <!-- Collapsed content -->
          <ul id="collapseExample1" class="collapse show list-group list-group-flush">
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
          </ul>
          <!-- Collapse 1 -->
  
          <!-- Collapse 2 -->
          <a class="list-group-item list-group-item-action py-2 ripple" aria-current="true"
            data-mdb-toggle="collapse" href="#collapseExample2" aria-expanded="true"
            aria-controls="collapseExample2">
            <i class="fas fa-chart-area fa-fw me-3"></i><span>Collapsed menu</span>
          </a>
          <!-- Collapsed content -->
          <ul id="collapseExample2" class="collapse list-group list-group-flush">
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
            <li class="list-group-item py-1">
              <a href="" class="text-reset">Link</a>
            </li>
          </ul>
          <!-- Collapse 2 -->
        </div>
      </div>
    </nav>
    <!-- Sidebar -->
  
   
  </header>
  <!--Main Navigation-->
  
  <!--Main layout-->
  <main style="margin-top: 58px;">
    <div class="container mt-5">
        <h2>Gestion des Utilisateurs</h2>
        <table class="table border rounded table-rounded">
    
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody id="tableBody">
              <script>
                
                axios.get('api/users')
                  .then(response => {
                    response.data.user.forEach(user => {
                      document.getElementById('tableBody').innerHTML +=
                        '<tr>' +
                          '<th scope="row">' + user.id + '</th>' +
                          '<td>' + user.firstname + '</td>' +
                          '<td>' + user.lastname + '</td>' +
                          '<td>' + user.email + '</td>' +
                          '<td>' + user.tel + '</td>' +
                          '<td><button class="btn btn-sucess btn-sm">Afficher</button><button class="btn btn-primary btn-sm">Modifier</button><button class="btn btn-danger btn-sm">Supprimer</button></td>' +
                        '</tr>';
                        

                    });
                  })
                  .catch(error => {
                    console.error('Une erreur s\'est produite lors de la récupération des utilisateurs:', error);
                    console.log(response.data);
                  });
              </script>
            </tbody>
        </table>
    </div>
  </main>
  <!--Main layout-->
  </body>
</html>