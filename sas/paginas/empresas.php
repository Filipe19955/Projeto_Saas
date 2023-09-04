<?php 
$pag = 'empresas';
 ?>

 <a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Empresa</a>


<div class="bs-example widget-shadow" style="padding:15px" id="listar">
	
</div>



<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>							
						</div>

						<div class="col-md-6">							
								<label>Email</label>
								<input type="email" class="form-control" id="email" name="email" placeholder="Seu Email" >							
						</div>
					</div>


					<div class="row">
						<div class="col-md-6">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" >							
						</div>

						<div class="col-md-6">							
								<label>CPF</label>
								<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Seu CPF">							
						</div>
					</div>


					<div class="row">
						<div class="col-md-4">							
								<label>CNPJ</label>
								<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Seu CNPJ" >							
						</div>

						<div class="col-md-4">							
								<label>Valor Mensalidade</label>
								<input type="text" class="form-control" id="valor" name="valor" placeholder="Valor Mensal" >							
						</div>

						<div class="col-md-4">							
								<label>Data PGTO</label>
								<input type="date" class="form-control" id="data_pgto" name="data_pgto" >							
						</div>

						
					</div>



				

					<div class="row">
						<div class="col-md-8">							
								<label>Endereço</label>
								<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" >							
						</div>

						<div class="col-md-4">							
								<label>Teste</label>
								<select class="form-control" id="teste" name="teste" >
								<option value="Não">Não</option>	
								<option value="Sim">Sim</option>	
								</select>						
						</div>
						
					</div>


					


					<input type="hidden" name="id" id="id">				

				<br>
				<small><div id="mensagem" align="center"></div></small>
			</div>
			<
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>






<!-- Modal Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>			
			<div class="modal-body">	
					
					<div class="row" style="margin-top: 0px">
					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Telefone: </b></span><span id="telefone_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>CPF: </b></span><span id="cpf_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Email: </b></span><span id="email_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>CNPJ: </b></span><span id="cnpj_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Valor Mensal: </b></span><span id="valor_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data PGTO: </b></span><span id="data_pgto_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Ativo: </b></span><span id="ativo_dados"></span>
					</div>

					<div class="col-md-6" style="margin-bottom: 5px">
						<span><b>Data Cadastro: </b></span><span id="data_cad_dados"></span>
					</div>

					<div class="col-md-12" style="margin-bottom: 5px">
						<span><b>Endereço: </b></span><span id="endereco_dados"></span>
					</div>
				</div>
					
			</div>	

			

		</div>
	</div>
</div>







<!-- Modal Arquivos -->
<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_arquivo"></span></h4>
				<button id="btn-fechar-arquivo" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>	
			<form id="form-arquivos">		
			<div class="modal-body">	
				<div class="row">
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome_arquivo" name="nome" placeholder="Nome do Arquivo" required>							
						</div>

						<div class="col-md-6">							
								<label>Data Validade</label>
								<input type="date" class="form-control" id="data_validade" name="data_validade"  >							
						</div>
					</div>	



						<div class="row">
						<div class="col-md-6">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto" name="foto" value="" onchange="carregarImg()">							
						</div>

						<div class="col-md-6">								
							<img src=""  width="80px" id="target">								
							
						</div>

						
					</div>

					<input type="hidden" name="id_usuario" id="id_usuario_arquivo">
					<input type="hidden" name="id_arquivo" id="id_arquivo">

					<small><div id="mensagem-arquivo" align="center"></div></small>

					<hr>

					<div id="listar-arquivos"></div>
					
			</div>	

			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>	
			</form>		

		</div>
	</div>
</div>





<!-- Modal Contas -->
<div class="modal fade" id="modalContas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_contas"></span></h4>
				<button id="btn-fechar-conta" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>	
					
			<div class="modal-body">

					<div id="listar-contas"></div>


					
			</div>	

				

		</div>
	</div>
</div>





