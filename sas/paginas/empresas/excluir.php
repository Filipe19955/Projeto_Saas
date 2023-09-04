<?php
$tabela = 'empresas';
require_once("../../../conexao.php");

$id = $_POST['id'];
$senha = $_POST['senha'];

$query = $pdo->query("SELECT * FROM usuarios where nivel = 'SAS' and senha = '$senha'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg == 0){
	echo 'senha incorreta';
	exit();
}

//excluir os usuários relacionados a empresa
$pdo->query("DELETE FROM usuarios where empresa = '$id'");

//excluir dados das demais tabelas
$pdo->query("DELETE FROM arquivos where empresa = '$id'");
$pdo->query("DELETE FROM caixa where empresa = '$id'");
$pdo->query("DELETE FROM caixas where empresa = '$id'");
$pdo->query("DELETE FROM cargos where empresa = '$id'");
$pdo->query("DELETE FROM categorias where empresa = '$id'");
$pdo->query("DELETE FROM cat_grade where empresa = '$id'");
$pdo->query("DELETE FROM clientes where empresa = '$id'");
$pdo->query("DELETE FROM comissoes where empresa = '$id'");
$pdo->query("DELETE FROM config where empresa = '$id'");
$pdo->query("DELETE FROM contratos where empresa = '$id'");
$pdo->query("DELETE FROM detalhes_grade where empresa = '$id'");
$pdo->query("DELETE FROM entradas where empresa = '$id'");
$pdo->query("DELETE FROM forma_pgtos where empresa = '$id'");
$pdo->query("DELETE FROM fornecedores where empresa = '$id'");
$pdo->query("DELETE FROM frequencias where empresa = '$id'");
$pdo->query("DELETE FROM itens_grade where empresa = '$id'");
$pdo->query("DELETE FROM itens_venda where empresa = '$id'");
$pdo->query("DELETE FROM pagar where empresa = '$id'");
$pdo->query("DELETE FROM produtos where empresa = '$id'");
$pdo->query("DELETE FROM receber where empresa = '$id'");
$pdo->query("DELETE FROM saidas where empresa = '$id'");
$pdo->query("DELETE FROM sangrias where empresa = '$id'");
$pdo->query("DELETE FROM trocas where empresa = '$id'");


$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';
 ?>