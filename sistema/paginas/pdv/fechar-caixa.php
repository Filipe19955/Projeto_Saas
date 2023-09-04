<?php 
$tabela = 'caixa';
require_once("../../../conexao.php");

$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$gerente = $_POST['gerente'];
$senha = $_POST['senha'];

$query_con = $pdo->query("SELECT * FROM caixas WHERE usuario = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_caixa = $res[0]['id'];

$query_con = $pdo->query("SELECT * FROM caixa WHERE operador = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_abertura = $res[0]['id'];
$valor_abertura = $res[0]['valor_ab'];

//validar senha
$query = $pdo->query("SELECT * from usuarios where id = '$gerente'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$senha_gerente = $res[0]['senha'];
	if($senha_gerente != $senha){
		echo 'Senha Incorreta!! Não foi possível abrir o caixa!';
		exit();
	}


//totalizar valor vendido
$valor_vendido = 0;
$query = $pdo->query("SELECT * FROM receber where empresa = '$id_empresa' and tipo = 'Venda' and id_ref = '$id_abertura' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
for($i=0; $i < $total_reg; $i++){	
	$valor_vendido += $res[$i]['valor'];
}


//totalizar valor sangrias
$valor_sangrias = 0;
$query = $pdo->query("SELECT * FROM sangrias where empresa = '$id_empresa' and id_caixa = '$id_abertura' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
for($i=0; $i < $total_reg; $i++){	
	$valor_sangrias += $res[$i]['valor'];
}

//totalizar valor quebra
$valor_quebra = $valor - ($valor_abertura + $valor_vendido - $valor_sangrias);



$query = $pdo->prepare("UPDATE $tabela SET data_fec = curDate(), hora_fec = curTime(), valor_fec = :valor, valor_vendido = '$valor_vendido', valor_quebra = '$valor_quebra', gerente_fec = '$gerente', status = 'Fechado', valor_sangrias = '$valor_sangrias' where id = '$id_abertura' "); 	

$query->bindValue(":valor", "$valor");
$query->execute();


$pdo->query("UPDATE caixas SET status = 'Fechado' WHERE usuario = '$id_usuario' and status = 'Aberto'");

echo 'Salvo com Sucesso';
 ?>