<!-- Modal Excluir -->
<div class="modal fade" id="modalExcluir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_excluir"></span></h4>
				<button id="btn-fechar-excluir" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>	
			<form id="form-excluir">		
			<div class="modal-body">	
				<div class="row">
						<div class="col-md-8">							
								<label>Senha Administrador <small>(Confirmar Exclusão da Empresa e de Todos os Seus Dados no Sistema)</small></label>													
						</div>

						<div class="col-md-4">
							<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha para Exclusão" required>	
						</div>

						
					</div>	


					<input type="hidden" name="id_usuario" id="id_usuario_excluir">
					<input type="hidden" name="id" id="id_excluir">

					<small><div id="mensagem-excluir-modal" align="center"></div></small>

									
			</div>	

			<div class="modal-footer">       
				<button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
			</div>	
			</form>		

		</div>
	</div>
</div>







<!-- Modal Contas -->
<div class="modal fade" id="modalContrato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_contrato"></span></h4>
				<button id="btn-fechar-conta" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>	
			<form id="form-contrato">	
			<div class="modal-body">

					<div>
						<textarea name="contrato" id="contrato" class="textareag"> </textarea>
					</div>
					<input type="hidden" name="id" id="id_contrato">

					<small><div id="mensagem-contrato" align="center"></div></small>
					
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Gerar Relatório</button>
			</div>	
			</form>		

				

		</div>
	</div>
</div>


<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>

<script src="//js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>



		<script type="text/javascript">
			function carregarImg() {
				var target = document.getElementById('target');
    			var file = document.querySelector("#foto").files[0];

				var arquivo = file['name'];
				resultado = arquivo.split(".", 2);



				if(resultado[1] === 'pdf'){
					$('#target').attr('src', "images/pdf.png");
					return;
				}

				if(resultado[1] === 'rar' || resultado[1] === 'zip'){
					$('#target').attr('src', "images/rar.png");
					return;
				}

				if(resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt'){
					$('#target').attr('src', "images/word.png");
					return;
				}


				if(resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls'){
					$('#target').attr('src', "images/excel.png");
					return;
				}


				if(resultado[1] === 'xml'){
					$('#target').attr('src', "images/xml.png");
					return;
				}



				var reader = new FileReader();

				reader.onloadend = function () {
					target.src = reader.result;
				};

				if (file) {
					reader.readAsDataURL(file);

				} else {
					target.src = "";
				}
			}
		</script>





 <script type="text/javascript">
	
$("#form-arquivos").submit(function () {
	var id_empresa = $('#id_arquivo').val();
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/inserir-arquivo.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-arquivo').text('');
            $('#mensagem-arquivo').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {

                //$('#btn-fechar-arquivo').click();
                limparArquivos();
                listarArquivos(id_empresa);          

            } else {

                $('#mensagem-arquivo').addClass('text-danger')
                $('#mensagem-arquivo').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});




$("#form-excluir").submit(function () {	
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/excluir.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-excluir-modal').text('');
            $('#mensagem-excluir-modal').removeClass()
            if (mensagem.trim() == "Excluído com Sucesso") {

                $('#btn-fechar-excluir').click();
               listar();        

            } else {

                $('#mensagem-excluir-modal').addClass('text-danger')
                $('#mensagem-excluir-modal').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


$("#form-contrato").submit(function () {
	var id_emp = $('#id_contrato').val();
    event.preventDefault();
    nicEditors.findEditor('contrato').saveContent();
    var formData = new FormData(this);

    $.ajax({
        url: 'paginas/' + pag + "/salvar-contrato.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#mensagem-contrato').text('');
            $('#mensagem-contrato').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {                
                   
                let a= document.createElement('a');
                a.target= '_blank';
                a.href= '../rel/contrato_class.php?id=' + id_emp;
                a.click();  	 

            } else {

                $('#mensagem-contrato').addClass('text-danger')
                $('#mensagem-contrato').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});


</script>


<script type="text/javascript">
	function listarArquivos(id){
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/listar-arquivos.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){
            $("#listar-arquivos").html(result);           
        }
    });
}



function excluirArquivo(id){
	var id_usuario = localStorage.id_usu;
	var id_empresa = $('#id_arquivo').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-arquivo.php",
        method: 'POST',
        data: {id, id_usuario},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarArquivos(id_empresa);
            } 
        }
    });
}


function listarContas(id){
	pag = 'empresas';
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/listar-contas.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){
            $("#listar-contas").html(result);           
        }
    });
}



function listarTextoContrato(id){
	pag = 'empresas';
	var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/texto-contrato.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){            
            nicEditors.findEditor("contrato").setContent(result);	          
        }
    });
}

</script>



