<?php include("templade/cabecera.php"); ?>

<?php 
include("administrador/config/bd.php");

$sentenciaSQL=$conexion->prepare("SELECT * FROM pedido");
$sentenciaSQL->execute();
$listaPedido=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>


<?php foreach($listaPedido as $pedido ){ ?>
<div class="col-md-3">
<div class="card">
	<img class="card-img-top" src="./img/<?php echo $pedido['imagen']; ?>" alt="">
	<div class="card-body">
		<h4 class="card-title"><?php echo $pedido['nombre']; ?></h4>
		<a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>
	</div>
</div>
</div>

<?php } ?>


<?php include("templade/pie.php"); ?>   