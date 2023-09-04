<?php 
@session_start();
require_once("../../conexao.php");
$pag = 'pdv';

$data_hoje = date('Y-m-d');

$id_empresa = @$_SESSION['id_empresa'];
$id_usuario = @$_SESSION['id_usuario'];

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Tela PDV</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<link rel="stylesheet" type="text/css" href="../css/tela-pdv.css">
	<link rel="shortcut icon" href="../../img/icone.png" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <style type="text/css">
    .select2-selection__rendered {
      line-height: 36px !important;
      font-size:16px !important;
      color:#666666 !important;

    }

    .select2-selection {
      height: 36px !important;
      font-size:16px !important;
      color:#666666 !important;

    }
  </style>  

</head>
<body>

	<div class='checkout'>
    <div class="row">
      <div class="col-md-5 col-sm-12">
        <div class='order py-2'>
          <p class="background">LISTA DE PRODUTOS</p>

          <span id="listar">

          </span>

          


        </div>
      </div>

      

      <div id='payment' class='payment col-md-7'>
        <form method="post" id="form-buscar">
          <div class="row py-2">
            <div class="col-md-7">

              <p class="background">CÓDIGO DE BARRAS</p>
              <input type="text" class="form-control form-control-lg" id="codigo" name="codigo" placeholder="Código de Barras" >

              <p class="background mt-3">PRODUTO</p>
              <input type="text" class="form-control  form-control-md" id="produto" name="produto" placeholder="Produto"  >

              <p class="background mt-3">DESCRIÇÃO</p>
              <input type="text" class="form-control  form-control-md" id="descricao" name="descricao" placeholder="Descrição do Produto"  >

              <div class="row">
                <div class="col-6">
                  <p class="background mt-3">QUANTIDADE</p>
                  <input type="text" class="form-control  form-control-md" id="quantidade" name="quantidade" placeholder="Quantidade"  >

                  <p class="background mt-1">VALOR UNITÁRIO</p>
                  <input type="text" class="form-control  form-control-md" id="valor_unitario" name="valor_unitario" placeholder="Valor"  >

                  <p class="background mt-1">ESTOQUE</p>
                  <input type="text" class="form-control  form-control-md" id="estoque" name="estoque" placeholder="Estoque"  >
                </div>

                <div class="col-6 mt-4">
                  <img id="imagem" src="" width="100%">
                </div>
              </div>



            </div>

            <div class="col-md-5">

              <p class="background">TOTAL DO ITEM</p>
              <input type="text" class="form-control form-control-md" id="total_item" name="total_item" placeholder="Código de Barras"  >


              <p class="background mt-3">SUB TOTAL</p>
              <input type="text" class="form-control  form-control-md" id="sub_total_item" name="sub_total" placeholder="Sub Total"  >

              <p class="background mt-3">DESCONTO EM <span id="tipo_desconto"></span></p>
              <input type="text" class="form-control  form-control-md" id="desconto" name="desconto" placeholder="" >


              <p class="background mt-3">TOTAL COMPRA</p>
              <input type="text" class="form-control  form-control-md" id="total_compra" name="total_compra" placeholder="Total da Compra" required="" >

              <p class="background mt-3">VALOR RECEBIDO</p>
              <input type="text" class="form-control  form-control-md" id="valor_recebido" name="valor_recebido" placeholder="R$ 0,00"  >

              <p class="background mt-3">TROCO</p>
              <input type="text" class="form-control  form-control-md" id="valor_troco" name="valor_troco" placeholder="Valor Troco"  >

              <input type="hidden" name="forma_pgto_input" id="forma_pgto_input">
               <input type="hidden" name="cliente_input" id="cliente_input">
                <input type="hidden" name="data_pgto" id="data_pgto" value="<?php echo $data_hoje ?>">
                <input type="hidden" name="tipo_desc" id="tipo_desc">
                <input type="hidden" name="totalvenda" id="totalvenda">
                <input type="hidden" name="vendedor" id="vendedor_input">
                <input type="hidden" name="acrescimo_input" id="acrescimo_input">

                  <input type="hidden" name="id_usuario" id="id_usuario_buscar">
                    <input type="hidden" name="id_empresa" id="id_empresa_buscar">

                     <input type="hidden" name="garantia" id="garantia_input">

            </div>
          </div>

        </form>



      </div>
      

    </div>
  </div>

