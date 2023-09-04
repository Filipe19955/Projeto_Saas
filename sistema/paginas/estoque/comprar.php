<?php
$tabela = 'produtos';
require_once("../../../conexao.php");

$data_hoje = date('Y-m-d');

$id = $_POST['id'];
$valor_venda = $_POST['valor_venda'];
$quantidade = $_POST['quantidade'];
$total_compra = $_POST['total_compra'];
$valor_compra = $_POST['valor_compra'];
$valor_lucro = $_POST['valor_lucro'];
$fornecedor = $_POST['fornecedor'];
$data_venc = $_POST['data_pgto'];
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];
$id_usuario = $_POST['id_usuario'];

$cat_grade = $_POST['cat_grade'];
$itens_grade = $_POST['itens_grade'];

$cat_grade2 = $_POST['cat_grade2'];
$itens_grade2 = $_POST['itens_grade2'];

if(strtotime($data_venc) > strtotime($data_hoje)){
	$pago = 'Não';
	$data_pgto = '';
	$usuario_baixa = '';
}else{
	$pago = 'Sim';
	$data_pgto = $data_hoje;
	$usuario_baixa = $id_usuario;
}

$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome = 'Compra '.$res[0]['nome'];
$estoque = $res[0]['estoque'];
$quantidade_estoque = $quantidade + $estoque;




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


$pdo->query("UPDATE $tabela SET valor_venda = '$valor_venda', valor_compra = '$valor_compra', fornecedor = '$fornecedor', lucro = '$valor_lucro', estoque = '$quantidade_estoque' where id = '$id'");

$pdo->query("INSERT INTO pagar SET empresa = '$id_empresa', tipo = 'Compra', descricao = '$nome', pessoa = '$fornecedor', valor = '$total_compra', data_lanc = curDate(), data_venc = '$data_venc', data_pgto = '$data_pgto', usuario_lanc = '$id_usuario', usuario_pgto = '$usuario_baixa', frequencia = '0', arquivo = 'sem-foto.png', pago = '$pago', id_ref = '$id' ");

$ultimo_id = $pdo->lastInsertId();

$pdo->query("INSERT INTO detalhes_grade SET empresa = '$id_empresa', tipo = 'Compra', produto = '$id', id_ref = '$ultimo_id', quantidade = '$quantidade', cat_grade = '$cat_grade', cat_grade2 = '$cat_grade2', itens_grade = '$itens_grade', itens_grade2 = '$itens_grade2' ");

echo 'Salvo com Sucesso';
 ?>