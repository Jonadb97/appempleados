<?php
include '../../templates/header.php';
include '../../db.php';

if(isset($_GET['ID'])) {
    $ID = (isset($_GET['ID']))? $_GET['ID'] : '';

    $sentencia = $connection->prepare("DELETE FROM usuarios WHERE id = :ID");
    $sentencia->bindParam(':ID', $ID);
    $sentencia->execute();
     header('Location: index.php');

}


$sentence = $connection->prepare("SELECT * FROM usuarios");
$sentence->execute();

$listausuarios  = $sentence->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container p-2">
<h1>Usuarios</h1>

<div class="row column-gap-3">
<div class="card">
            <div class="card-header">
                Usuarios | <a href="<?php echo $view; ?>users/create.php" class="btn btn-success">Agregar usuario</a>
            </div>
            <div class="card-body">
                <table id="tabla_id" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre del usuario</th>
                            <th>Contraseña</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach ($listausuarios as $usuario) { ?>

                            <tr>
                                <td><?php echo $usuario['id']; ?></td>
                                <td><?php echo $usuario['usuario']; ?></td>
                                <td><input type="password" readonly class="form-control disabled text-muted" id="id" name="id" value="<?php echo $usuario['password']; ?>"></td>
                                <td><?php echo $usuario['correo']; ?></td>
                                <td>
                                    <a href="edit.php?ID=<?php echo $usuario['id']; ?>" class="btn btn-primary">Editar</a>
                                    <a href="javascript:borrar(<?php echo $usuario['id']; ?>)" class="btn btn-danger">Eliminar</a>
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