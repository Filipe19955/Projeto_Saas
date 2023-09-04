<?php 
@session_start();
require_once("../conexao.php");
$pag_inicial = 'home';
if(@$_SESSION['nivel'] != 'Administrador' and @$_SESSION['nivel'] != 'SAS'){
	require_once("verificar-permissoes.php");
}

if(@$_GET['pagina'] == ""){
	$pagina = $pag_inicial;
}else{
	$pagina = $_GET['pagina'];
}

if(@$_GET['id_empresa'] != ""){
	$id_empresa = @$_GET['id_empresa'];
}else{
	$id_empresa = @$_SESSION['id_empresa'];
}

$id_usuario = @$_SESSION['id_usuario'];
$email_usuario = @$_SESSION['email'];
$nivel_usuario = @$_SESSION['nivel'];

//verificar se a empresa tem conta vencida
		$query2 = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' and pessoa = '$id_empresa' order by data_venc asc");
		$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
		$total_reg2 = @count($res2);
		if($total_reg2 > 0){

			$query = $pdo->query("SELECT * FROM config WHERE empresa = '0'");
			$res = $query->fetchAll(PDO::FETCH_ASSOC);
			$total_reg = @count($res);
			$dias_bloqueio = $res[0]['dias_bloqueio'];
			$msg_bloqueio = $res[0]['msg_bloqueio'];
			$alerta_div = '';
			$margem_home = '60px';
											 
		}else{
			$msg_bloqueio = '';
			$alerta_div = 'ocultar';
			$margem_home = '0px';
		}

$data_atual = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$data_mes = $ano_atual."-".$mes_atual."-01";
$data_ano = $ano_atual."-01-01";

$data_inicio_mes = $ano_atual."-".$mes_atual."-01";

if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
    $dia_final_mes = '30';
}else if($mes_atual == '2'){
    $dia_final_mes = '28';
}else{
    $dia_final_mes = '31';
}

$data_final_mes = $ano_atual."-".$mes_atual."-".$dia_final_mes;



?>
<!DOCTYPE HTML>
<html>
<head>
	<title id="titulo_empresa"></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="../img/icone.png" type="image/x-icon">

	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />

	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />

	<!-- font-awesome icons CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<!-- //font-awesome icons CSS-->

	<!-- side nav css file -->
	<link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
	<!-- //side nav css file -->

	<!-- js-->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/modernizr.custom.js"></script>

	<!--webfonts-->
	<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
	<!--//webfonts--> 

	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->

	<!-- Metis Menu -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<!--//Metis Menu -->
	<style>
		#chartdiv {
			width: 100%;
			height: 295px;
		}
	</style>
	<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
	<script src="js/pie-chart.js" type="text/javascript"></script>
	<script type="text/javascript">

		$(document).ready(function () {

			carregarDados();
			carregarDadosConfig();

			$('#conteudo-principal').css('display', 'block');

			$('#demo-pie-1').pieChart({
				barColor: '#2dde98',
				trackColor: '#eee',
				lineCap: 'round',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-2').pieChart({
				barColor: '#8e43e7',
				trackColor: '#eee',
				lineCap: 'butt',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});

			$('#demo-pie-3').pieChart({
				barColor: '#ffc168',
				trackColor: '#eee',
				lineCap: 'square',
				lineWidth: 8,
				onStep: function (from, to, percent) {
					$(this.element).find('.pie-value').text(Math.round(percent) + '%');
				}
			});


		});

	</script>
	<!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->



	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/> 
	<script type="text/javascript" src="DataTables/datatables.min.js"></script>

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

