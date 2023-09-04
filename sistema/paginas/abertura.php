<?php 
$pag = 'abertura';

//verificar se ele tem a permissão de estar nessa página
if(@$abertura == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}


//VERIFICAR SE O USUÁRIO JÁ TEM CAIXA OPERANDO
$query = $pdo->query("SELECT * FROM caixas where empresa = '$id_empresa' and status = 'Aberto' and usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
echo '<script>window.location="paginas/pdv.php"</script>';
}

 ?>



<div class="bs-example widget-shadow" style="padding:20px">
	<form id="form-ab">
	<div class="row">
						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Caixa</label> 
									<select class="form-control" name="caixa" style="width:100%;" required> 
									<option value="">Selecione um Caixa</option>
									<?php 
									$query = $pdo->query("SELECT * FROM caixas where empresa = '$id_empresa' and status = 'Fechado'");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>
						<div class="col-md-2">
							<div class="form-group"> 
								<label>Valor Abertura</label> 
								<input type="text" class="form-control" name="valor" id="valor_abertura"  required> 
							</div>
						</div>


						<div class="col-md-3">						
							<div class="form-group"> 
								<label>Gerente</label> 
									<select class="form-control" name="gerente" style="width:100%;" required> 
									<option value="">Selecione um Gerente</option>
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and (nivel = 'Administrador' or nivel = 'Gerente') and ativo = 'Sim'");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>	


							<div class="col-md-2">
							<div class="form-group"> 
								<label>Senha Gerente</label> 
								<input type="password" class="form-control" name="senha" id="senha_gerente"  required> 
							</div>
						</div>

							

						<div class="col-md-2">										
								<button type="submit" class="btn btn-primary" style="margin-top:20px">Abrir</button>							
						</div>

						<br>
						

					</div>

					<small><div id="mensagem" align="center"></div></small>

					<input type="hidden" name="id_usuario" id="id_usuario">
					<input type="hidden" name="id_empresa" id="id_empresa">


				</form>
</div>


<div class="main-page" style="margin-top: 20px">
	<div class="col_3">

		<?php 
			$query = $pdo->query("SELECT * FROM caixas where empresa = '$id_empresa' order by id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

	for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$status = $res[$i]['status'];
$usuario = $res[$i]['usuario'];

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$operador = @$res2[0]['nome'];
}else{
	$operador = 'Sem Operador';
}


if($status == 'Fechado'){
	$classe_status = 'red';
	$icone = 'icone-reg.png';
}else{
	$classe_status = 'green';
	$icone = 'icone-reg2.png';
}

		 ?>

		<div class="col-md-3 widget widget10">
			<div class="r3_counter_box">
				<img src="images/<?php echo $icone ?>" width="80px" class="pull-left">
				<div class="stats" align="center" style="margin-top: 10px">
					<h5><strong><?php echo $nome ?></strong></h5>
					<span style="color:<?php echo $classe_status ?>"><small>(<?php echo $status ?>)</small></span>			
				</div>
				
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important"><img src="images/icone-usu.jpg" width="20px"><small><?php echo $operador ?></small></span></div>
			</div>
		</div>

<?php } } ?>


	</div>
</div>


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>


 <script type="text/javascript">
	$(document).ready( function () {
    	$('#id_usuario').val(localStorage.id_usu);
    	$('#id_empresa').val(localStorage.id_empresa);
    	$('#senha_gerente').val('');
} );



$("#form-ab").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/salvar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                //redirecionar para tela do pdv
                window.location="paginas/pdv.php";
                //location.reload();

            } else {

                $('#mensagem').addClass('text-danger')
                $('#mensagem').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});

</script>