<?php include("../templade/cabecera.php"); ?>
<?php

$txtIDEmpleado=(isset($_POST['txtIDEmpleado']))?$_POST['txtIDEmpleado']:""; 
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:""; 
$txtApellido=(isset($_POST['txtApellido']))?$_POST['txtApellido']:""; 
$txtGmail=(isset($_POST['txtGmail']))?$_POST['txtGmail']:""; 
$txtTelefono=(isset($_POST['txtTelefono']))?$_POST['txtTelefono']:"";
$txtDireccion=(isset($_POST['txtDireccion']))?$_POST['txtDireccion']:"";  
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:""; 
$accion=(isset($_POST['accion']))?$_POST['accion']:""; 

include("../config/bd.php");

switch($accion){
    case"Agregar": 
    $sentenciaSQL=$conexion->prepare("INSERT INTO empleado (nombre, apellido, gmail, telefono, direccion, imagen) VALUES (:nombre, :apellido, :gmail, :telefono, :direccion, :imagen);");
    $sentenciaSQL->bindParam(':nombre',$txtNombre);
    $sentenciaSQL->bindParam(':apellido',$txtApellido);
    $sentenciaSQL->bindParam(':gmail',$txtGmail);
    $sentenciaSQL->bindParam(':telefono',$txtTelefono);
    $sentenciaSQL->bindParam(':direccion',$txtDireccion);

    $fecha= new DateTime();
    $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

    $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

    if($tmpImagen!=""){
      move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
    }

    $sentenciaSQL->bindParam(':imagen',$nombreArchivo );
    $sentenciaSQL->execute();
    header("Location:empleado.php");
    break;
    case"Modificar": 
       
      $sentenciaSQL=$conexion->prepare("UPDATE empleado SET nombre=:nombre, apellido=:apellido, gmail=:gmail, telefono=:telefono, direccion=:direccion WHERE idempleado=:idempleado");
      $sentenciaSQL->bindParam(':nombre',$txtNombre);
      $sentenciaSQL->bindParam(':apellido',$txtApellido);
      $sentenciaSQL->bindParam(':gmail',$txtGmail);
      $sentenciaSQL->bindParam(':telefono',$txtTelefono);
      $sentenciaSQL->bindParam(':direccion',$txtDireccion);
      $sentenciaSQL->bindParam(':idempleado',$txtIDEmpleado);
      $sentenciaSQL->execute();

      if($txtImagen!=""){

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM empleado WHERE idempleado=:idempleado");
        $sentenciaSQL->bindParam(':idempleado',$txtIDEmpleado);
        $sentenciaSQL->execute();
        $empleado=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        if(isset($empleado["imagen"]) &&($empleado["imagen"]!="imagen.jpg")){

        if(file_exists("../../img/".$empleado["imagen"])){
          unlink("../../img/".$empleado["imagen"]);
           }

        }


      $sentenciaSQL=$conexion->prepare("UPDATE empleado SET imagen=:imagen WHERE idempleado=:idempleado");
      $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
      $sentenciaSQL->bindParam(':idempleado',$txtIDEmpleado);
      $sentenciaSQL->execute();
    }
    header("Location:empleado.php");
      break;
    case"Cancelar": 
      header("Location:empleado.php");
      break;
    case"Seleccionar": 
      $sentenciaSQL=$conexion->prepare("SELECT * FROM empleado WHERE idempleado=:idempleado");
      $sentenciaSQL->bindParam(':idempleado',$txtIDEmpleado);
      $sentenciaSQL->execute();
      $empleado=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
 
      $txtNombre=$empleado['nombre'];
      $txtApellido=$empleado['apellido'];
      $txtGmail=$empleado['gmail'];
      $txtTelefono=$empleado['telefono'];
      $txtDireccion=$empleado['direccion'];
      $txtImagen=$empleado['imagen'];
      
        break;
    case"Borrar": 
    
      $sentenciaSQL=$conexion->prepare("DELETE FROM empleado WHERE idempleado=:idempleado");
      $sentenciaSQL->bindParam(':idempleado',$txtIDEmpleado);
      $sentenciaSQL->execute();
      header("Location:empleado.php");
        break;
}
$sentenciaSQL=$conexion->prepare("SELECT * FROM empleado");
$sentenciaSQL->execute();
$listaEmpleado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="col-md-11">

  <div class="card">
    <div class="card-header">
       Datos de Empleado
    </div>
    <div class="card-body">
     <form method="POST" enctype="multipart/form-data" >
      
        
             <div class="mb-3"> 
               <label for="txtIDEmpleado">ID:</label>
               <input type="text" required readonly class="form-control" value="<?php echo $txtIDEmpleado; ?>" name="txtIDEmpleado" id="txtIDEmpleado" placeholder="ID">
             </div>

             <div class="mb-3"> 
               <label for="txtNombre" class="form-label">Nombres:</label>
               <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Empleado">
             </div>

             <div class="mb-3"> 
               <label for="txtApellido" class="form-label">Apellidos:</label>
               <input type="text" required class="form-control" value="<?php echo $txtApellido; ?>" name="txtApellido" id="txtApellido" placeholder="Apellido del Empleado">
             </div>

             <div class="mb-3"> 
               <label for="txtGmail" class="form-label">Gmail:</label>
               <input type="email" required class="form-control" value="<?php echo $txtGmail; ?>" name="txtGmail" id="txtGmail" placeholder="Gmail del Empleado">
             </div> 

             <div class="mb-3"> 
               <label for="txtTelefono" class="form-label">Telefono:</label>
               <input type="text" required class="form-control" maxlength="9" value="<?php echo $txtTelefono; ?>" name="txtTelefono" id="txtTelefono" placeholder="Telefono del Empleado">
             </div>

             <div class="mb-3"> 
               <label for="txtDireccion" class="form-label">Direccion:</label>
               <input type="text" required class="form-control" value="<?php echo $txtDireccion; ?>" name="txtDireccion" id="txtDireccion" placeholder="Direccion del Empleado">
             </div>

             <div class="mb-3">
                <label for="txtImagen"  class="form-label">Imagen:</label>