<?php 
require_once("verificar.php");
 ?>
	
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content" id="conteudo-principal" style="display:none">

		<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
			<!--left-fixed -navigation-->
			<aside class="sidebar-left" style="overflow: scroll; height:100%; scrollbar-width: thin;">

				<nav class="navbar navbar-inverse">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<h1><a class="navbar-brand" href="index.php"><span class="fa fa-usd"></span> Sistema SaaS<span class="dashboard_text"><span id="nome_sistema_titulo"></span></span></a></h1>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="sidebar-menu">
							<li class="header">MENU NAVEGAÇÃO</li>
							<li class="treeview <?php echo $home ?>">
								<a href="index.php">
									<i class="fa fa-dashboard"></i> <span>Home</span>
								</a>
							</li>
							<li class="treeview <?php echo $menu_pessoas ?>">
								<a href="#">
									<i class="fa fa-users"></i>
									<span>Pessoas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li class="<?php echo $clientes ?>"><a href="index.php?pagina=clientes"><i class="fa fa-angle-right"></i> Clientes</a></li>

									<li class="<?php echo $usuarios ?>"><a href="index.php?pagina=usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>

									<li class="<?php echo $funcionarios ?>"><a href="index.php?pagina=funcionarios"><i class="fa fa-angle-right"></i> Funcionários</a></li>

									<li class="<?php echo $fornecedores ?>"><a href="index.php?pagina=fornecedores"><i class="fa fa-angle-right"></i> Fornecedores</a></li>
									
									
								</ul>
							</li>


							<li class="treeview <?php echo $menu_cadastros ?>">
								<a href="#">
									<i class="fa fa-floppy-o"></i>
									<span>Cadastros</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li class="<?php echo $cargos ?>"><a href="index.php?pagina=cargos"><i class="fa fa-angle-right"></i> Cargos</a></li>

									<li class="<?php echo $frequencias ?>"><a href="index.php?pagina=frequencias"><i class="fa fa-angle-right"></i> Frequências</a></li>

									<li class="<?php echo $caixas ?>"><a href="index.php?pagina=caixas"><i class="fa fa-angle-right"></i> Caixas</a></li>

									<li class="<?php echo $formas_pgto ?>"><a href="index.php?pagina=forma_pgtos"><i class="fa fa-angle-right"></i> Formas de Pagamento</a></li>

									
								</ul>
							</li>


							<li class="treeview <?php echo $menu_produtos ?>">
								<a href="#">
									<i class="fa fa-shopping-cart"></i>
									<span>Produtos</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li class="<?php echo $categorias ?>"><a href="index.php?pagina=categorias"><i class="fa fa-angle-right"></i> Categorias</a></li>

									<li class="<?php echo $produtos ?>"><a href="index.php?pagina=produtos"><i class="fa fa-angle-right"></i> Produtos</a></li>

									<li class="<?php echo $entradas ?>"><a href="index.php?pagina=entradas"><i class="fa fa-angle-right"></i> Lista de Entradas</a></li>

									<li class="<?php echo $saidas ?>"><a href="index.php?pagina=saidas"><i class="fa fa-angle-right"></i> Lista de Saídas</a></li>

									<li class="<?php echo $estoque ?>"><a href="index.php?pagina=estoque"><i class="fa fa-angle-right"></i> Estoque Baixo</a></li>

									<li class="<?php echo $trocas ?>"><a href="index.php?pagina=trocas"><i class="fa fa-angle-right"></i> Troca de Produtos</a></li>

									
								</ul>
							</li>



							<li class="treeview <?php echo $menu_financeiro ?>">
								<a href="#">
									<i class="fa fa-money"></i>
									<span>Financeiro</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li class="<?php echo $receber ?>"><a href="index.php?pagina=receber"><i class="fa fa-angle-right"></i> Contas à Receber</a></li>

									<li class="<?php echo $pagar ?>"><a href="index.php?pagina=pagar"><i class="fa fa-angle-right"></i> Despesas</a></li>

									<li class="<?php echo $compras ?>"><a href="index.php?pagina=compras"><i class="fa fa-angle-right"></i> Compras</a></li>

									<li class="<?php echo $vendas ?>"><a href="index.php?pagina=vendas"><i class="fa fa-angle-right"></i> Vendas</a></li>

									<li class="<?php echo $fluxo ?>"><a href="index.php?pagina=fluxo"><i class="fa fa-angle-right"></i> Fluxo de Caixa</a></li>

									<li class="<?php echo $comissoes ?>"><a href="index.php?pagina=comissoes"><i class="fa fa-angle-right"></i> Comissões</a></li>
									
								</ul>
							</li>


							<li class="treeview <?php echo $menu_relatorio ?>">
								<a href="#">
									<i class="fa fa-file-o"></i>
									<span>Relatórios</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">

									<li class="<?php echo $rel_vendas ?>"><a href="#" data-toggle="modal" data-target="#relVendas"><i class="fa fa-angle-right"></i> Relatório de Vendas</a></li>

									<li class="<?php echo $rel_clientes ?>"><a href="../rel_sistema/clientes_class.php" target="_blank"><i class="fa fa-angle-right"></i> Relatório de Clientes</a></li>

									<li class="<?php echo $rel_recebimentos ?>"><a href="#" data-toggle="modal" data-target="#relReceber"><i class="fa fa-angle-right"></i> Relatório de Recebimentos</a></li>

									<li class="<?php echo $rel_despesas ?>"><a href="#" data-toggle="modal" data-target="#relPagar"><i class="fa fa-angle-right"></i> Relatório de Despesas</a></li>

									<li class="<?php echo $rel_lucro ?>"><a href="#" data-toggle="modal" data-target="#relLucro"><i class="fa fa-angle-right"></i> Demonstrativo de Lucro</a></li>

									<li class="<?php echo $rel_produtos ?>"><a href="../rel_sistema/produtos_class.php" target="_blank"><i class="fa fa-angle-right"></i> Relatório de Produtos</a></li>

									<li class="<?php echo $rel_estoque ?>"><a href="../rel_sistema/estoque_class.php" target="_blank"><i class="fa fa-angle-right"></i> Relatório de Estoque Baixo</a></li>

									<li class="<?php echo $rel_entradas_saidas ?>"><a href="#" data-toggle="modal" data-target="#relEntradas"><i class="fa fa-angle-right"></i> Entradas e Saídas</a></li>

									<li class="<?php echo $rel_caixas ?>"><a href="#" data-toggle="modal" data-target="#relCaixas"><i class="fa fa-angle-right"></i> Relatório dos Caixas</a></li>

									<li class="<?php echo $rel_comissoes ?>"><a href="#" data-toggle="modal" data-target="#relComissoes"><i class="fa fa-angle-right"></i> Relatório de Comissões</a></li>

									<li class="<?php echo $rel_trocas ?>"><a href="#" data-toggle="modal" data-target="#relTrocas"><i class="fa fa-angle-right"></i> Relatório de Trocas</a></li>


									
								</ul>
							</li>


							<li class="treeview <?php echo $abertura ?>">
								<a href="index.php?pagina=abertura">
									<i class="fa fa-usd"></i> <span>Caixa (PDV)</span>
								</a>
							</li>

							<li class="treeview <?php echo $minhas_comissoes ?>">
								<a href="index.php?pagina=minhas_comissoes">
									<i class="fa fa-money"></i> <span>Minhas Comissões</span>
								</a>
							</li>


							<?php
							if($nivel_usuario == 'Administrador'){
							$query = $pdo->query("SELECT * FROM empresas where email = '$email_usuario'");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$total_reg = @count($res);
							if($total_reg > 1){
								
							 ?>

							<li class="treeview">
								<a href="#">
									<i class="fa fa-globe"></i>
									<span>Empresas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<?php 
									for($i=0; $i < $total_reg; $i++){	
										$id = $res[$i]['id'];
										$nome = $res[$i]['nome'];
									 ?>
									<li><a href="#" onclick="painelEmpresa('<?php echo $id ?>')"><i class="fa fa-angle-right"></i> <?php echo $nome ?></a></li>

								<?php } ?>						
									
									
								</ul>
							</li>

						<?php } } ?>



						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</aside>
		</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="alerta-msg <?php echo $alerta_div ?>">
				<div class="text-alerta"><i class="fa fa-info-circle"></i> <b>Aviso: </b><?php echo $msg_bloqueio ?></div>
			</div>
			<div class="header-left">

				<!--toggle button start-->
				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="profile_details_left"><!--notifications of menu start -->
					<ul class="nofitications-dropdown">

						<li class="dropdown head-dpdn">
							<?php 
							$query = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and empresa = '$id_empresa' order by data_venc asc");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$total_reg = @count($res);
							if($total_reg <= 1){
								 $texto_pendentes = 'recebimento Vencido';
								}else{
									$texto_pendentes = 'recebimentos Vencidos';
								}
							 ?>
							
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-usd" style="color:#FFF; width:15px; height:15px"></i><span class="badge" style="background:red"><?php echo $total_reg ?></span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>Possui <?php echo $total_reg ?> <?php echo $texto_pendentes ?> </h3>
									</div>
								</li>

								<?php 
									for($i=0; $i < $total_reg; $i++){	
									$descricao = $res[$i]['descricao'];
									$pessoa = $res[$i]['pessoa'];
									$valor = $res[$i]['valor'];									
									$data_venc = $res[$i]['data_venc'];

										$query2 = $pdo->query("SELECT * FROM empresas where id = '$pessoa'");
										$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
										if(@count($res2) > 0){
											$nome_pessoa = $res2[0]['nome'];
										}else{
											$nome_pessoa = 'Sem Cliente';
										}


									if($descricao == ""){
										$descricao = $nome_pessoa;
									}

									
									$data_vencF = implode('/', array_reverse(explode('-', $data_venc)));
									$valorF = number_format($valor, 2, ',', '.');
								 ?>

								<li><a href="#">
									<div class="user_img"><img src="images/1.jpg" alt=""></div>
									<div class="notification_desc">
										<p><?php echo $descricao ?></p>
										<p><span>R$ <?php echo $valorF ?> Venc: <?php echo $data_vencF ?></span></p>
									</div>
									<div class="clearfix"></div>	
								</a>
							</li>
								<?php } ?>
							
								
								<li>
									<div class="notification_bottom">
										<a href="index.php?pagina=receber">Ver todos os Recebimentos</a>
									</div> 
								</li>
							</ul>
						</li>




							<li class="dropdown head-dpdn">
							<?php 
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

								if($estoque_baixo <= 1){
								 $texto_pendentes = 'Produto com Estoque Baixo';
								}else{
									$texto_pendentes = 'Produtos com Estoque Baixo';
								}
							 ?>
							
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-shopping-cart" style="color:#FFF"></i><span class="badge" style="background:#f37f06"><?php echo $estoque_baixo ?></span></a>
							<ul class="dropdown-menu">
								<li>
									<div class="notification_header">
										<h3>Possui <?php echo $estoque_baixo ?> <?php echo $texto_pendentes ?> </h3>
									</div>
								</li>

								<?php 
									for($i=0; $i < $total_reg; $i++){	
										$nivel_estoque = $res[$i]['nivel_estoque'];
										$estoque = $res[$i]['estoque'];
										$nome = $res[$i]['nome'];

											if($estoque < $nivel_estoque){	
												$estoque_baixo += 1;
											
								 ?>

								<li><a href="#">
									<div class="user_img"><img src="images/1.jpg" alt=""></div>
									<div class="notification_desc">
										<p><?php echo $nome ?></p>
										<p><span><span style="color:red !important"><?php echo $estoque ?> Produtos </span> / Nível <span style="color:green !important">Mínimo: <?php echo $nivel_estoque ?></span></span></p>
									</div>
									<div class="clearfix"></div>	
								</a>
							</li>
								<?php } } ?>
							
								
								<li>
									<div class="notification_bottom">
										<a href="index.php?pagina=estoque">Ver todos os Produtos</a>
									</div> 
								</li>
							</ul>
						</li>
						


					</ul>
					<div class="clearfix"> </div>
				</div>
				
			</div>
			<div class="header-right">

				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img id="foto-usuario" src="images/perfil/sem-foto.jpg" alt="" width="50px" height="50px"> </span> 
									<div class="user-name esc">
										<p id="nome-usuario"></p>
										<big><span>Nível: <span id="nivel-usuario">Usuário</span></span></big>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li class="<?php echo $config ?>"> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 
								<li> <a href="" data-toggle="modal" data-target="#modalPerfil"><i class="fa fa-user"></i> Perfil</a> </li> 								
								<li> <a href="../logout.php"><i class="fa fa-sign-out"></i> Sair</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->




		<!-- main content start-->
		<div id="page-wrapper">
			<div style="margin-top: <?php echo $margem_home ?>">
			<?php 
			require_once('paginas/'.$pagina.'.php');
			?>
			</div>
		</div>





	</div>

	<!-- new added graphs chart js-->
	
	<script src="js/Chart.bundle.js"></script>
	<script src="js/utils.js"></script>
	
	
	
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};


		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->

	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
		$('.sidebar-menu').SidebarNav()
	</script>
	<!-- //side nav js -->
	
	
	
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->



	<!-- Mascaras JS -->
