<?php 
include('../conexao.php');

$dataInicial = $_GET['dataInicial'];
$dataFinal = $_GET['dataFinal'];
$status = $_GET['status'];
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




if($status == 'entradas'){
	$titulo_rel = 'Entradas';
}else{
	$titulo_rel = 'Saídas';	
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Relatório de <?php echo $titulo_rel ?></title>
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

	<div class="titulo_cab titulo_img"><u>Relatório de <?php echo $titulo_rel ?> Produtos</u></div>	
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

	
	$query = $pdo->query("SELECT * FROM $status where data >= '$dataInicial' and data <= '$dataFinal' and empresa = '$id_empresa' ORDER BY id desc");
				
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){
		 ?>

	<table class="table table-striped borda" cellpadding="6">
  <thead>
    <tr align="center">
    <th>Quantidade</th>	
	<th class="">Produto</th>
	<th class="esc">Motivo</th>	
	<th class="esc">Usuário</th>	
	<th class="esc">Data</th>	
    </tr>
  </thead>
  <tbody>

  	<?php 
  	for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$quantidade = $res[$i]['quantidade'];
$motivo = $res[$i]['motivo'];
$usuario = $res[$i]['usuario'];
$data = $res[$i]['data'];
$produto = $res[$i]['produto'];

$motivoF = mb_strimwidth($motivo, 0, 60, "...");

$data_F = implode('/', array_reverse(explode('-', $data)));

$query2 = $pdo->query("SELECT * FROM produtos where id = '$produto'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_produto = @$res2[0]['nome'];

$query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$nome_usuario = @$res2[0]['nome'];
		
  	 ?>

   <tr  class="<?php echo $classe_debito ?>">
<td><?php echo $quantidade ?></td>
<td class=""><?php echo $nome_produto ?></td>
<td class="esc"><?php echo $motivoF ?></td>
<td class="esc"><?php echo $nome_usuario ?></td>
<td class="esc"><?php echo $data_F ?></td>
    </tr>

<?php } ?>
  
  </tbody>
</table>

<?php }else{
echo 'Não possuem registros para serem exibidos!';
exit();
} ?>

	</div>








	<div class="footer"  align="center">
		<span style="font-size:10px"><?php echo $nome_sistema ?> Telefone: <?php echo $telefone_sistema ?></span> 
	</div>

</body>
</html>