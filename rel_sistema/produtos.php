<?php 
include('../conexao.php');

$id_empresa = @$_GET['id_empresa'];

$query = $pdo->query("SELECT * FROM config WHERE empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_sistema = $res[0]['nome_sistema'];
$telefone_sistema = $res[0]['telefone_sistema'];
$logo_rel = $res[0]['foto_rel'];


setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Produtos</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">


<style>

		@page {
			margin: 0px;

		}

		body{
			margin-top:5px;
			font-family:Times, "Times New Roman", Georgia, serif;
		}		

			.footer {
				margin-top:20px;
				width:100%;
				background-color: #ebebeb;
				padding:5px;
				position:absolute;
				bottom:0;
			}

		

		.cabecalho {    
			padding:10px;
			margin-bottom:30px;
			width:100%;
			font-family:Times, "Times New Roman", Georgia, serif;
		}

		.titulo_cab{
			color:#0340a3;
			font-size:20px;
		}

		
		
		.titulo{
			margin:0;
			font-size:28px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;

		}

		.subtitulo{
			margin:0;
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
			color:#6e6d6d;
		}



		hr{
			margin:8px;
			padding:0px;
		}


		
		.area-cab{
			
			display:block;
			width:100%;
			height:10px;

		}

		
		.coluna{
			margin: 0px;
			float:left;
			height:30px;
		}

		.area-tab{
			
			display:block;
			width:100%;
			height:30px;

		}


		.imagem {
			width: 160px;
			position:absolute;
			right:20px;
			top:10px;
		}

		.titulo_img {
			position: absolute;
			margin-top: 10px;
			margin-left: 10px;

		}

		.data_img {
			position: absolute;
			margin-top: 40px;
			margin-left: 10px;
			border-bottom:1px solid #000;
			font-size: 10px;
		}

		.endereco {
			position: absolute;
			margin-top: 50px;
			margin-left: 10px;
			border-bottom:1px solid #000;
			font-size: 10px;
		}

		.verde{
			color:green;
		}



		table.borda {
    		border-collapse: collapse; /* CSS2 */
    		background: #FFF;
    		font-size:12px;
    		vertical-align:middle;
		}
 
		table.borda td {
		    border: 1px solid #dbdbdb;
		}
		 
		table.borda th {
		    border: 1px solid #dbdbdb;
		    background: #ededed;
		    font-size:13px;
		}

		table{
			width:100%;
			text-align: center;
		}


		.esquerda{
			display:inline;
			width:50%;
			float:left;
		}

		.direita{
			display:inline;
			width:50%;
			float:right;
		}

		.text-danger{
			color:red;
		}

		.mx-2{
			margin:0px 10px;
		}
			
				

	</style>
</head>
<body>	

	<div class="titulo_cab titulo_img"><u>Relatório de Produtos </u></div>	
	<div class="data_img"><?php echo mb_strtoupper($data_hoje) ?></div>

	<img class="imagem" src="<?php echo $url_sistema ?>/sistema/images/logos/<?php echo $logo_rel ?>">

	
	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" >


		<?php 
		$estoque_baixo = 0;
		$query = $pdo->query("SELECT * FROM produtos where empresa = '$id_empresa' and ativo = 'Sim' ORDER BY id desc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		 ?>

	<table class="table table-striped borda" cellpadding="6">
  <thead>
    <tr align="center">
      	<th>Produto</th>	
		<th class="esc">Estoque</th>	
		<th class="esc">Venda</th>
		<th class="esc">Compra</th>		
		<th class="esc">Fornecedor</th>
		<th class="esc">Nível Mínimo</th>
    </tr>
  </thead>
  <tbody>

  	<?php 
for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$codigo = $res[$i]['codigo'];
$descricao = $res[$i]['descricao'];
$estoque = $res[$i]['estoque'];
$valor_venda = $res[$i]['valor_venda'];
$valor_compra = $res[$i]['valor_compra'];
$lucro = $res[$i]['lucro'];
$fornecedor = $res[$i]['fornecedor'];
$categoria = $res[$i]['categoria'];
$foto = $res[$i]['foto'];
$data = $res[$i]['data'];
$ativo = $res[$i]['ativo'];
$nivel_estoque = $res[$i]['nivel_estoque'];

$valor_vendaF = number_format($valor_venda, 2, ',', '.');
$valor_compraF = number_format($valor_compra, 2, ',', '.');

	
$data_cadF = implode('/', array_reverse(explode('-', $data)));



$query2 = $pdo->query("SELECT * FROM categorias where id = '$categoria'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_cat = $res2[0]['nome'];
}else{
	$nome_cat = "Nenhuma";
}	


$query2 = $pdo->query("SELECT * FROM fornecedores where id = '$fornecedor'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_forn = $res2[0]['nome'];
}else{
	$nome_forn = "Nenhum";
}	


if($estoque < $nivel_estoque){	
	$classe_estoque = 'text-danger';
}else{
	$classe_estoque = '';
}







  	 ?>

    <tr align="center">
 
<td style="background: #f3f3f3;" rowspan="2"><?php echo mb_strtoupper($nome) ?></td>
<td class="<?php echo $classe_estoque ?>"><?php echo $estoque ?></td>
<td class="esc">R$<?php echo $valor_vendaF ?></td>
<td class="esc">R$<?php echo $valor_compraF ?></td>
<td class="esc"><?php echo $nome_forn ?></td>
<td class="esc"><?php echo $nivel_estoque ?></td>
    </tr>

    <tr align="center">
    	
    	<td colspan="5">
    		<?php 
    		$texto_grade = '';
    			$query2 = $pdo->query("SELECT * FROM itens_grade where produto = '$id'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	for($i2=0; $i2 < $total_reg2; $i2++){		
	$nome_item = $res2[$i2]['nome'];
	$estoque_item = $res2[$i2]['estoque'];

	$texto_grade = $texto_grade.' '.$nome_item.':'.$estoque_item;
	if($i2 != $total_reg2 - 1){
		$texto_grade = $texto_grade .'  /  ';
	}
}


}
    		 ?>
    		<small> <?php echo $texto_grade ?></small>
    	</td>
    </tr>

<?php } ?>
  
  </tbody>
</table>

<?php }else{
echo 'Não possuem registros para serem exibidos!';
exit();
} ?>

	</div>




	<div class="col-md-12 p-2" style="margin-top: 20px">
		<div class="" align="right" style="margin-right: 20px">
	

		<span class=""> <small><small><small><small>TOTAL DE PRODUTOS</small> : <?php echo @$total_reg ?></small></small></small>  </span>


				
		</div>
	</div>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>



	<div class="footer"  align="center">
		<span style="font-size:10px"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></span> 
	</div>

</body>
</html>