<script type="text/javascript" src="js/mascaras.js"></script>

<!-- Ajax para funcionar Mascaras JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script> 

	
</body>
</html>






<!-- Modal Perfil -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Alterar Dados</h4>
				<button id="btn-fechar-perfil" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-perfil">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-6">							
								<label>Nome</label>
								<input type="text" class="form-control" id="nome_perfil" name="nome" placeholder="Seu Nome" required>							
						</div>

						<div class="col-md-6">							
								<label>Email</label>
								<input type="email" class="form-control" id="email_perfil" name="email" placeholder="Seu Nome" >							
						</div>
					</div>


					<div class="row">
						<div class="col-md-6">							
								<label>Telefone</label>
								<input type="text" class="form-control" id="telefone_perfil" name="telefone" placeholder="Seu Telefone" >							
						</div>

						<div class="col-md-6">							
								<label>CPF</label>
								<input type="text" class="form-control" id="cpf_perfil" name="cpf" placeholder="Seu CPF">							
						</div>
					</div>



					<div class="row">
						<div class="col-md-6">							
								<label>Senha</label>
								<input type="password" class="form-control" id="senha_perfil" name="senha" placeholder="Senha" required>							
						</div>

						<div class="col-md-6">							
								<label>Confirmar Senha</label>
								<input type="password" class="form-control" id="conf_senha_perfil" name="conf_senha" placeholder="Confirmar Senha" value="" required>							
						</div>
					</div>


					<div class="row">
						<div class="col-md-12">							
								<label>Endereço</label>
								<input type="text" class="form-control" id="endereco_perfil" name="endereco" placeholder="Endereço" >							
						</div>
						
					</div>


					<div class="row">
						<div class="col-md-6">							
								<label>Foto</label>
								<input type="file" class="form-control" id="foto_perfil" name="foto" value="<?php echo $foto_usuario ?>" onchange="carregarImgPerfil()">							
						</div>

						<div class="col-md-6">								
							<img src=""  width="80px" id="target-usu">								
							
						</div>

						
					</div>


					<input type="hidden" name="id" id="id_perfil">
				

				<br>
				<small><div id="msg-perfil" align="center"></div></small>
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Config -->
<div class="modal fade" id="modalConfig" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Editar Configurações</h4>
				<button id="btn-fechar-config" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-config">
			<div class="modal-body">
				

					<div class="row">
						<div class="col-md-3">							
								<label>Nome do Sistema</label>
								<input type="text" class="form-control" id="nome_sistema" name="nome_sistema" placeholder="" value="<?php echo @$nome_sistema ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>Email Sistema</label>
								<input type="email" class="form-control" id="email_sistema" name="email_sistema" placeholder="Email do Sistema" value="<?php echo @$email_sistema ?>" >							
						</div>


						<div class="col-md-3">							
								<label>Telefone Sistema</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone_sistema" placeholder="Telefone do Sistema" value="<?php echo @$telefone_sistema ?>" required>							
						</div>


							<div class="col-md-2">							
								<label>Tipo Relatório</label>
								<select class="form-control" name="tipo_rel" id="tipo_rel">
									<option value="PDF" >PDF</option>
									<option value="HTML" >HTML</option>
								</select>							
						</div>


					
					</div>



					<div class="row">
						<div class="col-md-8">							
								<label>Endereço Sistema</label>
								<input type="text" class="form-control" id="endereco_sistema" name="endereco_sistema" placeholder="Rua X, Numero X Bairro X" value="<?php echo @$endereco_sistema ?>" required>							
						</div>

						<div class="col-md-4">							
								<label>CNPJ Sistema</label>
								<input type="text" class="form-control" id="cnpj_sistema" name="cnpj_sistema" placeholder="CNPJ do Sistema" value="<?php echo @$cnpj_sistema ?>" >							
						</div>					


					
					</div>


				
				


					<div class="row">

						<div class="col-md-2">							
								<label>Tipo Desconto</label>
								<select class="form-control" name="tipo_desconto" id="tipo_desconto">
									<option value="%" >% Porcentagem</option>
									<option value="R$" >R$ Valor</option>
								</select>							
						</div>

						<div class="col-md-2">							
								<label>Comissão %</label>
								<input type="number" class="form-control" id="comissao_config" name="comissao" placeholder="Comissão Vendedor"  required>							
						</div>

						<div class="col-md-3">							
								<label>Token Api</label>
								<input type="text" class="form-control" id="token" name="token" placeholder="Token Whatsapp"  >							
						</div>

							<div class="col-md-3">						
								<div class="form-group"> 
									<label>Logo Relatório (*Jpg)</label> 
									<input class="form-control" type="file" name="foto-logo-rel" onChange="carregarImgLogoRel();" id="foto-logo-rel">
								</div>						
							</div>
							<div class="col-md-2" >
								<div id="divImg">
									<img src="images/logos/logo-rel.jpg"  width="80px" id="target-logo-rel" style="margin-top: 20px">									
								</div>
							</div>


						
					</div>					
				

				<br>
				<small><div id="msg-config" align="center"></div></small>
				<input type="hidden" name="id_empresa" id="id_empresa_config">
			</div>
			<div class="modal-footer">       
				<button type="submit" class="btn btn-primary">Salvar</button>
			</div>
			</form>
		</div>
	</div>
