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

    
    
    <div class="container-fluid">
        <div class="row">
            @yield('content')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Main Content</h1>
                </div>
                <div class="container">
                    <?php
                    if (isset($_GET['content'])) {
                        $content = $_GET['content'];
                        if ($content == '1') {
                            include 'content1.blade.php';
                        } elseif ($content == '2') {
                            include 'content2.php';
                        } elseif ($content == '3') {
                            include 'content3.php';
                        } elseif ($content == '4') {
                            include 'content4.php';
                        } elseif ($content == '0') {
                          include 'accueil.php';
                        } else {?>
                            @yield('content2')<?php // Default content to include
                        }
                    } else {
                        ?>@yield('content2')"<?php; // Default content to include
                    }
                    ?>
                </div>
            </main>
        </div>
    </div>
    
    </main>
    
    </body>
</html>