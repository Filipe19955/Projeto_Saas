<?php 
$tabela = 'produtos';
require_once("../../../conexao.php");

$id_empresa = $_POST['id_empresa'];

$query = $pdo->query("SELECT * FROM $tabela where empresa = '$id_empresa' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Estoque</th>	
	<th class="esc">Valor Venda</th>	
	<th class="esc">Fornecedor</th>	
	<th class="esc">Categoria</th>	
	<th class="esc">Foto</th>	
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$codigo = $res[$i]['codigo'];
$descricao = $res[$i]['descricao'];
$estoque = $res[$i]['estoque'];
$valor_venda = $res[$i]['valor_venda'];
$valor_compra = $res[$i]['valor_compra'];
$lucro = $res[$i]['lucro'];
$fornecedor = $res[$i]['fornecedor'];
$categoria = $res[$i]['categoria'];
$foto = $res[$i]['foto'];
$data = $res[$i]['data'];
$ativo = $res[$i]['ativo'];
$nivel_estoque = $res[$i]['nivel_estoque'];

$valor_vendaF = number_format($valor_venda, 2, ',', '.');
$valor_compraF = number_format($valor_compra, 2, ',', '.');

	
$data_cadF = implode('/', array_reverse(explode('-', $data)));

if($ativo == 'Sim'){
	$icone = 'fa-check-square';
	$titulo_link = 'Desativar Item';
	$acao = 'Não';
	$classe_ativo = '';
}else{
	$icone = 'fa-square-o';
	$titulo_link = 'Ativar Item';
	$acao = 'Sim';
	$classe_ativo = '#c4c4c4';
}


$query2 = $pdo->query("SELECT * FROM categorias where id = '$categoria'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_cat = $res2[0]['nome'];
}else{
	$nome_cat = "Nenhuma";
}	


$query2 = $pdo->query("SELECT * FROM fornecedores where id = '$fornecedor'");
$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
$total_reg2 = @count($res2);
if($total_reg2 > 0){
	$nome_forn = $res2[0]['nome'];
}else{
	$nome_forn = "Nenhum";
}	


if($estoque < $nivel_estoque){	
	



echo <<<HTML
<tr style="color:{$classe_ativo}">
<td>{$nome}</td>
<td class="esc">{$estoque}</td>
<td class="esc">R$ {$valor_vendaF}</td>
<td class="esc">{$nome_forn}</td>
<td class="esc">{$nome_cat}</td>
<td><a href="images/produtos/{$foto}" target="_blank"><img src="images/produtos/{$foto}" width="30px" height="30px"></a></td>
<td>


<big><a href="#" onclick="mostrar('{$codigo}','{$nome}','{$descricao}','{$estoque}','{$valor_vendaF}','{$valor_compraF}','{$lucro}', '{$nome_forn}', '{$nome_cat}', '{$foto}', '{$data_cadF}', '{$ativo}','{$nivel_estoque}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


<big><a href="#" onclick="comprar('{$id}', '{$lucro}', '{$valor_venda}', '{$valor_compra}', '{$nome}')" title="Comprar Produtos"><i class="fa fa-shopping-cart" style="color:#741b47"></i></a></big>


<big><a href="#" onclick="entrada('{$id}', '{$nome}')" title="Entrada Produtos"><i class="fa fa-sign-in" style="color:#1d6aeb"></i></a></big>

<big><a href="#" onclick="saida('{$id}', '{$nome}')" title="Saída Produtos"><i class="fa fa-sign-out text-danger" ></i></a></big>

</td>
</tr>
HTML;
} }

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
</small>
HTML;

}else{
	echo '<small>Não possui registros cadastrados!</small>';
}

 ?>




 <script type="text/javascript">
	$(document).ready( function () {
    $('#tabela').DataTable({
    		"ordering": false,
			"stateSave": true
    	});
    $('#tabela_filter label input').focus();
} );
</script>




