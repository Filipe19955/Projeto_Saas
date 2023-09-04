<?php 
$tabela = 'empresas';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * FROM $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Nome</th>	
	<th class="esc">Telefone</th>	
	<th class="esc">Email</th>
	<th class="esc">CNPJ</th>
	<th class="esc">Data PGTO</th>
	<th class="esc">Valor</th>
	<th>Ações</th>
	</tr> 
	</thead> 
	<tbody>	
HTML;

for($i=0; $i < $total_reg; $i++){	
$id = $res[$i]['id'];
$nome = $res[$i]['nome'];
$telefone = $res[$i]['telefone'];
$email = $res[$i]['email'];
$cpf = $res[$i]['cpf'];
$cnpj = $res[$i]['cnpj'];
$ativo = $res[$i]['ativo'];
$data_cad = $res[$i]['data_cad'];
$data_pgto = $res[$i]['data_pgto'];
$valor = $res[$i]['valor'];
$endereco = $res[$i]['endereco'];	
$teste = $res[$i]['teste'];	

$valorF = number_format($valor, 2, ',', '.');
$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));

$whats = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);


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

if($teste == 'Sim'){
	$texto_teste = '<small><span class="text-danger">(TESTE)</span></small>';
}else{
	$texto_teste = '';
}


//verificar se a empresa tem conta vencida
$query2 = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' and pessoa = '$id' order by data_venc asc");
							$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
							$total_reg2 = @count($res2);
							if($total_reg2 > 0){
								 $conta_pendente = 'text-danger';
								}else{
									$conta_pendente = '';
								}


echo <<<HTML
<tr style="color:{$classe_ativo}">
<td><a href="#" onclick="painelEmpresa('{$id}')" class="{$conta_pendente}">{$nome} {$texto_teste}</a></td>
<td class="esc">{$telefone}</td>
<td class="esc">{$email}</td>
<td class="esc">{$cnpj}</td>
<td class="esc">{$data_pgtoF}</td>
<td class="esc">R$ {$valorF}</td>
<td>

<big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$cpf}','{$cnpj}','{$valor}','{$data_pgto}','{$endereco}','{$teste}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

<big><a href="#" onclick="excluirModal('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-trash-o text-danger"></i></a></big>

<big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$cpf}','{$cnpj}','{$valorF}','{$data_pgtoF}','{$endereco}','{$ativo}','{$data_cadF}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>



<big><a href="http://api.whatsapp.com/send?1=pt_BR&phone=$whats&text=" target="_blank" title="Abrir Whatsapp" class="text-verde"><i class="fa fa-whatsapp text-verde"></i></a></big>


<big><a href="#" onclick="arquivo('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-files-o text-primary"></i></a></big>


<big><a href="#" onclick="contas('{$id}','{$nome}')" title="Ver Contas"><i class="fa fa-dollar text-verde"></i></a></big>

<big><a href="#" onclick="contrato('{$id}','{$nome}')" title="Gerar Contrato"><i class="fa fa-file-pdf-o text-primary"></i></a></big>

</td>
</tr>
HTML;
}

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
	function editar(id, nome, email, telefone, cpf, cnpj, valor, data_pgto, endereco, teste){

		if(teste == ""){
			teste = 'Não';
		}

		$('#id').val(id);
		$('#nome').val(nome);
		$('#email').val(email);
		$('#telefone').val(telefone);
		$('#cpf').val(cpf);
		$('#cnpj').val(cnpj);
		$('#valor').val(valor);
		$('#data_pgto').val(data_pgto);
		$('#endereco').val(endereco);	
		$('#teste').val(teste).change();		
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}



	function mostrar(nome, email, telefone, cpf, cnpj, valor, data_pgto, endereco, ativo, data_cad){
		
		$('#titulo_dados').text(nome);
		$('#email_dados').text(email);
		$('#telefone_dados').text(telefone);
		$('#cpf_dados').text(cpf);
		$('#cnpj_dados').text(cnpj);
		$('#valor_dados').text(valor);
		$('#data_pgto_dados').text(data_pgto);
		$('#endereco_dados').text(endereco);	
		$('#ativo_dados').text(ativo);	
		$('#data_cad_dados').text(data_cad);
				
		$('#modalDados').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
		$('#email').val('');
		$('#telefone').val('');
		$('#cpf').val('');
		$('#cnpj').val('');
		$('#valor').val('');
		$('#data_pgto').val('');
		$('#endereco').val('');
	}



	function arquivo(id, nome){
		
		$('#titulo_arquivo').text(nome);		
		$('#id_arquivo').val(id);	
		$('#id_usuario_arquivo').val(localStorage.id_usu);	
		$('#target').attr("src", "images/arquivos/sem-foto.png");			
		$('#id_arquivo').val(id);				
		$('#modalArquivos').modal('show');
		listarArquivos(id);
		limparArquivos();
	}

	function limparArquivos(){
		$('#nome_arquivo').val('');
		$('#data_validade').val('');
		$('#foto').val('');
		$('#target').attr("src", "images/arquivos/sem-foto.png");
	}



	function contas(id, nome){
		
		$('#titulo_contas').text(nome);		
		$('#modalContas').modal('show');
		listarContas(id);
		
	}


	function contrato(id, nome){		
		$('#titulo_contrato').text(nome);
		$('#id_contrato').val(id);		
		$('#modalContrato').modal('show');
		listarTextoContrato(id);
		
	}



	function excluirModal(id, nome){
		$('#id_usuario_excluir').val(localStorage.id_usu);	
		$('#titulo_excluir').text(nome);		
		$('#id_excluir').val(id);				
		$('#modalExcluir').modal('show');		
	}

	function painelEmpresa(id){
		localStorage.setItem('id_empresa', id);
		 let a= document.createElement('a');
          a.target= '_blank';
          a.href= '../sistema/index.php?id_empresa='+id;
          a.click();
	}


</script>