<?php 
$tabela = 'sangrias';
require_once("../../../conexao.php");

$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];
$valor = $_POST['valor'];
$gerente = $_POST['gerente'];
$senha = $_POST['senha'];

$query_con = $pdo->query("SELECT * FROM caixas WHERE usuario = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_caixa = $res[0]['id'];

$query_con = $pdo->query("SELECT * FROM caixa WHERE operador = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_abertura = $res[0]['id'];

//validar senha
$query = $pdo->query("SELECT * from usuarios where id = '$gerente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$senha_gerente = $res[0]['senha'];
	if($senha_gerente != $senha){
		echo 'Senha Incorreta!! Não foi possível abrir o caixa!';
		exit();
	}

$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', data = curDate(), hora = curTime(), valor = :valor, usuario = '$gerente', caixa = '$id_caixa', id_caixa = '$id_abertura' "); 	

$query->bindValue(":valor", "$valor");
$query->execute();

echo 'Salvo com Sucesso';
 ?>