</body>
</html>






<!-- Modal Sangria -->
<div class="modal fade" id="modalSangria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel" style="color:#5b5b5b">Efetuar Sangria</h3>
				<button id="btn-fechar-sangria" type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-sangria">
				<div class="modal-body">	
					<div class="row" style="margin-bottom: 10px">
						<div class="col-md-7">							
							<label>Valor</label>
							<input type="text" class="form-control" id="valor_sangria" name="valor" placeholder="Valor da Sangria" required>							
						</div>
					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-md-7">						
							<div class="form-group"> 
								<label>Gerente</label> 
								<select class="form-select" name="gerente" style="width:100%;" required> 
									<option value="">Selecione um Gerente</option>
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and (nivel = 'Administrador' or nivel = 'Gerente') and ativo = 'Sim'");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
										?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>	
						<div class="col-md-5">
							<div class="form-group"> 
								<label>Senha Gerente</label> 
								<input type="password" class="form-control" name="senha" id="senha_gerente_sangria"  required> 
							</div>
						</div>
					</div>		

					<input type="hidden" name="id_usuario" id="id_usuario_sangria">
					<input type="hidden" name="id_empresa" id="id_empresa_sangria">


					<br>
					<small><div id="msg-sangria" align="center"></div></small>
				</div>
				<div class="modal-footer">       
					<button type="submit" class="btn btn-primary">Sangria</button>
				</div>
			</form>
		</div>
	</div>
</div>





<!-- Modal Fechar Caixa -->
<div class="modal fade" id="modalFecharCaixa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="exampleModalLabel" style="color:#5b5b5b">Fechar Caixa</h3>
				<button id="btn-fechar-caixa" type="button"  class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="form-caixa">
				<div class="modal-body">	
					<div class="row" style="margin-bottom: 10px">
						<div class="col-md-7">							
							<label>Valor</label>
							<input type="text" class="form-control" id="valor_fechamento" name="valor" placeholder="Valor total do Caixa" required>							
						</div>
            <div class="col-md-5">              
              <label>Total Caixa</label>
              <input type="text" class="form-control" id="total_caixa" placeholder="" readonly="true">             
            </div>

					</div>
					<div class="row" style="margin-bottom: 10px">
						<div class="col-md-7">						
							<div class="form-group"> 
								<label>Gerente</label> 
								<select class="form-select" name="gerente" style="width:100%;" required> 
									<option value="">Selecione um Gerente</option>
									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and (nivel = 'Administrador' or nivel = 'Gerente') and ativo = 'Sim'");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
										?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>	
						<div class="col-md-5">
							<div class="form-group"> 
								<label>Senha Gerente</label> 
								<input type="password" class="form-control" name="senha" id="senha_gerente_fechar"  required> 
							</div>
						</div>
					</div>		

					<input type="hidden" name="id_usuario" id="id_usuario_fechar">
					<input type="hidden" name="id_empresa" id="id_empresa_fechar">


					<br>
					<small><div id="msg-caixa" align="center"></div></small>
				</div>
				<div class="modal-footer">       
					<button type="submit" class="btn btn-primary">Fechar Caixa</button>
				</div>
			</form>
		</div>
	</div>
</div>








