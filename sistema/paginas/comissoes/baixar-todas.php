<?php
$tabela = 'comissoes';
require_once("../../../conexao.php");

$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];

$dataInicial = @$_POST['data_inicial'];
$dataFinal = @$_POST['data_final'];
$funcionario = @$_POST['id_funcionario'];

$total_comissoes = 0;
$query = $pdo->query("SELECT * FROM $tabela where data_lanc >= '$dataInicial' and data_lanc <= '$dataFinal' and empresa = '$id_empresa' and pago = 'Não' and vendedor = '$funcionario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){
	$total_comissoes += $res[$i]['valor'];
}


$pdo->query("UPDATE $tabela set usuario_pgto = '$id_usuario', pago = 'Sim', data_pgto = curDate() where data_lanc >= '$dataInicial' and data_lanc <= '$dataFinal' and empresa = '$id_empresa' and pago = 'Não' and vendedor = '$funcionario'");


$pdo->query("INSERT INTO pagar SET empresa = '$id_empresa', tipo = 'Comissão', descricao = 'Comissão Paga', pessoa = '$funcionario', valor = '$total_comissoes', data_venc = curDate(), frequencia = '0', data_lanc = curDate(), data_pgto = curDate(), usuario_lanc = '$id_usuario', usuario_pgto = '$id_usuario', arquivo = 'sem-foto.png', pago = 'Sim'");

echo 'Baixado com Sucesso';
 ?>