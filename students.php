<?php
    session_start();
    $usuario = $_SESSION['user_name'];
    $code = $_SESSION['user_code'];
    include_once("conexion_postgres.php");

    if(empty($usuario)){
        header("location: index.php");
    }
    if($_GET['add'] == 'add') {
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $Estudiante = $_GET['student'];
      $sql = "INSERT INTO inscripciones VALUES('$Curso','$Estudiante','$Año','$Periodo')";   
      pg_query($sql);
      header('location: students.php');
    }
    if($_GET['remove'] == 'remove') {
      $Curso = $_SESSION['curso'];
      $Periodo = $_SESSION['periodo'];
      $Año = $_SESSION['año'];
      $Estudiante = $_GET['student'];
      $sql = "DELETE FROM inscripciones WHERE cod_curso='$Curso' AND cod_estudiante='$Estudiante' AND año='$Año' AND periodo='$Periodo'";
      pg_query($sql);
      header('location: students.php');
    }
   else{
    $Curso = $_SESSION['curso'];
    $Periodo = $_SESSION['periodo'];
    $Año = $_SESSION['año'];
    $getEstudiantes = "SELECT e.cod_estudiante, e.nombre, e.apellido FROM estudiantes e JOIN inscripciones i ON e.cod_estudiante=i.cod_estudiante WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' ORDER BY e.cod_estudiante;";
    $query = pg_query($conexion,$getEstudiantes);
    $cantidad = pg_numrows($query);
  }

?>

<!DOCTYPE html>

<html lang="en">
  <head>
    <title>Students</title>
    <meta property="og:title" content="Students" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        data-tag="font" />
        
    <link rel="stylesheet" href="./style1.css" />
    <link href="./collapsibles.css" rel="stylesheet" />
    <link href="./students4.css" rel="stylesheet" />
    <link href="./studentS.css" rel="stylesheet" />
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
          <span class="students-text2">Enrolled students</span>
          <div class="collapsibles-container5">
          <button id="bAdd" class="collapsibles-button button">Add student</button>
              <?php 
                  if($cantidad == 0){
                      blank();
                  }
                  else{
              ?>
          <button id="bRemove" class="collapsibles-button1 button">
              Delete student
          </button>
          </div>
          <div class="students-nav2">
            <table class="students-table">
                  <thead>
                      <tr>
                          <th class="col">Code</th>
                          <th class="col">First name</th>
                          <th class="col">Last name</th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php 
                          while($row = pg_fetch_assoc($query)){
                      ?>
                      <tr>
                          <td class="col"><?php echo $row['cod_estudiante']; ?></td>
                          <td class="col"><?php echo $row['nombre']; ?></td>
                          <td class="col"><?php echo $row['apellido']; ?></td>
                      </tr>
                  <?php
                      }}
                      function blank(){
                          echo "</div><div class='students-nav2'><h1>Blank list</h1>";
                      }
                  ?>
                  </tbody>
            </table>
          </div>
        </div>


        <div id="add" class="collapsibles-container2">
          <div class="collapsibles-container3">
            <form class="collapsibles-form">
              <div class="collapsibles-container4">
                <span class="collapsibles-text3">Add student</span>
                <div class="collapsibles-container6">
                  <span class="collapsibles-text4">Select the student</span><?php 
                                    $getCursos = "SELECT cod_estudiante,nombre,apellido FROM estudiantes WHERE cod_estudiante NOT IN (select cod_estudiante FROM inscripciones WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo')";
                                    $query1 = pg_query($conexion,$getCursos);
                                ?>
                                <select name="student" id="student" class="collapsibles-select">
                                    <?php
                                        while ($valores = pg_fetch_object($query1)){
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
                <button name="add" id="addB" value="add" class="collapsibles-button2 button">Continue</button>
              </div>
            </form>
            <button id="hAdd" class="collapsibles-button3 button">x</button>
          </div>
        </div>


        <div id="remove" class="collapsibles-container7">
          <div class="collapsibles-container3">
            <form class="collapsibles-form">
              <div class="collapsibles-container4">
                <span class="collapsibles-text3">Delete student</span>
                <div class="collapsibles-container6">
                  <span class="collapsibles-text4">Select the student</span>
                                <?php 
                                    $getCursos = "SELECT e.cod_estudiante, e.nombre, e.apellido FROM estudiantes e JOIN inscripciones i ON e.cod_estudiante=i.cod_estudiante WHERE cod_curso='$Curso' AND año='$Año' AND periodo='$Periodo' GROUP BY e.cod_estudiante, e.nombre, e.apellido ORDER BY e.nombre;";
                                    $query = pg_query($conexion,$getCursos);
                                ?>
                                <select name="student" name="student" class="collapsibles-select">
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
                <button name="remove" id="removeB" value="remove" class="collapsibles-button2 button">Continue</button>
              </div>
            </form>
            <button id="hRemove" class="collapsibles-button3 button">x</button>
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
    <script type="text/javascript" src="students.js"></script>
  </body>
</html>
