<?php
$tabela = 'empresas';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];

//excluir os usuários relacionados a empresa
$pdo->query("UPDATE usuarios SET ativo = '$acao' where empresa = '$id'");

$pdo->query("UPDATE $tabela SET ativo = '$acao' where id = '$id'");
echo 'Alterado com Sucesso';
 ?>