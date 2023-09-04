<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];

echo '<option value="0">Selecionar Itens</option>';								

$query = $pdo->query("SELECT * FROM itens_grade where cat_grade = '$id'  order by nome asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){			
echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';
}

?>