<?php 
$tabela = 'receber';
require_once("../../../conexao.php");
$data_hoje = date('Y-m-d');

$id_pessoa = $_POST['id'];
$id_empresa = $_POST['id_empresa'];

$res = $pdo->query("SELECT * FROM $tabela where pessoa = '$id_pessoa' and empresa = '$id_empresa' order by id desc limit 1");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$id = $dados[0]['id'];
$id_empresa = $dados[0]['empresa'];
$hora = $dados[0]['hora'];
$total_venda = $dados[0]['valor'];
$valor_recebido = $dados[0]['valor_recebido'];
$tipo_pgto = $dados[0]['saida'];
$status = $dados[0]['pago'];
$troco = $dados[0]['troco'];
$data = $dados[0]['data_lanc'];
$desconto = $dados[0]['desconto'];
$operador = $dados[0]['usuario_lanc'];
$cliente = $dados[0]['pessoa'];
$acrescimo = $dados[0]['acrescimo'];
$vendedor = $dados[0]['vendedor'];
$data_pgto = $dados[0]['data_venc'];
$garantia = $dados[0]['garantia'];

$res = $pdo->query("SELECT * from usuarios where id = '$vendedor' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_vendedor = $dados[0]['nome'];
}else{
	$nome_vendedor = 'Sem Lançamento';
}


$res = $pdo->query("SELECT * from config where empresa = '$id_empresa' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);

if(@count($dados) > 0){
	$nome_sistema = $dados[0]['nome_sistema'];
	$telefone_sistema = $dados[0]['telefone_sistema'];
	$endereco_sistema = $dados[0]['endereco_sistema'];
	$cnpj_sistema = $dados[0]['cnpj_sistema'];
	$tipo_desconto = $dados[0]['tipo_desconto'];
}

$data2 = implode('/', array_reverse(explode('-', $data)));
$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));

$nome_pgto = $tipo_pgto;


if($tipo_desconto == '%'){
	$descontoF = number_format($desconto , 0, ',', '').'%';			
}else{
	$descontoF = 'R$ '.number_format($desconto , 2, ',', '.');
}


$garantia_dias = date('Y-m-d', strtotime("+$garantia days",strtotime($data))); 
$garantia_diasF = implode('/', array_reverse(explode('-', $garantia_dias)));



$res = $pdo->query("SELECT * from itens_venda where venda = '$id' order by id asc");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$linhas = count($dados);

echo '<div class="row">
<div class="col-md-6"><b>Última Compra: </b> '.$data2.'</div> 
<div class="col-md-6" align="right"><b>Vendedor: </b>'.$nome_vendedor.' </div>
</div>';

$sub_tot;
for ($i=0; $i < count($dados); $i++) { 

	$id_produto = $dados[$i]['produto']; 
	$quantidade = $dados[$i]['quantidade'];
	$id_item= $dados[$i]['id'];
	$valor = $dados[$i]['valor_unitario'];


	$res_p = $pdo->query("SELECT * from produtos where id = '$id_produto' ");
	$dados_p = $res_p->fetchAll(PDO::FETCH_ASSOC);
	$nome_produto = $dados_p[0]['nome'];  
			//$valor = $dados_p[0]['valor_venda'];


	$total_item = $valor * $quantidade;



	$detalhes_da_grade = '';
	$query_con = $pdo->query("SELECT * FROM detalhes_grade WHERE id_ref = '$id_item' and tipo = 'Venda'");
	$res_con = $query_con->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res_con) > 0){
		$cat_grade = $res_con[0]['cat_grade'];
		$cat_grade2 = $res_con[0]['cat_grade2'];
		$itens_grade = $res_con[0]['itens_grade'];
		$itens_grade2 = $res_con[0]['itens_grade2'];


		$query2 = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res2) > 0){
			$nome_itens_grade = $res2[0]['nome'];
		}else{
			$nome_itens_grade = '';
		}


		$query2 = $pdo->query("SELECT * FROM itens_grade where id = '$itens_grade2'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		if(@count($res2) > 0){
			$nome_itens_grade2 = $res2[0]['nome'];
		}else{
			$nome_itens_grade2 = '';
		}

		$detalhes_da_grade = '<small>('.$nome_itens_grade.' '.$nome_itens_grade2.')</small>';
	}

	echo '<small><i><div class="row" style="font-weight: inherit; padding:0px;">';
	echo '<div align="left" class="col-md-9">'.$quantidade.' - '.$nome_produto.' '.$detalhes_da_grade;
	echo '</div>';
	echo '<div align="right" class="col-md-3">';
	echo 'R$';

	@$total_item;
	@$sub_tot = @$sub_tot + @$total_item;
	$sub_total = $sub_tot;	

	$sub_total = number_format( $sub_total , 2, ',', '.');
	$total_item = number_format( $total_item , 2, ',', '.');
	$total = number_format( $total_venda , 2, ',', '.');

	echo $total_item ;

		echo '</div>';
		echo '</div></i></small>';
	}

	echo '<div class="row" align="center">
<span style="margin-right:10px"><b>SubTotal: </b> R$'.$sub_total.'</span> 
<span style="margin-right:10px"><b>Desconto: </b>'.$descontoF.' </span>
<b>Total: </b> R$'.$total.'
</div>';

	?>