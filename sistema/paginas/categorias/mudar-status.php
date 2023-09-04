<?php
$tabela = 'categorias';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];

$pdo->query("UPDATE $tabela SET ativo = '$acao' where id = '$id'");
$pdo->query("UPDATE produtos SET ativo = '$acao' where categoria = '$id'");

echo 'Alterado com Sucesso';
 ?>