<?php include("../templade/cabecera.php"); ?>
<?php

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:""; 
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:""; 
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:""; 
$accion=(isset($_POST['accion']))?$_POST['accion']:""; 

include("../config/bd.php");

switch($accion){
    case"Agregar": 
    $sentenciaSQL=$conexion->prepare("INSERT INTO pedido (nombre, imagen) VALUES (:nombre, :imagen);");
    $sentenciaSQL->bindParam(':nombre',$txtNombre);

    $fecha= new DateTime();
    $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

    $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

    if($tmpImagen!=""){
      move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
    }

    $sentenciaSQL->bindParam(':imagen',$nombreArchivo );
    $sentenciaSQL->execute();
    header("Location:productos.php");
    break;
    case"Modificar": 
       
      $sentenciaSQL=$conexion->prepare("UPDATE pedido SET nombre=:nombre WHERE id=:id");
      $sentenciaSQL->bindParam(':nombre',$txtNombre);
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();

      if($txtImagen!=""){

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM pedido WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $pedido=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        if(isset($pedido["imagen"]) &&($pedido["imagen"]!="imagen.jpg")){

        if(file_exists("../../img/".$pedido["imagen"])){
          unlink("../../img/".$pedido["imagen"]);
           }

        }


      $sentenciaSQL=$conexion->prepare("UPDATE pedido SET imagen=:imagen WHERE id=:id");
      $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();
    }
    header("Location:productos.php");
      break;
    case"Cancelar": 
      header("Location:productos.php");
      break;
    case"Seleccionar": 
      $sentenciaSQL=$conexion->prepare("SELECT * FROM pedido WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();
      $pedido=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
 
      $txtNombre=$pedido['nombre'];
      $txtImagen=$pedido['imagen'];
      //echo"Presionado bot??n Seleccionar";
        break;
    case"Borrar": 
    

    
      $sentenciaSQL=$conexion->prepare("DELETE FROM pedido WHERE id=:id");
      $sentenciaSQL->bindParam(':id',$txtID);
      $sentenciaSQL->execute();
      header("Location:productos.php");
        break;
}
$sentenciaSQL=$conexion->prepare("SELECT * FROM pedido");
$sentenciaSQL->execute();
$listaPedido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="col-md-5">

   <div class="card">
     <div class="card-header">
       Datos de Producto
     </div>

     <div class="card-body">
      <form method="POST" enctype="multipart/form-data">

           <div class="mb-3"> 
                <label for="txtID">ID:</label>
                <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
           </div>

           <div class="mb-3"> 
                <label for="txtNombre" class="form-label">Nombre:</label>
                <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Producto">
           </div>

           <div class="mb-3">
                <label for="txtImagen"  class="form-label">Imagen:</label>
</br>

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

       </form>
     </div>
     
   </div>


</div>

<br/>
<div class="col-md-12">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Imagen</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($listaPedido as $pedido){ ?>
        <tr>
          <td><?php echo $pedido['id']; ?></td>
          <td><?php echo $pedido['nombre']; ?></td>
          <td>


          <img src="../../img/<?php echo $pedido['imagen']; ?>" width="100" alt="" srcset="">

            
          </td>
          <td>


            
            <form method="post">

                   <input type="hidden" name="txtID" id="txtID" value="<?php echo $pedido['id']; ?>"/>

                   <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary"/>

                   <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>

            </form>


          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
</div>


<?php include("../templade/pie.php"); ?>
