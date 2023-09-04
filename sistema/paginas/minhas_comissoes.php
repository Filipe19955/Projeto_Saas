<?php 
$pag = 'minhas_comissoes';

//verificar se ele tem a permissão de estar nessa página
if(@$minhas_comissoes == 'ocultar'){
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



<div class="row">
	<form method="post" action="../rel_sistema/comissoes_class.php" target="_blank">
	<div class="col-md-10">		
		

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Inicial" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:20px">
			<input type="date" class="form-control " name="dataInicial"  id="data-inicial" value="<?php echo $data_inicio_mes ?>" required onchange="listar()">
		</div>

		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Data de Vencimento Final" class="fa fa-calendar-o"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:30px">
			<input type="date" class="form-control " name="dataFinal"  id="data-final" value="<?php echo $data_final_mes ?>" required onchange="listar()">
		</div>


		<div class="esc" style="float:left; margin-right:10px"><span><small><i title="Filtrar por Status" class="bi bi-search"></i></small></span></div>
		<div class="esc" style="float:left; margin-right:20px">
			<select class="form-control" aria-label="Default select example" name="pago" id="status-busca" onchange="listar()">
				<option value="">Pendentes / Pagas</option>
				<option value="Não">Pendentes</option>
				<option value="Sim">Pagas</option>
				
			</select>
		</div>

		<div style="margin-top:5px;"> 
		<small >			
			<a title="Comissões de Hoje" class="text-muted" href="#" onclick="alterarData('<?php echo $data_hoje ?>', '<?php echo $data_hoje ?>')"><span>Hoje</span></a> / 
			<a title="Comissões de Ontem" class="text-muted" href="#" onclick="alterarData('<?php echo $data_ontem ?>', '<?php echo $data_ontem ?>')"><span>Ontem</span></a> /
			<a title="Comissões Mês" class="text-muted" href="#" onclick="alterarData('<?php echo $data_inicio_mes ?>', '<?php echo $data_final_mes ?>')"><span>Mês</span></a> / 
			<a title="Todo Período" class="text-muted" href="#" onclick="alterarData('<?php echo $data_inicio_tudo ?>', '<?php echo $data_final_mes ?>')"><span>Tudo</span></a>
		</small>
		</div>

		<input type="hidden" name="busca" value="data_lanc">
		<input type="hidden" name="pessoa" value="<?php echo $id_usuario ?>">

		
	</div>

	<div class="col-md-2">
		<button type="submit" class="btn btn-primary">Gerar Relatório</button>
	</div>
	</form>
	
</div>



<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
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
	function listar(){

	var id_usuario = localStorage.id_usu;
	var id_empresa = localStorage.id_empresa;
	var data_inicial = $("#data-inicial").val();
	var data_final = $("#data-final").val();
	var status = $("#status-busca").val();
    $.ajax({
        url: 'paginas/' + pag + "/listar.php",
        method: 'POST',
        data: {id_usuario, data_inicial, data_final, status, id_empresa},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);
            $('#mensagem-excluir').text('');
        }
    });
}
</script>




<script type="text/javascript">
	function alterarData(data1, data2){
		$("#data-inicial").val(data1)
		$("#data-final").val(data2)
		listar();
	}
</script>