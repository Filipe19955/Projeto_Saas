<?php 
require_once("../../../conexao.php");

$id_usuario = $_POST['id_usuario'];
$id_empresa = $_POST['id_empresa'];
$novo_estoque = '';
$data_hoje = date('Y-m-d');

$valor_totalF = 0;
$valor_total = 0;
$total_vendaF = 0;

$id_do_produto = '';

//RECUPERAR O ID DA ABERTURA
$query_con = $pdo->query("SELECT * FROM caixa WHERE operador = '$id_usuario' and status = 'Aberto'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$id_abertura = $res[0]['id'];

$estoque = "";
$nome = "Código não Cadastrado";
$descricao = "";
$imagem = "";
$valor = "";
$valor_total = "";

$codigo = $_POST['codigo'];
$separar_codigo = explode("*", $codigo);
$quantidade = $_POST['quantidade'];

if(@count($separar_codigo) > 1){
  $quantidade = $separar_codigo[0];
  $codigo = $separar_codigo[1];
}

$desconto = $_POST['desconto'];
$desconto = str_replace(',', '.', $desconto);
$total_desconto = $desconto;
$valor_recebido = $_POST['valor_recebido'];
$valor_recebido = str_replace(',', '.', $valor_recebido);

$desconto_porcentagem = $_POST['tipo_desc'];
if($desconto_porcentagem == '%'){
	$desconto_porcentagem = 'Sim';
}

$forma_pgto_input = $_POST['forma_pgto_input'];
$cliente_input = $_POST['cliente_input'];
$data_pgto = $_POST['data_pgto'];

$totalvenda = @$_POST['totalvenda'];
$vendedor = @$_POST['vendedor'];
$acrescimo_input = @$_POST['acrescimo_input'];




if(strtotime($data_pgto) > strtotime($data_hoje)){
	$data_pagamento = '';
	$usuario_pagamento = '';
	$pago = 'Não';
}else{
	$data_pagamento = $data_hoje;
	$usuario_pagamento = $id_usuario;
	$pago = 'Sim';
}

//DEFINIR QUAL O TIPO DE PAGAMENTO E REDIRECIONAR PARA API (cartões)
if($forma_pgto_input == 'Cartão de Débito'){
	//VAMOS REDIRECIONR PARA API PAGAMENTO NO CRÉDITO OU DEBITO CASO VOCE IMPLEMENTE
}


if($forma_pgto_input == 'Fiado' || strtotime($data_pgto) > strtotime($data_hoje)){
	//VENDA FIADO
	if($cliente_input == ""){
		echo 'Selecione um Cliente!';
		exit();
	}
}


//FECHAR A VENDA
if($forma_pgto_input != ""){



	$troco = $_POST['valor_troco'];
	$garantia = @$_POST['garantia'];
	
	if($garantia == ""){
		$garantia = 0;
	}
	$troco = str_replace('R$', '', $troco);
	$troco = str_replace('.', '', $troco);
	$troco = str_replace(',', '.', $troco);

	$total_compra = $_POST['totalvenda'];

	$total_sem_taxa = $_POST['total_compra'];
	$total_sem_taxa = str_replace('R$', '', $total_sem_taxa);
	$total_sem_taxa = str_replace('.', '', $total_sem_taxa);
	$total_sem_taxa = str_replace(',', '.', $total_sem_taxa);


	if($troco < 0){
		echo 'O troco não pode ser menor que zero!';
		exit();
	}

	if($total_compra <= 0){
		echo 'Não é possível efetuar uma venda sem itens!';
		exit();
	}

	if($valor_recebido == ""){
		$valor_recebido = $total_compra;
	}

	if($desconto != ""){
		if($desconto_porcentagem == 'Sim'){
		$desconto = $desconto . '%';
		}else{
		$desconto = 'R$ '.$desconto . ',00';
		}
	}else{
		$desconto = 'R$ 0,00';
	}
	

	$res = $pdo->prepare("INSERT INTO receber SET empresa = '$id_empresa', tipo = 'Venda', descricao = 'Venda',  valor = :valor, data_lanc = curDate(), hora = curTime(), data_venc = '$data_pgto', data_pgto = '$data_pagamento', usuario_lanc = :usuario, usuario_pgto = '$usuario_pagamento', frequencia = '0', valor_recebido = :valor_recebido, desconto = :desconto, troco = :troco, saida = :forma_pgto, id_ref = :abertura, pessoa = '$cliente_input', pago = '$pago', arquivo = 'sem-foto.png', acrescimo = '$acrescimo_input', vendedor = '$vendedor', garantia = '$garantia' ");

	$res->bindValue(":valor_recebido", $valor_recebido);
	$res->bindValue(":desconto", $total_desconto);
	$res->bindValue(":valor", $total_compra);
	$res->bindValue(":usuario", $id_usuario);
	$res->bindValue(":troco", $troco);
	$res->bindValue(":forma_pgto", $forma_pgto_input);
	$res->bindValue(":abertura", $id_abertura);
	$res->execute();
	$id_venda = $pdo->lastInsertId();


// COMISSAO DO VENDEDOR
if($vendedor != "" and $vendedor != "0"){
//RECUPERAR O VALOR DA COMISSAO
	//RECUPERAR NOME DO VENDEDOR
$query_con = $pdo->query("SELECT * FROM usuarios WHERE id = '$vendedor'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$nome_vendedor = $res[0]['nome'];
$comissao_vendedor = $res[0]['comissao'];
$descricao_comissao = 'Comissão: '.$nome_vendedor;

$query_con = $pdo->query("SELECT * FROM config WHERE empresa = '$id_empresa'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
if($comissao_vendedor != ""){
	$comissao = $comissao_vendedor;
}else{
	$comissao = $res[0]['comissao'];
}

$total_comissao = $total_sem_taxa * $comissao / 100;
$pdo->query("INSERT INTO comissoes SET empresa = '$id_empresa', descricao = '$descricao_comissao', valor = '$total_comissao', data_lanc = curDate(), usuario_lanc = '$id_usuario', id_ref = '$id_venda', vendedor = '$vendedor', pago = 'Não'");
}

		
	//RELACIONAR OS ITENS DA VENDA COM A NOVA VENDA
	$query_con = $pdo->query("UPDATE itens_venda SET empresa = '$id_empresa', venda = '$id_venda' WHERE usuario = '$id_usuario' and venda = 0");

	echo 'Venda Salva!&-/z'.$id_venda;
	exit();
}


$troco = 0;
$trocoF = 0;

if($desconto == ""){
	$desconto = 0;
}


if($codigo != ""){

$valor_unit = $_POST['valor_unitario'];
$valor_unit = str_replace(',', '.', $valor_unit);


$query_con = $pdo->query("SELECT * FROM produtos WHERE codigo = '$codigo'");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
if(@count($res) > 0){
	$estoque = $res[0]['estoque'];
	$nome = $res[0]['nome'];
	$descricao = $res[0]['descricao'];
	$imagem = $res[0]['foto'];
	$valor = $res[0]['valor_venda'];
	$id = $res[0]['id'];
	$id_do_produto = $res[0]['id'];

	if($estoque == ""){
		$estoque = 0;
	}

	if($valor == 0){
	if($valor_unit == "" || $valor_unit <= 0){
	echo 'Preencha um Valor para o Produto!';
	exit();
}
}




	if($estoque < $quantidade and $valor != "0"){
		echo 'Quantidade em Estoque Insuficiente!&-/z Por enquanto temos '.$estoque .' Produtos em Estoque';
		exit();
	}

	if($valor <= 0){
		$valor = $valor_unit;
	}

	

	$valor_total = $valor * $quantidade;
	$valor_totalF =  number_format($valor_total, 2, ',', '.');


	//INSERIR NA TABELA ITENS VENDAS
	$res = $pdo->prepare("INSERT INTO itens_venda SET empresa = '$id_empresa', produto = :produto, valor_unitario = :valor, usuario = :usuario, venda = '0', quantidade = :quantidade, data = curDate()");
	$res->bindValue(":produto", $id);
	$res->bindValue(":valor", $valor);
	$res->bindValue(":usuario", $id_usuario);
	$res->bindValue(":quantidade", $quantidade);
	
	
	$res->execute();
	$id_item_venda = $pdo->lastInsertId();

	if($estoque > 0){
		//ABATER OS PRODUTOS DO ESTOQUE
		$novo_estoque = $estoque - $quantidade;
		$res = $pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE id = '$id'");
		$res->bindValue(":estoque", $novo_estoque);
		$res->execute();
	}



}else{
	echo 'Código do Produto não Encontrado!';
		exit();
}
}



//TOTALIZAR A VENDA

$total_venda = 0;
$query_con = $pdo->query("SELECT * FROM itens_venda WHERE empresa = '$id_empresa' and usuario = '$id_usuario' and venda = 0 order by id desc");
$res = $query_con->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){ 
	for($i=0; $i < $total_reg; $i++){
	foreach ($res[$i] as $key => $value){	}

		
		$valor_total_item = $res[$i]['valor_unitario'] * $res[$i]['quantidade'];
		
		$total_venda += $valor_total_item;
		
				
	}

	if($desconto_porcentagem == 'Sim'){
		$desconto = str_replace('%', '', $desconto);
		if($desconto < 10){
			$desconto = '0.0'.$desconto;
		}else{
			$desconto = '0.'.$desconto;
		}
		
		$total_venda = $total_venda -  ($total_venda * $desconto);
	}else{
		$total_venda = $total_venda - $desconto;
	}
	
	$total_vendaF =  number_format($total_venda, 2, ',', '.');

	if($valor_recebido == ""){
		$valor_recebido = 0;
	}else{
		$troco = $valor_recebido - $total_venda;
		$trocoF =  number_format($troco, 2, ',', '.');
	}	

	
		
}


//verificar se o produto possui grade
$query = $pdo->query("SELECT * FROM cat_grade where produto = '$id_do_produto'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$grade = $total_reg;
}else{
	$grade = $total_reg;
}


$dados = $novo_estoque .'&-/z'. $nome .'&-/z'. $descricao .'&-/z'. $imagem .'&-/z'. $valor .'&-/z'. $valor_total .'&-/z'. $valor_totalF .'&-/z'. $total_venda .'&-/z'. @$total_vendaF .'&-/z'. $troco .'&-/z'. $trocoF.'&-/z'. $grade.'&-/z'. $id_do_produto.'&-/z'. @$id_item_venda;
	echo $dados;




 ?>