</div>








<!-- Modal Rel Conta Receber -->
<div class="modal fade" id="relReceber" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Recebimentos
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Rec', 'Rec')">
							<span style="color:#000" id="tudo-Rec">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Rec', 'Rec')">
							<span id="hoje-Rec">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Rec', 'Rec')">
							<span style="color:#000" id="mes-Rec">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Rec', 'Rec')">
							<span style="color:#000" id="ano-Rec">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/receber_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Rec" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Rec" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>


					</div>



					<div class="row">
						<div class="col-md-8">						
							<div class="form-group"> 
								<label>Cliente</label> 
								<select class="form-control selec2" name="pessoa" style="width:100%;"> 

									<option value="">Selecione um Cliente</option>

									<?php 
									$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa' order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>



						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Pago</label> 
								<select class="form-control" name="pago" style="width:100%;">
									<option value="">Todas</option>
									<option value="Sim">Somente Pagas</option>
									<option value="Não">Pendentes</option>

								</select> 
							</div>						
						</div>

						


					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group"> 
								<label>Tipo Recebimento</label> 
								<select class="form-control" name="tipo" style="width:100%;">
									<option value="">Todos</option>
									<option value="Venda">Vendas</option>
									<option value="Conta">Contas</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group"> 
								<label>Consultar Por</label> 
								<select class="form-control" name="busca" style="width:100%;">
									<option value="data_venc">Data de Vencimento</option>
									<option value="data_pgto">Data de Pagamento</option>

								</select>
							</div>
						</div>

					</div>




				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>







