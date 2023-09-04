<?php 
require_once("../conexao.php");

if(@$_GET['pagina'] != ""){
	$pagina = @$_GET['pagina'];
}else{
	$pagina = 'home';
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

//Criar uma config caso não tenha nenhuma
$query = $pdo->query("SELECT * FROM config WHERE empresa = 0");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);

if($total_reg == 0){
  $pdo->query("INSERT into config SET empresa = '0', nome_sistema = 'Sistema de Vendas', tipo_rel = 'PDF', teste = 'Sim', dias_teste = '3' ");
}else{
	$nome_sistema = $res[0]['nome_sistema'];
	$email_sistema = $res[0]['email_sistema'];
	$telefone_sistema = $res[0]['telefone_sistema'];
	$tipo_rel = $res[0]['tipo_rel'];
	$dias_bloqueio = $res[0]['dias_bloqueio'];
	$msg_bloqueio = $res[0]['msg_bloqueio'];
	$teste_config = $res[0]['teste'];
	$dias_teste = $res[0]['dias_teste'];
	$token = $res[0]['token'];
	$data_envio = $res[0]['data'];
}




?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $nome_sistema ?></title>
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
						<h1><a class="navbar-brand" href="index.php"><span class="fa fa-usd"></span> Sistema SaaS<span class="dashboard_text"><?php echo $nome_sistema ?></span></a></h1>
					</div>
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="sidebar-menu">
							<li class="header">MENU NAVEGAÇÃO</li>
							<li class="treeview">
								<a href="index.php">
									<i class="fa fa-dashboard"></i> <span>Home</span>
								</a>
							</li>
							<li class="treeview">
								<a href="#">
									<i class="fa fa-users"></i>
									<span>Pessoas</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li><a href="index.php?pagina=usuarios"><i class="fa fa-angle-right"></i> Usuários</a></li>

									<li><a href="index.php?pagina=empresas"><i class="fa fa-angle-right"></i> Empresas</a></li>
									
								</ul>
							</li>


							<li class="treeview">
								<a href="#">
									<i class="fa fa-floppy-o"></i>
									<span>Cadastros</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li><a href="index.php?pagina=frequencias"><i class="fa fa-angle-right"></i> Frequências</a></li>

									<li><a href="index.php?pagina=grupos"><i class="fa fa-angle-right"></i> Grupos</a></li>

									<li><a href="index.php?pagina=acessos"><i class="fa fa-angle-right"></i> Acessos</a></li>


									
								</ul>
							</li>



							<li class="treeview">
								<a href="#">
									<i class="fa fa-money"></i>
									<span>Financeiro</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li><a href="index.php?pagina=receber"><i class="fa fa-angle-right"></i> Contas à Receber</a></li>

									<li><a href="index.php?pagina=pagar"><i class="fa fa-angle-right"></i> Despesas</a></li>

									
								</ul>
							</li>


							<li class="treeview">
								<a href="#">
									<i class="fa fa-file-o"></i>
									<span>Relatórios</span>
									<i class="fa fa-angle-left pull-right"></i>
								</a>
								<ul class="treeview-menu">
									<li><a href="../rel/empresas_class.php" target="_blank"><i class="fa fa-angle-right"></i> Relatório de Empresas</a></li>

									<li><a href="#" data-toggle="modal" data-target="#relReceber"><i class="fa fa-angle-right"></i> Relatório de Recebimentos</a></li>

									<li><a href="#" data-toggle="modal" data-target="#relPagar"><i class="fa fa-angle-right"></i> Relatório de Despesas</a></li>

									<li><a href="#" data-toggle="modal" data-target="#relLucro"><i class="fa fa-angle-right"></i> Demonstrativo de Lucro</a></li>

									
								</ul>
							</li>

						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</aside>
		</div>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush" data-toggle="collapse" data-target=".collapse"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="profile_details_left"><!--notifications of menu start -->
					<ul class="nofitications-dropdown">
						<li class="dropdown head-dpdn">
							<?php 
							$query = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' order by data_venc asc");
							$res = $query->fetchAll(PDO::FETCH_ASSOC);
							$total_reg = @count($res);
							if($total_reg <= 1){
								 $texto_pendentes = 'recebimento Vencido';
								}else{
									$texto_pendentes = 'recebimentos Vencidos';
								}
							 ?>
							
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-usd" style="color:#FFF"></i><span class="badge"><?php echo $total_reg ?></span></a>
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
								<li> <a href="" data-toggle="modal" data-target="#modalConfig"><i class="fa fa-cog"></i> Configurações</a> </li> 
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
			<?php 
			require_once('paginas/'.$pagina.'.php');
			?>
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

						<div class="col-md-3">							
								<label>Email Sistema</label>
								<input type="email" class="form-control" id="email_sistema" name="email_sistema" placeholder="Email do Sistema" value="<?php echo @$email_sistema ?>" >							
						</div>


						<div class="col-md-3">							
								<label>Telefone Sistema</label>
								<input type="text" class="form-control" id="telefone_sistema" name="telefone_sistema" placeholder="Telefone do Sistema" value="<?php echo @$telefone_sistema ?>" required>							
						</div>


							<div class="col-md-3">							
								<label>Tipo Relatório</label>
								<select class="form-control" name="tipo_rel">
									<option value="PDF" <?php if(@$tipo_rel == 'PDF'){?> selected <?php } ?> >PDF</option>
									<option value="HTML" <?php if(@$tipo_rel == 'HTML'){?> selected <?php } ?> >HTML</option>
								</select>							
						</div>


					
					</div>

					<div class="row">
						<div class="col-md-12">							
								<label>Mensagem de Bloqueio</label>
								<input type="text" class="form-control" id="msg_bloqueio" name="msg_bloqueio" placeholder="Reguralize sua mensalidade, seu acesso ao sistema será bloqueado!" value="<?php echo @$msg_bloqueio ?>">							
						</div>
					</div>


					<div class="row">
						<div class="col-md-2">							
								<label>Dias Bloqueio</label>
								<input type="number" class="form-control" id="dias_bloqueio" name="dias_bloqueio" placeholder="" value="<?php echo @$dias_bloqueio ?>">							
						</div>

						<div class="col-md-2">							
								<label>Testar Sistema</label>
								<select class="form-control" name="teste" id="teste_config">
									<option value="Sim" <?php if(@$teste_config == 'Sim'){?> selected <?php } ?> >Sim</option>
									<option value="Não" <?php if(@$teste_config == 'Não'){?> selected <?php } ?> >Não</option>
								</select>							
						</div>

						<div class="col-md-2">							
								<label>Dias Teste</label>
								<input type="number" class="form-control" id="dias_teste" name="dias_teste" placeholder="" value="<?php echo @$dias_teste ?>">							
						</div>

							<div class="col-md-3">							
								<label>Token Api</label>
								<input type="text" class="form-control" id="token" name="token" placeholder="Token Whatsapp" value="<?php echo @$token ?>" >							
						</div>

						
					</div>
				
					

					<div class="row">
						<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo (*PNG)</label> 
									<input class="form-control" type="file" name="foto-logo" onChange="carregarImgLogo();" id="foto-logo">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg" style="background:#dbdbdb">
									<img src="../img/logo.png"  width="80px" id="target-logo">									
								</div>
							</div>


							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Ícone (*Png)</label> 
									<input class="form-control" type="file" name="foto-icone" onChange="carregarImgIcone();" id="foto-icone">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/icone.png"  width="50px" id="target-icone">									
								</div>
							</div>

						
					</div>




					<div class="row">
							<div class="col-md-4">						
								<div class="form-group"> 
									<label>Logo Relatório (*Jpg)</label> 
									<input class="form-control" type="file" name="foto-logo-rel" onChange="carregarImgLogoRel();" id="foto-logo-rel">
								</div>						
							</div>
							<div class="col-md-2">
								<div id="divImg">
									<img src="../img/logo-rel.jpg"  width="80px" id="target-logo-rel">									
								</div>
							</div>


						
					</div>					
				

				<br>
				<small><div id="msg-config" align="center"></div></small>
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
			<form method="post" action="../rel/receber_class.php" target="_blank">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Data Inicial</label> 
								<input type="date" class="form-control" name="dataInicial" id="dataInicialRel-Rec" value="<?php echo date('Y-m-d') ?>" required> 
							</div>						
						</div>
						<div class="col-md-4">
							<div class="form-group"> 
								<label>Data Final</label> 
								<input type="date" class="form-control" name="dataFinal" id="dataFinalRel-Rec" value="<?php echo date('Y-m-d') ?>" required> 
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
								<label>Cliente / Empresa</label> 
								<select class="form-control selec2" name="pessoa" style="width:100%;"> 

									<option value="">Selecione uma Empresa</option>

									<?php 
									$query = $pdo->query("SELECT * FROM empresas order by nome asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){		
											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>
						<div class="col-md-6">
							<div class="form-group"> 
								<label>Consultar Por</label> 
								<select class="form-control sel13" name="busca" style="width:100%;">
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
			<form method="post" action="../rel/pagar_class.php" target="_blank">
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

					<div class="col-md-6">						
							<div class="form-group"> 
								<label>Pago</label> 
								<select class="form-control" name="pago" style="width:100%;">
									<option value="">Todas</option>
									<option value="Sim">Somente Pagas</option>
									<option value="Não">Pendentes</option>

								</select> 
							</div>						
						</div>

						<div class="col-md-6">
							<div class="form-group"> 
								<label>Consultar Por</label> 
								<select class="form-control sel13" name="busca" style="width:100%;">
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
			<form method="post" action="../rel/lucro_class.php" target="_blank">
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
					location.reload();				
						

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

		$.ajax({
			url: "carregar-dados.php",
			type: 'POST',
			data: {id_usu},

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
	$(document).ready(function() {
    $('.selec2').select2({
    	dropdownParent: $('#relReceber')
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