<div class="modal fade" tabindex="-1" id="modalBuscarProduto" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Buscar Produto </h4>
        <button id="btn-fechar-modal-prod" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">

        <div>
          <?php 
          $query = $pdo->query("SELECT * from produtos where empresa = '$id_empresa' and ativo = 'Sim' and estoque > 0 order by id desc");
          $res = $query->fetchAll(PDO::FETCH_ASSOC);
          $total_reg = @count($res);
          if($total_reg > 0){ 
            ?>
            <small>
              <table id="tabela" class="table table-hover my-4" style="width:100%">
                <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>Estoque</th>
                    <th>Valor</th>               
                    <th>Foto</th>


                  </tr>
                </thead>
                <tbody>

                  <?php 
                  for($i=0; $i < $total_reg; $i++){
                    foreach ($res[$i] as $key => $value){ }

                      $id_cat = $res[$i]['categoria'];
                    $query_2 = $pdo->query("SELECT * from categorias where id = '$id_cat'");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $nome_cat = $res_2[0]['nome'];


            //BUSCAR OS DADOS DO FORNECEDOR
                    $id_forn = $res[$i]['fornecedor'];
                    $query_f = $pdo->query("SELECT * from fornecedores where id = '$id_forn'");
                    $res_f = $query_f->fetchAll(PDO::FETCH_ASSOC);
                    $total_reg_f = @count($res_f);
                    if($total_reg_f > 0){ 
                      $nome_forn = $res_f[0]['nome'];
                      $tel_forn = $res_f[0]['telefone'];
                    }else{
                      $nome_forn = '';
                      $tel_forn = '';
                    }

                    $cod_prod = $res[$i]['codigo'];

                    ?>


                    <tr onclick="selecionarProduto('<?php echo $cod_prod ?>')">
                      <td><?php echo $res[$i]['nome'] ?></td>
                      <td><?php echo $res[$i]['codigo'] ?></td>
                      <td><?php echo $res[$i]['estoque'] ?></td>             
                      <td>R$ <?php echo number_format($res[$i]['valor_venda'], 2, ',', '.'); ?></td>

                      <td><img src="../images/produtos/<?php echo $res[$i]['foto'] ?>" width="40"></td>

                    </tr>


                  <?php } ?>

                </tbody>

              </table>
            </small>
          <?php }else{
            echo '<p>Não existem dados para serem exibidos!!';
          } ?>
        </div>

      </div> 

    </div>

  </div>
</div>







<div class="modal fade" tabindex="-1" id="modalDeletar" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Item</h5>
        <button type="button" id="btn-fechar" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="form-excluir">
        <div class="modal-body">

          <div class="row">
          <div class="mb-3 col-md-6">
            <label for="exampleFormControlInput1" class="form-label">Gerente</label>
            <select class="form-select" name="gerente" style="width:100%;" required> 
                  <option value="">Selecione um Gerente</option>
                  <?php 
                  $query = $pdo->query("SELECT * FROM usuarios where empresa = '$id_empresa' and (nivel = 'Administrador' or nivel = 'Gerente') and ativo = 'Sim'");
                  $res = $query->fetchAll(PDO::FETCH_ASSOC);
                  for($i=0; $i < @count($res); $i++){   
                    ?>  
                    <option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                  <?php } ?>

                </select>
          </div>  


          <div class="mb-3 col-md-6">
            <label for="exampleFormControlInput1" class="form-label">Senha Gerente</label>
            <input type="password" class="form-control" id="senha_gerente_deletar" name="senha_gerente" placeholder="Senha Gerente" required="" >
          </div> 
        </div>

          <small><div align="center" class="mt-1" id="mensagem-excluir">

          </div> </small>

        </div>
        <div class="modal-footer">
        
          <button name="btn-excluir" id="btn-excluir" type="submit" class="btn btn-danger">Excluir</button>

          <input name="id" type="hidden" id="id_deletar_item">

        </div>
      </form>
    </div>
  </div>
</div>










<div class="modal fade" tabindex="-1" id="modalGrade" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <form method="POST" id="form-grade">
        <div class="modal-body">

          <div class="row">
         
         <div class="col-md-6">             
                <label style="margin-bottom: 3px">Grade</label>
                <select class="form-select" name="cat_grade" id="cat_grade" style="width:100%;" onchange="alterarGrade()"> 
                  
                </select>               
            </div>

            <div class="col-md-6">              
                <label style="margin-bottom: 3px">Itens Grade</label>
                <select class="form-select" name="itens_grade" id="itens_grade" style="width:100%;"> 
                  <option value="0">Selecionar Itens</option>
                </select>               
            </div>        

         
        </div>


        <div class="row" style="margin-top: 15px" id="linha_grade_2">

          <div class="col-md-6">              
                <label style="margin-bottom: 3px">Grade 2 <small>(Se Houver)</small></label>
                <select class="form-select" name="cat_grade2" id="cat_grade2" style="width:100%;" onchange="alterarGrade2()"> 
                  
                </select>               
            </div>

            <div class="col-md-6">              
                <label style="margin-bottom: 3px">Itens Grade 2 <small>(Se Houver)</small></label>
                <select class="form-select" name="itens_grade2" id="itens_grade2" style="width:100%;"> 
                  <option value="0">Selecionar Itens</option>
                </select>               
            </div>

        </div>

          <small><div align="center" class="mt-1" id="msg-grade">

          </div> </small>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btn-fechar-grade" data-bs-dismiss="modal">Fechar</button>
          <button name="btn-excluir" id="btn-confirmar" type="submit" class="btn btn-primary">Confirmar</button>

         
          <input name="id_produto" type="hidden" id="id-prod-grade">
          <input name="id_item" type="hidden" id="id_item_venda">

          <input name="id_usuario" type="hidden" id="id_usuario_grade">
          <input name="id_empresa" type="hidden" id="id_empresa_grade">

        </div>
      </form>
    </div>
  </div>
