<?php 
$pag = 'saidas';

//verificar se ele tem a permissão de estar nessa página
if(@$saidas == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}
 ?>

 <a href="index.php?pagina=produtos" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Saída Produtos</a>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>

<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

