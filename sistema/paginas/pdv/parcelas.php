<?php 
require_once("../../../conexao.php");
@session_start();
$id_empresa = @$_SESSION['id_empresa'];
$id_usuario = @$_SESSION['id_usuario'];

//$query = $pdo->query("DELETE FROM contas_receber where id_venda = '-2' and usuario_lanc = '$id_usuario'");


$valor = $_POST['valor'];
$valor = str_replace(".", "", $valor);
$valor = str_replace(",", ".", $valor);
$data = $_POST['data'];
$parcelas = $_POST['parcelas'];

if($data == ''){
	$data = date('Y-m-d');
}




if($parcelas > 1){
	

	$novo_valor = $valor / $parcelas;
	$novo_valor = number_format($novo_valor, 2, '.', '');
	$resto_conta = $valor - $novo_valor * $parcelas;
	

	for($i=1; $i <= $parcelas; $i++){

		if($i == $parcelas){
			$novo_valor = $novo_valor + $resto_conta;
			round($novo_valor, 2, PHP_ROUND_HALF_ODD);
		}
		
	
		$query = $pdo->prepare("INSERT INTO receber set empresa = '$id_empresa', data_lanc = curDate(), data_venc = :data, valor = :valor, usuario_lanc = '$id_usuario', pago = 'Não', id_venda = '-2'");

		$query->bindValue(":valor", "$novo_valor");
		$query->bindValue(":data", "$data");
		$query->execute();

		$data = date('Y/m/d', strtotime("+1 month",strtotime($data)));
	}
}





echo 'Inserido com Sucesso';

?>