</div>









<div class="modal fade" tabindex="-1" id="modalVenda" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Fechar Venda - Total: <span id="total-modal-venda"></span></h4>
        <a type="button" class="btn-close" href="pdv.php" id="btn-fechar-venda" aria-label="Close"></a>
      </div>
      <form method="POST" id="form-fechar-venda">
        <div class="modal-body">


          <div class="row">
            <div class="col-md-8">
                  <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Cliente <a href="#" data-bs-toggle="modal" data-bs-target="#modalCliente" title="Novo Cliente"><i class="bi bi-plus"></i> Novo Cliente</a></label>
            <select class="form-select mt-1 sel2" aria-label="Default select example" name="cliente" id="cliente" style="width:100%" onchange="clienteFunc()" required>
             
                  

                </select>
          </div> 
            </div>

          

            <div class="col-md-4">
                  <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Vencimento</label>
            <input type="date" name="data_pg" id="data_pg" class="form-control" value="<?php echo $data_hoje ?>" onchange="datapgto()">
          </div>
            </div>

          </div>
      
          <div class="row">
            <div class="col-md-6">
          <div class="mb-3">
            
            <select class="form-select mt-1 " aria-label="Default select example" name="forma_pgto" id="forma_pgto" onchange="formaPgto()" required>
               <option value="" disabled selected>Forma Pagamento</option>
              <?php 
              $query = $pdo->query("SELECT * from forma_pgtos where empresa = '$id_empresa' order by id asc");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if($total_reg > 0){ 

                for($i=0; $i < $total_reg; $i++){
                  foreach ($res[$i] as $key => $value){ }
                    ?>

                  <option value="<?php echo $res[$i]['nome'] ?><?php if($res[$i]['acrescimo'] > 0) { echo '++'. $res[$i]['acrescimo']; } ?>"><?php echo $res[$i]['nome'] ?> <?php if($res[$i]['acrescimo'] > 0) { echo $res[$i]['acrescimo'].'%'; } ?></option>

                <?php }

              } ?>
            </select>
          </div> 

          <div class="col-md-4">
          <div class="mb-3" id="inputParcelado" style="display: none;">
          <label for="exampleFormControlInput1" class="form-label">Parcelas:</label>
          <input onkeyup="criarParcelas()" onchange="criarParcelas()" type="number" class="form-control" name="numero_parcelas" id="numero_parcelas" value="0">
          </div> 
          </div>

        </div>

         <div class="col-md-6" style="margin-top: 4px">
             <div class="mb-3">            
            <select class="form-select mt-1 sel2" aria-label="Default select example" name="vendedor" id="vendedor" onchange="vendedorFunc()" style="width:100%" required>
              <option value="">Selecione um Vendedor</option>
              <option value="0">Nenhum Vendedor</option>
              <?php 
              $query = $pdo->query("SELECT * from usuarios where nivel = 'Vendedor' and empresa = '$id_empresa' order by id asc");
              $res = $query->fetchAll(PDO::FETCH_ASSOC);
              $total_reg = @count($res);
              if($total_reg > 0){ 

                for($i=0; $i < $total_reg; $i++){
                  foreach ($res[$i] as $key => $value){ }
                    ?>

                  <option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

                <?php }

              }
              ?>
            </select>
          </div>  
         </div>


      </div>

          <input type="hidden" id="textovenda">
          
           <input type="hidden" id="totalantigo">
          <small><div align="center" class="mt-1" id="mensagem-venda">


          </div> </small>

        </div>
        <div class="modal-footer">
          
          <button name="btn-venda" id="btn-venda" type="submit" class="btn btn-success">Fechar Venda</button>

          
        </div>
      </form>
    </div>
  </div>
</div>








