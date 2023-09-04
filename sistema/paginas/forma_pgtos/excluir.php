<?php
$tabela = 'forma_pgtos';
require_once("../../../conexao.php");

$id = $_POST['id'];
$pdo->query("DELETE FROM $tabela where id = '$id'");
echo 'Excluído com Sucesso';
 ?>