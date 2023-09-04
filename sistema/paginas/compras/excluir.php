<?php
$tabela = 'pagar';
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['arquivo'];

if($foto != "sem-foto.png"){
	@unlink('../../images/contas/'.$foto);
}

$query = $pdo->query("SELECT * FROM detalhes_grade where id_ref = '$id' and tipo = 'Compra'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$produto = $res[0]['produto'];
$quantidade = $res[0]['quantidade'];
$cat_grade = $res[0]['cat_grade'];
$cat_grade2 = $res[0]['cat_grade2'];
$itens_grade = $res[0]['itens_grade'];
$itens_grade2 = $res[0]['itens_grade2'];


//retirar no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$produto'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $estoque - $quantidade;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$produto'");



//valores para itens grades
if($itens_grade != "0" && $itens_grade != ""){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade' and empresa = '$id_empresa' and tipo = 'Venda'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - $quantidade;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade'");
}




//valores para itens grades2
if($itens_grade2 != "0" && $itens_grade2 != ""){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - $quantidade;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade2'");
}





$pdo->query("DELETE FROM $tabela where id = '$id'");
$pdo->query("DELETE FROM detalhes_grade where id_ref = '$id'");

$pdo->query("INSERT into saidas SET produto = '$produto', quantidade = '$quantidade', motivo = 'Cancelamento da Compra',  data = curDate(), usuario = '$id_usuario', empresa = '$id_empresa' "); 

echo 'Excluído com Sucesso';
 ?>