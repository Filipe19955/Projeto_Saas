<?php
$tabela = 'trocas';
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$produto_entrada = $res[0]['produto_entrada'];
$produto_saida = $res[0]['produto_saida'];

$query = $pdo->query("SELECT * FROM detalhes_grade where id_ref = '$id' and tipo = 'Troca Entrada'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$itens_grade_entrada = $res[0]['itens_grade'];
$itens_grade_entrada2 = $res[0]['itens_grade2'];

$query = $pdo->query("SELECT * FROM detalhes_grade where id_ref = '$id' and tipo = 'Troca Saída'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$itens_grade_saida = $res[0]['itens_grade'];
$itens_grade_saida2 = $res[0]['itens_grade2'];



//entrar no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$produto_entrada'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $estoque - 1;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$produto_entrada'");


//sair no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$produto_saida'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $estoque + 1;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$produto_saida'");


//valores para itens grades entrada
if($itens_grade_entrada != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_entrada'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_entrada'");
}



//valores para itens grades entrada2
if($itens_grade_entrada2 != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_entrada2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque - 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_entrada2'");
}


//valores para itens grades saida
if($itens_grade_saida != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_saida'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque + 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_saida'");
}

//valores para itens grades saida2
if($itens_grade_saida2 != "0"){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade_saida2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque + 1;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade_saida2'");
}


$pdo->query("DELETE FROM $tabela where id = '$id'");
$pdo->query("DELETE FROM detalhes_grade where id_ref = '$id' and empresa = '$id_empresa' and tipo = 'Troca Entrada' and tipo = 'Troca Saída'");

echo 'Excluído com Sucesso';
 ?>