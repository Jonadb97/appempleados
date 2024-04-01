<?php
session_start();

if ($_POST) {
    include './db.php';

    $nombre = strval((isset($_POST['nombre'])) ? $_POST['nombre'] : '');
    $password = strval((isset($_POST['password'])) ? $_POST['password'] : '');

    $sentence = $connection->prepare("SELECT *,count(*) as n_usuarios FROM usuarios WHERE usuario = :nombre AND password = :password");

    $sentence->bindParam(':nombre', $nombre);
    $sentence->bindParam(':password', $password);

    $sentence->execute();

    $usuario  = $sentence->fetch(PDO::FETCH_LAZY);
    print_r($usuario);

    if ($usuario['n_usuarios'] == 1) {
        $_SESSION['usuario'] = $usuario['usuario'];
        $_SESSION['logueado'] = true;
        header('location: index.php');
    } else {
        $mensaje = 'Usuario o contraseña incorrectos';
        header('location: login.php?mensaje=Usuario o contraseña incorrectos');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body style="background-color: #d3bce6;">
    <main class="container" style="display: flex; align-items: center; justify-content: center;">

                <div class="card" style="width:18rem;">
                    <div class="card-header">Iniciar sesión</div>
                    <div class="card-body">

                        <?php if (isset($_GET['mensaje'])) { ?>
                            <div class="alert alert-danger" role="alert"><?php echo $_GET['mensaje'] ?></div>
                        <?php } ?>
                        <form action="" method="post">

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre" name="nombre">
                            </div>

                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>


                            <button class="btn btn-secondary" type="submit">Entrar</button>

                        </form>

                    </div>
                </div>
    </main>
</body>

</html>
<?php
include './templates/footer.php';
?>