<!-- Modal Cliente -->
<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Inserir Cliente</h4>
         <button type="button" class="btn-close" id="btn-fechar-cliente" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="form-cliente">
      <div class="modal-body">
        

          <div class="row" style="margin-bottom: 5px">
            <div class="col-md-6">              
                <label>Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu Nome" required>              
            </div>

            <div class="col-md-6">              
                <label>Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Seu Email" >              
            </div>
          </div>


         <div class="row" style="margin-bottom: 5px">
            <div class="col-md-6">              
                <label>Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone" >              
            </div>

            <div class="col-md-6">              
                <label>CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Seu CPF">              
            </div>

            
          </div>


              

         <div class="row" style="margin-bottom: 5px">
            <div class="col-md-12">             
                <label>Endereço</label>
                <input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço" >              
            </div>
            
          </div>

          <input type="hidden" name="id">
          <input type="hidden" name="id_empresa" value="<?php echo $id_empresa ?>">
          
        
        <br>
        <small><div id="mensagem-cliente" align="center"></div></small>
      </div>
      <div class="modal-footer">       
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
      </form>
    </div>
  </div>
</div>










<script type="text/javascript">var pag = "<?=$pag?>"</script>
<script src="js/ajax.js"></script>



<script type="text/javascript">
	$(document).ready(function() {    
    listarProdutos()
    carregarDadosConfig();

    buscarCodigo();
    document.getElementById('codigo').focus();
    document.getElementById('quantidade').value = '1';
    $('#imagem').attr('src', '../images/produtos/sem-foto.png');

    $('.sel2').select2({
      dropdownParent: $('#modalVenda')
    });

    listarClientes('');

} );
</script>

<script type="text/javascript">
	function carregarDadosConfig(){
		var id_usu = localStorage.id_usu;
    var id_empresa = localStorage.id_empresa;
    var nivel_usu = localStorage.nivel_usu;
		$.ajax({
			url: "../carregar-dados-config.php",
			type: 'POST',
			data: {id_usu, nivel_usu, id_empresa},

			success: function (result) {
				var split = result.split("-*");		
				$('#tipo_desconto').text(split[5]).change();
        $('#tipo_desc').val(split[5]).change();
				var place = 'Desconto em ' + split[5];
				$('#desconto').attr("placeholder", place);

			},			

		});		
	}
</script>

<script type="text/javascript">
	function listarProdutos(){
	var id_usuario = localStorage.id_usu;
	var id_empresa = localStorage.id_usu;
    $.ajax({
        url: pag + "/listar-produtos.php",
        method: 'POST',
        data: {id_usuario, id_empresa},
        dataType: "html",

        success:function(result){
            $("#listar").html(result);           
        }
    });
}
</script>




<script type="text/javascript">
  $(document).keyup(function(e) {

    if(e.keyCode === 113 || e.keyCode === 17){    	
      var myModal = new bootstrap.Modal(document.getElementById('modalVenda'), {
    })
    myModal.show();
    }


    if(e.keyCode === 18){
      var myModal = new bootstrap.Modal(document.getElementById('modalBuscarProduto'), {
    })
    myModal.show();
    }

    if(e.keyCode === 119){
      var myModal = new bootstrap.Modal(document.getElementById('modalSangria'), {
    })
    myModal.show();

    $('#id_empresa_sangria').val(localStorage.id_empresa);
    $('#id_usuario_sangria').val(localStorage.id_usu);
    $('#senha_gerente_sangria').val('');
    }


    if(e.keyCode === 115){
      var myModal = new bootstrap.Modal(document.getElementById('modalFecharCaixa'), {
    })
    myModal.show();

     $('#id_empresa_fechar').val(localStorage.id_empresa);
    $('#id_usuario_fechar').val(localStorage.id_usu);
    $('#senha_gerente_fechar').val('');

      setTimeout(function() {
  totalizarCaixa();
}, 500)

    }




     var codigo = $("#codigo").val();
    if(codigo === ''){
      if($("#textovenda").val() === ''){
         if(e.keyCode === 13){
          $("#textovenda").val('aberto'); 
              var myModal = new bootstrap.Modal(document.getElementById('modalVenda'), {
               backdrop: 'static',
               })

             myModal.show();
          }
      }else{
        if(e.keyCode === 13){
            $('#btn-venda').click();
        }        

      }
 
    }
    else{

      if(e.which == 13){

      buscarCodigo();
      }
    }

});

</script>



<script type="text/javascript">
	
