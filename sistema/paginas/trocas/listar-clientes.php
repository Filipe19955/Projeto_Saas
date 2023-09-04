<?php 
@session_start();
require_once("../../../conexao.php");

$id = $_POST['id'];


$query = $pdo->query("SELECT * FROM clientes WHERE id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo $res[0]['nome'].'-*'.$res[0]['cpf'];
}
 ?>

