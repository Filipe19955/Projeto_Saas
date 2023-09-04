<?php
$tabela = 'pagar';
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_usuario = $_POST['id_usuario'];

$data_atual = date('Y-m-d');
$dia = date('d');
$mes = date('m');
$ano = date('Y');


$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$descricao = $res[0]['descricao'];
$pessoa = $res[0]['pessoa'];
$valor = $res[0]['valor'];
$data_lanc = $res[0]['data_lanc'];
$data_venc = $res[0]['data_venc'];
$data_pgto = $res[0]['data_pgto'];
$usuario_lanc = $res[0]['usuario_lanc'];
$usuario_pgto = $res[0]['usuario_pgto'];
$frequencia = $res[0]['frequencia'];
$saida = $res[0]['saida'];
$arquivo = $res[0]['arquivo'];
$pago = $res[0]['pago'];

$pdo->query("UPDATE $tabela set usuario_pgto = '$id_usuario', pago = 'Sim', data_pgto = curDate() where id = '$id'");


//CRIAR A PRÓXIMA CONTA A PAGAR CASO EXISTA RECORRENCIA / FREQUENCIA
	$dias_frequencia = $frequencia;

	if($dias_frequencia == 30 || $dias_frequencia == 31){		
		$nova_data_vencimento = date('Y/m/d', strtotime("+1 month",strtotime($data_venc)));

	}else if($dias_frequencia == 90){
		$nova_data_vencimento = date('Y/m/d', strtotime("+3 month",strtotime($data_venc)));

	}else if($dias_frequencia == 180){ 
		$nova_data_vencimento = date('Y/m/d', strtotime("+6 month",strtotime($data_venc)));

	}else if($dias_frequencia == 360){
		$nova_data_vencimento = date('Y/m/d', strtotime("+1 year",strtotime($data_venc)));

	}else{		
		$nova_data_vencimento = date('Y/m/d', strtotime("+$dias_frequencia days",strtotime($data_venc))); 
	}


	if(@$dias_frequencia > 0){
		$pdo->query("INSERT INTO $tabela set empresa = '0', tipo = 'Empresa', descricao = '$descricao', pessoa = '$pessoa', valor = '$valor', data_lanc = curDate(), data_venc = '$nova_data_vencimento', frequencia = '$frequencia', arquivo = '$arquivo', pago = 'Não'");
						
	}



echo 'Baixado com Sucesso';
 ?>