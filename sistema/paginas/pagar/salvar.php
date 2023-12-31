<?php 
$tabela = 'pagar';
require_once("../../../conexao.php");

$descricao = $_POST['descricao'];
$funcionario = @$_POST['funcionario'];
$fornecedor = @$_POST['fornecedor'];
$valor = $_POST['valor'];
$valor = str_replace(',', '.', $valor);
$data_venc = $_POST['data_venc'];
$frequencia = $_POST['frequencia'];
$id_usuario = $_POST['id_usuario'];
$id = $_POST['id'];

$id_empresa = $_POST['id_empresa'];

if($funcionario != "" and $fornecedor != ""){
	echo 'Selecione um Funcionário ou um Fornecedor!';
	exit();
}

$pessoa = '0';
$tipo = 'Conta';

if($funcionario != ""){
	$pessoa = $funcionario;
	$tipo = 'Pagamento';
}

if($fornecedor != ""){
	$pessoa = $fornecedor;
	$tipo = 'Compra';
}


if($descricao == "" and $pessoa == ""){
	echo 'Escolha uma Empresa ou insira uma descrição!';
	exit();
}


if($descricao == "" and $fornecedor != ""){
	$query = $pdo->query("SELECT * FROM fornecedores where id = '$fornecedor'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$nome_pessoa = $res[0]['nome'];
	$descricao = $nome_pessoa;
}

if($descricao == "" and $funcionario != ""){
	$query = $pdo->query("SELECT * FROM usuarios where id = '$funcionario'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$nome_pessoa = $res[0]['nome'];
	$descricao = $nome_pessoa;
}


$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['arquivo'];
}else{
	$foto = 'sem-foto.png';
}

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['arquivo']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);
$caminho = '../../images/contas/' .$nome_img;

$imagem_temp = @$_FILES['arquivo']['tmp_name']; 

if(@$_FILES['arquivo']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'pdf' or $ext == 'rar' or $ext == 'zip' or $ext == 'doc' or $ext == 'docx'){ 

		if (@$_FILES['arquivo']['name'] != ""){

			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.png"){
				@unlink('../../images/contas/'.$foto);
			}

			$foto = $nome_img;
		}

		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



if($id == ""){
	$query = $pdo->prepare("INSERT INTO $tabela SET empresa = '$id_empresa', tipo = '$tipo', descricao = :descricao, pessoa = '$pessoa', valor = :valor, data_venc = '$data_venc', frequencia = '$frequencia', data_lanc = curDate(), usuario_lanc = '$id_usuario', arquivo = '$foto', pago = 'Não'");
	
}else{
	$query = $pdo->prepare("UPDATE $tabela SET descricao = :descricao, pessoa = '$pessoa', valor = :valor, data_venc = '$data_venc', frequencia = '$frequencia', data_lanc = curDate(), usuario_lanc = '$id_usuario', arquivo = '$foto' where id = '$id'");
	
}

$query->bindValue(":descricao", "$descricao");
$query->bindValue(":valor", "$valor");
$query->execute();
$ult_id = $pdo->lastInsertId();


echo 'Salvo com Sucesso';
 ?>