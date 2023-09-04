<?php 
$tabela = 'caixa';
require_once("../../../conexao.php");
$data_hoje = date('Y-m-d');

$id_empresa = $_POST['id_empresa'];

$data_inicial = @$_POST['data_inicial'];
$data_final = @$_POST['data_final'];
$status = @$_POST['status'];

$query = $pdo->query("SELECT * FROM $tabela where data_ab >= '$data_inicial' and data_ab <= '$data_final' and status LIKE '%$status%' and empresa = '$id_empresa' order by id desc");

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Status</th>
	<th class="esc">Caixa</th> 
	<th class="esc">Operador</th> 
	<th class="esc">Data Abertura</th>
	<th class="esc">Vendido</th>
	<th class="esc">Quebra</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
	$id = $res[$i]['id'];
	$id_operador = $res[$i]['operador'];
	$id_caixa = $res[$i]['caixa'];
	$status = $res[$i]['status'];

	$dataF = implode('/', array_reverse(explode('-', $res[$i]['data_ab'])));

	$vlr_quebra = $res[$i]['valor_quebra'];
	if($vlr_quebra != 0){
		$classe_quebra = 'text-danger';
	}else{
		$classe_quebra = '';
	}

	$valor_quebra = number_format( $res[$i]['valor_quebra'] , 2, ',', '.');
	$total_vendido = number_format( $res[$i]['valor_vendido'] , 2, ',', '.');



	$res_2 = $pdo->query("SELECT * from usuarios where id = '$id_operador' ");
	$dados = $res_2->fetchAll(PDO::FETCH_ASSOC);
	$nome_operador = $dados[0]['nome'];


	$res_2 = $pdo->query("SELECT * from caixas where id = '$id_caixa' ");
	$dados = $res_2->fetchAll(PDO::FETCH_ASSOC);
	$nome_caixa = $dados[0]['nome'];


	if($status == 'Aberto'){
		$classe = 'text-verde';
	}else{
		$classe = 'text-danger';
	}

echo <<<HTML
<tr>
<td><i class="fa fa-square {$classe} mr-1"></i> {$status}</td> 
					<td class="esc">{$nome_caixa}</td>	
				<td class="esc">{$nome_operador}</td>
				<td class="esc">{$dataF}</td>
				<td class="esc">R$ {$total_vendido}</td>
				<td class="esc {$classe_quebra}" >R$ {$valor_quebra}</td>
			<td>
				<big><a href="../rel_sistema/fluxo_class.php?id={$id}" title="Fluxo de Caixa" target="_blank"><i class="fa fa-file-pdf-o text-verde"></i></a></big>
				<big><a href="../rel_sistema/sangrias_class.php?id={$id}" title="Relatório de Sangrias" target="_blank"><i class="fa fa-file-pdf-o text-danger"></i></a></big>
			</td>

										
		
</tr>
HTML;
}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
</small>
HTML;

}else{
	echo '<small>Não possui registros cadastrados!</small>';
}

 ?>




 <script type="text/javascript">
	$(document).ready( function () {
    $('#tabela').DataTable({
    		"ordering": false,
			"stateSave": true
    	});
    $('#tabela_filter label input').focus();
} );
</script>




<script type="text/javascript">
	function editar(id, descricao, pessoa, valor, data_venc, frequencia, arquivo, tipo){

		
		$('#id').val(id);
		$('#descricao').val(descricao);
		$('#pessoa').val(pessoa).change();
		$('#valor').val(valor);
		$('#data_venc').val(data_venc);
		
		$('#fornecedor').val("").change();
		$('#funcionario').val("").change();

		if(tipo == 'Compra'){
			$('#fornecedor').val(pessoa).change();
		}

		if(tipo == 'Pagamento'){
			$('#funcionario').val(pessoa).change();
		}
			
			

		$('#arquivo').val('');
		

		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
    	
        $('#target').attr('src','images/contas/' + arquivo);			
        		
	}



	function mostrar(id, descricao, pessoa, valor, data_lanc, data_venc, data_pgto, usuario_lanc, usuario_pgto, frequencia, arquivo, pago, link){

		
		if(data_pgto == "00/00/0000" || data_pgto == ""){
			data_pgto = 'Não Pago Ainda';
		}


		$('#nome_mostrar').text(descricao);
		$('#pessoa_mostrar').text(pessoa);
		$('#valor_mostrar').text(valor);
		$('#lanc_mostrar').text(data_lanc);
		$('#venc_mostrar').text(data_venc);
		$('#pgto_mostrar').text(data_pgto);		
		$('#usu_lanc_mostrar').text(usuario_lanc);	
		$('#usu_pgto_mostrar').text(usuario_pgto);	
		$('#freq_mostrar').text(frequencia);
		
		$('#pago_mostrar').text(pago);
		
		$('#link_arquivo').attr('href','images/contas/' + link);
		$('#modalMostrar').modal('show');		
		$('#target_mostrar').attr('src','images/contas/' + arquivo);			
        	
	}

	function limparCampos(){
		$('#id').val('');
		$('#descricao').val('');		
		$('#valor').val('');		
		$('#data_venc').val('<?=$data_hoje?>');			
		$('#arquivo').val('');
		$('#target').attr('src','images/contas/sem-foto.png');
		$('#pessoa').val('').change();
		$('#frequencia').val('0').change();
	}



	function arquivo(id, nome){
		
		$('#titulo_arquivo').text(nome);		
		$('#id_arquivo').val(id);	
		$('#id_usuario_arquivo').val(localStorage.id_usu);	
		$('#id_empresa_arquivo').val(localStorage.id_empresa);	
		$('#target-arquivos').attr("src", "images/arquivos/sem-foto.png");			
		$('#id_arquivo').val(id);				
		$('#modalArquivos').modal('show');
		listarArquivos(id);
		limparArquivos();
	}

	function limparArquivos(){
		$('#nome_arquivo').val('');
		$('#data_validade').val('');
		$('#foto').val('');
		$('#target').attr("src", "images/arquivos/sem-foto.png");
	}


	

</script>