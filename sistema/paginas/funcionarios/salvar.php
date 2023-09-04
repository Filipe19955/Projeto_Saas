<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$endereco = $_POST['endereco'];
$nivel = $_POST['nivel'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
$comissao = $_POST['comissao'];

$senha = '123';
$senha_crip = md5($senha);


if($email == "" and $cpf == ""){
	echo 'Preencha o CPF ou o Email!';
	exit();
}

//validar cpf
if($cpf != ""){
	$query = $pdo->query("SELECT * from $tabela where cpf = '$cpf' ");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'CPF já Cadastrado, escolha outro!!';
		exit();
	}
}


//validar email
if($email != ""){
	$query = $pdo->query("SELECT * from $tabela where email = '$email'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'Email já Cadastrado, escolha outro!!';
		exit();
	}
}


if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, ativo = 'Sim', data = curDate(), endereco = :endereco, nivel = '$nivel', foto = 'sem-foto.jpg', senha = '123', senha_crip = '$senha_crip', comissao = '$comissao' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, email = :email, telefone = :telefone, cpf = :cpf, ativo = 'Sim', endereco = :endereco, nivel = '$nivel', comissao = '$comissao'  WHERE id = '$id' ");
	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":email", "$email");
$query->bindValue(":telefone", "$telefone");
$query->bindValue(":cpf", "$cpf");
$query->bindValue(":endereco", "$endereco");
$query->execute();


echo 'Salvo com Sucesso';
 ?>