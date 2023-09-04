<?php 
$tabela = 'trocas';
require_once("../../../conexao.php");

$cliente = @$_POST['cliente'];
$cpf = $_POST['cpf'];
$nome = $_POST['nome'];

$produto_entrada = @$_POST['produto_entrada'];
$cat_grade_entrada = @$_POST['cat_grade_entrada'];
$itens_grade_entrada = @$_POST['itens_grade_entrada'];
$cat_grade_entrada2 = @$_POST['cat_grade_entrada2'];
$itens_grade_entrada2 = @$_POST['itens_grade_entrada2'];


$produto_saida = @$_POST['produto_saida'];
$cat_grade_saida = @$_POST['cat_grade_saida'];
$itens_grade_saida = @$_POST['itens_grade_saida'];
$cat_grade_saida2 = @$_POST['cat_grade_saida2'];
$itens_grade_saida2 = @$_POST['itens_grade_saida2'];


$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];


if($cliente == ""){
	$query = $pdo->query("SELECT * from clientes where cpf = '$cpf' and empresa = '$id_empresa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) == 0 ){
		$query2 = $pdo->prepare("INSERT INTO clientes set empresa = '$id_empresa', nome = :nome, cpf = :cpf, data = curDate()");
		$query2->bindValue(":nome", "$nome");
		$query2->bindValue(":cpf", "$cpf");
		$query2->execute();
		$cliente = $pdo->lastInsertId();
	}else{
		$cliente = $res[0]['id'];
	}
}



//entrar no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$produto_entrada'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $estoque + 1;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$produto_entrada'");


//sair no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$produto_saida'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $estoque - 1;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$produto_saida'");


//valores para itens grades entrada
if($itens_grade_entrada != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_entrada'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque + 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_entrada'");
}

//valores para itens grades entrada2
if($itens_grade_entrada2 != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_entrada2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque + 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_entrada2'");
}


//valores para itens grades saida
if($itens_grade_saida != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_saida'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_saida'");
}

//valores para itens grades saida2
if($itens_grade_saida2 != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_saida2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_saida2'");
}


$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', cliente = '$cliente', produto_saida = '$produto_saida', produto_entrada = '$produto_entrada', usuario = '$id_usuario', data = curDate()"); 	
$query->execute();
$ultimo_id = $pdo->lastInsertId();


$pdo->query("INSERT INTO detalhes_grade SET empresa = '$id_empresa', tipo = 'Troca Entrada', produto = '$produto_entrada', id_ref = '$ultimo_id', quantidade = '1', cat_grade = '$cat_grade_entrada', cat_grade2 = '$cat_grade_entrada2', itens_grade = '$itens_grade_entrada', itens_grade2 = '$itens_grade_entrada2' ");

$pdo->query("INSERT INTO detalhes_grade SET empresa = '$id_empresa', tipo = 'Troca Saída', produto = '$produto_saida', id_ref = '$ultimo_id', quantidade = '1', cat_grade = '$cat_grade_saida', cat_grade2 = '$cat_grade_saida2', itens_grade = '$itens_grade_saida', itens_grade2 = '$itens_grade_saida2' ");

echo 'Salvo com Sucesso';
 ?>