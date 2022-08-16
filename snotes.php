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

      $notasE = pg_query("SELECT SUM(porcentaje) AS prom FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo';");
      $snotasE = pg_fetch_object($notasE);
      $EditE = pg_query("SELECT porcentaje FROM notas WHERE cod_nota='$CodeE';");
      $SEditE = pg_fetch_object($EditE);

      $_SESSION['sporcentajeE'] = $snotasE->prom + $PorcentajeE - $SEditE->porcentaje;
      $sporcentajeE = $_SESSION['sporcentajeE'];


      if($sporcentajeE > 100){
        echo '<script language="javascript">alert("...SUPERANDO EL 100%...");</script>';
      }
      else{
        $sql = "UPDATE notas SET descripcion='$DescripcionE', porcentaje='$PorcentajeE' WHERE cod_nota='$CodeE';";
        pg_query($sql);
        header('location: snotes.php');
      }
    }
    if($_GET['bedit'] == 'bedit'){

      $Enota = $_GET['noteE'];
      $Edit = pg_query("SELECT descripcion, porcentaje FROM notas WHERE cod_nota='$Enota';");
      $SEdit = pg_fetch_object($Edit);
    }

    if($_GET['add'] == 'add') {
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $Descripcion = $_GET['descripcion'];
      $Porcentaje = $_GET['porcentaje'];
      $notas = pg_query("SELECT SUM(porcentaje) AS prom FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo';");
      if(!empty($notas)){
        $snotas = pg_fetch_object($notas);
        $_SESSION['sporcentaje'] = $snotas->prom + $Porcentaje;
        $sporcentaje = $_SESSION['sporcentaje'];
        if($sporcentaje > 100){
          echo '<script language="javascript">alert("Superando el 100%");</script>';
        }
        else{
          $sql = "INSERT INTO notas(descripcion, porcentaje, cod_curso, año, periodo) VALUES('$Descripcion', '$Porcentaje', '$Curso', '$Año', '$Periodo')";
          pg_query($sql);
          header('location: snotes.php');
        }
      }
      else{
        $sql = "INSERT INTO notas(descripcion, porcentaje, cod_curso, año, periodo) VALUES('$Descripcion', '$Porcentaje', '$Curso', '$Año', '$Periodo')";
        pg_query($sql);
        header('location: snotes.php');
      }
    }
    if($_GET['remove'] == 'remove') {
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $Nota = $_GET['note'];
      $sql = "DELETE FROM notas WHERE cod_curso='$Curso' AND cod_nota='$Nota' AND año='$Año' AND periodo='$Periodo';";
      pg_query($sql);
      header('location: snotes.php');
    }
    else{
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $getEstudiantes = "SELECT cod_nota, descripcion, porcentaje FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY cod_nota;";
      $query = pg_query($conexion,$getEstudiantes);
      $cantidad = pg_numrows($query);
    }

?>

<!DOCTYPE html>

<html lang="en">

