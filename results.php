<?php
include 'Conexion.php';
include 'funciones.php';

csrf();

$error = false;
$config = include 'config.php';
$results = [
  'num' => 0,
  'felicidad' => 0,
  'estres' => 0,
  'satisfaccion' => 0,
  'clase_virtual' => 0,
  'inicio_presencial' => 0,
];

try {
  $conexion = new Conexion();
  $conexion = $conexion->obtenerConexion();

  $consultaSQL = "SELECT * FROM tbl_respuestas";

  $sentencia = $conexion->prepare($consultaSQL);
  $sentencia->execute();
  $resultados = $sentencia->fetchAll();
} catch (PDOException $e) {
  $error = $e->getMessage();
}

?>
<link rel="stylesheet" href="styles.css">

<?php
if ($error) {
?>
<div class="container mt-2">
  <div class="row">
    <div class="col-md-12">
      <div class="alert alert-danger" role="alert">
        <?= $error ?>
      </div>
    </div>
  </div>
</div>
<?php
}
?>

<div class="container">
  <h1 class="title">Resultados:</h1>

  <table class="table">
    <thead>
      <tr>
        <th>No.</th>
        <th>Carnet</th>
        <th>Nivel de felicidad</th>
        <th>Nivel de estrés</th>
        <th>Nivel de satisfacción</th>
        <th>Seguir con clases virtuales</th>
        <th>Proviene de clase presencial</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if ($resultados && $sentencia->rowCount() > 0) {
        foreach ($resultados as $fila) {
          $results['num'] = $fila['id'];
          $results['felicidad'] += $fila['nivel_felicidad'];
          $results['estres'] += $fila['nivel_estres'];
          $results['satisfaccion'] += $fila['nivel_satisfaccion'];
          $results['clase_virtual'] += $fila['clase_virtual'];
          $results['inicio_presencial'] += $fila['inicio_presencial'];
      ?>
      <tr>
        <td><?php echo escapar($fila["id"]); ?></td>
        <td><?php echo escapar($fila["carnet"]); ?></td>
        <td><?php echo escapar($fila["nivel_felicidad"]); ?></td>
        <td><?php echo escapar($fila["nivel_estres"]); ?></td>
        <td><?php echo escapar($fila["nivel_satisfaccion"]); ?></td>
        <td><?php echo escapar($fila["clase_virtual"]) ? "Sí" : "No"; ?></td>
        <td><?php echo escapar($fila["inicio_presencial"]) ? "Sí" : "No"; ?></td>
        <td><?php echo escapar($fila["created_at"]); ?></td>
      </tr>
      <?php
        }
      }
      ?>
    <tbody>
  </table>

  <?php
  if ($resultados && $sentencia->rowCount() > 0) {
    $results['felicidad'] = $results['felicidad'] / $results['num'];
    $results['estres'] = $results['estres'] / $results['num'];
    $results['satisfaccion'] = $results['satisfaccion'] / $results['num'];
  ?>

  <div class="container-statistics">
    <h4>Estadísticas</h4>
    <p>
      <strong>Nivel de felicidad:</strong>
      <?php echo round($results['felicidad'], 2) . "%" ?>
    </p>
    <p>
      <strong>Nivel de estrés:</strong>
      <?php echo round($results['estres'], 2) . "%" ?>
    </p>
    <p>
      <strong>Nivel de satisfacción:</strong>
      <?php echo round($results['satisfaccion'], 2) . "%" ?>
    </p>
    <p>
      <strong>Seguir con clases virtuales:</strong>
      <br />
      <strong>Sí: <?php echo $results['clase_virtual'] ?></strong>
      <span>-----</span>
      <strong>No: <?php echo $results['num'] - $results['clase_virtual'] ?></strong>
    </p>
    <p>
      <strong>Proviene de clase presencial:</strong>
      <br />
      <strong>Sí: <?php echo $results['inicio_presencial'] ?></strong>
      <span>-----</span>
      <strong>No: <?php echo $results['num'] - $results['inicio_presencial'] ?></strong>
    </p>
  </div>
  <?php
  }
  ?>
  <a href="./index.php">Regresar</a>
</div>