<script type="text/javascript">
	function editar(id, codigo, nome, categoria, venda, fornecedor, foto, nivel_estoque){
		$('#id').val(id);
		$('#nome').val(nome);
		$('#codigo').val(codigo);
		$('#categoria').val(categoria).change();
		$('#fornecedor').val(fornecedor).change();	
		$('#valor_venda').val(venda);
		$('#nivel_estoque').val(nivel_estoque);

		$('#target').attr('src','images/produtos/' + foto);
	
				
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');

		gerarCodigo()
		
	}



	function mostrar(codigo, nome, descricao, estoque, venda, compra, lucro, fornecedor, categoria, foto, data, ativo, nivel_estoque){
		
		$('#titulo_dados').text(nome);
		$('#codigo_dados').text(codigo);
		$('#categoria_dados').text(categoria);
		$('#venda_dados').text(venda);
		$('#compra_dados').text(compra);
		$('#estoque_dados').text(estoque);
		$('#nivel_estoque_dados').text(nivel_estoque);
		
		$('#lucro_dados').text(lucro);
		$('#fornecedor_dados').text(fornecedor);	
		$('#ativo_dados').text(ativo);	
		$('#data_cad_dados').text(data);
		$('#target_mostrar').attr('src','images/produtos/' + foto);
				
		$('#modalDados').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
		$('#codigo').val('');
		$('#valor_venda').val('');
		$('#target').attr('src','images/produtos/sem-foto.jpg');
		$('#foto').val('');
		$("#listar-codigo").html('');
		$('#nivel_estoque').val('');
	}


		function gerarEtiquetas(id, codigo, valor, nome){
		$('#id-etiqueta').val(id);
		$('#codigo-etiqueta').val(codigo);
		$('#valor-etiqueta').val(valor);
		$('#nome-etiqueta').val(nome);

		$('#titulo-etiquetas').text(nome);

		$('#modalEtiquetas').modal('show');
	}


	function comprar(id, lucro, venda, compra, nome){
		$('#quantidade_comprar').val('1');
		$('#total_compra').val('');
		$('#valor_venda_comprar').val('');


		$('#id-comprar').val(id);
		$('#valor_lucro').val(lucro);
		$('#valor_venda_comprar').val(venda);
		$('#valor_compra').val(compra);
		$('#id_empresa_comprar').val(localStorage.id_empresa);
		$('#id_usuario_comprar').val(localStorage.id_usu);

		$('#titulo-comprar').text(nome);

		$('#modalComprar').modal('show');
		calcular();
		listarSelectCatGrade(id, 'comprar');
		listarSelectCatGrade2(id, 'comprar');

		$('#itens_grade2_comprar').val('0').change();
		$('#itens_grade_comprar').val('0').change();


	}



	function grade(id, nome){		

		$('#id-grade').val(id);		
		$('#id_empresa_grade').val(localStorage.id_empresa);
		$('#id_usuario_grade').val(localStorage.id_usu);

		$('#titulo-grade').text(nome);

		$('#modalGrade').modal('show');
		listarGrade(id);

	}


	function entrada(id, nome){		

		$('#id-entrada').val(id);		
		$('#id_empresa_entrada').val(localStorage.id_empresa);
		$('#id_usuario_entrada').val(localStorage.id_usu);

		$('#titulo-entrada').text(nome);

		$('#quantidade_entrada').val('');	
		$('#motivo_entrada').val('');

		$('#estoque_check').prop('checked', false);	

		$('#modalEntrada').modal('show');
		listarSelectCatGrade(id, 'entrada');
		listarSelectCatGrade2(id, 'entrada');


		$('#itens_grade2_entrada').val('0').change();
		$('#itens_grade_entrada').val('0').change();
	}


	function saida(id, nome){		

		$('#id-saida').val(id);		
		$('#id_empresa_saida').val(localStorage.id_empresa);
		$('#id_usuario_saida').val(localStorage.id_usu);

		$('#titulo-saida').text(nome);

		$('#quantidade_saida').val('');	
		$('#motivo_saida').val('');	

		$('#modalSaida').modal('show');
		listarSelectCatGrade(id, 'saida');
		listarSelectCatGrade2(id, 'saida');

		$('#itens_grade2_saida').val('0').change();
		$('#itens_grade_saida').val('0').change();

	}

	


</script>