<?php 
$tabela = 'pagar';
require_once("../../../conexao.php");
$data_hoje = date('Y-m-d');

$data_inicial = @$_POST['data_inicial'];
$data_final = @$_POST['data_final'];
$status = @$_POST['status'];
$vencidas = @$_POST['vencidas'];

if($vencidas != ""){
	$query = $pdo->query("SELECT * FROM $tabela where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' order by data_venc asc");
}else{
	$query = $pdo->query("SELECT * FROM $tabela where data_venc >= '$data_inicial' and data_venc <= '$data_final' and pago LIKE '%$status%' and tipo = 'Empresa' and empresa = '0' order by id desc");
}


$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Descrição</th>
				<th class="esc">Valor</th> 
				<th class="esc">Vencimento</th> 
				<th class="esc">Frequência</th>				
				<th>Arquivo</th>				
				<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;
$pendentesF = 0;
$recebidasF = 0;
$vencidasF = 0;
$pendentes = 0;
$recebidas = 0;
$vencidas = 0;
for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$descricao = $res[$i]['descricao'];
$pessoa = $res[$i]['pessoa'];
$valor = $res[$i]['valor'];
$data_lanc = $res[$i]['data_lanc'];
$data_venc = $res[$i]['data_venc'];
$data_pgto = $res[$i]['data_pgto'];
$usuario_lanc = $res[$i]['usuario_lanc'];
$usuario_pgto = $res[$i]['usuario_pgto'];
$frequencia = $res[$i]['frequencia'];
$saida = $res[$i]['saida'];
$arquivo = $res[$i]['arquivo'];
$pago = $res[$i]['pago'];

//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx'){
	$tumb_arquivo = 'word.png';
}else{
	$tumb_arquivo = $arquivo;
}

$data_lancF = implode('/', array_reverse(explode('-', $data_lanc)));
$data_vencF = implode('/', array_reverse(explode('-', $data_venc)));
$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
$valorF = number_format($valor, 2, ',', '.');


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_lanc = $res2[0]['nome'];
}else{
	$nome_usu_lanc = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_pgto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_usu_pgto = $res2[0]['nome'];
}else{
	$nome_usu_pgto = 'Sem Usuário';
}


$query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
if(@count($res2) > 0){
	$nome_frequencia = $res2[0]['frequencia'];
}else{
	$nome_frequencia = 'Indefinida';
}




if($pago == 'Sim'){
	$classe_pago = 'text-verde';
	$ocultar = 'ocultar';
	$recebidas += $valor;
}else{
	$classe_pago = 'text-danger';
	$ocultar = '';	
	$pendentes += $valor;
}

$classe_debito = '';
if(strtotime($data_venc) < strtotime($data_hoje) and $pago != 'Sim'){
	$classe_debito = 'text-danger';
	$vencidas += $valor;
}

$recebidasF = number_format($recebidas, 2, ',', '.');
$pendentesF = number_format($pendentes, 2, ',', '.');
$vencidasF = number_format($vencidas, 2, ',', '.');

echo <<<HTML
<tr class="{$classe_debito}">
<td><i class="fa fa-square {$classe_pago} mr-1"></i> {$descricao}</td> 
					<td class="esc">R$ {$valorF}</td>	
				<td class="esc">{$data_vencF}</td>
				<td class="esc">{$nome_frequencia}</td>
				
				<td><a href="images/contas/{$arquivo}" target="_blank"><img src="images/contas/{$tumb_arquivo}" width="30px" height="30px"></a></td>
				<td>
					<big><a class="{$ocultar}" href="#" onclick="editar('{$id}', '{$descricao}','{$valor}','{$data_venc}','{$frequencia}','{$tumb_arquivo}')" title="Editar Dados"><i class="fa fa-edit text-primary "></i></a></big>

					<big><a href="#" onclick="mostrar('{$id}', '{$descricao}', '{$valor}','{$data_lancF}','{$data_vencF}','{$data_pgtoF}','{$nome_usu_lanc}','{$nome_usu_pgto}','{$nome_frequencia}','{$tumb_arquivo}','{$pago}','{$arquivo}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					
					<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>
				

		<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle {$ocultar}" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-check-square text-verde"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p style="color:#000">Confirmar Baixa da Conta? <a href="#" onclick="baixar('{$id}')"><span class="text-verde">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>
		
					

					<big><a href="#" onclick="arquivo('{$id}', '{$descricao}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a></big>
				</td>  
</tr>
HTML;
}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
<br>
<div align="right">
<span style="margin-right: 25px">Contas Vencidas: <span class="text-danger">R$ {$vencidasF}</span></span> 
<span style="margin-right: 25px">Contas Pendentes: <span class="text-danger">R$ {$pendentesF}</span></span> 
<span style="margin-right: 25px">Contas Pagas: <span class="text-verde">R$ {$recebidasF}</span></span> 
</div>

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
	function editar(id, descricao,  valor, data_venc, frequencia, arquivo){

		
		$('#id').val(id);
		$('#descricao').val(descricao);
		
		$('#valor').val(valor);
		$('#data_venc').val(data_venc);
		$('#frequencia').val(frequencia).change();
			

		$('#arquivo').val('');
		

		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		$('#mensagem').text('');
    	
        $('#target').attr('src','images/contas/' + arquivo);			
        		
	}



	function mostrar(id, descricao, valor, data_lanc, data_venc, data_pgto, usuario_lanc, usuario_pgto, frequencia, arquivo, pago, link){

		
		if(data_pgto == "00/00/0000" || data_pgto == ""){
			data_pgto = 'Não Pago Ainda';
		}


		$('#nome_mostrar').text(descricao);
		
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
		
		$('#frequencia').val('0').change();
	}



	function arquivo(id, nome){
		
		$('#titulo_arquivo').text(nome);		
		$('#id_arquivo').val(id);	
		$('#id_usuario_arquivo').val(localStorage.id_usu);	
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