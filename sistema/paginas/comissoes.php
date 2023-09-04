<?php 
$pag = 'comissoes';

//verificar se ele tem a permissão de estar nessa página
if(@$comissoes == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}


$data_hoje = date('Y-m-d');
$data_ontem = date('Y-m-d', strtotime("-1 days",strtotime($data_hoje)));

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
$data_inicio_tudo = '2000-01-01';

?>

<div class="bs-example widget-shadow" style="padding:15px">

	<div class="row">
		<div class="col-md-5" style="margin-bottom:5px;">
			<div style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Inicial" class="fa fa-calendar-o"></i></small></span></div>
			<div  style="float:left; margin-right:20px">
				<input type="date" class="form-control " name="data-inicial"  id="data-inicial-caixa" value="<?php echo $data_hoje ?>" required>
			</div>

			<div style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Final" class="fa fa-calendar-o"></i></small></span></div>
			<div  style="float:left; margin-right:30px">
				<input type="date" class="form-control " name="data-final"  id="data-final-caixa" value="<?php echo $data_hoje ?>" required>
			</div>
		</div>


			<div class="col-md-3" >	
			<div class="form-group">			
			<select class="form-control sel2" id="funcionario" name="funcionario" style="width:100%;" onchange="listar()"> 
				<option value="">Filtrar Vendedor</option>
				<?php 
				$query = $pdo->query("SELECT * FROM usuarios where nivel = 'Vendedor' and empresa = '$id_empresa' ORDER BY nome asc");
				$res = $query->fetchAll(PDO::FETCH_ASSOC);
				$total_reg = @count($res);
				if($total_reg > 0){
					for($i=0; $i < $total_reg; $i++){
						foreach ($res[$i] as $key => $value){}
							echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
					}
				}
				?>


			</select>   
		</div> 	
		</div>

		<div class="col-md-3">
		<button  onclick="baixarTudo()" type="button" class="btn btn-success"> Baixar Comissões</button>
	</div>


		

		<input type="hidden" id="buscar-contas">

	</div>

	<div class="row">
	



		<div class="col-md-3" align="center">	
			<div > 
				<small >
					<a title="Comissões Ontem" class="text-muted" href="#" onclick="valorData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> / 
					<a title="Comissões Hoje" class="text-muted" href="#" onclick="valorData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> / 
					<a title="Comissões Mês" class="text-muted" href="#" onclick="valorData('<?php echo $data_inicio_mes ?>', '<?php echo $data_final_mes ?>')"><span>Mês</span></a> / 
					<a title="Comissões Todas" class="text-muted" href="#" onclick="valorData('<?php echo $data_inicio_tudo ?>', '<?php echo $data_final_mes ?>')"><span>Tudo</span></a>
				</small>
			</div>
		</div>



	<div class="col-md-3"  align="center">	
			<div > 
				<small >
					<a title="Todos os Serviços" class="text-muted" href="#" onclick="buscarContas('')"><span>Todos</span></a> / 
					<a title="Pendentes" class="text-muted" href="#" onclick="buscarContas('Não')"><span>Pendentes</span></a> / 
					<a title="Pagos" class="text-muted" href="#" onclick="buscarContas('Sim')"><span>Pagos</span></a>
				</small>
			</div>
		</div>


	</div>

	<hr>
	<div id="listar">

	</div>
	
</div>






<!-- Modal BaixarTudo-->
<div class="modal fade" id="modalBaixarTudo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Pagar Comissões : <span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true" >&times;</span>
				</button>
			</div>
			
			<form id="form-excluir">
			<div class="modal-body">

					<div class="row">
						<div class="col-md-9">
							<div class="form-group">								
								 <p>Você confirma o pagamento de R$ <b><span id="total_pgto"></span></b> reais num total de <span id="total_comissoes"></span> comissões Pendentes.</p>
							</div> 	
						</div>
						<div class="col-md-3">
							<button type="submit" class="btn btn-primary">Confirmar</button>
						
						</div>
					</div>

					
						<input type="hidden" name="id_funcionario" id="id_funcionario">
						<input type="hidden" name="data_inicial" id="data_inicial">
						<input type="hidden" name="data_final" id="data_final">
						<input type="hidden" name="id_usuario" id="id_usuario">
						<input type="hidden" name="id_empresa" id="id_empresa">

					<br>
					<small><div id="mensagem" align="center"></div></small>
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
		});
	});
</script>


<script type="text/javascript">
	function valorData(dataInicio, dataFinal){
	 $('#data-inicial-caixa').val(dataInicio);
	 $('#data-final-caixa').val(dataFinal);	
	listar();
}
</script>



<script type="text/javascript">
	$('#data-inicial-caixa').change(function(){
			//$('#tipo-busca').val('');
			listar();
		});

		$('#data-final-caixa').change(function(){						
			//$('#tipo-busca').val('');
			listar();
		});	
</script>





<script type="text/javascript">
	function listar(){

	$('#id_funcionario').val('');
	$('#titulo_inserir').text('Sem Dados');
	$('#total_pgto').text('0');	
	$('#total_comissoes').text('0');
		

	var dataInicial = $('#data-inicial-caixa').val();
	var dataFinal = $('#data-final-caixa').val();	
	var status = $('#buscar-contas').val();	
	var funcionario = $('#funcionario').val();

	var id_empresa = localStorage.id_empresa;
	
    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {dataInicial, dataFinal, status, funcionario, id_empresa},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}
</script>



<script type="text/javascript">
	function buscarContas(status){
	 $('#buscar-contas').val(status);
	 listar();
	}
</script>





<script type="text/javascript">
	function baixarTudo(){

	var funcionario = $('#funcionario').val();
	 $('#id_empresa').val(localStorage.id_empresa);
	  $('#id_usuario').val(localStorage.id_usu);
	
	if(funcionario === ''){
		alert('Selecione um Funcionário');
		return;
	}

    $('#mensagem').text('');    
    $('#modalBaixarTudo').modal('show');
    limparCampos();
}
</script>




<script type="text/javascript">
	
$("#form-excluir").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/baixar-todas.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem').text('');
            $('#mensagem').removeClass()
            if (mensagem.trim() == "Baixado com Sucesso") {

                $('#btn-fechar').click();
                listar();          

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