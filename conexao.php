<?php 
$banco = 'sas';
$usuario = 'root';
$senha = '';
$servidor = 'localhost';

$url_sistema = "http://$_SERVER[HTTP_HOST]/";
$url = explode("//", $url_sistema);
if($url[1] == 'localhost/'){
	$url_sistema = "http://$_SERVER[HTTP_HOST]/vendas/";
}

date_default_timezone_set('America/Sao_Paulo');

try {
	$pdo = new PDO("mysql:dbname=$banco;host=$servidor;charset=utf8", "$usuario", "$senha");
} catch (Exception $e) {
	echo 'Erro nos dados de conexão com o banco!<br>'.$e;
}


require('api/mensagem.php');
//exit();

 ?>