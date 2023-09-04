<?php 
//fazer o agendamento da mensagem da api whatsapp para os clientes
//Criar uma config caso não tenha nenhuma
$data_hoje = date('Y-m-d');
$query = $pdo->query("SELECT * FROM config WHERE empresa = 0");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$token = $res[0]['token'];
$tokenp = $res[0]['token'];
$data_envio = $res[0]['data'];
$whats = $res[0]['telefone_sistema'];
$msg_bloqueio = $res[0]['msg_bloqueio'];
$whatsapp = '55'.preg_replace('/[ ()-]+/' , '' , $whats);
$what = '55'.preg_replace('/[ ()-]+/' , '' , $whats);

if($token != ""){
if($data_envio != $data_hoje){

		$query90 = $pdo->query("SELECT * FROM empresas where ativo = 'Sim' order by id desc");
		$res90 = $query90->fetchAll(PDO::FETCH_ASSOC);
		$total_reg90 = @count($res90);
		if($total_reg90 > 0){
			for($i90=0; $i90 < $total_reg90; $i90++){	
				
			$id_empresa = $res90[$i90]['id'];
			$nome = $res90[$i90]['nome'];
			$telefone = $res90[$i90]['telefone'];		
			$data_pgto = $res90[$i90]['data_pgto'];
			$valor = $res90[$i90]['valor'];
			

			$query2 = $pdo->query("SELECT * FROM config WHERE empresa = '$id_empresa'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
			$token2 = @$res2[0]['token'];

			$valorF = number_format($valor, 2, ',', '.');
			$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
			
			$cliente = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);

			if($token2 != ""){
				$whatsapp = $cliente;
				$token = $token2;
			}else{
				$whatsapp = $what;
				$token = $tokenp;
			}




//receber hoje
$total_receber_hoje = 0;
$query = $pdo->query("SELECT * FROM receber where data_venc = curDate() and pago != 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_hoje += $res[$i]['valor'];
}
$total_receber_hojeF = number_format($total_receber_hoje, 2, ',', '.');

//pagar hoje
$total_pagar_hoje = 0;
$query = $pdo->query("SELECT * FROM pagar where data_venc = curDate() and pago != 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_pagar_hoje += $res[$i]['valor'];
}
$total_pagar_hojeF = number_format($total_pagar_hoje, 2, ',', '.');



//totalizar estoque baixo
$estoque_baixo = 0;
$query = $pdo->query("SELECT * FROM produtos where ativo = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
for($i=0; $i < $total_reg; $i++){	
$nivel_estoque = $res[$i]['nivel_estoque'];
$estoque = $res[$i]['estoque'];
	if($estoque < $nivel_estoque){	
		$estoque_baixo += 1;
	}
}

$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_empresas = @count($res);



//recebimentos vencidos
$total_receber_vencidas = 0;
$query = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and empresa = '$id_empresa' order by data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contas_receber_venc = @count($res);
for($i=0; $i < @count($res); $i++){	
$total_receber_vencidas += $res[$i]['valor'];
}
$total_receber_vencidasF = number_format($total_receber_vencidas, 2, ',', '.');


//pagamentos vencidos
$total_pagar_vencidas = 0;
$query = $pdo->query("SELECT * FROM pagar where data_venc < curDate() and pago != 'Sim' and empresa = '$id_empresa' order by data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contas_pagar_venc = @count($res);
for($i=0; $i < @count($res); $i++){	
$total_pagar_vencidas += $res[$i]['valor'];
}
$total_pagar_vencidasF = number_format($total_pagar_vencidas, 2, ',', '.');



//total de contas vencidas
$total_contas_vencidas = $total_contas_receber_venc + $total_contas_pagar_venc;

			
			$mensagem = '*_DETALHAMENTO DIÁRIO_*%0A%0A';
			$mensagem .= '*Cliente:* '.$nome.'%0A';
			$mensagem .= '*Total de Contas à Pagar Hoje* R$ '.@$total_pagar_hojeF.'%0A';
			$mensagem .= '*Total de Contas à Receber Hoje* R$ '.@$total_receber_hojeF.'%0A';
			$mensagem .= '*Produtos com Estoque Baixo* '.@$estoque_baixo.'%0A';
			$mensagem .= '*Total de Clientes* '.@$total_empresas.'%0A';
			$mensagem .= '*Total de Contas Vencidas* '.@$total_contas_vencidas.'%0A';


			//verificar se a empresa tem conta vencida
		$query2 = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' and pessoa = '$id_empresa' order by data_venc asc");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){
			$mensagem .= '%0A%0A';
			$mensagem .= '*_Você possui Débitos_*%0A';
			$mensagem .= $msg_bloqueio.'%0A';
		}

		
		require('texto.php');

		}
	}

$pdo->query("UPDATE config SET data = curDate() WHERE empresa = 0");

}

}
 ?>