<?php
$tabela = 'comissoes';
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];

$total_comissoes = 0;
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){
	$total_comissoes += $res[$i]['valor'];
	$funcionario = $res[$i]['vendedor'];
}


$pdo->query("UPDATE $tabela set usuario_pgto = '$id_usuario', pago = 'Sim', data_pgto = curDate() where id = '$id'");

$pdo->query("INSERT INTO pagar SET empresa = '$id_empresa', tipo = 'Comissão', descricao = 'Comissão Paga', pessoa = '$funcionario', valor = '$total_comissoes', data_venc = curDate(), frequencia = '0', data_lanc = curDate(), data_pgto = curDate(), usuario_lanc = '$id_usuario', usuario_pgto = '$id_usuario', arquivo = 'sem-foto.png', pago = 'Sim'");

echo 'Baixado com Sucesso';
 ?>