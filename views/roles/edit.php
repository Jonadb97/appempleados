<?php
include '../../templates/header.php';

if(isset($_GET['ID'])) {
    $ID = (isset($_GET['ID']))? $_GET['ID'] : '';

    $sentence = $connection->prepare("SELECT id, nombrepuesto FROM roles WHERE id = :ID");
    $sentence->bindParam(':ID', $ID);
    $sentence->execute();

    $puesto  = $sentence->fetchAll(PDO::FETCH_ASSOC);
}

if(isset($_POST['nombrepuesto'])) {

    $newID = (isset($_POST['id']))? $_POST['id'] : '';
    $newnombrepuesto = (isset($_POST['nombrepuesto']))? $_POST['nombrepuesto'] : '';

    $sentence = $connection->prepare("UPDATE roles SET nombrepuesto = :newnombrepuesto WHERE id = :newID");
    $sentence->bindParam(':newID', $newID);
    $sentence->bindParam(':newnombrepuesto', $newnombrepuesto);
    $sentence->execute();


    header('Location: index.php?mensaje=Editado');
    
}



?>
<main class="container p-2">
<h1>Editar Puestos</h1>

<div class="row column-gap-3">


<div class="card col" style="width: auto; height: auto;">
            <div class="card-body">
                <form action="#" method="POST">

                <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="text" readonly class="form-control disabled text-muted" id="id" name="id" value="<?php print_r($puesto['0']['id']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="nombrepuesto" class="form-label">Nombre del puesto</label>
                        <input type="text" class="form-control" id="nombrepuesto" name="nombrepuesto" value="<?php print_r($puesto['0']['nombrepuesto']); ?>">
                    </div>

                    <button type="submit" class="btn btn-warning">Editar puesto</button>
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