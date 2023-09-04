<?php 
require_once("conexao.php");

$email = $_POST['email'];

$query = $pdo->query("SELECT * from usuarios where email = '$email'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$senha = $res[0]['senha'];
	$empresa = $res[0]['empresa'];

	$query2 = $pdo->query("SELECT * from empresas where id = '$empresa'");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res2) > 0){
		$nome_sistema = $res2[0]['nome'];
	}else{
		$nome_sistema = 'SAS ';
	}

	$query = $pdo->query("SELECT * FROM config WHERE empresa = 0");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$email_sistema = $res[0]['email_sistema'];

	//envio do email
	$destinatario = $email;
    $assunto = $nome_sistema . ' - Recuperação de Senha';
    $mensagem = 'Sua senha é ' .$senha;
    $cabecalhos = "From: ".$email_sistema;
   
    mail($destinatario, $assunto, $mensagem, $cabecalhos);

    echo 'Recuperado com Sucesso';
}else{
	echo 'Esse email não está Cadastrado!';
}

 ?>