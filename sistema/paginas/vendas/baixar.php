<?php
$tabela = 'receber';
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];

$data_atual = date('Y-m-d');
$dia = date('d');
$mes = date('m');
$ano = date('Y');


$pdo->query("UPDATE $tabela set usuario_pgto = '$id_usuario', pago = 'Sim', data_pgto = curDate() where id = '$id'");

echo 'Baixado com Sucesso';
 ?>