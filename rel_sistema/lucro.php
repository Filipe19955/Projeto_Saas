<?php 
include('../conexao.php');

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$id_empresa = $_GET['id_empresa'];


$query = $pdo->query("SELECT * FROM config WHERE empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_sistema = $res[0]['nome_sistema'];
$telefone_sistema = $res[0]['telefone_sistema'];
$logo_rel = $res[0]['foto_rel'];

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));


$dataInicialF = implode('/', array_reverse(explode('-', $dataInicial)));
$dataFinalF = implode('/', array_reverse(explode('-', $dataFinal)));

if($dataInicial == $dataFinal){
	$texto_apuracao = 'APURADO EM '.$dataInicialF;
}else if($dataInicial == '1980-01-01'){
	$texto_apuracao = 'APURADO EM TODO O PERÍODO';
}else{
	$texto_apuracao = 'APURAÇÃO DE '.$dataInicialF. ' ATÉ '.$dataFinalF;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Demonstrativo de Lucro</title>
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

		.text-success{
			color:green;
		}
			
				

	</style>

</head>
<body>	

	<div class="titulo_cab titulo_img"><u>Demonstrativo de Lucro</u></div>	
	<div class="data_img"><?php echo mb_strtoupper($data_hoje) ?></div>

	<img class="imagem" src="<?php echo $url_sistema ?>/sistema/images/logos/<?php echo $logo_rel ?>">


	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" >

		<section class="area-cab">
			
			<div>
				<small><small><small><u><?php echo $texto_apuracao ?></u></small></small></small>
			</div>

	
			</section>

			<br>

		<?php 
		
		$total_vendas = 0;
		$total_receber = 0;
		$total_pagar = 0;
		$total_compras = 0;
		$total_pagamentos = 0;
		$total_comissoes = 0;
		
		$total_entradas = 0;
		$total_saidas = 0;

		$saldo_total = 0;
		
		 ?>

	<table class="table table-striped borda" cellpadding="6">
  <thead>
    <tr align="center">     
      <td scope="col" align="center"><b>Vendas</b></td>
      <td scope="col"><b>Recebimentos</b></td>
      <td scope="col"><b>Despesas</b></td>
      <td scope="col"><b>Compras</b></td>
      <td scope="col"><b>Pagamentos</b></td>
      <td scope="col"><b>Comissões</b></td>
      
    </tr>
  </thead>
  <tbody>

  	<?php
  	
	//totalizar os vendas 
  	$query = $pdo->query("SELECT * FROM receber where data_pgto >= '$dataInicial' and data_pgto <= '$dataFinal' and pago = 'Sim' and tipo = 'Venda' and empresa = '$id_empresa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
  	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

		$total_vendas += $res[$i]['valor'];

	}



	//totalizar contas recebidas
  	$query = $pdo->query("SELECT * FROM receber where data_pgto >= '$dataInicial' and data_pgto <= '$dataFinal' and tipo = 'Conta' and pago = 'Sim' and empresa = '$id_empresa' ORDER BY data_pgto asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
  	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

		$total_receber += $res[$i]['valor'];

	}





	//totalizar contas despesas
  	$query = $pdo->query("SELECT * FROM pagar where data_pgto >= '$dataInicial' and data_pgto <= '$dataFinal' and tipo = 'Conta' and pago = 'Sim' and empresa = '$id_empresa' ORDER BY data_pgto asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
  	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

		$total_pagar += $res[$i]['valor'];

	}




	//totalizar contas compras
  	$query = $pdo->query("SELECT * FROM pagar where data_pgto >= '$dataInicial' and data_pgto <= '$dataFinal' and tipo = 'Compra' and pago = 'Sim' and empresa = '$id_empresa' ORDER BY data_pgto asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
  	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

		$total_compras += $res[$i]['valor'];

	}


	//totalizar contas comissoes
  	$query = $pdo->query("SELECT * FROM comissoes where data_lanc >= '$dataInicial' and data_lanc <= '$dataFinal'  and pago = 'Sim' and empresa = '$id_empresa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
  	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

		$total_comissoes += $res[$i]['valor'];

	}



	//totalizar contas pagamentos
  	$query = $pdo->query("SELECT * FROM pagar where data_pgto >= '$dataInicial' and data_pgto <= '$dataFinal' and tipo = 'Pagamento' and pago = 'Sim' and empresa = '$id_empresa' ORDER BY data_pgto asc");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);	
  	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){}

		$total_pagamentos += $res[$i]['valor'];

	}

		
		
	$total_vendasF = number_format($total_vendas, 2, ',', '.');
	$total_receberF = number_format($total_receber, 2, ',', '.');	
	$total_pagarF = number_format($total_pagar, 2, ',', '.');	
	$total_comprasF = number_format($total_compras, 2, ',', '.');	
	$total_pagamentosF = number_format($total_pagamentos, 2, ',', '.');	
	$total_comissoesF = number_format($total_comissoes, 2, ',', '.');	
	
	$total_entradas = $total_vendas + $total_receber;	
	$total_saidas = $total_pagar + $total_compras + $total_pagamentos + $total_comissoes;

	$total_entradasF = number_format($total_entradas, 2, ',', '.');	
	$total_saidasF = number_format($total_saidas, 2, ',', '.');	

	$saldo_total = $total_entradas - $total_saidas;

	$saldo_totalF = number_format($saldo_total, 2, ',', '.');

	if($saldo_total < 0){
		$classe_saldo = 'text-danger';
		$classe_img = 'negativo.jpg';

	}else{
		$classe_saldo = 'text-success';
		$classe_img = 'positivo.jpg';
	}

  	 ?>

    <tr align="center" class="">

<td class="text-success">R$ <?php echo $total_vendasF ?></td>
<td class="text-success">R$ <?php echo $total_receberF ?></td>
<td class="text-danger">R$ <?php echo $total_pagarF ?></td>
<td class="text-danger">R$ <?php echo $total_comprasF ?></td>
<td class="text-danger">R$ <?php echo $total_pagamentosF ?></td>
<td class="text-danger">R$ <?php echo $total_comissoesF ?></td>

    </tr>


 <tr align="center" class="">
<td style="background: #e6ffe8" colspan="2" scope="col">Total de Entradas / Ganhos</td>
<td style="background: #ffe7e6" colspan="4" scope="col">Total de Saídas / Despesas</td>
</tr>

 <tr align="center" class="">
<td colspan="2" class="text-success"> R$ <?php echo $total_entradasF ?></td>
<td colspan="4" class="text-danger"> R$ <?php echo $total_saidasF ?></td>
</tr>
  
  </tbody>
</table>
	</div>



	<div class="col-md-12 p-2">
		<div class="" align="center" style="margin-right: 20px">

			<img src="<?php echo $url_sistema ?>/img/<?php echo $classe_img ?>" width="100px">
			<span class="<?php echo $classe_saldo ?>">R$ <?php echo $saldo_totalF ?></span>

				
		</div>
	</div>
	

	<div class="footer"  align="center">
		<span style="font-size:10px"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></span> 
	</div>

</body>
</html>