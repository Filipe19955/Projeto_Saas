<?php 
$tabela = 'cat_grade';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];




$query = $pdo->prepare("INSERT into $tabela SET produto = '$id', empresa = '$id_empresa', nome = :nome"); 	


$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
 ?>