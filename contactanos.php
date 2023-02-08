<?php include("templade/cabecera.php"); ?>
<body>
 <form class="formulario" method="POST" action="guardarcontactenos.php">
    
      <h1>Contactanos</h1>
      <div class="contenedor">
      
      <div class="input-contenedor">
            <i class="fas fa-user icon"></i>
            <input type="text" name="txtnombre"  id="txtnombre" placeholder="Nombre Completo">
            
            </div>

            <div class="input-contenedor">
               <i class="fas fa-user icon"></i>
               <input type="text" name="txtapellido" id="txtapellido" placeholder="Apellido Completo">
               
            </div>
            
            <div class="input-contenedor">
            <i class="fas fa-envelope icon"></i>
            <input type="text" name="txtcorreo" id="txtcorreo" placeholder="Correo Electronico">
            
            </div>
            
            <div class="input-contenedor">
         <i class="fas fa-phone icon"></i>
            <input type="text"  maxlength="9" name="txttelefono" placeholder="Telefono">

            </div>

            <div class="input-contenedor">
               <i class="fas fa-calendar icon"></i>
               <input type="date" id="date" name="txtfecha">

               </div>


               <div class="input-contenedor">
                     <i class="fas fa-envelope icon"></i>
                        <textarea type="text" name="txtcomentarios" rows="12" cols="52" placeholder="Comentarios"></textarea>
         
               </div>

            
            </div>
            <input type="submit" value="Enviar" class="button">
            <p>Al Contactarnos, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
            <p>Muchas Gracias por su aporte</p>
      </div>
      </form>
      
   </body>

<?php include("templade/pie.php"); ?>   