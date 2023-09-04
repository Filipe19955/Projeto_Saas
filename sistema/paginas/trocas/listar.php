<?php 
$tabela = 'trocas';
require_once("../../../conexao.php");

$id_empresa = $_POST['id_empresa'];

$data_inicial = @$_POST['data_inicial'];
$data_final = @$_POST['data_final'];

$query = $pdo->query("SELECT * FROM $tabela where data >= '$data_inicial' and data <= '$data_final' and  empresa = '$id_empresa' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Produto Devolvido</th>	
	<th class="esc">Produto Saída</th>	
	<th class="esc">Usuário</th>	
	<th class="esc">Gerente</th>	
	<th class="esc">Data</th>		
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$produto_saida = $res[$i]['produto_saida'];
$produto_entrada = $res[$i]['produto_entrada'];
$usuario = $res[$i]['usuario'];
$cliente = $res[$i]['cliente'];
$data = $res[$i]['data'];
	
$dataF = implode('/', array_reverse(explode('-', $data)));


$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_usuario = $res2[0]['nome'];
}else{
	$nome_usuario = "Nenhuma";
}	


$query2 = $pdo->query("SELECT * FROM produtos where id = '$produto_saida'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_prod_saida = $res2[0]['nome'];
}else{
	$nome_prod_saida = "Nenhum";
}	

$query2 = $pdo->query("SELECT * FROM produtos where id = '$produto_entrada'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_prod_entrada = $res2[0]['nome'];
}else{
	$nome_prod_entrada = "Nenhum";
}	


$query2 = $pdo->query("SELECT * FROM clientes where id = '$cliente'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_cliente = $res2[0]['nome'];
}else{
	$nome_cliente = "Nenhuma";
}	

$detalhes_saida = '';
$query3 = $pdo->query("SELECT * FROM detalhes_grade where empresa = '$id_empresa' and id_ref = '$id' and tipo = 'Troca Saída'");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
$total_reg3 = @count($res3);
if($total_reg3 > 0){
	$itens_grade = $res3[0]['itens_grade'];
	$itens_grade2 = $res3[0]['itens_grade2'];


	$query2 = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_itens_grade = $res2[0]['nome'];
	}else{
		$nome_itens_grade = '';
	}


	$query2 = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_itens_grade2 = $res2[0]['nome'];
	}else{
		$nome_itens_grade2 = '';
	}

	$detalhes_saida = '<small>('.$nome_itens_grade.' '.$nome_itens_grade2.')</small>';

	if($nome_itens_grade == '' and $nome_itens_grade2 == ''){
		$detalhes_saida = '';
	}

}




$detalhes_entrada = '';
$query3 = $pdo->query("SELECT * FROM detalhes_grade where empresa = '$id_empresa' and id_ref = '$id' and tipo = 'Troca Entrada'");
$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
$total_reg3 = @count($res3);
if($total_reg3 > 0){	
	$itens_grade = $res3[0]['itens_grade'];
	$itens_grade2 = $res3[0]['itens_grade2'];


	$query2 = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_itens_grade = $res2[0]['nome'];
	}else{
		$nome_itens_grade = '';
	}


	$query2 = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_itens_grade2 = $res2[0]['nome'];
	}else{
		$nome_itens_grade2 = '';
	}

	$detalhes_entrada = '<small>('.$nome_itens_grade.' '.$nome_itens_grade2.')</small>';

	if($nome_itens_grade == '' and $nome_itens_grade2 == ''){
		$detalhes_entrada = '';
	}

}


echo <<<HTML
<tr >
<td >{$nome_prod_entrada} <span class='text-primary'>{$detalhes_entrada}</span></td>
<td class="esc">{$nome_prod_saida} <span class='text-danger'>{$detalhes_saida}</span></td>
<td class="esc">{$nome_usuario}</td>
<td class="esc">{$nome_cliente}</td>
<td class="esc">{$dataF}</td>

<td>


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

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
		$('#cliente').val('').change();		
		$('#produto_entrada').val('').change();
		$('#produto_saida').val('').change();
		
	}



</script>