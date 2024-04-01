<?php
include '../db.php';

if (isset($_GET['ID'])) {
    $ID = (isset($_GET['ID'])) ? $_GET['ID'] : '';

    $sentence = $connection->prepare("SELECT * FROM empleados WHERE id = :ID");
    $sentence->bindParam(':ID', $ID);
    $sentence->execute();

    $empleado  = $sentence->fetchAll(PDO::FETCH_ASSOC);

    // SUBCONSULTA
    $sentenciapuestos = $connection->prepare("SELECT *,
(SELECT nombrepuesto FROM roles WHERE roles.id = empleados.idpuesto limit 1) as puesto
FROM empleados  WHERE id = :ID");
    $sentenciapuestos->bindParam(':ID', $ID);
    $sentenciapuestos->execute();
    $empleadoselect = $sentenciapuestos->fetchAll(PDO::FETCH_ASSOC);
}

$sentence = $connection->prepare("SELECT * FROM roles");
$sentence->execute();
$listapuestos  = $sentence->fetchAll(PDO::FETCH_ASSOC);



ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendación</title>
</head>

<body>

    <h1>Carta de recomendación</h1>
    <div style="display: flex; flex-direction: column; justify-content: space-evenly; padding: 2rem;">
        <p>
        <p>
            A quien corresponda:
        </p>

        <p>
            Tengo el agrado de recomendar a <strong><?php echo $empleado[0]['nombre'] ?> <?php echo $empleado[0]['apellido'] ?> </strong> para el puesto de <?php echo $empleadoselect[0]['puesto'] ?>.<br> Conozco a <?php echo $empleado[0]['nombre'] ?> desde <?php echo $empleado[0]['fechaingreso'] - date('d M Y') ?> cuando se incorporó a nuestra empresa como <?php echo $empleadoselect[0]['puesto'] ?>.
        </p>

        <p>
            <?php echo $empleado[0]['nombre'] ?> demostró durante su tiempo en nuestra empresa ser un/a profesional proactivo/a, responsable y con gran capacidad de trabajo en equipo.<br>Destacó por su puntualidad, compromiso y excelentes habilidades comunicativas.
        </p>

        <p>
            Adjunto el CV de <?php echo $empleado[0]['nombre'] ?> para que puedan evaluar en detalle su experiencia y formación.<br>Creo que <?php echo $empleado[0]['nombre'] ?> sería una incorporación valiosa para cualquier equipo, dado su alto desempeño y sólidos valores.
        </p>

        <p>
            Quedo a disposición para ampliar cualquier información adicional sobre <?php echo $empleado[0]['nombre'] ?> .<br>Muchas gracias por su tiempo y consideración.
        </p>

            <br>

            Saludos cordiales,

            <br>
            <br>

            Joe Johnson González

            <br>
            <br>

            CEO of Global Top Notch Coach Advisors Inc. © 2024
        </p>
    </div>
</body>

</html>

<style>
    body, html {
        color: #1f1f1f;
        margin: 2rem;
    }
</style>

<?php
$HTML = ob_get_clean(); //Termina stream de start más arriba, streamea el html y lo almacena acá

require_once('../libs/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$opciones = $dompdf->getOptions();
$opciones->set(array('isRemoteEnabled', TRUE));
$dompdf->setOptions($opciones);

$dompdf->loadHtml($HTML);

$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream('carta.pdf', array("Attachment" => false));

?>