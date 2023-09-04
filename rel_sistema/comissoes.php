<?php 
include('../conexao.php');

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$pago = $_GET['pago'];
$pessoa = $_GET['pessoa'];
$busca = $_GET['busca'];
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


if($pago == ''){
	$acao_rel = '';
}else{
	if($pago == 'Sim'){
		$acao_rel = ' Pagas ';
	}else{
		$acao_rel = ' Pendentes ';
	}
	
}



$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$pessoa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_pessoa = @$res[0]['nome'];

if($pessoa != ''){
	$texto_pessoa = ' Vendedor: '.$nome_pessoa;	
}else{
	$texto_pessoa = '';	
}

$pago = '%'.$pago.'%';

?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Comissões</title>
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

		.text-success{
			color:green;
		}

		.mx-2{
			margin:0px 10px;
		}
			
				

	</style>

</head>
<body>	

	<div class="titulo_cab titulo_img"><u>Relatório de Comissões <?php echo $acao_rel ?> <?php echo $texto_pessoa ?>  </u></div>	
	<div class="data_img"><?php echo mb_strtoupper($data_hoje) ?></div>

	<img class="imagem" src="<?php echo $url_sistema ?>/sistema/images/logos/<?php echo $logo_rel ?>">

	
	<br><br><br>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>

	<div class="mx-2" >

			
			<div style="margin-top: -20px; margin-bottom: 10px">
				<small><small><small><u><?php echo $texto_apuracao ?></u></small></small></small>
			</div>	
			

		


		<?php 
		$pendentesF = 0;
$recebidasF = 0;
$vencidasF = 0;
$pendentes = 0;
$recebidas = 0;
$vencidas = 0;

		if($pessoa != ""){
			$query = $pdo->query("SELECT * FROM comissoes where $busca >= '$dataInicial' and $busca <= '$dataFinal' and pago LIKE '$pago' and vendedor = '$pessoa'  and empresa = '$id_empresa' ORDER BY id desc");
		}else{
			$query = $pdo->query("SELECT * FROM comissoes where $busca >= '$dataInicial' and $busca <= '$dataFinal' and pago LIKE '$pago' and empresa = '$id_empresa' ORDER BY id desc");
		}
		
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		 ?>

	<table class="table table-striped borda" cellpadding="6">
  <thead>
    <tr align="center">
     <th class="esc">Valor</th> 
	<th class="esc">Vendedor</th>
	<th class="esc">Data Venda</th>		
	<th class="esc">Data Pgto</th>	
	<th class="esc">Valor Venda</th>
	<th class="esc">Operador</th>
    </tr>
  </thead>
  <tbody>

  	<?php 
  	for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
	$valor = $res[$i]['valor'];
	$data_lanc = $res[$i]['data_lanc'];
	$data_pgto = $res[$i]['data_pgto'];
	
	$usuario_lanc = $res[$i]['usuario_lanc'];
	$usuario_baixa = $res[$i]['usuario_pgto'];	
	$funcionario = $res[$i]['vendedor'];
	$id_venda = $res[$i]['id_ref'];
	$pago = $res[$i]['pago'];
		
	$valorF = number_format($valor, 2, ',', '.');
	$data_lancF = implode('/', array_reverse(explode('-', $data_lanc)));
	$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
	
	

		$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_baixa'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_usuario_pgto = $res2[0]['nome'];
		}else{
			$nome_usuario_pgto = 'Nenhum!';
		}



		$query2 = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_vendedor = $res2[0]['nome'];
		}else{
			$nome_vendedor = 'Nenhum!';
		}



		$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$nome_usuario_lanc = $res2[0]['nome'];
		}else{
			$nome_usuario_lanc = 'Sem Referência!';
		}



		$valor_vendaF = 0;
		$query2 = $pdo->query("SELECT * FROM receber where id = '$id_venda'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$valor_venda = $res2[0]['valor'];
			$valor_vendaF = number_format($valor_venda, 2, ',', '.');
		}


		if($pago == 'Sim'){
	$classe_pago = 'text-verde';
	$ocultar = 'ocultar';
	$recebidas += $valor;
	$imagem = 'verde.jpg';
}else{
	$classe_pago = 'text-danger';
	$ocultar = '';	
	$pendentes += $valor;
	$imagem = 'vermelho.jpg';
	$data_pgtoF = 'Pendente';
}

$recebidasF = number_format($recebidas, 2, ',', '.');
$pendentesF = number_format($pendentes, 2, ',', '.');
		
  	 ?>

   <tr  class="">
<td><img src="<?php echo $url_sistema ?>img/<?php echo $imagem ?>" width="10px" height="10px" style="margin-top: 4px"> R$ <?php echo $valorF ?></td> 
					<td class="esc"><?php echo $nome_vendedor ?></td>	
				<td class="esc"><?php echo $data_lancF ?></td>				
				<td class="esc"><?php echo $data_pgtoF ?></td>
				<td class="esc">R$ <?php echo $valor_vendaF ?></td>
				<td><?php echo $nome_usuario_lanc ?></td>
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

		<span class="text-danger"> <small><small><small><small>PENDENTES</small> : R$ <?php echo @$pendentesF ?></small></small></small>  </span>

		<span class="text-success"> <small><small><small><small>PAGAS</small> : R$ <?php echo @$recebidasF ?></small></small></small>  </span>


				
		</div>
	</div>
	<div class="cabecalho" style="border-bottom: solid 1px #0340a3">
	</div>



	<div class="footer"  align="center">
		<span style="font-size:10px"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></span> 
	</div>

</body>
</html>