<?php 
@session_start();
require_once("../conexao.php");

$id_usuario = $_POST['id_usu'];
$nivel_usuario = $_POST['nivel_usu'];
$id_empresa = $_POST['id_empresa'];

$_SESSION['id_usuario'] = $id_usuario;
$_SESSION['nivel'] = $nivel_usuario;
$_SESSION['id_empresa'] = $id_empresa;

//trazer dados do usuário logado
$query = $pdo->query("SELECT * FROM usuarios WHERE id = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo $res[0]['nome'].'-*'.$res[0]['nivel'].'-*'.$res[0]['foto'].'-*'.$res[0]['email'].'-*'.$res[0]['cpf'].'-*'.$res[0]['telefone'].'-*'.$res[0]['senha'].'-*'.$res[0]['endereco'].'-*'.$res[0]['ativo'];
}
 ?>

