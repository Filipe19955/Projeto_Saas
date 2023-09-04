<?php 
require_once("../../../conexao.php");

$id = $_POST['id'];
$id_grade = @$_POST['id_grade'];

echo '<option value="0">Selecionar Grade</option>';								

if($id_grade != "0" || $id_grade != ""){
	$query = $pdo->query("SELECT * FROM cat_grade where produto = '$id' and id != '$id_grade' order by nome asc");
}else{
	$query = $pdo->query("SELECT * FROM cat_grade where produto = '$id'  order by nome asc");
}

$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){		
	
echo '<option value="'.$res[$i]['id'].'">'.$res[$i]['nome'].'</option>';

}

?>