$("#form-sangria").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/sangria.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#msg-sangria').text('');
            $('#msg-sangria').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {
                
                 $('#btn-fechar-sangria').click();
                 alert('Sangria Efetuada!');

            } else {

                $('#msg-sangria').addClass('text-danger')
                $('#msg-sangria').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});




$("#form-caixa").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/fechar-caixa.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
            $('#msg-caixa').text('');
            $('#msg-caixa').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {
                
                 window.location="../index.php?pagina=abertura";

            } else {

                $('#msg-caixa').addClass('text-danger')
                $('#msg-caixa').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});



$("#form-grade").submit(function () {
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: pag + "/confirmar-grade.php",
        type: 'POST',
        data: formData,

        success: function (mensagem) {
         
            $('#msg-grade').text('');
            $('#msg-grade').removeClass()
            if (mensagem.trim() == "Salvo com Sucesso") {                
                
                 $('#btn-fechar-grade').click();
                 listarProdutos();
                 document.getElementById('codigo').focus();

            } else {

                $('#msg-grade').addClass('text-danger')
                $('#msg-grade').text(mensagem)
            }


        },

        cache: false,
        contentType: false,
        processData: false,

    });

});

</script>


<link rel="stylesheet" type="text/css" href="../DataTables/datatables.min.css"/> 
  <script type="text/javascript" src="../DataTables/datatables.min.js"></script>

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
  function selecionarProduto(codigo){
    $('#codigo').val(codigo);    
    $('#btn-fechar-modal-prod').click();
    document.querySelector("#quantidade").select();
  }
</script>





<script type="text/javascript">
  function modalExcluir(id){
    event.preventDefault();
    document.getElementById('id_deletar_item').value = id; 
    $('#senha_gerente_deletar').val('');   


    var myModal = new bootstrap.Modal(document.getElementById('modalDeletar'), {

    })

    myModal.show();
  }
</script>




<!--AJAX PARA EXCLUIR DADOS -->
<script type="text/javascript">
  $("#form-excluir").submit(function () {

    var pag = "<?=$pag?>";
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: pag + "/excluir-item.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        $('#mensagem').removeClass()

        if (mensagem.trim() == "Excluído com Sucesso!") {

          $('#mensagem-excluir').addClass('text-success')

          $('#btn-fechar').click();
          window.location = "pdv.php";

        } else {

          $('#mensagem-excluir').addClass('text-danger')
        }

        $('#mensagem-excluir').text(mensagem)

      },

      cache: false,
      contentType: false,
      processData: false,

    });
  });
</script>






<!--AJAX PARA INSERIR CLIENTE -->
<script type="text/javascript">
  $("#form-cliente").submit(function () {

    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: "clientes/salvar.php",
      type: 'POST',
      data: formData,

      success: function (mensagem) {

        $('#mensagem').removeClass()

        if (mensagem.trim() == "Salvo com Sucesso") {

          $('#mensagem-cliente').addClass('text-success')

          $('#btn-fechar-cliente').click();
          listarClientes('Salvo');

          setTimeout(function() {
  clienteFunc();
}, 500)
          

        } else {

          $('#mensagem-cliente').addClass('text-danger')
        }

        $('#mensagem-cliente').text(mensagem)

      },

      cache: false,
      contentType: false,
      processData: false,

    });
  });
</script>






