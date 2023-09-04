<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];
$estoque = @$_POST['estoque'];

echo '<option value="0">Selecionar Itens</option>';								

if($estoque == 'Sim'){
	$query = $pdo->query("SELECT * FROM itens_grade where cat_grade = '$id' and estoque > 0 order by nome asc");
}else{
	$query = $pdo->query("SELECT * FROM itens_grade where cat_grade = '$id'  order by nome asc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){			
echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
}

?>