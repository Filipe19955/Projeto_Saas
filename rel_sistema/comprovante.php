<?php 
include('../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$data_atual = date('Y-m-d');

$id = $_GET['id'];


//BUSCAR AS INFORMAÇÕES DO PEDIDO
$res = $pdo->query("SELECT * from receber where id = '$id' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
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

$nome_cliente = 'Não Informado';
$cpf_cliente = '';
$nome_vendedor = '';

$res = $pdo->query("SELECT * from clientes where id = '$cliente' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_cliente = $dados[0]['nome'];
	$cpf_cliente = $dados[0]['cpf'];
}

$res = $pdo->query("SELECT * from usuarios where id = '$vendedor' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_vendedor = $dados[0]['nome'];
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

$res = $pdo->query("SELECT * from usuarios where id = '$operador' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$nome_operador = $dados[0]['nome'];


if($tipo_desconto == '%'){
	$descontoF = number_format($desconto , 0, ',', '').'%';			
}else{
	$descontoF = 'R$ '.number_format($desconto , 2, ',', '.');
}


$garantia_dias = date('Y-m-d', strtotime("+$garantia days",strtotime($data))); 
$garantia_diasF = implode('/', array_reverse(explode('-', $garantia_dias)));
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<?php if(@$_GET['imp'] != 'Não'){ ?>
<script type="text/javascript">
	$(document).ready(function() {    		
		window.print();
		window.close(); 
	} );
</script>
<?php } ?>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

<style type="text/css">
	*{
		margin:0px;

		/*Espaçamento da margem da esquerda e da Direita*/
		padding:0px;
		background-color:#ffffff;


	}
	.text {
		&-center { text-align: center; }
	}
	
	.printer-ticket {
		display: table !important;
		width: 100%;

		/*largura do Campos que vai os textos*/
		max-width: 400px;
		font-weight: light;
		line-height: 1.3em;

		/*Espaçamento da margem da esquerda e da Direita*/
		padding: 0px;
		font-family: TimesNewRoman, Geneva, sans-serif; 

		/*tamanho da Fonte do Texto*/
		font-size: 11px; 



	}
	
	.th { 
		font-weight: inherit;
		/*Espaçamento entre as uma linha para outra*/
		padding:5px;
		text-align: center;
		/*largura dos tracinhos entre as linhas*/
		border-bottom: 1px dashed #000000;
	}

	.itens { 
		font-weight: inherit;
		/*Espaçamento entre as uma linha para outra*/
		padding:5px;
		
	}

	.valores { 
		font-weight: inherit;
		/*Espaçamento entre as uma linha para outra*/
		padding:2px 5px;
		
	}


	.cor{
		color:#000000;
	}
	
	
	.title { 
		font-size: 12px;
		text-transform: uppercase;
		font-weight: bold;
	}

	/*margem Superior entre as Linhas*/
	.margem-superior{
		padding-top:5px;
	}
	
	
}
</style>



<div class="printer-ticket">		
	<div  class="th title"><?php echo $nome_sistema ?></div>

	<div  class="th">
		<?php echo $endereco_sistema ?> <br />
		<small>Contato: <?php echo $telefone_sistema ?> 
		<?php if($cnpj_sistema != ""){echo ' / CNPJ '. @$cnpj_sistema; } ?>
	</small>  
</div>



<div  class="th">Cliente <?php echo $nome_cliente ?> <?php if($cpf_cliente != ""){ ?>CPF: <?php echo $cpf_cliente ?> <?php } ?>			
<br>
Venda: <b><?php echo $id ?></b> - Data: <?php echo $data2 ?> Hora: <?php echo $hora ?>
</div>

<div  class="th title" >Comprovante de Venda</div>

<div  class="th">CUMPOM NÃO FISCAL</div>

<?php 
$res = $pdo->query("SELECT * from itens_venda where venda = '$id' order by id asc");
		$dados = $res->fetchAll(PDO::FETCH_ASSOC);
		$linhas = count($dados);

		$sub_tot;
		for ($i=0; $i < count($dados); $i++) { 
			foreach ($dados[$i] as $key => $value) {
			}

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

			?>

	<div class="row itens">

		<div align="left" class="col-9"> <?php echo $quantidade ?> - <?php echo $nome_produto ?> <?php echo $detalhes_da_grade ?>

	</div>		

	<div align="right" class="col-3">
	R$ <?php

				@$total_item;
				@$sub_tot = @$sub_tot + @$total_item;
				$sub_total = $sub_tot;
				

				$sub_total = number_format( $sub_total , 2, ',', '.');
				$total_item = number_format( $total_item , 2, ',', '.');
				$total = number_format( $total_venda , 2, ',', '.');
				

				echo $total_item ;
		?>
	</div>

</div>

<?php } ?>

<div class="th" style="margin-bottom: 7px"></div>


	<div class="row valores">			
		<div class="col-6">SubTotal</div>
		<div class="col-6" align="right">R$ <?php echo @$sub_total ?></div>
	</div>		

	<div class="row valores">			
		<div class="col-6">Desconto</div>
		<div class="col-6" align="right"> <?php echo @$descontoF ?></div>
	</div>	

	<?php if($acrescimo > 0){ ?>
			<div class="row valores">			
		<div class="col-6">Acréscimo</div>
		<div class="col-6" align="right"> <?php echo @$acrescimo ?>%</div>
	</div>	
	<?php } ?>

	<div class="row valores">			
		<div class="col-6">Total</div>
		<div class="col-6" align="right"><b>R$ <?php echo @$total ?></b></div>
	</div>	

	<div class="row valores">			
		<div class="col-6">Total Pago</div>
		<div class="col-6" align="right">R$ <?php echo @$valor_recebido ?></div>
	</div>	

	<div class="row valores">			
		<div class="col-6">Troco</div>
		<div class="col-6" align="right">R$ <?php echo @$troco ?></div>
	</div>		


<div class="th" style="margin-bottom: 10px"></div>

	<div class="row valores">			
		<div class="col-6">Forma de Pagamento</div>
		<div class="col-6" align="right"> <?php echo @$nome_pgto ?></div>
	</div>	

		<div class="row valores">			
		<div class="col-6">Operador</div>
		<div class="col-6" align="right"> <?php echo @$nome_operador ?></div>
	</div>	


	<?php if($vendedor != '0' and $vendedor != ''){ ?>
			<div class="row valores">			
		<div class="col-6">Vendedor</div>
		<div class="col-6" align="right"> <?php echo @$nome_vendedor ?></div>
	</div>	
	<?php } ?>


		<?php if(strtotime($data_pgto) > strtotime($data_atual)){ ?>
			<div class="row valores">			
		<div class="col-6">Data PGTO</div>
		<div class="col-6" align="right"> <?php echo @$data_pgtoF ?></div>
	</div>	
	<?php } ?>

	<?php if($garantia > 0){ ?>
			<div class="row valores">			
		<div class="col-6"><b>Garantia válida até:</b></div>
		<div class="col-6" align="right"> <b><?php echo @$garantia_diasF ?></b></div>
	</div>	
	<?php } ?>


<div class="th" style="margin-bottom: 10px"></div>

