<?php 
require_once("../conexao.php");
@session_start();
$id_usuario = $_SESSION['id_usuario'];


$home = 'ocultar';
$config = 'ocultar';
$abertura = 'ocultar';
$minhas_comissoes = 'ocultar';

//grupo pessoas
$usuarios = 'ocultar';
$funcionarios = 'ocultar';
$clientes = 'ocultar';
$fornecedores = 'ocultar';


//grupo cadastros
$frequencias = 'ocultar';
$cargos = 'ocultar';
$caixas = 'ocultar';
$formas_pgto = 'ocultar';

//grupo produtos
$produtos = 'ocultar';
$categorias = 'ocultar';
$estoque = 'ocultar';
$saidas = 'ocultar';
$entradas = 'ocultar';
$trocas = 'ocultar';

//grupo financeiro
$vendas = 'ocultar';
$compras = 'ocultar';
$pagar = 'ocultar';
$receber = 'ocultar';
$comissoes = 'ocultar';
$fluxo = 'ocultar';


//relatorios
$rel_produtos = 'ocultar';
$rel_entradas_saidas = 'ocultar';
$rel_comissoes = 'ocultar';
$rel_recebimentos = 'ocultar';
$rel_clientes = 'ocultar';
$rel_lucro = 'ocultar';
$rel_vendas = 'ocultar';
$rel_despesas = 'ocultar';
$rel_estoque = 'ocultar';
$rel_caixas = 'ocultar';
$rel_trocas = 'ocultar';


$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	for($i=0; $i < $total_reg; $i++){
		foreach ($res[$i] as $key => $value){}
		$permissao = $res[$i]['permissao'];
		
		$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$nome = $res2[0]['nome'];
		$chave = $res2[0]['chave'];
		$id = $res2[0]['id'];

		if($chave == 'home'){
			$home = '';
		}


		if($chave == 'config'){
			$config = '';
		}

		if($chave == 'minhas_comissoes'){
			$minhas_comissoes = '';
		}

		if($chave == 'abertura'){
			$abertura = '';
		}







		if($chave == 'usuarios'){
			$usuarios = '';
		}

		if($chave == 'funcionarios'){
			$funcionarios = '';
		}

		if($chave == 'clientes'){
			$clientes = '';
		}
		
		if($chave == 'fornecedores'){
			$fornecedores = '';
		}





		if($chave == 'formas_pgto'){
			$formas_pgto = '';
		}

		if($chave == 'frequencias'){
			$frequencias = '';
		}

		if($chave == 'cargos'){
			$cargos = '';
		}

		if($chave == 'caixas'){
			$caixas = '';
		}

		



		if($chave == 'produtos'){
			$produtos = '';
		}

		if($chave == 'categorias'){
			$categorias = '';
		}

		if($chave == 'estoque'){
			$estoque = '';
		}

		if($chave == 'saidas'){
			$saidas = '';
		}

		if($chave == 'entradas'){
			$entradas = '';
		}

		if($chave == 'trocas'){
			$trocas = '';
		}



		if($chave == 'compras'){
			$compras = '';
		}

		if($chave == 'vendas'){
			$vendas = '';
		}

		if($chave == 'pagar'){
			$pagar = '';
		}

		if($chave == 'receber'){
			$receber = '';
		}

		if($chave == 'comissoes'){
			$comissoes = '';
		}

		if($chave == 'fluxo'){
			$fluxo = '';
		}






		if($chave == 'rel_produtos'){
			$rel_produtos = '';
		}

		if($chave == 'rel_entradas_saidas'){
			$rel_entradas_saidas = '';
		}

		if($chave == 'rel_comissoes'){
			$rel_comissoes = '';
		}

		if($chave == 'rel_recebimentos'){
			$rel_recebimentos = '';
		}

		if($chave == 'rel_clientes'){
			$rel_clientes = '';
		}

		if($chave == 'rel_lucro'){
			$rel_lucro = '';
		}

		if($chave == 'rel_vendas'){
			$rel_vendas = '';
		}

		if($chave == 'rel_despesas'){
			$rel_despesas = '';
		}

		if($chave == 'rel_estoque'){
			$rel_estoque = '';
		}

		if($chave == 'rel_caixas'){
			$rel_caixas = '';
		}

		if($chave == 'rel_trocas'){
			$rel_trocas = '';
		}




	}

}



if($home != 'ocultar'){
	$pag_inicial = 'home';
}else if($abertura != 'ocultar'){
	$pag_inicial = 'abertura';
}else{
	$query = $pdo->query("SELECT * FROM usuarios_permissoes where usuario = '$id_usuario' order by id asc limit 1");
	$res = $query->fetchAll(PDO::FETCH_ASSOC);
	$total_reg = @count($res);
	if($total_reg > 0){	
			$permissao = $res[0]['permissao'];		
			$query2 = $pdo->query("SELECT * FROM acessos where id = '$permissao'");
			$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);		
			$pag_inicial = $res2[0]['chave'];		

	}
}



if($usuarios == 'ocultar' and $funcionarios == 'ocultar' and $clientes == 'ocultar' and $fornecedores == 'ocultar'){
	$menu_pessoas = 'ocultar';
}else{
	$menu_pessoas = '';
}



if($cargos == 'ocultar' and $caixas == 'ocultar' and $formas_pgto == 'ocultar' and $frequencias == 'ocultar'){
	$menu_cadastros = 'ocultar';
}else{
	$menu_cadastros = '';
}



if($produtos == 'ocultar' and $categorias == 'ocultar' and $estoque == 'ocultar' and $saidas == 'ocultar' and $entradas == 'ocultar'  and $trocas == 'ocultar'){
	$menu_produtos = 'ocultar';
}else{
	$menu_produtos = '';
}



if($compras == 'ocultar' and $vendas == 'ocultar' and $pagar == 'ocultar' and $receber == 'ocultar' and $comissoes == 'ocultar' and $fluxo == 'ocultar'){
	$menu_financeiro = 'ocultar';
}else{
	$menu_financeiro = '';
}



if($rel_produtos == 'ocultar' and $rel_entradas_saidas == 'ocultar' and $rel_comissoes == 'ocultar' and $rel_recebimentos == 'ocultar' and $rel_clientes == 'ocultar' and $rel_lucro == 'ocultar' and $rel_vendas == 'ocultar' and $rel_despesas == 'ocultar' and $rel_estoque == 'ocultar' and $rel_caixas == 'ocultar' and $rel_trocas == 'ocultar'){
	$menu_relatorio = 'ocultar';
}else{
	$menu_relatorio = '';
}



 ?>