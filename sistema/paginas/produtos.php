<?php 
$pag = 'produtos';

//verificar se ele tem a permissão de estar nessa página
if(@$produtos == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

 ?>

 <a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Novo Produto</a>


<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>



<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-3">							
								<label>Código</label>
								<input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código de Barras" required onKeyup="gerarCodigo()">							
						</div>

						<div class="col-md-3">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
						</div>

						<div class="col-md-3">							
								<label>Categoria</label>
								<select class="form-control sel2" name="categoria" id="categoria" style="width:100%;"> 		
								<option value="0">Selecionar Categoria</option>							
									<?php 
									$query = $pdo->query("SELECT * FROM categorias where empresa = '$id_empresa' and ativo = 'Sim'  order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>								
						</div>

							<div class="col-md-3">							
								<label>Estoque Mínimo</label>
								<input type="text" class="form-control" id="nivel_estoque" name="nivel_estoque" placeholder="Nível Estoque" required>							
						</div>

						
					</div>


					<div class="row">
						<div class="col-md-3">							
								<label>Valor Venda</label>
								<input type="text" class="form-control" id="valor_venda" name="valor_venda" placeholder="Valor Venda" >							
						</div>

						<div class="col-md-3">							
								<label>Fornecedor</label>
									<select class="form-control sel2" name="fornecedor" id="fornecedor" style="width:100%;"> 
									<option value="0">Selecionar Fornecedor</option>								
									<?php 
									$query = $pdo->query("SELECT * FROM fornecedores where empresa = '$id_empresa'  order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>							
						</div>


						<div class="col-md-4">						
								<div class="form-group"> 
									<label>Foto do Produto</label> 
									<input class="form-control" type="file" name="foto" onChange="carregarImg();" id="foto">
								</div>						
							</div>
							<div class="col-md-2" >
								<div id="divImg">
									<img src=""  width="100px" id="target" style="margin-top: 20px">									
								</div>
							</div>

					

						
					</div>

					<div id="listar-codigo"></div>
					


					<input type="hidden" name="id" id="id">
					<input type="hidden" name="id_empresa" id="id_empresa">
				

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>






<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>			
			<div class="modal-body">	
					
					<div class="row" style="margin-top: 0px">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Código: </b></span><span id="codigo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Categoria: </b></span><span id="categoria_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Valor Venda: </b></span><span id="venda_dados"></span>
					</div>

					

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Valor Compra </b></span><span id="compra_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Lucro: </b></span><span id="lucro_dados"></span>%
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Fornecedor: </b></span><span id="fornecedor_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_cad_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Estoque: </b></span><span id="estoque_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Nível Estoque: </b></span><span id="nivel_estoque_dados"></span>
					</div>

					<br><br><br>
					<div class="col-md-12" style="margin-bottom: 5px" align="center">
						<img width="200px" id="target_mostrar">	
					</div>

					
				</div>
					
			</div>	

			

		</div>
	</div>
</div>






<!-- Modal etiquetas -->
<div class="modal fade" id="modalEtiquetas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo-etiquetas"></span></h4>
				<button id="btn-fechar-etiquetas" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="barras/barcode.php" method="post" target="_blank">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-8">							
								<label>Quantidade Gerada</label>
								<input type="text" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade de etiquetas" required >							
						</div>

						<div class="col-md-4">							
								<button type="submit" class="btn btn-primary" style="margin-top: 20px">Gerar Etiquetas</button>					
						</div>

					</div>

						
						


					<input type="hidden" name="id" id="id-etiqueta">
					<input type="hidden" name="codigo" id="codigo-etiqueta">
					<input type="hidden" name="valor" id="valor-etiqueta">
					<input type="hidden" name="nome" id="nome-etiqueta">
				

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>


		
			</form>
		</div>
	</div>
</div>







<!-- Modal comprar -->
<div class="modal fade" id="modalComprar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo-comprar"></span></h4>
				<button id="btn-fechar-comprar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-comprar">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-4">							
								<label>Quantidade</label>
								<input type="number" class="form-control" id="quantidade_comprar" name="quantidade" placeholder="Quantidade de Produtos"  onKeyup="calcular()" onchange="calcular()" required>							
						</div>

						<div class="col-md-4">							
								<label>Total Compra</label>
								<input type="text" class="form-control" id="total_compra" name="total_compra" placeholder="Total da Compra"  onKeyup="calcular()" required>							
						</div>

						<div class="col-md-4">							
								<label>Valor Unit Compra</label>
								<input type="text" class="form-control" id="valor_compra" name="valor_compra" placeholder="Valor Unitário"  >							
						</div>

					</div>

					<div class="row">
						<div class="col-md-4">							
								<label>Lucro %</label>
								<input type="text" class="form-control" id="valor_lucro" name="valor_lucro" placeholder="Valor em Porcentagem" onKeyup="calcular()">							
						</div>

						<div class="col-md-8">							
								<label>Fornecedor</label>
								<select class="form-control sel3" name="fornecedor" id="fornecedor_comprar" style="width:100%;"> 
									<option value="0">Selecionar Fornecedor</option>								
									<?php 
									$query = $pdo->query("SELECT * FROM fornecedores where empresa = '$id_empresa'  order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>								
						</div>


					</div>


					<div class="row">


						<div class="col-md-6">							
								<label>Valor Venda</label>
								<input type="text" class="form-control" id="valor_venda_comprar" name="valor_venda" placeholder="Valor Venda"  >							
						</div>

						<div class="col-md-6">		
							<label>Data PGTO</label>
								<input type="date" class="form-control" id="data_pgto" name="data_pgto" required>
						</div>

						</div>	

						<div id="grade-comprar-1" class="row">
						<div class="col-md-6">							
								<label>Grade</label>
								<select class="form-control sel3" name="cat_grade" id="cat_grade_comprar" style="width:100%;" onchange="alterarGrade('comprar')"> 
									
								</select>								
						</div>

						<div class="col-md-6">							
								<label>Itens Grade</label>
								<select class="form-control sel3" name="itens_grade" id="itens_grade_comprar" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>
					</div>


					


					<div class="row" id="grade-comprar-2">
						
						<div class="col-md-6">							
								<label>Grade 2 <small>(Se Houver)</small></label>
								<select class="form-control sel3" name="cat_grade2" id="cat_grade2_comprar" style="width:100%;" onchange="alterarGrade2('comprar')"> 
									
								</select>								
						</div>

						<div class="col-md-6">							
								<label>Itens Grade 2 <small>(Se Houver)</small></label>
								<select class="form-control sel3" name="itens_grade2" id="itens_grade2_comprar" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	
						


					<input type="hidden" name="id" id="id-comprar">
					<input type="hidden" name="id_empresa" id="id_empresa_comprar">
					<input type="hidden" name="id_usuario" id="id_usuario_comprar">
				

				<br>
				<small><div id="mensagem-comprar" align="center"></div></small>
			</div>

			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Comprar</button>
			</div>
		
			</form>
		</div>
	</div>
</div>










<!-- Modal grade -->
<div class="modal fade" id="modalGrade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo-grade"></span></h4>
				<button id="btn-fechar-grade" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-grade">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-9">	
								<input type="text" class="form-control" id="nome_grade" name="nome" placeholder="Cor, Tamanho, Numeração"  required>							
						</div>

						<div class="col-md-3">							
							<button type="submit" class="btn btn-primary" >Salvar</button>								
						</div>

						</div>


					<input type="hidden" name="id" id="id-grade">
					<input type="hidden" name="id_empresa" id="id_empresa_grade">
					<input type="hidden" name="id_usuario" id="id_usuario_grade">
				

				<br>
				<small><div id="mensagem-grade" align="center"></div></small>


				<hr>

					<div id="listar-grade"></div>

			</div>

		
		
			</form>
		</div>
	</div>
</div>






<!-- Modal itens grade -->
<div class="modal fade" id="modalItensGrade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo-itens-grade"></span></h4>
				<button id="btn-fechar-itens-grade" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-itens-grade">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-9">	
								<input type="text" class="form-control" id="nome_itens_grade" name="nome" placeholder="Vermelho, Verde"  required>							
						</div>

						<div class="col-md-3">							
							<button type="submit" class="btn btn-primary" >Salvar</button>								
						</div>

						</div>


					<input type="hidden" name="id" id="id-itens-grade">
					<input type="hidden" name="id_produto" id="id-itens-grade-produto">
					<input type="hidden" name="id_empresa" id="id_empresa_itens_grade">
					<input type="hidden" name="id_usuario" id="id_usuario_itens_grade">
				

				<br>
				<small><div id="mensagem-itens-grade" align="center"></div></small>


				<hr>

					<div id="listar-itens-grade"></div>

			</div>

		
		
			</form>
		</div>
	</div>
</div>









<!-- Modal entrada prod -->
<div class="modal fade" id="modalEntrada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Entrada: <span id="titulo-entrada"></span></h4>
				<button id="btn-fechar-entrada" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-entrada">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-3">							
								<label>Quantidade</label>
								<input type="number" class="form-control" id="quantidade_entrada" name="quantidade" placeholder="Quantidade de Produtos"  required>							
						</div>

						<div class="col-md-9">							
								<label>Motivo</label>
								<input type="text" class="form-control" id="motivo_entrada" name="motivo" placeholder="Produto Devolvido, Encontrado, etc"  required>							
						</div>

						

					</div>

				


					<div class="row" id="grade-entrada-1">
						

						<div class="col-md-6">							
								<label>Grade</label>
								<select class="form-control sel4" name="cat_grade" id="cat_grade_entrada" style="width:100%;" onchange="alterarGrade('entrada')"> 
									
								</select>								
						</div>

						<div class="col-md-6">							
								<label>Itens Grade</label>
								<select class="form-control sel4" name="itens_grade" id="itens_grade_entrada" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	


					<div class="row" id="grade-entrada-2">
						
						<div class="col-md-6">							
								<label>Grade 2 <small>(Se Houver)</small></label>
								<select class="form-control sel4" name="cat_grade2" id="cat_grade2_entrada" style="width:100%;" onchange="alterarGrade2('entrada')"> 
									
								</select>								
						</div>

						<div class="col-md-6">							
								<label>Itens Grade 2 <small>(Se Houver)</small></label>
								<select class="form-control sel4" name="itens_grade2" id="itens_grade2_entrada" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	


					<div class="row">
						<div class="col-md-12">							
								<div class="form-check">
							  <input class="form-check-input" name="estoque" id="estoque_check" type="checkbox" value="Sim">
							  <label class="form-check-label" for="flexCheckDefault">
							    Alterar o estoque Geral dos Produtos? <small>(Somente se não entrou pela Venda)</small>
							  </label>
							</div>							
						</div>
					</div>
						


					<input type="hidden" name="id" id="id-entrada">
					<input type="hidden" name="id_empresa" id="id_empresa_entrada">
					<input type="hidden" name="id_usuario" id="id_usuario_entrada">
				

				<br>
				<small><div id="mensagem-entrada" align="center"></div></small>
			</div>

			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Entrada</button>
			</div>
		
			</form>
		</div>
	</div>
</div>








<!-- Modal saida prod -->
<div class="modal fade" id="modalSaida" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Saída: <span id="titulo-saida"></span></h4>
				<button id="btn-fechar-saida" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-saida">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-3">							
								<label>Quantidade</label>
								<input type="number" class="form-control" id="quantidade_saida" name="quantidade" placeholder="Quantidade de Produtos"  required>							
						</div>

						<div class="col-md-9">							
								<label>Motivo</label>
								<input type="text" class="form-control" id="motivo_saida" name="motivo" placeholder="Produto Devolvido, Encontrado, etc"  required>							
						</div>

						

					</div>

				


					<div class="row" id="grade-saida-1">
						

						<div class="col-md-6">							
								<label>Grade</label>
								<select class="form-control sel5" name="cat_grade" id="cat_grade_saida" style="width:100%;" onchange="alterarGrade('saida')"> 
									
								</select>								
						</div>

						<div class="col-md-6">							
								<label>Itens Grade</label>
								<select class="form-control sel5" name="itens_grade" id="itens_grade_saida" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	


					<div class="row" id="grade-saida-2">
						
						<div class="col-md-6">							
								<label>Grade 2 <small>(Se Houver)</small></label>
								<select class="form-control sel5" name="cat_grade2" id="cat_grade2_saida" style="width:100%;" onchange="alterarGrade2('saida')"> 
									
								</select>								
						</div>

						<div class="col-md-6">							
								<label>Itens Grade 2 <small>(Se Houver)</small></label>
								<select class="form-control sel5" name="itens_grade2" id="itens_grade2_saida" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	


						


					<input type="hidden" name="id" id="id-saida">
					<input type="hidden" name="id_empresa" id="id_empresa_saida">
					<input type="hidden" name="id_usuario" id="id_usuario_saida">
				

				<br>
				<small><div id="mensagem-saida" align="center"></div></small>
			</div>

			<div class="modal-footer">       
				<button type="submit" class="btn btn-danger">Saída</button>
			</div>
		
			</form>
		</div>
	</div>
</div>




<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
    $('.sel2').select2({
    	dropdownParent: $('#modalForm')
    });

    $('.sel3').select2({
    	dropdownParent: $('#modalComprar')
    });

     $('.sel4').select2({
    	dropdownParent: $('#modalEntrada')
    });

      $('.sel5').select2({
    	dropdownParent: $('#modalSaida')
    });
});
</script>





<script type="text/javascript">
	function carregarImg() {
    var target = document.getElementById('target');
    var file = document.querySelector("#foto").files[0];
    
        var reader = new FileReader();

        reader.onloadend = function () {
            target.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);

        } else {
            target.src = "";
        }
    }
</script>


<script type="text/javascript">
	function gerarCodigo(){
		var codigo = $('#codigo').val();

		
		    $.ajax({
		        url: 'paginas/' + pag + "/gerar-codigo.php",
		        method: 'POST',
		        data: {codigo},
		        dataType: "html",

		        success:function(result){
		            $("#listar-codigo").html(result);
		           
		        }
		    });
		
	}



function calcular(){
		var lucro = $('#valor_lucro').val();
		var venda = $('#valor_venda_comprar').val();
		var compra = $('#valor_compra').val();
		var qtd = $('#quantidade_comprar').val();
		var total_compra = $('#total_compra').val();

		lucro = lucro.replace('%', '');		
		lucro = lucro.replace(',', '.');

		venda = venda.replace('.', '');
		venda = venda.replace(',', '.');

		compra = compra.replace('.', '');
		compra = compra.replace(',', '.');

		total_compra = total_compra.replace('.', '');
		total_compra = total_compra.replace(',', '.');

		if(lucro == ""){
			lucro = 0;
		}

		if(venda == ""){
			venda = 0;
		}

		if(compra == ""){
			compra = 0;
		}

		if(qtd == ""){
			qtd = 0;
		}

		if(total_compra == ""){
			total_compra = 0;
		}


		var vlr_unit = parseFloat(total_compra) / parseFloat(qtd);
		$('#valor_compra').val(vlr_unit.toFixed(2));

		var vlr_venda = parseFloat(vlr_unit) + (parseFloat(vlr_unit) * parseFloat(lucro)) / 100;
		$('#valor_venda_comprar').val(vlr_venda.toFixed(2));

		
	}




$("#form-comprar").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/comprar.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-comprar').text('');
            $('#mensagem-comprar').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-comprar').click();
                listar();          

            } else {

                $('#mensagem-comprar').addClass('text-danger')
                $('#mensagem-comprar').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});





