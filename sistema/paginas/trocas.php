<?php 
$pag = 'trocas';

//verificar se ele tem a permissão de estar nessa página
if(@$trocas == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_hoje)));
$data_amanha = date('Y-m-d', strtotime("+1 days",strtotime($data_hoje)));

$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_inicio_mes = $ano_atual."-".$mes_atual."-01";

if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
    $dia_final_mes = '30';
}else if($mes_atual == '2'){
    $dia_final_mes = '28';
}else{
    $dia_final_mes = '31';
}

$data_final_mes = $ano_atual."-".$mes_atual."-".$dia_final_mes;

 ?>


<div class="row">
	<div class="col-md-12">
		
		<div style="float:left; margin-right:35px">
			<a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Troca</a>
		</div>

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Inicial" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:20px">
			<input type="date" class="form-control " name="data-inicial"  id="data-inicial" value="<?php echo $data_inicio_mes ?>" required onchange="listar()">
		</div>

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Final" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:30px">
			<input type="date" class="form-control " name="data-final"  id="data-final" value="<?php echo $data_final_mes ?>" required onchange="listar()">
		</div>


		

		<div style="margin-top:5px;"> 
		<small >			
			<a title="Trocas Hoje" class="text-muted" href="#" onclick="alterarData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> / 
			<a title="Trocas de Ontem" class="text-muted" href="#" onclick="alterarData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> /
			<a title="Contas à Pagar Mês" class="text-muted" href="#" onclick="alterarData('<?php echo $data_inicio_mes ?>', '<?php echo $data_final_mes ?>')"><span>Mês</span></a>
		</small>
		</div>

		
	</div>

	
</div>


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
						<div class="col-md-4">		
							<label>Clientes</label>
									<select class="form-control sel2" name="cliente" id="cliente" style="width:100%;" onchange="listarClientes()"> 		
								<option value="">Selecionar Cliente</option>							
									<?php 
									$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa'  order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>		
						</div>

						<div class="col-md-4">							
								<label>CPF Cliente</label>
								<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF do Cliente" required onKeyup="listarClientesCpf()">							
						</div>

						<div class="col-md-4">							
								<label>Nome Cliente</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome Cliente" required>							
						</div>

						
						
				</div>
				

					
					<div class="row">
						<div class="col-md-4">		
							<label>Produto Entrada</label>
									<select class="form-control sel2" name="produto_entrada" id="produto_entrada" style="width:100%;" required onchange="listarGradeEntrada()"> 		
								<option value="">Selecionar Produto</option>							
									<?php 
									$query = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' and ativo = 'Sim'  order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>		
						</div>

						<div class="col-md-2" id="grade-entrada-1">							
								<label>Grade 1</label>
								<select class="form-control " name="cat_grade_entrada" id="cat_grade_entrada" style="width:100%;" onchange="alterarGradeEntrada()"> 
									
								</select>								
						</div>

						<div class="col-md-2" id="cat-entrada-1">							
								<label>Itens Grade 1</label>
								<select class="form-control " name="itens_grade_entrada" id="itens_grade_entrada" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>

						<div class="col-md-2" id="grade-entrada-2">							
								<label>Grade 2</label>
								<select class="form-control " name="cat_grade_entrada2" id="cat_grade_entrada2" style="width:100%;" onchange="alterarGradeEntrada2()"> 
									
								</select>								
						</div>

						<div class="col-md-2" id="cat-entrada-2">							
								<label>Itens Grade 2</label>
								<select class="form-control " name="itens_grade_entrada2" id="itens_grade_entrada2" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	


					
							<div class="row">
						<div class="col-md-4">		
							<label>Produto Saída</label>
									<select class="form-control sel2" name="produto_saida" id="produto_saida" style="width:100%;" required onchange="listarGradeSaida()"> 		
								<option value="">Selecionar Produto</option>							
									<?php 
									$query = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' and ativo = 'Sim'  order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>		
						</div>

						<div class="col-md-2" id="grade-saida-1">							
								<label>Grade 1</label>
								<select class="form-control " name="cat_grade_saida" id="cat_grade_saida" style="width:100%;" onchange="alterarGradeSaida()"> 
									
								</select>								
						</div>

						<div class="col-md-2" id="cat-saida-1">							
								<label>Itens Grade 1</label>
								<select class="form-control " name="itens_grade_saida" id="itens_grade_saida" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>

						<div class="col-md-2" id="grade-saida-2">							
								<label>Grade 2</label>
								<select class="form-control " name="cat_grade_saida2" id="cat_grade_saida2" style="width:100%;" onchange="alterarGradeSaida2()"> 
									
								</select>								
						</div>

						<div class="col-md-2" id="cat-saida-2">							
								<label>Itens Grade 2</label>
								<select class="form-control " name="itens_grade_saida2" id="itens_grade_saida2" style="width:100%;"> 
									<option value="0">Selecionar Itens</option>
								</select>								
						</div>


					</div>	

					


					<input type="hidden" name="id" id="id">
					<input type="hidden" name="id_empresa" id="id_empresa">
					<input type="hidden" name="id_usuario" id="id_usuario">
				

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









