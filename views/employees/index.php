<?php
include '../../templates/header.php';
include '../../db.php';

$sentence = $connection->prepare("SELECT * FROM empleados");
$sentence->execute();

$listaempleados  = $sentence->fetchAll(PDO::FETCH_ASSOC);

$sentenceroles = $connection->prepare("SELECT * FROM roles");
$sentenceroles->execute();

$listapuestos  = $sentenceroles->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['ID'])) {
    $ID = (isset($_GET['ID'])) ? $_GET['ID'] : '';

    $sentencia = $connection->prepare("SELECT foto, cv FROM empleados WHERE id = :ID");
    $sentencia->bindParam(':ID', $ID);
    $sentencia->execute();

    $registro_foto_cv = $sentencia->fetch(PDO::FETCH_LAZY);

    if (isset($registro_foto_cv['foto'])  && $registro_foto_cv['foto'] != '') {
        if (file_exists('../../files/' . $registro_foto_cv['foto'])) {
            unlink('../../files/' . $registro_foto_cv['foto']);
        }
    }

    if (isset($registro_foto_cv['cv'])  && $registro_foto_cv['cv'] != '') {
        if (file_exists('../../files/' . $registro_foto_cv['cv'])) {
            unlink('../../files/' . $registro_foto_cv['cv']);
        }
    }


    $sentencia = $connection->prepare("DELETE FROM empleados WHERE id = :ID");
    $sentencia->bindParam(':ID', $ID);
    $sentencia->execute();
    header('Location: index.php');
}

// SUBCONSULTA
$sentenciapuestos = $connection->prepare("SELECT *,
(SELECT nombrepuesto FROM roles WHERE roles.id = empleados.idpuesto limit 1) as puesto
FROM empleados");
$sentenciapuestos->execute();
$listaempleados = $sentenciapuestos->fetchAll(PDO::FETCH_ASSOC);


?>

<main class="container p-2">

    <h1>Empleados</h1>

    <div class="row column-gap-3 justify-content-center">

        <div class="card" style="width: 100%; height: auto;">
            <div class="card-header">
                Lista de empleados | <a href="<?php echo $GLOBALS['view'];  ?>employees/create.php"><button class="btn btn-success">Crear registro</button></a>
            </div>
            <div class="card-body">
                <table id="tabla_id" class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Foto</th>
                            <th scope="col">CV</th>
                            <th scope="col">Puesto</th>
                            <th scope="col">Fecha de ingreso</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listaempleados as $empleado) { ?>

                            <tr>
                                <td><?php echo $empleado['id']; ?></td>
                                <td><?php echo $empleado['nombre'];
                                    echo ' ';
                                    echo $empleado['apellido']; ?></td>
                                <td>
                                    <a target="__blank" href="../../files/<?php echo $empleado['foto']; ?>"><button id="myInput" type="button" class="btn-profile" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <img width="50px" height="50px" src="../../files/<?php echo $empleado['foto']; ?>" class="rounded" style="object-fit: cover;" alt="">
                                        </button></a>
                                </td>
                                <td><a target="__blank" href="../../files/<?php echo $empleado['cv']; ?>"><?php echo $empleado['cv']; ?></a></td>
                                <td><?php echo $empleado['puesto']; ?></td>
                                <td><?php echo $empleado['fechaingreso']; ?></td>
                                <td width="400px" colspan="3">
                                    <a target="__blank" href="<?php echo $view; ?>../files/carta_recomendacion.php?ID=<?php echo $empleado['id']; ?>" class="btn btn-primary">Carta</a>
                                    <a href="<?php echo $view; ?>employees/edit.php?ID=<?php echo $empleado['id']; ?>" class="btn btn-warning">Editar</a>
                                    <a type="submit" href="javascript:borrar(<?php echo $empleado['id']; ?>)" class="btn btn-danger">Eliminar</a>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>


            </div>

        </div>

    </div>

</main>
<script>
    function borrar(id) {
        Swal.fire({
            title: 'Borrar',
            text: '¿Realmente quieres eliminar?',
            icon: 'warning',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php?ID=' + id;
            } else if (result.isDenied) {

            }
        })
        // index.php?ID=
    }
</script>
<?php
include '../../templates/footer.php';
?>