<!-- Modal Rel Conta Pagar -->
<div class="modal fade" id="relPagar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Despesas
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Pag', 'Pag')">
							<span style="color:#000" id="tudo-Pag">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Pag', 'Pag')">
							<span id="hoje-Pag">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Pag', 'Pag')">
							<span style="color:#000" id="mes-Pag">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Pag', 'Pag')">
							<span style="color:#000" id="ano-Pag">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/pagar_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Pag" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Pag" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>

						

					</div>



					<div class="row">

					<div class="col-md-4">						
							<div class="form-group"> 
								<label>Pago</label> 
								<select class="form-control" name="pago" style="width:100%;">
									<option value="">Todas</option>
									<option value="Sim">Somente Pagas</option>
									<option value="Não">Pendentes</option>

								</select> 
							</div>						
						</div>

						<div class="col-md-4">
							<div class="form-group"> 
								<label>Consultar Por</label> 
								<select class="form-control sel13" name="busca" style="width:100%;">
									<option value="data_venc">Data de Vencimento</option>
									<option value="data_pgto">Data de Pagamento</option>

								</select>
							</div>
						</div>


						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Tipo Pagamento</label> 
								<select class="form-control" name="tipo" style="width:100%;">
									<option value="">Todos</option>
									<option value="Pagamento">Pagamento</option>
									<option value="Conta">Contas</option>									
									<option value="Compra">Compra</option>
									<option value="Comissão">Comissão</option>
								</select>
							</div>					
						</div>



					</div>




				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>