<head>
  <title>Notes</title>
  <meta property="og:title" content="Notes" />
  <meta property="twitter:card" content="summary_large_image" />
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" data-tag="font" />
  <link rel="stylesheet" href="./style1.css" />
  <link rel="stylesheet" href="./stylen.css" />
  <link rel="stylesheet" href="./collapsibles.css" />
  <link rel="stylesheet" href="./students4.css" />
  <link rel="stylesheet" href="./studentC.css" />
  <link rel="stylesheet" href="./collapsiblen1.css" />
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
        <span class="students-text2">List of notes</span>
        <div class="collapsibles-container5">
          <button id="bAdd" class="collapsibles-button1 button">
            Add note
          </button>
          <?php 
                  if($cantidad == 0){
                      blank();
                  }
                  else{
              ?>
          <button id="bEdit" class="collapsibles-button1 button">
            Edit note
          </button>
          <button id="bRemove" class="collapsibles-button1 button">
            Delete note
          </button>
        </div>
        <div class="students-nav2">
          <table class="students-table">
            <thead>
              <tr>
                <th class="col">Code</th>
                <th class="col">Description</th>
                <th class="col">Percentage</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                          while($row = pg_fetch_assoc($query)){
                      ?>
              <tr>
                <td class="col"><?php echo $row['cod_nota']; ?></td>
                <td class="col"><?php echo $row['descripcion']; ?></td>
                <td class="col"><?php echo $row['porcentaje']; ?></td>
              </tr>
            </tbody>
            <?php
                      }}
                      function blank(){
                          echo "</div><div class='students-nav2'><h1>Blank list</h1>";
                      }
                  ?>
          </table>
        </div>
      </div>


      <div id="add" class="collapsiblen-container02">
        <div class="collapsiblen-container03">
          <form class="collapsiblen-form">
            <div class="collapsiblen-container04">
              <span class="collapsiblen-text03">Add note</span>
              <div class="collapsiblen-container05">
                <div class="collapsiblen-container06">
                  <span class="collapsiblen-text04">Note description</span>
                  <?php
                    if($sporcentaje > 100){
                  ?>
                  <input name="descripcion" type="text" required maxlength="100" placeholder="..." autocomplete="off" value="<?php echo $Descripcion; ?>" class="collapsiblen-textinput input" />
                  <?php
                    }
                    else{
                  ?>
                  <input name="descripcion" type="text" required maxlength="100" placeholder="..." autocomplete="off" class="collapsiblen-textinput input" />
                  <?php
                    }
                  ?>
                </div>
                <div class="collapsiblen-container07">
                  <span class="collapsiblen-text05">Percentage</span>
                  <input name="porcentaje" type="text" required maxlength="3" placeholder="%" autocomplete="off" class="collapsiblen-textinput1 input" />
                </div>
              </div>
              <button value="add" name="add" class="collapsiblen-button button">Continue</button>
            </div>
          </form>
          <button id="hAdd" class="collapsiblen-button01 button">x</button>
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
                  $getNotas = "SELECT cod_nota, descripcion FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' GROUP BY cod_nota, descripcion ORDER BY descripcion;";
                  $query = pg_query($getNotas);
                ?>
                <select name="noteE" class="collapsiblen-select">
                  <?php
                    while ($valores = pg_fetch_object($query)){
                  ?>
                  <option value="<?php echo $valores->cod_nota; ?>">
                    <?php 
                      echo $valores->descripcion; 
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
                  <span class="collapsiblen-text09">Note description</span>
                  <input name="descripcionE" id="descripcion" type="text" required maxlength="100" placeholder="..." autocomplete="off"
                    class="collapsiblen-textinput2 input" />
                </div>
                <div class="collapsiblen-container17">
                  <span class="collapsiblen-text10">Percentage</span>
                  <input name="porcentajeE" id="porcentaje" type="text" required maxlength="3" placeholder="%" autocomplete="off"
                    class="collapsiblen-textinput3 input" />
                </div>
              </div>
              <button name="Fbedit" id="Fbedit" type="submit" class="collapsiblen-button05 button">Continue</button>
            </div>
          </form>
          <button id="hEdit" class="collapsiblen-button06 button">x</button>
        </div>
      </div>


      <div id="remove" class="collapsiblen-container02">
        <div class="collapsiblen-container08">
          <form class="collapsiblen-form1">
            <div class="collapsiblen-container09">
              <span class="collapsiblen-text06">Delete note</span>
              <div class="collapsiblen-container10">
                <span class="collapsiblen-text07">Select the note</span>
                <?php
                  $getNotas = "SELECT cod_nota, descripcion FROM notas WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' GROUP BY cod_nota, descripcion ORDER BY descripcion;";
                  $query = pg_query($getNotas);
                ?>
                <select name="note" class="collapsiblen-select">
                  <?php
                    while ($valores = pg_fetch_object($query)){
                  ?>
                  <option value="<?php echo $valores->cod_nota; ?>">
                    <?php 
                      echo $valores->descripcion; 
                    ?>
                  </option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <button name="remove" value="remove" class="collapsiblen-button02 button">Continue</button>
            </div>
          </form>
          <button id="hRemove" class="collapsiblen-button03 button">x</button>
        </div>
      </div>

      <footer class="collapsibles-footer">
        <span class="collapsibles-text5">© 2022 Cristian Infante</span>
        <div class="collapsibles-icon-group">
          <button class="collapsibles-button4 button">
            <svg viewBox="0 0 877.7142857142857 1024" class="collapsibles-icon">
              <path
                d="M585.143 512c0-80.571-65.714-146.286-146.286-146.286s-146.286 65.714-146.286 146.286 65.714 146.286 146.286 146.286 146.286-65.714 146.286-146.286zM664 512c0 124.571-100.571 225.143-225.143 225.143s-225.143-100.571-225.143-225.143 100.571-225.143 225.143-225.143 225.143 100.571 225.143 225.143zM725.714 277.714c0 29.143-23.429 52.571-52.571 52.571s-52.571-23.429-52.571-52.571 23.429-52.571 52.571-52.571 52.571 23.429 52.571 52.571zM438.857 152c-64 0-201.143-5.143-258.857 17.714-20 8-34.857 17.714-50.286 33.143s-25.143 30.286-33.143 50.286c-22.857 57.714-17.714 194.857-17.714 258.857s-5.143 201.143 17.714 258.857c8 20 17.714 34.857 33.143 50.286s30.286 25.143 50.286 33.143c57.714 22.857 194.857 17.714 258.857 17.714s201.143 5.143 258.857-17.714c20-8 34.857-17.714 50.286-33.143s25.143-30.286 33.143-50.286c22.857-57.714 17.714-194.857 17.714-258.857s5.143-201.143-17.714-258.857c-8-20-17.714-34.857-33.143-50.286s-30.286-25.143-50.286-33.143c-57.714-22.857-194.857-17.714-258.857-17.714zM877.714 512c0 60.571 0.571 120.571-2.857 181.143-3.429 70.286-19.429 132.571-70.857 184s-113.714 67.429-184 70.857c-60.571 3.429-120.571 2.857-181.143 2.857s-120.571 0.571-181.143-2.857c-70.286-3.429-132.571-19.429-184-70.857s-67.429-113.714-70.857-184c-3.429-60.571-2.857-120.571-2.857-181.143s-0.571-120.571 2.857-181.143c3.429-70.286 19.429-132.571 70.857-184s113.714-67.429 184-70.857c60.571-3.429 120.571-2.857 181.143-2.857s120.571-0.571 181.143 2.857c70.286 3.429 132.571 19.429 184 70.857s67.429 113.714 70.857 184c3.429 60.571 2.857 120.571 2.857 181.143z">
              </path>
            </svg>
          </button>
          <button class="collapsibles-button5 button">
            <svg viewBox="0 0 602.2582857142856 1024" class="collapsibles-icon2">
              <path
                d="M548 6.857v150.857h-89.714c-70.286 0-83.429 33.714-83.429 82.286v108h167.429l-22.286 169.143h-145.143v433.714h-174.857v-433.714h-145.714v-169.143h145.714v-124.571c0-144.571 88.571-223.429 217.714-223.429 61.714 0 114.857 4.571 130.286 6.857z">
              </path>
            </svg>
          </button>
          <button class="collapsibles-button6 button">
            <svg viewBox="0 0 877.7142857142857 1024" class="collapsibles-icon4">
              <path
                d="M438.857 73.143c242.286 0 438.857 196.571 438.857 438.857 0 193.714-125.714 358.286-300 416.571-22.286 4-30.286-9.714-30.286-21.143 0-14.286 0.571-61.714 0.571-120.571 0-41.143-13.714-67.429-29.714-81.143 97.714-10.857 200.571-48 200.571-216.571 0-48-17.143-86.857-45.143-117.714 4.571-11.429 19.429-56-4.571-116.571-36.571-11.429-120.571 45.143-120.571 45.143-34.857-9.714-72.571-14.857-109.714-14.857s-74.857 5.143-109.714 14.857c0 0-84-56.571-120.571-45.143-24 60.571-9.143 105.143-4.571 116.571-28 30.857-45.143 69.714-45.143 117.714 0 168 102.286 205.714 200 216.571-12.571 11.429-24 30.857-28 58.857-25.143 11.429-89.143 30.857-127.429-36.571-24-41.714-67.429-45.143-67.429-45.143-42.857-0.571-2.857 26.857-2.857 26.857 28.571 13.143 48.571 64 48.571 64 25.714 78.286 148 52 148 52 0 36.571 0.571 70.857 0.571 81.714 0 11.429-8 25.143-30.286 21.143-174.286-58.286-300-222.857-300-416.571 0-242.286 196.571-438.857 438.857-438.857zM166.286 703.429c1.143-2.286-0.571-5.143-4-6.857-3.429-1.143-6.286-0.571-7.429 1.143-1.143 2.286 0.571 5.143 4 6.857 2.857 1.714 6.286 1.143 7.429-1.143zM184 722.857c2.286-1.714 1.714-5.714-1.143-9.143-2.857-2.857-6.857-4-9.143-1.714-2.286 1.714-1.714 5.714 1.143 9.143 2.857 2.857 6.857 4 9.143 1.714zM201.143 748.571c2.857-2.286 2.857-6.857 0-10.857-2.286-4-6.857-5.714-9.714-3.429-2.857 1.714-2.857 6.286 0 10.286s7.429 5.714 9.714 4zM225.143 772.571c2.286-2.286 1.143-7.429-2.286-10.857-4-4-9.143-4.571-11.429-1.714-2.857 2.286-1.714 7.429 2.286 10.857 4 4 9.143 4.571 11.429 1.714zM257.714 786.857c1.143-3.429-2.286-7.429-7.429-9.143-4.571-1.143-9.714 0.571-10.857 4s2.286 7.429 7.429 8.571c4.571 1.714 9.714 0 10.857-3.429zM293.714 789.714c0-4-4.571-6.857-9.714-6.286-5.143 0-9.143 2.857-9.143 6.286 0 4 4 6.857 9.714 6.286 5.143 0 9.143-2.857 9.143-6.286zM326.857 784c-0.571-3.429-5.143-5.714-10.286-5.143-5.143 1.143-8.571 4.571-8 8.571 0.571 3.429 5.143 5.714 10.286 4.571s8.571-4.571 8-8z">
              </path>
            </svg>
          </button>
        </div>
      </footer>
      <button class="collapsibles-button7 button"><a href="menu.php">Back</a></button>
    </div>
  </div>
  <script type="text/javascript" src="notes1.js"></script>
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
