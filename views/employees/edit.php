<?php
include '../../templates/header.php';
include '../../db.php';

if (isset($_GET['ID'])) {
    $ID = (isset($_GET['ID'])) ? $_GET['ID'] : '';

    $sentence = $connection->prepare("SELECT * FROM empleados WHERE id = :ID");
    $sentence->bindParam(':ID', $ID);
    $sentence->execute();

    $empleado  = $sentence->fetchAll(PDO::FETCH_ASSOC);
}

$sentence = $connection->prepare("SELECT * FROM roles");
$sentence->execute();
$listapuestos  = $sentence->fetchAll(PDO::FETCH_ASSOC);

if ($_POST) {

    $nombre = strval((isset($_POST['nombre'])) ? $_POST['nombre'] : '');
    $apellido = strval((isset($_POST['apellido'])) ? $_POST['apellido'] : '');
    $correo = strval((isset($_POST['correo'])) ? $_POST['correo'] : '');
    $puesto = (isset($_POST['puesto'])) ? $_POST['puesto'] : '';
    $fechaingreso = (isset($_POST['fecha_ingreso'])) ? $_POST['fecha_ingreso'] : '';

    $fecha_ = new DateTime();

    $foto = (isset($_FILES['foto']['name'])) ? $_FILES['foto']['name'] : '';

    $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . " " . $_FILES['foto']['name'] : '';

    $tmp_foto = (isset($_FILES['foto']['tmp_name'])) ? $_FILES['foto']['tmp_name'] : '';

    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "../../files/" . $nombreArchivo_foto);

        $sentencia = $connection->prepare("SELECT foto FROM empleados WHERE id = :ID");
        $sentencia->bindParam(':id', $ID);
        $sentencia->execute();

        $foto_recuperada = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($foto_recuperada['foto'])  && $foto_recuperada['foto'] != '') {
            if (file_exists('../../files/' . $foto_recuperada['foto'])) {
                unlink('../../files/' . $foto_recuperada['foto']);
            }
        }

        $sentencia = $connection->prepare("UPDATE empleados SET
        foto = :foto,
        WHERE id = :ID");
        $sentencia->bindParam(':foto', $nombreArchivo_foto);
        $sentencia->bindParam(':id', $ID);
        $sentencia->execute();
    }



    $cv = (isset($_FILES['cv']['name'])) ? $_FILES['cv']['name'] : '';


    $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . " " . $_FILES['cv']['name'] : '';

    $tmp_cv = (isset($_FILES['cv']['tmp_name'])) ? $_FILES['cv']['tmp_name'] : '';

    if ($tmp_cv != '') {
        move_uploaded_file($tmp_cv, "../../files/" . $nombreArchivo_cv);

        $sentencia = $connection->prepare("SELECT cv FROM empleados WHERE id = :ID");
        $sentencia->bindParam(':id', $ID);
        $sentencia->execute();

        $cv_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

        if (isset($cv_recuperado['cv'])  && $cv_recuperado['cv'] != '') {
            if (file_exists('../../files/' . $cv_recuperado['cv'])) {
                unlink('../../files/' . $cv_recuperado['cv']);
            }
        }

        $sentencia = $connection->prepare("UPDATE empleados SET
        cv = :cv,
        WHERE id = :ID");
        $sentencia->bindParam(':cv', $nombreArchivo_cv);
        $sentencia->bindParam(':id', $ID);
        $sentencia->execute();
    }

    $sentencia = $connection->prepare("UPDATE `empleados` SET
    `nombre`=:nombre,
    `apellido`=:apellido,
    `correo`=:correo,
    `idpuesto`=:puesto,
    `fechaingreso`=:fechaingreso
    WHERE `empleados`.`id`=:id
    ");

    $sentencia->bindParam(':nombre', $nombre);
    $sentencia->bindParam(':apellido', $apellido);
    $sentencia->bindParam(':correo', $correo);
    $sentencia->bindParam(':puesto', $puesto);
    $sentencia->bindParam(':fechaingreso', $fechaingreso);
    $sentencia->bindParam(':id', $ID);

    try {
        $sentencia->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    header('Location: index.php');
}

?>
<main class="container p-2">
    <h1>Editar Empleados</h1>

    <div class="row column-gap-3">

        <div class="card col" style="width: auto; height: auto;">
            <div class="card-header">
                Datos del empleado <img src="../../files/<?php echo $empleado[0]['foto']; ?>" alt="" class="img-fluid rounded" style="margin-left: 75%;" width="100px">
            </div>
            <div class="card-body form-group">

                <form action="" method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">ID</label>
                        <input disabled type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $empleado[0]['id']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $empleado[0]['nombre']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $empleado[0]['apellido']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $empleado[0]['correo']; ?>">
                    </div>


                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <small class="text-muted"><?php echo $empleado[0]['foto']; ?></small>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>

                    <div class="mb-3">
                        <label for="cv" class="form-label">CV</label>
                        <small class="text-muted"><?php echo $empleado[0]['cv']; ?></small>
                        <input type="file" class="form-control" id="cv" name="cv">
                    </div>

                    <div class="mb-3">
                        <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                        <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $empleado[0]['fechaingreso']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="puesto" class="form-label">Puesto</label>
                        <select class="form-select" id="puesto" name="puesto">
                            <?php foreach ($listapuestos as $registro) { ?>

                                <option value="<?php echo $registro['id']; ?>" <?php if ($empleado[0]['idpuesto'] == $registro['id']) : echo 'selected';
                                                                                endif ?>><?php echo $registro['nombrepuesto']; ?></option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Editar registro</button>
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