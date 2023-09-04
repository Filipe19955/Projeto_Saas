<?php 
$tabela = 'arquivos';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$data_validade = $_POST['data_validade'];
$id_usuario = $_POST['id_usuario'];
$id_ref = $_POST['id_arquivo'];
$foto = 'sem-foto.png';
$id_empresa = $_POST['id_empresa'];

//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/arquivos/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'rar' or $ext == 'zip' or $ext == 'pdf' or $ext == 'doc' or $ext == 'docx'){ 
	
			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}


$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', nome = :nome, tipo = 'Pagar', usuario = '$id_usuario', data_cad = curDate(), data_validade = '$data_validade', foto = '$foto', id_ref = '$id_ref'  "); 
$query->bindValue(":nome", "$nome");
$query->execute();

echo 'Salvo com Sucesso';
?>