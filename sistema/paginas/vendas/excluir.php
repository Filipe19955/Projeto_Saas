<?php
$tabela = 'receber';
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


$query_item = $pdo->query("SELECT * FROM itens_venda where venda = '$id'");
$res_item = $query_item->fetchAll(PDO::FETCH_ASSOC);
$total_reg_item = @count($res_item);
for($i=0; $i < $total_reg_item; $i++){

$id_item = $res_item[$i]['id'];
$produto = $res_item[$i]['produto'];
$quantidade = $res_item[$i]['quantidade'];

$pdo->query("INSERT into entradas SET produto = '$produto', quantidade = '$quantidade', motivo = 'Cancelamento da Venda',  data = curDate(), usuario = '$id_usuario', empresa = '$id_empresa' "); 

//devolver no estoque do produto
$query = $pdo->query("SELECT * FROM produtos where id = '$produto'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = $res[0]['estoque'];
$quantidade_estoque = $estoque + $quantidade;
$pdo->query("UPDATE produtos SET estoque = '$quantidade_estoque' where id = '$produto'");



$query = $pdo->query("SELECT * FROM detalhes_grade where id_ref = '$id_item' and tipo = 'Venda'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
$cat_grade = $res[0]['cat_grade'];
$cat_grade2 = $res[0]['cat_grade2'];
$itens_grade = $res[0]['itens_grade'];
$itens_grade2 = $res[0]['itens_grade2'];


//valores para itens grades
if($itens_grade != "0" && $itens_grade != ""){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque + $quantidade;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade'");
}

//valores para itens grades2
if($itens_grade2 != "0" && $itens_grade2 != ""){
$query = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$estoque = @$res[0]['estoque'];
$quantidade_itens_grade = $estoque + $quantidade;
$pdo->query("UPDATE itens_grade SET estoque = '$quantidade_itens_grade' where id = '$itens_grade2'");
}

}



}


$pdo->query("DELETE FROM $tabela where id = '$id'");
$pdo->query("DELETE FROM detalhes_grade where id_ref = '$id' and empresa = '$id_empresa' and tipo = 'Venda'");
$pdo->query("DELETE FROM comissoes where id_ref = '$id' and empresa = '$id_empresa'");

echo 'Excluído com Sucesso';
 ?>