<!-- Modal Rel Lucro -->
<div class="modal fade" id="relLucro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Lucro
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Luc', 'Luc')">
							<span style="color:#000" id="tudo-Luc">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Luc', 'Luc')">
							<span style="color:#000" id="hoje-Luc">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Luc', 'Luc')">
							<span id="mes-Luc">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Luc', 'Luc')">
							<span style="color:#000" id="ano-Luc">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/lucro_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Luc" value="<?php echo $data_inicio_mes ?>" required> 
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Luc" value="<?php echo $data_final_mes ?>" required> 
							</div>
						</div>

						

					</div>



				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>











<!-- Modal Rel Entradas Saidas -->
<div class="modal fade" id="relEntradas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Entradas e Saídas Produtos
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Ent', 'Ent')">
							<span style="color:#000" id="tudo-Ent">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Ent', 'Ent')">
							<span id="hoje-Ent">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Ent', 'Ent')">
							<span style="color:#000" id="mes-Ent">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Ent', 'Ent')">
							<span style="color:#000" id="ano-Ent">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/entradas_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Ent" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Ent" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>

							<div class="col-md-4">						
							<div class="form-group"> 
								<label>Entradas / Saídas</label> 
								<select class="form-control" name="status" style="width:100%;">								
									<option value="entradas">Entradas</option>
									<option value="saidas">Saídas</option>

								</select> 
							</div>						
						</div>


					</div>



				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>









<!-- Modal Rel Entradas Saidas -->
<div class="modal fade" id="relCaixas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório dos Caixas
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Cai', 'Cai')">
							<span style="color:#000" id="tudo-Cai">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Cai', 'Cai')">
							<span id="hoje-Cai">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Cai', 'Cai')">
							<span style="color:#000" id="mes-Cai">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Cai', 'Cai')">
							<span style="color:#000" id="ano-Cai">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/caixas_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Cai" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Cai" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>
							

					</div>



				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>









