<?php 
$tabela = 'caixa';
require_once("../../../conexao.php");

$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];
$caixa = $_POST['caixa'];
$valor = $_POST['valor'];
$gerente = $_POST['gerente'];
$senha = $_POST['senha'];
//validar nome

$query = $pdo->query("SELECT * from usuarios where id = '$gerente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$senha_gerente = $res[0]['senha'];
	if($senha_gerente != $senha){
		echo 'Senha Incorreta!! Não foi possível abrir o caixa!';
		exit();
	}

$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', data_ab = curDate(), hora_ab = curTime(), valor_ab = :valor, gerente_ab = '$gerente', caixa = '$caixa', operador = '$id_usuario', status = 'Aberto' "); 	

$query->bindValue(":valor", "$valor");
$query->execute();

$pdo->query("UPDATE caixas set status = 'Aberto', usuario = '$id_usuario' where id = '$caixa'"); 

echo 'Salvo com Sucesso';
 ?>