$("#form-grade").submit(function () {
    var id_prod =  $("#id-grade").val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-grade.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-grade').text('');
            $('#mensagem-grade').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#nome_grade').val('');
                listarGrade(id_prod);          

            } else {

                $('#mensagem-grade').addClass('text-danger')
                $('#mensagem-grade').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});




	function listarGrade(id){
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/listar-grade.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){
            $("#listar-grade").html(result);           
        }
    });
}


function excluirGrade(id){	
	var id_usuario = localStorage.id_usu;
	var id_prod = $('#id-grade').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-grade.php",
        method: 'POST',
        data: {id, id_usuario},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarGrade(id_prod);
            } 
        }
    });
}






$("#form-itens-grade").submit(function () {
    var id_prod =  $("#id-itens-grade").val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-itens-grade.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-itens-grade').text('');
            $('#mensagem-itens-grade').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#nome_itens_grade').val('');
                listarItensGrade(id_prod);          

            } else {

                $('#mensagem-itens-grade').addClass('text-danger')
                $('#mensagem-itens-grade').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});




	function listarItensGrade(id){
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/listar-itens-grade.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){
            $("#listar-itens-grade").html(result);           
        }
    });
}


function excluirItensGrade(id){	
	var id_usuario = localStorage.id_usu;
	var id_prod = $('#id-itens-grade').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-itens-grade.php",
        method: 'POST',
        data: {id, id_usuario},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarItensGrade(id_prod);
            } 
        }
    });
}






	function listarSelectCatGrade(id, item){

    $.ajax({
        url: 'paginas/' + pag + "/select-cat-grade.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#cat_grade_"+item).html(result);           
        }
    });

   
}


