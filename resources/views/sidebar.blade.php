@extends('layout')
@section('content')

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="index.php?content=0" class="list-group-item list-group-item-action py-2 ripple">
                <img src="home_icon.png" class="me-3" alt="Home">Accueil
            </a>
            <a href="index.php?content=1" class="list-group-item list-group-item-action py-2 ripple">
                <img src="image/user.png" class="me-3" alt="User">User
            </a>
            <a href="index.php?content=2" class="list-group-item list-group-item-action py-2 ripple">
                <img src="settings_icon.png" class="me-3" alt="Settings">Contenu 2
            </a>
            <a href="index.php?content=3" class="list-group-item list-group-item-action py-2 ripple">
                <img src="chart_icon.png" class="me-3" alt="Chart">Contenu 3
            </a>
            <a href="index.php?content=4" class="list-group-item list-group-item-action py-2 ripple">
                <img src="chart_icon.png" class="me-3" alt="Chart">Contenu 4
            </a>
        </div>
    </div>
</nav>

@stop