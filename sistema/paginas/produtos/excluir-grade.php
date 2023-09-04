<?php
$tabela = 'cat_grade';
require_once("../../../conexao.php");

$id = $_POST['id'];


$pdo->query("DELETE FROM $tabela where id = '$id'");
$pdo->query("DELETE FROM itens_grade where cat_grade = '$id'");

echo 'Excluído com Sucesso';
 ?>