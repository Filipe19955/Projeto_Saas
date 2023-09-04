<?php 
$tabela = 'usuarios';
require_once("../../../conexao.php");

$query = $pdo->query("SELECT * FROM $tabela where (nivel = 'Administrador' or nivel = 'SAS') order by id desc");
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
	<th class="esc">Nível</th>	
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
$nivel = $res[$i]['nivel'];
$ativo = $res[$i]['ativo'];
$data_cad = $res[$i]['data'];
$endereco = $res[$i]['endereco'];
$senha = $res[$i]['senha'];
	
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));

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

if($nivel == 'SAS'){
	$senha = '********';
}		

echo <<<HTML
<tr style="color:{$classe_ativo}">
<td>{$nome}</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$email}</td>
<td class="esc">{$nivel}</td>
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


<big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$cpf}','{$endereco}','{$ativo}','{$data_cadF}', '{$senha}', '{$nivel}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>


<big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>




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



	function mostrar(nome, email, telefone, cpf, endereco, ativo, data_cad, senha, nivel){
		
		$('#titulo_dados').text(nome);
		$('#email_dados').text(email);
		$('#telefone_dados').text(telefone);
		$('#cpf_dados').text(cpf);
		$('#senha_dados').text(senha);
		
		$('#nivel_dados').text(nivel);
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
		$('#endereco').val('');
	}

</script>