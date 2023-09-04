<?php 
$tabela = 'produtos';
require_once("../../../conexao.php");
$nome = $_POST['nome'];
$codigo = $_POST['codigo'];
$categoria = $_POST['categoria'];
$fornecedor = $_POST['fornecedor'];
$valor_venda = $_POST['valor_venda'];
$nivel_estoque = $_POST['nivel_estoque'];
$valor_venda = str_replace(',', '.', $valor_venda);
$id = $_POST['id'];
$id_empresa = $_POST['id_empresa'];


//validar codigo
if($codigo != ""){
	$query = $pdo->query("SELECT * from $tabela where codigo = '$codigo' and empresa = '$id_empresa'");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	if(@count($res) > 0 and $id != $res[0]['id']){
		echo 'Código já Cadastrado, escolha outro!!';
		exit();
	}
}




//validar troca da foto
$query = $pdo->query("SELECT * FROM $tabela where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto'];
}else{
	$foto = 'sem-foto.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = '../../images/produtos/'.$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif' or $ext == 'webp'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('../../images/produtos/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}




if($id == ""){
	$query = $pdo->prepare("INSERT into $tabela SET empresa = '$id_empresa', nome = :nome, valor_venda = :valor_venda, codigo = :codigo, categoria = '$categoria', ativo = 'Sim', data = curDate(), fornecedor = '$fornecedor', foto = '$foto', nivel_estoque = '$nivel_estoque' "); 	

}else{
	$query = $pdo->prepare("UPDATE $tabela SET nome = :nome, valor_venda = :valor_venda, codigo = :codigo, categoria = '$categoria', fornecedor = '$fornecedor', foto = '$foto', nivel_estoque = '$nivel_estoque' WHERE id = '$id' ");
	
}

$query->bindValue(":nome", "$nome");
$query->bindValue(":valor_venda", "$valor_venda");
$query->bindValue(":codigo", "$codigo");
$query->execute();

echo 'Salvo com Sucesso';
 ?>