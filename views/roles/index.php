<?php
include '../../templates/header.php';
include '../../db.php';

if(isset($_GET['ID'])) {
    $ID = (isset($_GET['ID']))? $_GET['ID'] : '';

    $sentencia = $connection->prepare("DELETE FROM roles WHERE id = :ID");
    $sentencia->bindParam(':ID', $ID);
    $sentencia->execute();
    $mensaje = "Eliminado";
     header('Location: index.php?mensaje=' . $mensaje);

}


$sentence = $connection->prepare("SELECT * FROM roles");
$sentence->execute();

$listapuestos  = $sentence->fetchAll(PDO::FETCH_ASSOC);
?>




<main class="container p-2">
<h1>Puestos</h1>

<div class="row column-gap-3">
        <div class="card">
            <div class="card-header">
                Puestos | <a href="<?php echo $view; ?>/roles/create.php" class="btn btn-success">Agregar puesto</a>
            </div>


            <div class="card-body">
                <table id="tabla_id" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del puesto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($listapuestos as $registro) {?>
                        
                        <tr>
                            <td><?php echo $registro['id']; ?></td>
                            <td><?php echo $registro['nombrepuesto']; ?></td>
                            <td>
                                <a href="<?php echo $view; ?>roles/edit.php?ID=<?php echo $registro['id']; ?>"  class="btn btn-primary">Editar</a>
                                <a  href="javascript:borrar(<?php echo $registro['id']; ?>)" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>

                    <?php }?>

                    </tbody>
                </table>
            </div>
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