<?php 
$tabela = 'frequencias';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$dias = $_POST['dias'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];

if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', frequencia = :nome, dias = '$dias' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET frequencia = :nome, dias = '$dias' WHERE id = '$id' ");
	
}

$query->bindValue(":nome", "$nome");
$query->execute();


echo 'Salvo com Sucesso';
 ?>