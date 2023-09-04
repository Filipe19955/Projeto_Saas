<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$id = $_POST['id'];

$senha = '123';
$senha_crip = md5($senha);

if($email == "" and $cpf == ""){
	echo 'Preencha o CPF ou o Email!';
	exit();
}

//validar cpf
if($cpf != ""){
	$query = $pdo->query("SELECT * from $tabela where cpf = '$cpf'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'CPF já Cadastrado, escolha outro!!';
		exit();
	}
}


if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '0', nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, ativo = 'Sim', data = curDate(), endereco = :endereco, nivel = 'SAS', foto = 'sem-foto.jpg', senha = '123', senha_crip = '$senha_crip' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, ativo = 'Sim', endereco = :endereco WHERE id = '$id' ");
	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":endereco", "$endereco");
$query->execute();


echo 'Salvo com Sucesso';
 ?>