function listarSelectItensGrade(id, item){

    $.ajax({
        url: 'paginas/' + pag + "/select-itens-grade.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#itens_grade_"+item).html(result);           
        }
    });
}


function alterarGrade(item){
	var id_grade = $("#cat_grade_"+item).val();
	var id_prod = $("#id-"+item).val();
    listarSelectItensGrade(id_grade, item);
    listarSelectCatGrade2(id_prod, item)
}






function listarSelectCatGrade2(id, item){
	var id_grade = $("#cat_grade_"+item).val();
    $.ajax({
        url: 'paginas/' + pag + "/select-cat-grade.php",
        method: 'POST',
        data: {id, id_grade},
        dataType: "html",

        success:function(result){        	
            $("#cat_grade2_"+item).html(result);           
        }
    });

   
}


function listarSelectItensGrade2(id, item){

    $.ajax({
        url: 'paginas/' + pag + "/select-itens-grade.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#itens_grade2_"+item).html(result);           
        }
    });
}


function alterarGrade2(item){
	var id_grade = $("#cat_grade2_"+item).val();
    listarSelectItensGrade2(id_grade, item);
}





$("#form-entrada").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/entrada.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-entrada').text('');
            $('#mensagem-entrada').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-entrada').click();
                listar();          

            } else {

                $('#mensagem-entrada').addClass('text-danger')
                $('#mensagem-entrada').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});





$("#form-saida").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/saida.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-saida').text('');
            $('#mensagem-saida').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                $('#btn-fechar-saida').click();
                listar();          

            } else {

                $('#mensagem-saida').addClass('text-danger')
                $('#mensagem-saida').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


</script>

