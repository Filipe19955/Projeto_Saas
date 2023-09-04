<?php
$tabela = 'itens_grade';
require_once("../../../conexao.php");

$id = $_POST['id'];

$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';
 ?>