<?php 
$tabela = 'clientes';
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
	<th class="esc">Telefone</th>	
	<th class="esc">Email</th>	
	<th class="esc">CPF</th>	
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
$data_cad = $res[$i]['data'];
$endereco = $res[$i]['endereco'];
	
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));


$whats = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);


//verificar se cliente tem conta vencida
$query2 = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and empresa = '$id_empresa' and pessoa = '$id' order by data_venc asc");
							$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
							$total_reg2 = @count($res2);
							if($total_reg2 > 0){
								 $conta_pendente = 'text-danger';
								}else{
									$conta_pendente = '';
								}


echo <<<HTML
<tr>
<td class="{$conta_pendente}">{$nome}</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$email}</td>
<td class="esc">{$cpf}</td>
<td>

<big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$cpf}','{$endereco}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
</li>


<big><a href="#" onclick="mostrar('{$id}', '{$nome}','{$email}','{$telefone}','{$cpf}','{$endereco}', '{$data_cadF}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>



<big><a href="http://api.whatsapp.com/send?1=pt_BR&phone=$whats&text=" target="_blank" title="Abrir Whatsapp" class="text-verde"><i class="fa fa-whatsapp text-verde"></i></a></big>


<big><a href="#" onclick="arquivo('{$id}','{$nome}')" title="Anexar Arquivo"><i class="fa fa-files-o text-primary"></i></a></big>


<big><a href="#" onclick="contas('{$id}','{$nome}')" title="Ver Contas"><i class="fa fa-dollar text-verde"></i></a></big>


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
	function editar(id, nome, email, telefone, cpf, endereco){
		$('#id').val(id);
		$('#nome').val(nome);
		$('#email').val(email);
		$('#telefone').val(telefone);
		$('#cpf').val(cpf);	
			
	
		$('#endereco').val(endereco);		
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}



	function mostrar(id, nome, email, telefone, cpf, endereco, data_cad){
		
		$('#titulo_dados').text(nome);
		$('#email_dados').text(email);
		$('#telefone_dados').text(telefone);
		$('#cpf_dados').text(cpf);
		
		
		
		$('#endereco_dados').text(endereco);	
		
		$('#data_cad_dados').text(data_cad);
				
		$('#modalDados').modal('show');
		listarVendas(id);
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
		$('#email').val('');
		$('#telefone').val('');
		$('#cpf').val('');		
		$('#endereco').val('');
	}



	
	function arquivo(id, nome){
		
		$('#titulo_arquivo').text(nome);		
		$('#id_arquivo').val(id);	
		$('#id_usuario_arquivo').val(localStorage.id_usu);	
		$('#id_empresa_arquivo').val(localStorage.id_empresa);
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

	

</script>