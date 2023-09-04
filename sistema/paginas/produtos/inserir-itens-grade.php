<?php 
$tabela = 'itens_grade';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
$id_produto = $_POST['id_produto'];

$query = $pdo->prepare("INSERT into $tabela SET produto = '$id_produto', empresa = '$id_empresa', nome = :nome, estoque = '0', cat_grade = '$id' "); 	


$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
 ?>