<?php 
$tabela = 'entradas';
require_once("../../../conexao.php");
$quantidade = $_POST['quantidade'];
$motivo = $_POST['motivo'];

$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];
$estoque = @$_POST['estoque'];

$cat_grade = $_POST['cat_grade'];
$itens_grade = $_POST['itens_grade'];

$cat_grade2 = $_POST['cat_grade2'];
$itens_grade2 = $_POST['itens_grade2'];


if($estoque == 'Sim'){
//entrar no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $quantidade + $estoque;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$id'");
}


//valores para itens grades
if($itens_grade != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $quantidade + $estoque;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade'");
}



//valores para itens grades2
if($itens_grade2 != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $quantidade + $estoque;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade2'");
}




$query = $pdo->prepare("INSERT into $tabela SET produto = '$id', quantidade = '$quantidade', motivo = :motivo,  data = curDate(), usuario = '$id_usuario', empresa = '$id_empresa' "); 	

$query->bindValue(":motivo", "$motivo");
$query->execute();

echo 'Salvo com Sucesso';
 ?>