<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog de Libros</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
<?php $url="http://".$_SERVER['HTTP_HOST']."/sitio3"  ?>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <ul class="nav navbar-nav">
            
            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url."/index.php"; ?>">Volver al Inicio</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url."/productos.php"; ?>">Biblioteca de Libros</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url."/nosotros.php"; ?>">Sobre Nosotros</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo $url."/administrador/index.php"; ?>">Administrar Biblioteca</a>

            </li>
            

        </ul>
    </nav>

    <div class="container">
</br>
        <div class="row">