<?php 
$tabela = 'cat_grade';
require_once("../../../conexao.php");
$data_hoje = date('Y-m-d');

$id_ref = $_POST['id'];


$query = $pdo->query("SELECT * FROM $tabela where produto = '$id_ref' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small><small>
	<table class="table table-hover">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Estoque</th>	
	<th class="esc">Itens</th>
	<th>Excluir</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$produto = $res[$i]['produto'];

$estoque = 0;
//buscar total de itens da categoria
$query2 = $pdo->query("SELECT * FROM itens_grade where cat_grade = '$id' order by id desc");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
for($i2=0; $i2 < $total_reg2; $i2++){
	$est = $res2[$i2]['estoque'];	
	$estoque += $est;
}

echo <<<HTML
<tr>
<td>{$nome}</td>
<td class="esc">{$estoque}</td>
<td class="esc">{$total_reg2}</td>
<td>


<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirGrade('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>

<big><a href="#" onclick="itens_grade('{$id}', '{$nome}', '{$produto}')" title="Itens da Grade"><i class="fa fa-plus" style="color:#056704"></i></a></big>


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
	echo '<small>Não possui nenhuma grade cadastrada!</small>';
}

 ?>



 <script type="text/javascript">
 	function itens_grade(id, nome, produto){		

		$('#id-itens-grade').val(id);	
		$('#id-itens-grade-produto').val(produto);		
		$('#id_empresa_itens_grade').val(localStorage.id_empresa);
		$('#id_usuario_itens_grade').val(localStorage.id_usu);

		$('#titulo-itens-grade').text(nome);

		$('#modalItensGrade').modal('show');
		listarItensGrade(id);

	}
 </script>