<?php 
include('../conexao.php');

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_hoje = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

$data_atual = date('Y-m-d');

$id = $_GET['id'];


//BUSCAR AS INFORMAÇÕES DO PEDIDO
$res = $pdo->query("SELECT * from pagar where id = '$id' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
$id_empresa = $dados[0]['empresa'];
$total_venda = $dados[0]['valor'];
$tipo_pgto = $dados[0]['saida'];
$status = $dados[0]['pago'];
$data = $dados[0]['data_lanc'];
$operador = $dados[0]['usuario_lanc'];
$cliente = $dados[0]['pessoa'];
$data_pgto = $dados[0]['data_venc'];
$tipo = $dados[0]['tipo'];
$descricao = $dados[0]['descricao'];

if($descricao == ''){
	$descricao = 'Pagamento Emitido ';
}

$nome_cliente = '';
$cpf_cliente = '';
$referente = $descricao;

if($tipo == 'Pagamento'){
	$res = $pdo->query("SELECT * from usuarios where id = '$cliente' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_cliente = $dados[0]['nome'].', ';
	$cpf_cliente = $dados[0]['cpf'];
	$referente = 'ao pagamento deste funcionário ';
}
}

if($tipo == 'Comissão'){
	$res = $pdo->query("SELECT * from usuarios where id = '$cliente' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_cliente = $dados[0]['nome'].', ';
	$cpf_cliente = $dados[0]['cpf'];
	$referente = 'ao pagamento de comissão ';
}
}

if($tipo == 'Compra'){
	$res = $pdo->query("SELECT * from fornecedores where id = '$cliente' ");
$dados = $res->fetchAll(PDO::FETCH_ASSOC);
if(@count($dados) > 0){
	$nome_cliente = $dados[0]['nome'].', ';
	$cpf_cliente = $dados[0]['cpf'];
	$referente = 'à compra de Produtos ';
}
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
$total_vendaF = 'R$ '.number_format($total_venda , 2, ',', '.');

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

<div class="row" style="padding:10px; border:1px solid #000; margin:5px">
<div class="col-6">
<b>Nº Recibo</b> <?php echo $id ?>
</div>
<div class="col-6" align="right">
<b>Valor</b> <?php echo $total_vendaF ?>
</div>
</div>

	



<div  class="th title" >Recibo de Pagamento</div>



<div style="padding:10px" align='center'>Eu, <?php echo $nome_cliente ?>recebi de <?php echo $nome_sistema ?> a quantia de <b><?php echo $total_vendaF ?></b> na data <?php echo $data2 ?> correspondente <?php echo $referente ?> </div>
<br><br>
<div align="center" style="padding:10px">
__________________________________________<br>
ASSINATURA
</div>

<br><br>

	<div  class="th">
		<small><?php echo $endereco_sistema ?></small> <br />
		<small>Contato: <?php echo $telefone_sistema ?> 
		<?php if($cnpj_sistema != ""){echo ' / CNPJ '. @$cnpj_sistema; } ?>
	</small>  
</div>

</div>
