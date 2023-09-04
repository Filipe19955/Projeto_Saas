<?php 
require_once("../../../conexao.php");
@session_start();
$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];

$cat_grade = @$_POST['cat_grade'];
$cat_grade2 = @$_POST['cat_grade2'];
$itens_grade = @$_POST['itens_grade'];
$itens_grade2 = @$_POST['itens_grade2'];
$id_produto = @$_POST['id_produto'];
$id_item = @$_POST['id_item'];

//RECUPERAR A QUANTIDADE DE ITENS
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE id = '$id_item'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$quantidade = $res[0]['quantidade'];

//RECUPERAR O ID DA ABERTURA
$query_con = $pdo->query("SELECT * FROM caixa WHERE operador = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_abertura = $res[0]['id'];


//abater estoque das grades

if($itens_grade != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - $quantidade;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade'");
}

if($itens_grade2 != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - $quantidade;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade2'");
}


$pdo->query("INSERT INTO detalhes_grade SET empresa = '$id_empresa', tipo = 'Venda', produto = '$id_produto', id_ref = '$id_item', quantidade = '$quantidade', cat_grade = '$cat_grade', cat_grade2 = '$cat_grade2', itens_grade = '$itens_grade', itens_grade2 = '$itens_grade2' ");

echo 'Salvo com Sucesso';

?>