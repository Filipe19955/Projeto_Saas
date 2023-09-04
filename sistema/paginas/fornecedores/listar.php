<?php 
$tabela = 'fornecedores';
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
	<th class="esc">CPF / CNPJ</th>	
	<th class="esc">Pessoa</th>
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
$pessoa = $res[$i]['pessoa'];
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));



echo <<<HTML
<tr>
<td>{$nome}</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$email}</td>
<td class="esc">{$cpf}</td>
<td class="esc">{$pessoa}</td>
<td>

<big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$cpf}','{$endereco}','{$pessoa}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

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


<big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$cpf}','{$endereco}', '{$data_cadF}','{$pessoa}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>





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
	function editar(id, nome, email, telefone, cpf, endereco, pessoa){
		$('#id').val(id);
		$('#nome').val(nome);
		$('#email').val(email);
		$('#telefone').val(telefone);
		$('#cpf').val(cpf);	
		$('#pessoa').val(pessoa).change();	
			
	
		$('#endereco').val(endereco);		
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}



	function mostrar(nome, email, telefone, cpf, endereco, data_cad, pessoa){
		
		$('#titulo_dados').text(nome);
		$('#email_dados').text(email);
		$('#telefone_dados').text(telefone);
		$('#cpf_dados').text(cpf);
		$('#pessoa_dados').text(pessoa);
		
		
		
		$('#endereco_dados').text(endereco);	
		
		$('#data_cad_dados').text(data_cad);
				
		$('#modalDados').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
		$('#email').val('');
		$('#telefone').val('');
		$('#cpf').val('');		
		$('#endereco').val('');
	}

</script>