<!-- Modal Rel Conta Vendas -->
<div class="modal fade" id="relVendas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Vendas
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Ven', 'Ven')">
							<span style="color:#000" id="tudo-Ven">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Ven', 'Ven')">
							<span id="hoje-Ven">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Ven', 'Ven')">
							<span style="color:#000" id="mes-Ven">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Ven', 'Ven')">
							<span style="color:#000" id="ano-Ven">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/vendas_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Ven" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Ven" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group"> 
								<label>Consultar Por</label> 
								<select class="form-control" name="busca" style="width:100%;">
									<option value="data_lanc">Data da Venda</option>
									<option value="data_venc">Data de Vencimento</option>
									<option value="data_pgto">Data de Pagamento</option>
								</select>
							</div>
						</div>


					</div>



					<div class="row">
						<div class="col-md-8">						
							<div class="form-group"> 
								<label>Cliente</label> 
								<select class="form-control selec_cli" name="pessoa" style="width:100%;"> 

									<option value="">Selecione um Cliente</option>

									<?php 
									$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa' order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>



						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Pagas</label> 
								<select class="form-control" name="pago" style="width:100%;">
									<option value="">Todas</option>
									<option value="Sim">Somente Pagas</option>
									<option value="Não">Pendentes</option>

								</select> 
							</div>						
						</div>


						

						


					</div>




				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>








