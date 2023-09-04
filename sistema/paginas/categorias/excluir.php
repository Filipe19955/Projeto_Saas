<?php
$tabela = 'categorias';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM produtos where categoria = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	echo 'Não é possível excluir a categoria porque tem produtos relacionados a ela, primeiro exclua os produtos e depois a categoria!';
	exit();
}


$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';
 ?>