<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
    $('.sel2').select2({
    	dropdownParent: $('#modalForm')
    });

   
});
</script>



<script type="text/javascript">


	function listarSelectCatGradeEntrada(id){
	
    $.ajax({
        url: 'paginas/produtos/select-cat-grade.php',
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){  
        
            $("#cat_grade_entrada").html(result);           
        }
    });

   
}


function listarSelectItensGradeEntrada(id){
	
    $.ajax({
        url: 'paginas/produtos/select-itens-grade.php',
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){            	
            $("#itens_grade_entrada").html(result);           
        }
    });
}


function listarGradeEntrada(){	
	var id_prod = $("#produto_entrada").val();

	//buscar quantidade de grade do produto
	 $.ajax({
        url: 'paginas/trocas/buscar-grade.php',
        method: 'POST',
        data: {id_prod},
        dataType: "html",

        success:function(result){        	
           if(result == 0){
              $('#grade-entrada-1').css("display", "none");
              $('#grade-entrada-2').css("display", "none");
              $('#cat-entrada-1').css("display", "none");
              $('#cat-entrada-2').css("display", "none");
            }else if(result == 1){
              $('#grade-entrada-2').css("display", "none");
              $('#cat-entrada-2').css("display", "none");
              $('#grade-entrada-1').css("display", "inline-block");
              $('#cat-entrada-1').css("display", "inline-block");
            }else{
            	 $('#grade-entrada-2').css("display", "inline-block");
              $('#grade-entrada-1').css("display", "inline-block");
              $('#cat-entrada-1').css("display", "inline-block");
              $('#cat-entrada-2').css("display", "inline-block");
            }           
        }
    });

    listarSelectCatGradeEntrada(id_prod);    
}



function alterarGradeEntrada(){
	var id_grade = $("#cat_grade_entrada").val();
	
    listarSelectItensGradeEntrada(id_grade);

    var id_prod = $("#produto_entrada").val();  
   
    listarSelectCatGradeEntrada2(id_prod);    
}







function listarSelectCatGradeEntrada2(id){
	var id_grade = $("#cat_grade_entrada").val();
    $.ajax({
        url: 'paginas/produtos/select-cat-grade.php',
        method: 'POST',
        data: {id, id_grade},
        dataType: "html",

        success:function(result){        	
            $("#cat_grade_entrada2").html(result);           
        }
    });

   
}


function listarSelectItensGradeEntrada2(id){

    $.ajax({
        url: 'paginas/produtos/select-itens-grade.php',
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#itens_grade_entrada2").html(result);           
        }
    });
}


function listarGradeEntrada2(){	
	var id_prod = $("#produto_entrada").val();	
    listarSelectCatGradeEntrada2(id_prod);    
}



