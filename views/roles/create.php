<?php
include '../../templates/header.php';
include '../../db.php';

if($_POST) {

    $nombrepuesto = (isset($_POST['nombrepuesto']))? $_POST['nombrepuesto'] : '';

    $nombrepuestostringified = strval($nombrepuesto);

    $sentencia = $connection->prepare("INSERT INTO roles (id, nombrepuesto) VALUES (null, :nombrepuestostringified)");

    $sentencia->bindParam(':nombrepuestostringified', $nombrepuestostringified);

    $sentencia->execute();
    $mensaje = 'Agregado';
    header('Location: index.php?mensaje=' . $mensaje);
}
?>
<main class="container p-2">
<h1>Crear Puestos</h1>

<div class="row column-gap-3">

<div class="card col" style="width: auto; height: auto;">
            <div class="card-body">
                <form action="#" method="POST">

                    <div class="mb-3">
                        <label for="nombrepuesto" class="form-label">Nombre del puesto</label>
                        <input type="text" class="form-control" id="nombrepuesto" name="nombrepuesto">
                    </div>

                    <button type="submit" class="btn btn-primary">Agregar puesto</button>
                    <a href="<?php echo $view; ?>roles"  type="button" class="btn btn-secondary">Cancelar</a>

                </form>


            </div>
        </div>
</div>

    

</div>



    

</main>
<?php
include '../../templates/footer.php';
?>