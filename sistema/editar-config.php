<?php 
require_once("../conexao.php");
$nome = $_POST['nome_sistema'];
$email = $_POST['email_sistema'];
$telefone = $_POST['telefone_sistema'];
$tipo_rel = $_POST['tipo_rel'];
$id_empresa = $_POST['id_empresa'];
$tipo_desconto = $_POST['tipo_desconto'];
$comissao = $_POST['comissao'];
$endereco_sistema = $_POST['endereco_sistema'];
$cnpj_sistema = $_POST['cnpj_sistema'];
$token = $_POST['token'];

//validar troca da foto
$query = $pdo->query("SELECT * FROM config where empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto_rel'];
}else{
	$foto = 'logo-rel.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto-logo-rel']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = 'images/logos/' .$nome_img;

$imagem_temp = @$_FILES['foto-logo-rel']['tmp_name']; 

if(@$_FILES['foto-logo-rel']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'jpg'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "logo-rel.jpg"){
				@unlink('images/logos/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}



$query = $pdo->prepare("UPDATE config SET nome_sistema = :nome_sistema, email_sistema = :email_sistema, telefone_sistema = :telefone_sistema, tipo_rel = '$tipo_rel', foto_rel = '$foto', tipo_desconto = '$tipo_desconto', comissao = '$comissao', endereco_sistema = '$endereco_sistema', cnpj_sistema = '$cnpj_sistema', token = '$token' where empresa = '$id_empresa'");

$query->bindValue(":nome_sistema", "$nome");
$query->bindValue(":email_sistema", "$email");
$query->bindValue(":telefone_sistema", "$telefone");
$query->execute();

echo 'Editado com Sucesso';
 ?>
