<?php 
require_once("../../../conexao.php");
$id_empresa = $_POST['id_empresa'];
$param = @$_POST['param'];

 if($param != 'Salvo'){
 echo '<option value="">Selecionar Cliente</option>';
 echo '<option value="0">Sem Cliente</option>';
 }
 $query = $pdo->query("SELECT * from clientes where empresa = '$id_empresa' order by id desc");
 $res = $query->fetchAll(PDO::FETCH_ASSOC);
 $total_reg = @count($res);
 if($total_reg > 0){ 

  for($i=0; $i < $total_reg; $i++){
    foreach ($res[$i] as $key => $value){ }
      
    echo '<option value="'.$res[$i]['id'].'">'. $res[$i]['nome'] .' / '. $res[$i]['cpf'] .'</option>';

}

} 

?>