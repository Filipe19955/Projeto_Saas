<?php 
@session_start();
require_once("../../../conexao.php");

$cpf = $_POST['cpf'];


$query = $pdo->query("SELECT * FROM clientes WHERE cpf = '$cpf'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo $res[0]['nome'].'-*'.$res[0]['cpf'];
}
 ?>

