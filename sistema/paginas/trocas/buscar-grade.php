<?php 
$tabela = 'produtos';
require_once("../../../conexao.php");

$id = $_POST['id_prod'];

//verificar se o produto possui grade
$query2 = $pdo->query("SELECT * FROM cat_grade where produto = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
echo @count($res2);

?>