<?php
    session_start();
    $usuario = $_SESSION['user_name'];
    $code = $_SESSION['user_code'];
    include_once("conexion_postgres.php");

    if(empty($usuario)){
        header("location: index.php");
    }
    if(!empty($_GET['Fbedit'])){
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $CodeE = $_GET['Fbedit'];
      $DescripcionE = $_GET['descripcionE'];
      $PorcentajeE = $_GET['porcentajeE'];

      $a1 = $_GET['valor'];
      $i = 0;
      $cE = $_SESSION['cE'];
      $update = "SELECT cod_nota FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY cod_nota;";
      $update = pg_query($update);
      while($row3 = pg_fetch_object($update)){
        $codN = $row3->cod_nota;
        $temp = "UPDATE calificaciones SET valor='$a1[$i]' WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' AND cod_estudiante='$cE' AND cod_nota='$codN';";
        $temp = pg_query($temp);
        $i++;
      }
      header('location: calificaciones.php');
    }
    if($_GET['bedit'] == 'bedit'){

      $Enota = $_GET['studentR'];
      $Edit = pg_query("SELECT * FROM estudiantes WHERE cod_estudiante='$Enota';");
      $SEdit = pg_fetch_object($Edit);
      $_SESSION['cE'] = $Enota;
    }

    if($_GET['add'] == 'add') {
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $Estudiante = $_GET['student'];
      $sql = "INSERT INTO inscripciones VALUES('$Curso','$Estudiante','$Año','$Periodo')";   
      pg_query($sql);
      header('location: calificaciones.php');
    }
    if($_GET['remove'] == 'remove') {
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $Estudiante = $_GET['student'];
      $sql = "DELETE FROM inscripciones WHERE cod_curso='$Curso' AND cod_estudiante='$Estudiante' AND año='$Año' AND periodo='$Periodo'";
      pg_query($sql);
      header('location: calificaciones.php');
    }
   else{
    $Curso = $_SESSION['curso'];
    $Periodo = $_SESSION['periodo'];
    $Año = $_SESSION['año'];
    $getEstudiantes = "SELECT e.cod_estudiante, e.nombre, e.apellido FROM estudiantes e JOIN inscripciones i ON e.cod_estudiante=i.cod_estudiante WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY e.cod_estudiante;";
    $getNotas = "SELECT  e.cod_estudiante, e.nombre, e.apellido, c.valor, c.cod_nota  FROM estudiantes e JOIN calificaciones c ON e.cod_estudiante=c.cod_estudiante WHERE c.cod_curso='$Curso' AND c.año='$Año' AND c.periodo='$Periodo' GROUP BY e.cod_estudiante, e.nombre, e.apellido, c.valor, c.cod_nota ORDER BY e.cod_estudiante;";
    $query = pg_query($conexion,$getEstudiantes);
    $cantidad = pg_numrows($query);
    $query1 = pg_query($conexion,$getNotas);
    $cantidad1 = pg_numrows($query1);
  }

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <title>Calificaciones</title>
    <meta property="og:title" content="Calificaciones" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        data-tag="font" />
        
    <link rel="stylesheet" href="./style1.css" />
    <link rel="stylesheet" href="./stylen.css" />
    <link href="./collapsibles.css" rel="stylesheet" />
    <link href="./students4.css" rel="stylesheet" />
    <link href="./studentD.css" rel="stylesheet" />
    <link rel="stylesheet" href="./collapsiblen1.css" />
    <style data-tag="default-style-sheet">
      td{
        width: 15%;
      }
      .collapsiblen-textinput4 {
        width: 90%;
        padding: var(--dl-space-space-unit);
        font-size: 20px;
        text-align: center;
        border-width: 0px;
        border-radius: 0px;
        background-color: rgba(238, 238, 238, 0.3);
      }
      .collapsiblen-textinput5 {
        width: 90%;
        padding: var(--dl-space-space-unit);
        font-size: 20px;
        text-align: center;
        border-width: 0px;
        border-radius: 0px;
        background-color: rgba(238, 238, 238, 0);
      }
      input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
    </style>
  </head>
  <body>
    <div>

      <div class="collapsibles-container">
        <header data-role="Header" class="collapsibles-header">
          <div class="collapsibles-container1">
            <span class="collapsibles-text">
              <?php
                  echo "Welcome $usuario";
              ?>
            </span>
          </div>
        </header>


        <div id="principal" class="students-nav1">
          <span class="students-text2">Current notes</span>
          <div class="collapsibles-container5">
            <?php 
                $notasE = pg_query("SELECT * FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY descripcion;");
                $prom = pg_numrows($notasE);
              if($prom != 0){
            ?>
            <button id="bEdit" class="collapsibles-button button">Edit notes</button>
            <?php
            }
            ?>
            <?php 
              if($cantidad == 0){
                blank();
              }
              else{
            ?>
          </div>
          <div class="students-nav2">
            <table class="students-table">
              <thead>
                <tr>
                  <th class="col">Code</th>
                  <th class="col">First name</th>
                  <th class="col">Last name</th>
                  <?php 
                    $i = 1;
                    if($prom == 0){
                      ?>
                      <th class="col">There are no notes</th>
                      <?php
                    }
                    while($row = pg_fetch_object($notasE)){
                  ?>
                    <th class="col"><?php echo $row->descripcion; ?></th>
                  <?php
                    }
                  ?>
                  <th class="col">Total</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $row2 = pg_fetch_assoc($query1); 
                  while($row = pg_fetch_assoc($query)){
                ?>
                <tr>
                  <td class="col"><?php echo $row['cod_estudiante']; ?></td>
                  <td class="col"><?php echo $row['nombre']; ?></td>
                  <td class="col"><?php echo $row['apellido']; ?></td>
                  <?php 
                    $notasE = "SELECT * FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY descripcion;";
                    $notasE = pg_query($notasE);
                    $total = 0;
                    while($row3 = pg_fetch_object($notasE)){
                      $cod = $row['cod_estudiante'];
                      $codN = $row3->cod_nota;
                      $temp = "SELECT valor FROM calificaciones WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' AND cod_estudiante='$cod' AND cod_nota='$codN' GROUP BY cod_estudiante, valor;";
                      $temp = pg_query($temp);
                      $temp = pg_fetch_object($temp);
                      $total += ($temp->valor * $row3->porcentaje)/100;
                  ?>
                    <td class="col" id="<?php echo $codN ?>"><?php echo $temp->valor; ?></td>
                  <?php
                    }
                  ?>
                  <td class="col"><?php echo $total; ?></td>
                </tr>
              <?php
                }
              ?>
              <?php
                }
                function blank(){
                  echo "</div><div class='students-nav2'><h1>Blank list</h1>";
                }
              ?>
              </tbody>
            </table>
          </div>
        </div>


        <div id="Edit" class="collapsiblen-container02">
        <div class="collapsiblen-container08">
          <span class="collapsiblen-text06">Edit note</span>
          <form id="search" class="collapsiblen-form1">
            <div class="collapsiblen-container09">
              <div class="collapsiblen-container10">
                <span class="collapsiblen-text07">Select the note</span>
                <?php 
                  $getCursos = "SELECT e.cod_estudiante, e.nombre, e.apellido FROM estudiantes e JOIN inscripciones i ON e.cod_estudiante=i.cod_estudiante WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' GROUP BY e.cod_estudiante, e.nombre, e.apellido ORDER BY e.cod_estudiante;";
                  $query = pg_query($conexion,$getCursos);
                ?>
                <select name="studentR" name="studentR" class="collapsiblen-select">
                  <?php
                    while ($valores = pg_fetch_object($query)){
                  ?>
                  <option value="<?php echo $valores->cod_estudiante; ?>">
                    <?php 
                      echo $valores->nombre, " ", $valores->apellido; 
                    ?>
                  </option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <button name="bedit" value="bedit" class="collapsiblen-button02 button">Continue</button>
            </div>
          </form>
          <form id="edit1" class="collapsiblen-form2">
            <div class="collapsiblen-container14">
              <div class="collapsiblen-container15">
                <div class="collapsiblen-container16">
                  <table class="students-table">
                    <thead>
                      <tr>
                        <th class="col">Code</th>
                        <th class="col">First name</th>
                        <th class="col">Last name</th>
                        <?php 
                          $i = 1;
                          $notasE = pg_query("SELECT COUNT(*) AS prom FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo';");
                          $snotasE = pg_fetch_object($notasE);
                          while($i <= $snotasE->prom){
                        ?>
                          <th class="col">Note <?php echo $i ?></th>
                        <?php
                          $i++;
                          }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="col">
                          <input name="codEN"  class="collapsiblen-textinput5 input" value="<?php echo $SEdit->cod_estudiante; ?>" disabled ></input>
                        </td>
                        <td class="col">
                          <input class="collapsiblen-textinput5 input" value="<?php echo $SEdit->nombre; ?>" disabled ></input>
                        </td>
                        <td class="col">
                          <input class="collapsiblen-textinput5 input" value="<?php echo $SEdit->apellido; ?>" disabled ></input>
                        </td>
                        <?php 
                          $notasE = "SELECT cod_nota FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY cod_nota;";
                          $notasE = pg_query($notasE);
                          while($row3 = pg_fetch_object($notasE)){
                            $codN = $row3->cod_nota;
                            $temp = "SELECT valor FROM calificaciones WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' AND cod_estudiante='$SEdit->cod_estudiante' AND cod_nota='$codN' GROUP BY cod_estudiante, valor;";
                            $temp = pg_query($temp);
                            $temp = pg_fetch_object($temp);
                        ?>
                          <td>
                            <input id="edit" name="valor[]" class="collapsiblen-textinput4 input" value="<?php echo $temp->valor; ?>" placeholder="<?php echo $temp->valor; ?>" type="number" step="0.1" min="0" max="5"></input>
                        </td>
                        <?php
                          }
                        ?>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <button name="Fbedit" value="Fbedit" type="submit" class="collapsiblen-button05 button">Continue</button>
            </div>
          </form>
          <button id="hEdit" class="collapsiblen-button06 button">x</button>
        </div>
      </div>

        <footer class="collapsibles-footer">
          <span class="collapsibles-text5">© 2022 Cristian Infante</span>
          <div class="collapsibles-icon-group">
            <button class="collapsibles-button4 button">
              <svg
                viewBox="0 0 877.7142857142857 1024"
                class="collapsibles-icon"
              >
                <path
                  d="M585.143 512c0-80.571-65.714-146.286-146.286-146.286s-146.286 65.714-146.286 146.286 65.714 146.286 146.286 146.286 146.286-65.714 146.286-146.286zM664 512c0 124.571-100.571 225.143-225.143 225.143s-225.143-100.571-225.143-225.143 100.571-225.143 225.143-225.143 225.143 100.571 225.143 225.143zM725.714 277.714c0 29.143-23.429 52.571-52.571 52.571s-52.571-23.429-52.571-52.571 23.429-52.571 52.571-52.571 52.571 23.429 52.571 52.571zM438.857 152c-64 0-201.143-5.143-258.857 17.714-20 8-34.857 17.714-50.286 33.143s-25.143 30.286-33.143 50.286c-22.857 57.714-17.714 194.857-17.714 258.857s-5.143 201.143 17.714 258.857c8 20 17.714 34.857 33.143 50.286s30.286 25.143 50.286 33.143c57.714 22.857 194.857 17.714 258.857 17.714s201.143 5.143 258.857-17.714c20-8 34.857-17.714 50.286-33.143s25.143-30.286 33.143-50.286c22.857-57.714 17.714-194.857 17.714-258.857s5.143-201.143-17.714-258.857c-8-20-17.714-34.857-33.143-50.286s-30.286-25.143-50.286-33.143c-57.714-22.857-194.857-17.714-258.857-17.714zM877.714 512c0 60.571 0.571 120.571-2.857 181.143-3.429 70.286-19.429 132.571-70.857 184s-113.714 67.429-184 70.857c-60.571 3.429-120.571 2.857-181.143 2.857s-120.571 0.571-181.143-2.857c-70.286-3.429-132.571-19.429-184-70.857s-67.429-113.714-70.857-184c-3.429-60.571-2.857-120.571-2.857-181.143s-0.571-120.571 2.857-181.143c3.429-70.286 19.429-132.571 70.857-184s113.714-67.429 184-70.857c60.571-3.429 120.571-2.857 181.143-2.857s120.571-0.571 181.143 2.857c70.286 3.429 132.571 19.429 184 70.857s67.429 113.714 70.857 184c3.429 60.571 2.857 120.571 2.857 181.143z"
                ></path>
              </svg>
            </button>
            <button class="collapsibles-button5 button">
              <svg
                viewBox="0 0 602.2582857142856 1024"
                class="collapsibles-icon2"
              >
                <path
                  d="M548 6.857v150.857h-89.714c-70.286 0-83.429 33.714-83.429 82.286v108h167.429l-22.286 169.143h-145.143v433.714h-174.857v-433.714h-145.714v-169.143h145.714v-124.571c0-144.571 88.571-223.429 217.714-223.429 61.714 0 114.857 4.571 130.286 6.857z"
                ></path>
              </svg>
            </button>
            <button class="collapsibles-button6 button">
              <svg
                viewBox="0 0 877.7142857142857 1024"
                class="collapsibles-icon4"
              >
                <path
                  d="M438.857 73.143c242.286 0 438.857 196.571 438.857 438.857 0 193.714-125.714 358.286-300 416.571-22.286 4-30.286-9.714-30.286-21.143 0-14.286 0.571-61.714 0.571-120.571 0-41.143-13.714-67.429-29.714-81.143 97.714-10.857 200.571-48 200.571-216.571 0-48-17.143-86.857-45.143-117.714 4.571-11.429 19.429-56-4.571-116.571-36.571-11.429-120.571 45.143-120.571 45.143-34.857-9.714-72.571-14.857-109.714-14.857s-74.857 5.143-109.714 14.857c0 0-84-56.571-120.571-45.143-24 60.571-9.143 105.143-4.571 116.571-28 30.857-45.143 69.714-45.143 117.714 0 168 102.286 205.714 200 216.571-12.571 11.429-24 30.857-28 58.857-25.143 11.429-89.143 30.857-127.429-36.571-24-41.714-67.429-45.143-67.429-45.143-42.857-0.571-2.857 26.857-2.857 26.857 28.571 13.143 48.571 64 48.571 64 25.714 78.286 148 52 148 52 0 36.571 0.571 70.857 0.571 81.714 0 11.429-8 25.143-30.286 21.143-174.286-58.286-300-222.857-300-416.571 0-242.286 196.571-438.857 438.857-438.857zM166.286 703.429c1.143-2.286-0.571-5.143-4-6.857-3.429-1.143-6.286-0.571-7.429 1.143-1.143 2.286 0.571 5.143 4 6.857 2.857 1.714 6.286 1.143 7.429-1.143zM184 722.857c2.286-1.714 1.714-5.714-1.143-9.143-2.857-2.857-6.857-4-9.143-1.714-2.286 1.714-1.714 5.714 1.143 9.143 2.857 2.857 6.857 4 9.143 1.714zM201.143 748.571c2.857-2.286 2.857-6.857 0-10.857-2.286-4-6.857-5.714-9.714-3.429-2.857 1.714-2.857 6.286 0 10.286s7.429 5.714 9.714 4zM225.143 772.571c2.286-2.286 1.143-7.429-2.286-10.857-4-4-9.143-4.571-11.429-1.714-2.857 2.286-1.714 7.429 2.286 10.857 4 4 9.143 4.571 11.429 1.714zM257.714 786.857c1.143-3.429-2.286-7.429-7.429-9.143-4.571-1.143-9.714 0.571-10.857 4s2.286 7.429 7.429 8.571c4.571 1.714 9.714 0 10.857-3.429zM293.714 789.714c0-4-4.571-6.857-9.714-6.286-5.143 0-9.143 2.857-9.143 6.286 0 4 4 6.857 9.714 6.286 5.143 0 9.143-2.857 9.143-6.286zM326.857 784c-0.571-3.429-5.143-5.714-10.286-5.143-5.143 1.143-8.571 4.571-8 8.571 0.571 3.429 5.143 5.714 10.286 4.571s8.571-4.571 8-8z"
                ></path>
              </svg>
            </button>
          </div>
        </footer>
        <button class="collapsibles-button7 button"><a href="menu.php">Back</a></button>
      </div>
    </div>

    <script type="text/javascript" src="notes2.js"></script>
    <script type="text/javascript">
      if(<?php echo $Enota; ?>){
          document.getElementById('principal').style.display = "none";
          document.getElementById('search').style.display = "none";
          document.getElementById('Edit').style.display = "block";
          document.getElementById('descripcion').setAttribute('value','<?php echo $SEdit->descripcion ?>');
          document.getElementById('porcentaje').setAttribute('value','<?php echo $SEdit->porcentaje ?>');
          document.getElementById('Fbedit').setAttribute('value','<?php echo $Enota ?>');
      }


    </script>
  </body>
</html>
