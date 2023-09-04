<?php 
$tabela = 'saidas';
require_once("../../../conexao.php");

$id_empresa = $_POST['id_empresa'];

$query = $pdo->query("SELECT * FROM $tabela where empresa = '$id_empresa' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Quantidade</th>	
	<th class="">Produto</th>
	<th class="esc">Motivo</th>	
	<th class="esc">Usuário</th>	
	<th class="esc">Data</th>	
	
	
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$quantidade = $res[$i]['quantidade'];
$motivo = $res[$i]['motivo'];
$usuario = $res[$i]['usuario'];
$data = $res[$i]['data'];
$produto = $res[$i]['produto'];

$motivoF = mb_strimwidth($motivo, 0, 60, "...");

$data_F = implode('/', array_reverse(explode('-', $data)));

$query2 = $pdo->query("SELECT * FROM produtos where id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_produto = @$res2[0]['nome'];

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_usuario = @$res2[0]['nome'];

echo <<<HTML
<tr>
<td>{$quantidade}</td>
<td class="">{$nome_produto}</td>
<td class="esc">{$motivoF}</td>
<td class="esc">{$nome_usuario}</td>
<td class="esc">{$data_F}</td>


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