function alterarGradeEntrada2(){
	var id_grade = $("#cat_grade_entrada2").val();
    listarSelectItensGradeEntrada2(id_grade);
}


</script>






<script type="text/javascript">


	function listarSelectCatGradeSaida(id){
	
    $.ajax({
        url: 'paginas/produtos/select-cat-grade.php',
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){  
        
            $("#cat_grade_saida").html(result);           
        }
    });

   
}


function listarSelectItensGradeSaida(id){
	
    $.ajax({
        url: 'paginas/produtos/select-itens-grade.php',
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){            	
            $("#itens_grade_saida").html(result);           
        }
    });
}


function listarGradeSaida(){	
	var id_prod = $("#produto_saida").val();

	//buscar quantidade de grade do produto
	 $.ajax({
        url: 'paginas/trocas/buscar-grade.php',
        method: 'POST',
        data: {id_prod},
        dataType: "html",

        success:function(result){        	
           if(result == 0){
              $('#grade-saida-1').css("display", "none");
              $('#grade-saida-2').css("display", "none");
              $('#cat-saida-1').css("display", "none");
              $('#cat-saida-2').css("display", "none");
            }else if(result == 1){
              $('#grade-saida-2').css("display", "none");
              $('#cat-saida-2').css("display", "none");
              $('#grade-saida-1').css("display", "inline-block");
              $('#cat-saida-1').css("display", "inline-block");
            }else{
            	 $('#grade-saida-2').css("display", "inline-block");
              $('#grade-saida-1').css("display", "inline-block");
              $('#cat-saida-1').css("display", "inline-block");
              $('#cat-saida-2').css("display", "inline-block");
            }           
        }
    });

	
    listarSelectCatGradeSaida(id_prod);    
}



function alterarGradeSaida(){
	var id_grade = $("#cat_grade_saida").val();
	
    listarSelectItensGradeSaida(id_grade);

    var id_prod = $("#produto_saida").val();  
   
    listarSelectCatGradeSaida2(id_prod);    
}







function listarSelectCatGradeSaida2(id){
	var id_grade = $("#cat_grade_saida").val();
    $.ajax({
        url: 'paginas/produtos/select-cat-grade.php',
        method: 'POST',
        data: {id, id_grade},
        dataType: "html",

        success:function(result){        	
            $("#cat_grade_saida2").html(result);           
        }
    });

   
}


function listarSelectItensGradeSaida2(id){

    $.ajax({
        url: 'paginas/produtos/select-itens-grade.php',
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){        	
            $("#itens_grade_saida2").html(result);           
        }
    });
}


function listarGradeSaida2(){	
	var id_prod = $("#produto_saida").val();	
    listarSelectCatGradeSaida2(id_prod);    
}



function alterarGradeSaida2(){
	var id_grade = $("#cat_grade_saida2").val();
    listarSelectItensGradeSaida2(id_grade);
}


</script>


<script type="text/javascript">
	function listarClientes(){
	var id = $("#cliente").val();
	
    $.ajax({
        url: 'paginas/' + pag + "/listar-clientes.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){  
        
            var split = result.split("-*");				
				$('#nome').val(split[0]);
				$('#cpf').val(split[1]);       
        }
    });

   
}


function listarClientesCpf(){
	var cpf = $("#cpf").val();
	
    $.ajax({
        url: 'paginas/' + pag + "/listar-clientes-cpf.php",
        method: 'POST',
        data: {cpf},
        dataType: "html",

        success:function(result){  
        
            var split = result.split("-*");				
				$('#nome').val(split[0]);
				      
        }
    });

   
}
</script>


<script type="text/javascript">
	function listar(){

	var id_usuario = localStorage.id_usu;
	var id_empresa = localStorage.id_empresa;
	var data_inicial = $("#data-inicial").val();
	var data_final = $("#data-final").val();

    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {id_usuario, data_inicial, data_final, id_empresa},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}
</script>
