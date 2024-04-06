@extends('layout')
@section('content2')

</style>
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
            response.data.users.forEach(user => {
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
