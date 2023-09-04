<?php 
require_once("../../../conexao.php");
$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];

//RECUPERAR O NOME DO CAIXA
$query_con = $pdo->query("SELECT * FROM caixas WHERE usuario = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$nome_caixa = $res[0]['nome'];

echo '<ul class="order-list">';

$total_venda = 0;
$total_vendaF = 0;

$query_con = $pdo->query("SELECT * FROM itens_venda WHERE usuario = '$id_usuario' and venda = 0 order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){	}

		$id_item = $res[$i]['id'];
		$produto = $res[$i]['produto'];
		$quantidade = $res[$i]['quantidade'];
		$valor_unitario = $res[$i]['valor_unitario'];
		$valor_total_item = $quantidade * $valor_unitario;
		$valor_total_itemF =  number_format($valor_total_item, 2, ',', '.');

		$total_venda += $valor_total_item;
		

		$query_p = $pdo->query("SELECT * FROM produtos WHERE id = '$produto'");
		$res_p = $query_p->fetchAll(PDO::FETCH_ASSOC);
		$nome_produto = $res_p[0]['nome'];
		$valor_produto = $res_p[0]['valor_venda'];
		$foto_produto = $res_p[0]['foto'];


$detalhes_da_grade = '';
$query_con = $pdo->query("SELECT * FROM detalhes_grade WHERE id_ref = '$id_item' and tipo = 'Venda'");
$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
if(@count($res_con) > 0){
	$cat_grade = $res_con[0]['cat_grade'];
	$cat_grade2 = $res_con[0]['cat_grade2'];
	$itens_grade = $res_con[0]['itens_grade'];
	$itens_grade2 = $res_con[0]['itens_grade2'];


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

$detalhes_da_grade = '<small>('.$nome_itens_grade.' '.$nome_itens_grade2.')</small>';

}


           echo '<li class="mb-1"><img src="../images/produtos/'.$foto_produto.'"><h4>'.$quantidade.' - '.mb_strtoupper($nome_produto). ' '.$detalhes_da_grade. ' <a href="#" onclick="modalExcluir('.$id_item.')" title="Excluir Item" style="text-decoration: none">
				<i class="bi bi-x text-danger mx-1"></i>
								</a> </h4><h5>'.$valor_total_itemF.'</h5></li>';



}

}

$total_vendaF =  number_format($total_venda, 2, ',', '.');

echo '</ul>';
echo '<h4 class="total mt-4">Total de Itens ('.$total_reg.') - '.$nome_caixa.'</h4>';
echo '<div class="row"><div class="col-md-9"><h1>R$ <span id="sub_total">'.@$total_vendaF.'</span></h1>
<small><small><small>(F2) Fechar Venda / (Alt) Buscar Produto / (F8) Sangria / (Ctrl) Fechar Caixa </small></small></small>
</div><div class="col-md-3" align="right"><a style="text-decoration:none" class="text-danger" href="../index.php" title="Fechar Caixa ou Sair do PDV">
<i class="bi bi-box-arrow-right"></i> <small>Sair</small> </a>

</div>';



 ?>
