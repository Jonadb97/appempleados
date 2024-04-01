<?php
include 'templates/header.php';
include 'db.php';

$sentence = $connection->prepare("SELECT * FROM empleados ORDER BY fechaingreso DESC");
$sentence->execute();

$listaempleados  = $sentence->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container p-2">
    <h1>Bienvenid@ <?php echo $_SESSION['usuario']; ?></h1>
    <hr>
    <h2>Últimos ingresos:</h2>

    <br>

    <div class="row column-gap-3">

        <div class="card col" style="width: auto; height: auto;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $listaempleados[0]['nombre'];
                                        echo ' ';
                                        echo $listaempleados[0]['apellido']; ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $listaempleados[0]['puesto']; ?></h6>
                <p class="card-text">Ingreso: <?php echo $listaempleados[0]['fechaingreso']; ?></p>
            </div>
            <img src="files/<?php echo $listaempleados[0]['foto']; ?>" class="card-img-bottom" width="300px" height="300px" alt="..." style="object-fit: cover;">

        </div>

        <div class="card col" style="width: auto; height: auto;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $listaempleados[1]['nombre'];
                                        echo ' ';
                                        echo $listaempleados[1]['apellido']; ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $listaempleados[1]['puesto']; ?></h6>
                <p class="card-text">Ingreso: <?php echo $listaempleados[1]['fechaingreso']; ?></p>
            </div>
            <img src="files/<?php echo $listaempleados[1]['foto']; ?>" class="card-img-bottom" width="300px" height="300px" alt="..." style="object-fit: cover;">

        </div>

    </div>





</main>
<?php
include 'templates/footer.php';
?>