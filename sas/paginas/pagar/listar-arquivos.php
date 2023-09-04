<?php 
$tabela = 'arquivos';
require_once("../../../conexao.php");
$data_hoje = date('Y-m-d');

$id_ref = $_POST['id'];


$query = $pdo->query("SELECT * FROM $tabela where empresa = '0' and tipo = 'Pagar' and id_ref = '$id_ref' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small><small>
	<table class="table table-hover">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Cadastrado</th>
	<th class="esc">Validade</th>
	<th class="">Arquivo</th>
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$data_validade = $res[$i]['data_validade'];
$data_validadeF = implode('/', array_reverse(explode('-', $data_validade)));	
$data_cad = $res[$i]['data_cad'];
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
$arquivo = $res[$i]['foto'];

$classe_data = '';
if(strtotime($data_validade) < strtotime($data_hoje)){
	if($data_validadeF != '00/00/0000'){
		$classe_data = 'text-danger';
	}	
}

//extensão do arquivo
$ext = pathinfo($arquivo, PATHINFO_EXTENSION);
if($ext == 'pdf'){
	$tumb_arquivo = 'pdf.png';
}else if($ext == 'rar' || $ext == 'zip'){
	$tumb_arquivo = 'rar.png';
}else if($ext == 'doc' || $ext == 'docx' || $ext == 'txt'){
	$tumb_arquivo = 'word.png';
}else if($ext == 'xlsx' || $ext == 'xlsm' || $ext == 'xls'){
	$tumb_arquivo = 'excel.png';
}else if($ext == 'xml'){
	$tumb_arquivo = 'xml.png';
}else{
	$tumb_arquivo = $arquivo;
}

if($data_validadeF == '00/00/0000'){
	$data_validadeF = 'Sem Validade';	
}

echo <<<HTML
<tr>
<td>{$nome}</td>
<td class="esc">{$data_cadF}</td>
<td class="esc {$classe_data}">{$data_validadeF}</td>
<td class="esc"><a href="images/arquivos/{$arquivo}" target="_blank"><img src="images/arquivos/{$tumb_arquivo}" width="30px"></a></td>
<td>


<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirArquivo('{$id}')"><span class="text-danger">Sim</span></a></p>
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
</table>
</small></small>
HTML;

}else{
	echo '<small>Não possui nenhum arquivo cadastrado!</small>';
}

 ?>