<script type="text/javascript">  
  function buscarCodigo(){
    var id_usuario = localStorage.id_usu;
  var id_empresa = localStorage.id_empresa;

  $('#id_usuario_buscar').val(id_usuario)
  $('#id_empresa_buscar').val(id_empresa)

  $('#id_usuario_grade').val(id_usuario)
  $('#id_empresa_grade').val(id_empresa)

    var pag = "<?=$pag?>";
    var valor_prod = $('#valor_unitario').val();
    
    $.ajax({
      url: pag + "/buscar-codigo.php",
      method: 'POST',
      data: $('#form-buscar').serialize(),
      dataType: "html",

      success:function(result){
      //alert(result)        

        $('#mensagem-venda').text("");



        if(result.trim() === "Não é possível efetuar uma venda sem itens!"){
          $('#mensagem-venda').addClass('text-danger')
          $('#mensagem-venda').text(result)
          document.getElementById('forma_pgto_input').value = "";
           return;
        }

         if(result.trim() === "O troco não pode ser menor que zero!"){
          $('#mensagem-venda').addClass('text-danger')
          $('#mensagem-venda').text(result)          
           return;
        }

        var array = result.split("&-/z");

        if(array[0] === "Venda Salva!"){
          
          //$('#btn-fechar-venda').click();
          
          let a= document.createElement('a');
          a.target= '_blank';
          a.href= '../../rel_sistema/comprovante.php?id=' + array[1];
          a.click();

          setTimeout(function() {
            location.reload();
          }, 500)

          return;
        }


         if(array[0] === "Quantidade em Estoque Insuficiente!"){
         texto_msg = result.replace("&-/z"," ");
         alert(texto_msg)
        $('#codigo').val('') 
         document.getElementById('codigo').focus();

          return;
         }

         if(array[0] === "Código do Produto não Encontrado!"){        
         alert(array[0])
          return;
         }

         if(array[0] === "Preencha um Valor para o Produto!"){        
         alert(array[0]);
         document.querySelector("#valor_unitario").select();
          return;
         }

         if(array[0] === "Selecione um Cliente!"){        
         alert(array[0]);         
          return;
         }





        if(array.length == 2){
           var ms1 = array[0];
           var ms2 = array[1];
           
        }else{

        var estoque = array[0];
        var nome = array[1];
        var descricao = array[2];
        var imagem = array[3];
        var valor = array[4];
        var subtotal = array[5];
        var subtotalF = array[6];
        var totalVenda = array[7];
        var totalVendaF = array[8];
         var troco = array[9];
        var trocoF = array[10];
        var grade = array[11];
        var id_produto = array[12];
        var id_item = array[13];

        $('#totalvenda').val(totalVenda)
        $('#totalantigo').val(totalVenda)

        console.log(result);
        
        
        document.getElementById('total_compra').value = totalVendaF; 
        $('#total-modal-venda').text('R$ ' + totalVendaF);
               

        document.getElementById('valor_troco').value = 'R$ ' + trocoF; 


        if(nome.trim() != "Código não Cadastrado"){

          document.getElementById('estoque').value = estoque;
          document.getElementById('produto').value = nome;
          document.getElementById('descricao').value = descricao;
          document.getElementById('valor_unitario').value = valor;

          if(imagem.trim() === ""){
           $('#imagem').attr('src', '../images/produtos/sem-foto.jpg');
         }else{
           $('#imagem').attr('src', '../images/produtos/' + imagem);
         }


         var audio = new Audio('../images/barCode.wav');
         audio.addEventListener('canplaythrough', function() {
          audio.play();
        });
         

         valor_format = "R$ " + valor.replace(".",",");
         document.getElementById('total_item').value = valor_format;
         
         document.getElementById('sub_total_item').value = 'R$ ' + subtotalF;


         document.getElementById('codigo').value = "";
        document.getElementById('quantidade').value = "1";
        document.getElementById('valor_unitario').value = "";
        document.getElementById('codigo').focus();

         listarProdutos();

          if(grade > 0){
            
            if(grade == 1){
              $('#linha_grade_2').css("display", "none");
            }else{
              $('#linha_grade_2').css("display", "flex");
            }

            $('#id-prod-grade').val(id_produto)
            $('#id_item_venda').val(id_item)
            $('#cat_grade').val('')
            $('#cat_grade2').val('')
            $('#itens_grade').val('')
            $('#itens_grade2').val('')
            
            //document.getElementById('id_produto_grade').value = id_produto;           
            var myModal = new bootstrap.Modal(document.getElementById('modalGrade'), {
              backdrop: 'static',
            })

            myModal.show();

            listarSelectCatGrade(id_produto)
          

            
          }

          


         }

       }




       
     } 

   });
  }
</script>






<script type="text/javascript">
    function listarSelectCatGrade(id){

    $.ajax({
        url: "produtos/select-cat-grade.php",
        method: 'POST',
        data: {id},
        dataType: "html",

        success:function(result){         
            $("#cat_grade").html(result);           
        }
    });

   
}


function listarSelectItensGrade(id){
    var estoque = 'Sim';
    $.ajax({
        url: "produtos/select-itens-grade.php",
        method: 'POST',
        data: {id, estoque},
        dataType: "html",

        success:function(result){         
            $("#itens_grade").html(result);           
        }
    });
}


function alterarGrade(){
  var id_grade = $("#cat_grade").val();
  var id_prod = $("#id-prod-grade").val();
    listarSelectItensGrade(id_grade);
    listarSelectCatGrade2(id_prod)
}