<br/>

                <?php if($txtImagen!=""){ ?>

                  <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen ?>" width="100" alt="" srcset="">

                <?php } ?>

                <input type="file"  class="form-control"  name="txtImagen" id="txtImagen" placeholder="Insertar Imagen">
           </div>

             <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" <?php echo($accion=="Seleccionar")?"disabled":""; ?> value="Agregar"  class="btn btn-success">Agregar</button>
                <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
             </div>
         </div>
      </form>
    </div>
  </div>

<br/>
    <div class="col-md-15">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombres</th>
          <th>Apellidos</th>
          <th>Gmail</th>
          <th>Telefono</th>
          <th>Direccion</th>
          <th>Imagen</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($listaEmpleado as $empleado){ ?>
        <tr>
          <td><?php echo $empleado['idempleado']; ?></td>
          <td><?php echo $empleado['nombre']; ?></td>
          <td><?php echo $empleado['apellido']; ?></td>
          <td><?php echo $empleado['gmail']; ?></td>
          <td><?php echo $empleado['telefono']; ?></td>
          <td><?php echo $empleado['direccion']; ?></td>
          <td>

          <img src="../../img/<?php echo $empleado['imagen']; ?>" width="100" alt="" srcset="">
   
          </td>
           <td>


            
            <form  method="post">

                   <input type="hidden" name="txtIDEmpleado" id="txtIDEmpleado" value="<?php echo $empleado['idempleado']; ?>"/>

                   <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                   <input type="submit" name="accion" value="Borrar"  class="btn btn-danger"/>

            </form>


          </td>
        </tr>
        <?php } ?>
      </tbody>
      <a href="../../reporte.php" target="_blank">REPORTE</a>
    </table>
</div>


<?php include("../templade/pie.php"); ?>