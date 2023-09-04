<?php 
$pag = 'estoque';

//verificar se ele tem a permissão de estar nessa página
if(@$estoque == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

 ?>


<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
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
						<div class="col-md-3">							
								<label>Lucro %</label>
								<input type="text" class="form-control" id="valor_lucro" name="valor_lucro" placeholder="Valor em Porcentagem" onKeyup="calcular()">							
						</div>

						<div class="col-md-5">							
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

						<div class="col-md-4">							
								<label>Valor Venda</label>
								<input type="text" class="form-control" id="valor_venda_comprar" name="valor_venda" placeholder="Valor Venda"  >							
						</div>

					</div>


					<div class="row">
						<div class="col-md-4">		
							<label>Data PGTO</label>
								<input type="date" class="form-control" id="data_pgto" name="data_pgto" required>
						</div>

						<div class="col-md-4">							
								<label>Grade</label>
								<select class="form-control sel3" name="cat_grade" id="cat_grade_comprar" style="width:100%;" onchange="alterarGrade('comprar')"> 
									
								</select>								
						</div>

						<div class="col-md-4">							
								<label>Itens Grade</label>
								<select class="form-control sel3" name="itens_grade" id="itens_grade_comprar" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	


					<div class="row">
						
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

				


					<div class="row">
						

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


					<div class="row">
						
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

				


					<div class="row">
						

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


					<div class="row">
						
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

