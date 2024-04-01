<?php
include '../../templates/header.php';
include '../../db.php';

if ($_POST) {

    $nombre = strval((isset($_POST['nombre'])) ? $_POST['nombre'] : '');
    $apellido = strval((isset($_POST['apellido'])) ? $_POST['apellido'] : '');
    $correo = strval((isset($_POST['correo'])) ? $_POST['correo'] : '');

    $fecha_ = new DateTime();

    $foto = strval((isset($_FILES['foto']['name'])) ? $_FILES['foto']['name'] : '');

    $nombreArchivo_foto = ($foto != '')? $fecha_->getTimestamp(). " " . $_FILES['foto']['name'] : '';
    $tmp_foto = $_FILES['foto']['tmp_name'];
    if ($tmp_foto!= '') {
        move_uploaded_file($tmp_foto, "../../files/". $nombreArchivo_foto);
    }

    $cv = strval((isset($_FILES['cv']['name'])) ? $_FILES['cv']['name'] : '');
    

    $nombreArchivo_cv = ($cv != '')? $fecha_->getTimestamp(). " " . $_FILES['cv']['name'] : '';
    $tmp_cv = $_FILES['cv']['tmp_name'];
    if ($tmp_cv!= '') {
        move_uploaded_file($tmp_cv, "../../files/". $nombreArchivo_cv);
    }

    $puesto = strval((isset($_POST['puesto'])) ? $_POST['puesto'] : '');
    $fecha_ingreso = strval((isset($_POST['fecha_ingreso'])) ? $_POST['fecha_ingreso'] : '');

    $sentencia = $connection->prepare("INSERT INTO `empleados` (`id`, `nombre`, `apellido`, `correo`, `foto`, `cv`, `idpuesto`, `fechaingreso`) VALUES (NULL, :nombre, :apellido, :correo, :foto, :cv, :puesto, :fecha_ingreso) ");

    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':apellido', $apellido);
    $sentencia->bindParam(':correo', $correo);
    $sentencia->bindParam(':foto', $nombreArchivo_foto);
    $sentencia->bindParam(':cv', $nombreArchivo_cv);
    $sentencia->bindParam(':puesto', $puesto);
    $sentencia->bindParam(':fecha_ingreso', $fecha_ingreso);

    $sentencia->execute();

    header('Location: '. $view. 'employees');
    
}

$sentence = $connection->prepare("SELECT * FROM roles");
$sentence->execute();

$listapuestos  = $sentence->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="container p-2">
    <h1>Agregar Empleados</h1>

    <div class="row column-gap-3">

        <div class="card col" style="width: auto; height: auto;">
            <div class="card-header">
                Datos del empleado
            </div>
            <div class="card-body form-group">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido">
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo">
                    </div>


                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto:</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">CV:</label>
                        <input type="file" class="form-control" id="cv" name="cv">
                    </div>

                    <div class="mb-3">
                        <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
                    </div>

                    <div class="mb-3">
                        <label for="puesto" class="form-label">Puesto</label>
                        <select class="form-select" id="puesto" name="puesto">
                            <?php foreach ($listapuestos as $registro) { ?>

                                <option value="<?php echo $registro['id']; ?>"><?php echo $registro['nombrepuesto']; ?></option>

                            <?php } ?>

                        </select>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Agregar registro</button>
                        <a href="<?php echo $view; ?>employees" class="btn btn-secondary">Cancelar</a>
                    </div>

                </form>


            </div>
        </div>

    </div>





</main>
<?php
include '../../templates/footer.php';
?>