<!-- Modal Rel Comissões -->
<div class="modal fade" id="relComissoes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Comissões
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Com', 'Com')">
							<span style="color:#000" id="tudo-Com">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Com', 'Com')">
							<span id="hoje-Com">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Com', 'Com')">
							<span style="color:#000" id="mes-Com">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Com', 'Com')">
							<span style="color:#000" id="ano-Com">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/comissoes_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Com" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Com" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group"> 
								<label>Consultar Por</label> 
								<select class="form-control" name="busca" style="width:100%;">
									<option value="data_lanc">Data da Venda</option>							
									<option value="data_pgto">Data de Pagamento</option>
								</select>
							</div>
						</div>


					</div>



					<div class="row">
						<div class="col-md-8">						
							<div class="form-group"> 
								<label>Cliente</label> 
								<select class="form-control selec_ven" name="pessoa" style="width:100%;"> 

									<option value="">Selecione um Vendedor</option>

									<?php 
									$query = $pdo->query("SELECT * FROM usuarios where nivel = 'Vendedor' and empresa = '$id_empresa' order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>



						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Pagas</label> 
								<select class="form-control" name="pago" style="width:100%;">
									<option value="">Todas</option>
									<option value="Sim">Somente Pagas</option>
									<option value="Não">Pendentes</option>

								</select> 
							</div>						
						</div>


						

						


					</div>




				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>









<!-- Modal Rel Entradas Saidas -->
<div class="modal fade" id="relTrocas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel">Relatório de Trocas
					<small>(
						<a href="#" onclick="datas('1980-01-01', 'tudo-Ent', 'Ent')">
							<span style="color:#000" id="tudo-Ent">Tudo</span>
						</a> / 
						<a href="#" onclick="datas('<?php echo $data_atual ?>', 'hoje-Ent', 'Ent')">
							<span id="hoje-Ent">Hoje</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_mes ?>', 'mes-Ent', 'Ent')">
							<span style="color:#000" id="mes-Ent">Mês</span>
						</a> /
						<a href="#" onclick="datas('<?php echo $data_ano ?>', 'ano-Ent', 'Ent')">
							<span style="color:#000" id="ano-Ent">Ano</span>
						</a> 
					)</small>



				</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" action="../rel_sistema/trocas_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Ent" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Ent" value="<?php echo date('Y-m-d') ?>" required> 
							</div>
						</div>

							

					</div>



				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Gerar Relatório</button>
				</div>
			</form>

		</div>
	</div>
</div>








<script type="text/javascript">
	function carregarImgPerfil() {
    var target = document.getElementById('target-usu');
    var file = document.querySelector("#foto_perfil").files[0];
    
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
	$("#form-perfil").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-perfil.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-perfil').text('');
				$('#msg-perfil').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-perfil').click();
					carregarDados();				
						

				} else {

					$('#msg-perfil').addClass('text-danger')
					$('#msg-perfil').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>






 <script type="text/javascript">
	$("#form-config").submit(function () {

		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: "editar-config.php",
			type: 'POST',
			data: formData,

			success: function (mensagem) {
				$('#msg-config').text('');
				$('#msg-config').removeClass()
				if (mensagem.trim() == "Editado com Sucesso") {

					$('#btn-fechar-config').click();
					carregarDadosConfig();			
						

				} else {

					$('#msg-config').addClass('text-danger')
					$('#msg-config').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>




<script type="text/javascript">
	function carregarImgLogo() {
    var target = document.getElementById('target-logo');
    var file = document.querySelector("#foto-logo").files[0];
    
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
	function carregarImgLogoRel() {
    var target = document.getElementById('target-logo-rel');
    var file = document.querySelector("#foto-logo-rel").files[0];
    
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
	function carregarImgIcone() {
    var target = document.getElementById('target-icone');
    var file = document.querySelector("#foto-icone").files[0];
    
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
	function carregarDados(){
		var id_usu = localStorage.id_usu;
		var id_empresa = localStorage.id_empresa;
		var nivel_usu = localStorage.nivel_usu;

		$.ajax({
			url: "carregar-dados.php",
			type: 'POST',
			data: {id_usu, nivel_usu, id_empresa},

			success: function (result) {
				var split = result.split("-*");				
				$('#nome-usuario').text(split[0]);
				$('#nivel-usuario').text(split[1]);
				$('#foto-usuario').attr("src", "images/perfil/" + split[2]);

				$('#nome_perfil').val(split[0]);
				$('#target-usu').attr("src", "images/perfil/" + split[2]);
				$('#email_perfil').val(split[3]);
				$('#cpf_perfil').val(split[4]);
				$('#telefone_perfil').val(split[5]);
				$('#senha_perfil').val(split[6]);
				$('#endereco_perfil').val(split[7]);
				$('#id_perfil').val(id_usu);


				if(split[8].trim() != 'Sim'){					
					window.location="../index.php";
				}
			},			

		});		
	}
</script>





<script type="text/javascript">
	function carregarDadosConfig(){
		var id_usu = localStorage.id_usu;
		var id_empresa = localStorage.id_empresa;
		var nivel_usu = localStorage.nivel_usu;
		
		$('#id_empresa_config').val(id_empresa);

		$.ajax({
			url: "carregar-dados-config.php",
			type: 'POST',
			data: {id_usu, nivel_usu, id_empresa},

			success: function (result) {
				var split = result.split("-*");				
				$('#titulo_empresa').text(split[0]);
				$('#nome_sistema_titulo').text(split[0]);
				$('#target-logo-rel').attr("src", "images/logos/" + split[4]);

				$('#nome_sistema').val(split[0]);
				$('#email_sistema').val(split[1]);
				$('#telefone_sistema').val(split[2]);
				$('#tipo_rel').val(split[3]).change();
				$('#tipo_desconto').val(split[5]).change();
				$('#comissao_config').val(split[6]);
				$('#endereco_sistema').val(split[7]);
				$('#cnpj_sistema').val(split[8]);
				$('#token').val(split[9]);



			},			

		});		
	}
</script>



<script type="text/javascript">
	$(document).ready(function() {
    $('.selec2').select2({
    	dropdownParent: $('#relReceber')
    });

    $('.selec_cli').select2({
    	dropdownParent: $('#relVendas')
    });

    $('.selec_ven').select2({
    	dropdownParent: $('#relComissoes')
    });
});
</script>






<script type="text/javascript">
	function datas(data, id, campo){			

		var data_atual = "<?=$data_atual?>";
		var separarData = data_atual.split("-");
		var mes = separarData[1];
		var ano = separarData[0];

		var separarId = id.split("-");

		
		if(separarId[0] == 'tudo'){
			data_atual = '2100-12-31';
		}

		if(separarId[0] == 'ano'){
			data_atual = ano + '-12-31';
		}

		if(separarId[0] == 'mes'){
			if(mes == 4 || mes == 6 || mes == 9 || mes == 11){
				data_atual = ano + '-'+ mes + '-30';
			}else if (mes == 2){
				data_atual = ano + '-'+ mes + '-28';
			}else{
				data_atual = ano + '-'+ mes + '-31';
			}

		}

		$('#dataInicialRel-'+campo).val(data);
		$('#dataFinalRel-'+campo).val(data_atual);

		document.getElementById('hoje-'+campo).style.color = "#000";
		document.getElementById('mes-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";	
		document.getElementById('tudo-'+campo).style.color = "#000";
		document.getElementById('ano-'+campo).style.color = "#000";
		document.getElementById(id).style.color = "blue";		
	}
</script>


<script type="text/javascript">
	function painelEmpresa(id){
		localStorage.setItem('id_empresa', id);
		carregarDadosConfig()
		location.reload();
	}
</script>