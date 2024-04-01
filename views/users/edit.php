<?php
include '../../templates/header.php';


if (isset($_GET['ID'])) {
    $ID = (isset($_GET['ID'])) ? $_GET['ID'] : '';

    $sentence = $connection->prepare("SELECT id, usuario, password, correo FROM usuarios WHERE id = :ID");
    $sentence->bindParam(':ID', $ID);
    $sentence->execute();

    $data  = $sentence->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_POST['usuario'])) {

    $newID = (isset($_POST['id']))? $_POST['id'] : '';
    $usuario = (isset($_POST['usuario'])? $_POST['usuario'] : '');
    $correo = (isset($_POST['correo']))? $_POST['correo'] : '';
    $password = (isset($_POST['password']))? $_POST['password'] : '';

    $sentence = $connection->prepare("UPDATE usuarios SET
    usuario=:usuario,
    password=:password,
    correo=:correo
    WHERE id=:newID
    ");
    $sentence->bindParam(":newID", $newID);
    $sentence->bindParam(":usuario", $usuario);
    $sentence->bindParam(":password", $password);
    $sentence->bindParam(":correo", $correo);

    $sentence->execute();

   


    header('Location: index.php');
    
}
?>
<main class="container p-2">
    <h1>Editar Usuarios</h1>

    <div class="row column-gap-3">


        <div class="card col" style="width: auto; height: auto;">
            <div class="card-header">
                Datos del usuario
            </div>

            <div class="card-body">
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" readonly class="form-control disabled text-muted" id="id" name="id" value="<?php print_r($data[0]['id']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre" value="<?php echo $data[0]['usuario']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Email</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $data[0]['correo']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" value="<?php echo $data[0]['password']; ?>">
                    </div>

                    <button type="submit" class="btn btn-warning">Editar usuario</button>
                    <a href="<?php echo $view; ?>users" type="submit" class="btn btn-danger ms-1">Cancelar</a>
                </form>

            </div>
        </div>
    </div>


    </div>





</main>
<?php
include '../../templates/footer.php';
?>