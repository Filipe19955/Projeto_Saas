<?php 
require_once("../../../conexao.php");
$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];


$query_con = $pdo->query("SELECT * FROM caixa WHERE operador = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_abertura = $res[0]['id'];
$valor_abertura = $res[0]['valor_ab'];

$total_sangrias = 0;
$query = $pdo->query("SELECT * FROM sangrias where empresa = '$id_empresa' and id_caixa = '$id_abertura' ORDER BY id asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){	
$valor = $res[$i]['valor'];
	$total_sangrias += $valor;
}
}


$total_vendas = 0;
$query = $pdo->query("SELECT * FROM receber where empresa = '$id_empresa' and tipo = 'Venda' and id_ref = '$id_abertura' ORDER BY id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){	
$valor = $res[$i]['valor'];
	$total_vendas += $valor;
}
}

$valor_caixa = $valor_abertura - $total_sangrias + $total_vendas;
$valor_caixaF = number_format( $valor_caixa , 2, ',', '.');
echo 'R$ '.$valor_caixaF;
?>