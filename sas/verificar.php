<?php 
@session_start();
$id_empresa = @$_SESSION['id_empresa']; 
?>
<script type="text/javascript">
	if(localStorage.nivel_usu.trim() != 'SAS'){
		window.location="../index.php";
	}

	var id_empresa = "<?=$id_empresa?>";
	if(id_empresa != "" && id_empresa != localStorage.id_empresa){
		window.location="../index.php";
	}
	
</script>


