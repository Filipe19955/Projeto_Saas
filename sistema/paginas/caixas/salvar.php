<?php 
$tabela = 'caixas';
require_once("../../../conexao.php");

$nome = $_POST['nome'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];


//validar nome

	$query = $pdo->query("SELECT * from $tabela where nome = '$nome' and empresa = '$id_empresa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'Cargo já Cadastrado, escolha outro!!';
		exit();
	}

if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', nome = :nome, status = 'Fechado' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome WHERE id = '$id' ");
	
}

$query->bindValue(":nome", "$nome");
$query->execute();


echo 'Salvo com Sucesso';
 ?>