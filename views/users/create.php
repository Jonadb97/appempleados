<?php
include '../../templates/header.php';
include '../../db.php';

if ($_POST) {

    $nombreusuario = strval((isset($_POST['name'])) ? $_POST['name'] : '');
    $password = strval((isset($_POST['password'])) ? $_POST['password'] : '');
    $correo = strval((isset($_POST['email'])) ? $_POST['email'] : '');

    $sentencia = $connection->prepare("INSERT INTO usuarios (id, usuario, password, correo) VALUES (null, :name, :password, :email)");

    $sentencia->bindParam(':name', $nombreusuario);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':email', $correo);

    $sentencia->execute();

    header('Location: '. $view. 'users');
}
?>
<main class="container p-2">
    <h1>Crear Usuarios</h1>

    <div class="row column-gap-3">

        <div class="card col" style="width: auto; height: auto;">
            <div class="card-header">
                Datos del usuario
            </div>

            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Crear usuario</button><a href="<?php echo $view; ?>users"  type="submit" class="btn btn-danger ms-1">Cancelar</a>
                </form>

            </div>
        </div>
    </div>


    </div>





</main>
<?php
include '../../templates/footer.php';
?>