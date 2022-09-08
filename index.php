<?php
include 'Conexion.php';
include 'funciones.php';

csrf();
if (isset($_POST['submit']) && !hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  die();
}

if (isset($_POST['submit'])) {
  $resultado = [
    'error' => false,
    'mensaje' => 'No se pudo registrar su respuesta.'
  ];

  $config = include 'config.php';

  try {
    $conexion = new Conexion();
    $conexion = $conexion->obtenerConexion();

    $form = [
      "carnet" => $_POST['carnet'],
      "felicidad" => $_POST['felicidad'],
      "estres" => $_POST['estres'],
      "satisfaccion" => $_POST['satisfaccion'],
      "clase_virtual" => $_POST['clase_virtual'] == 'Sí' ? 1 : 0,
      "inicio_presencial" => $_POST['inicio_presencial'] == 'Sí' ? 1 : 0,
    ];

    $sql = "INSERT INTO tbl_respuestas (carnet, nivel_felicidad, nivel_estres, nivel_satisfaccion, clase_virtual, inicio_presencial)";
    $sql .= " VALUES (:" . implode(", :", array_keys($form)) . ")";

    $sentencia = $conexion->prepare($sql);
    $sentencia->execute($form);

    echo '<script>alert("Respuesta registrada. Muchas gracias")</script>';
  } catch (PDOException $e) {
    $resultado['error'] = true;
    $resultado['mensaje'] = $e->getMessage();
  }
}

?>

<!-- Si hubo algún error: -->
<?php
if (isset($resultado)) {
?>
<div class="container">
  <p class="error">
    <?php
      if ($resultado['error']) {
        $resultado['mensaje'];
      }
      ?>
  </p>
</div>
<?php
}
?>

<!-- Si no hubo ningún error: -->
<link rel="stylesheet" href="styles.css">
<div class="container">
  <h1 class="title">Formulario para medir el nivel de felicidad de los estudiantes</h1>
  <form method="post" class="form">

    <div class="containerInput">
      <label class="label" htmlFor='name'>
        Carnet
      </label>
      <input class="inputText" type='text' id='name' name='carnet' placeholder='Ej: 1190-19-4642' value=''
        autoComplete='off' required />
    </div>

    <div class="containerInput">
      <label class="label">¿Cuál es su nivel de felicidad con las clases virtuales en ingeniería?</label>
      <div class="radioContainer">
        <label for="">Muy mal</label>
        <input type="range" list="tickmarks" name='felicidad' value='50'>
        <datalist id="tickmarks">
          <option value="0"></option>
          <option value="10"></option>
          <option value="20"></option>
          <option value="30"></option>
          <option value="40"></option>
          <option value="50"></option>
          <option value="60"></option>
          <option value="70"></option>
          <option value="80"></option>
          <option value="90"></option>
          <option value="100"></option>
        </datalist>
        <label for="">Muy bien</label>
      </div>
    </div>

    <div class="containerInput">
      <label class="label">¿Cuál es su nivel de estrés con las clases virtuales en ingeniería?</label>
      <div class="radioContainer">
        <label for="">Mucho estrés</label>
        <input type="range" list="tickmarks" name='estres' value='50'>
        <datalist id="tickmarks">
          <option value="0"></option>
          <option value="10"></option>
          <option value="20"></option>
          <option value="30"></option>
          <option value="40"></option>
          <option value="50"></option>
          <option value="60"></option>
          <option value="70"></option>
          <option value="80"></option>
          <option value="90"></option>
          <option value="100"></option>
        </datalist>
        <label for="">Poco estrés</label>
      </div>
    </div>

    <div class="containerInput">
      <label class="label">¿Cuan satisfecho se siente con las clases virtuales?</label>
      <div class="radioContainer">
        <label for="">Muy insatisfecho</label>
        <input type="range" list="tickmarks" name='satisfaccion' value='50'>
        <datalist id="tickmarks">
          <option value="0"></option>
          <option value="10"></option>
          <option value="20"></option>
          <option value="30"></option>
          <option value="40"></option>
          <option value="50"></option>
          <option value="60"></option>
          <option value="70"></option>
          <option value="80"></option>
          <option value="90"></option>
          <option value="100"></option>
        </datalist>
        <label for="">Muy satisfecho</label>
      </div>
    </div>

    <div class="containerInput">
      <label class="label">¿Le gustaría seguir recibiendo clases virtuales?</label>
      <div class="radioContainer">
        <input type='radio' name='clase_virtual' id='virtual_si' value='Sí' required />
        <label for='virtual_si'>Sí</label>
      </div>
      <div class="radioContainer">
        <input type='radio' name='clase_virtual' id='virtual_no' value='No' required />
        <label for='virtual_no'>No</label>
      </div>
    </div>

    <div class="containerInput">
      <label class="label">Cuando inicio su carrera, ¿las clases eran presenciales?</label>
      <div class="radioContainer">
        <input type='radio' name='inicio_presencial' id='presencial_si' value='Sí' required />
        <label for='presencial_si'>Sí</label>
      </div>
      <div class="radioContainer">
        <input type='radio' name='inicio_presencial' id='presencial_no' value='No' required />
        <label for='presencial_no'>No</label>
      </div>
    </div>

    <input name="csrf" type="hidden" value="<?php echo escapar($_SESSION['csrf']); ?>">
    <button class="btnSubmit" type='submit' name='submit'>
      Guardar
    </button>

  </form>

  <a href="./results.php">Ver resultados</a>
</div>