function listarSelectCatGrade2(id){
  
  var id_grade = $("#cat_grade").val();
    $.ajax({
        url: "produtos/select-cat-grade.php",
        method: 'POST',
        data: {id, id_grade},
        dataType: "html",

        success:function(result){         
            $("#cat_grade2").html(result);           
        }
    });

   
}


function listarSelectItensGrade2(id){
  var estoque = 'Sim';
    $.ajax({
        url: "produtos/select-itens-grade.php",
        method: 'POST',
        data: {id, estoque},
        dataType: "html",

        success:function(result){         
            $("#itens_grade2").html(result);           
        }
    });
}


function alterarGrade2(){
  var id_grade = $("#cat_grade2").val();
    listarSelectItensGrade2(id_grade);
}

function formaPgto(){
  var totalantigo = $("#totalantigo").val();
  var totalvenda = $("#totalvenda").val();
  var forma_pgto = $("#forma_pgto").val();
  var array = forma_pgto.split("++");
  var porcent = array[1];
  $("#forma_pgto_input").val(array[0]);
  $("#acrescimo_input").val(array[1]);
  if(porcent != "" && porcent != "undefined" && porcent != undefined){
    var novototal = parseFloat(totalantigo) + (parseFloat(totalantigo) * parseFloat(porcent)) / 100;
    $('#totalvenda').val(novototal.toFixed(2));
    var f = novototal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
    $('#total-modal-venda').text(f);
  }else{    
    var novototal = parseFloat(totalantigo) + 0;
    $('#totalvenda').val(novototal.toFixed(2));
    var f = novototal.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
    $('#total-modal-venda').text(f);
  }

  var elementoSelect = document.getElementById("forma_pgto");
    var opcaoSelecionada = elementoSelect.options[elementoSelect.selectedIndex].text;
    var inputParcelado = document.getElementById("inputParcelado");

    if (opcaoSelecionada.includes("Parcelado")) {
        inputParcelado.style.display = "block";
    } else {
        inputParcelado.style.display = "none";
    }
  
}

function vendedorFunc(){
  var vendedor = $("#vendedor").val(); 
  $("#vendedor_input").val(vendedor);
}

function datapgto(){
var datapgto = $("#data_pg").val();
$("#data_pgto").val(datapgto);
}



function clienteFunc(){
  var cliente = $("#cliente").val();
  $("#cliente_input").val(cliente);
}



function listarClientes(param){
   var pag = "<?=$pag?>";
  var id_empresa = localStorage.id_empresa;
    $.ajax({
        url: pag + "/listar-clientes.php",
        method: 'POST',
        data: {id_empresa, param},
        dataType: "html",

        success:function(result){          
            $("#cliente").html(result);           
        }
    });
}

function criarParcelas(){

      valor = $('#total_compra').val();
      parcelas = $('#numero_parcelas').val();
      data = $('#data_pg').val();

      console.log("Valor:", valor);
       console.log("Parcelas:", parcelas);
      console.log("Data:", data);
      
      $.ajax({
        url: pag + "/parcelas.php",
        method: 'POST',
        data: {valor, parcelas, data},
        dataType: "text",

        success: function (mensagem) {
          if (mensagem.trim() == "Inserido com Sucesso") {
            
          }               
        },

      });
    }

</script>



<script type="text/javascript">
  $("#desconto").keyup(function () {
    buscarCodigo();
  });
</script>


<script type="text/javascript">
  $("#valor_recebido").keyup(function () {
    buscarCodigo();
  });
</script>


<script type="text/javascript">
  $("#form-fechar-venda").submit(function () {
    var garantia = $("#garantia").val();
    $("#garantia_input").val(garantia);
    event.preventDefault();
    buscarCodigo();
  });
</script>


<script type="text/javascript">
  function totalizarCaixa(){
    var id_empresa = localStorage.id_empresa; 
    var id_usuario = localStorage.id_usu; 
    $.ajax({
        url: pag + "/totalizar-caixa.php",
        method: 'POST',
        data: {id_empresa, id_usuario},
        dataType: "html",

        success:function(result){  

            $("#total_caixa").val(result);           
        }
    });
  }
</script>


  <!-- Mascaras JS -->
<script type="text/javascript" src="../js/mascaras.js"></script>
<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

