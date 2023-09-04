<?php 

//verificar se ele tem a permissão de estar nessa página
if(@$home == 'ocultar'){
    echo "<script>window.location='../index.php'</script>";
    exit();
}

//totalizar as empresas
$query = $pdo->query("SELECT * FROM clientes where empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_empresas = @count($res);

//receber hoje
$total_receber_hoje = 0;
$query = $pdo->query("SELECT * FROM receber where data_venc = curDate() and pago != 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_hoje += $res[$i]['valor'];
}
$total_receber_hojeF = number_format($total_receber_hoje, 2, ',', '.');

//pagar hoje
$total_pagar_hoje = 0;
$query = $pdo->query("SELECT * FROM pagar where data_venc = curDate() and pago != 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_pagar_hoje += $res[$i]['valor'];
}
$total_pagar_hojeF = number_format($total_pagar_hoje, 2, ',', '.');

//Saldo do Mês
$total_receber_mes = 0;
$query = $pdo->query("SELECT * FROM receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_mes += $res[$i]['valor'];
}


$total_pagar_mes = 0;
$query = $pdo->query("SELECT * FROM pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_pagar_mes += $res[$i]['valor'];
}

$total_saldo_mes = $total_receber_mes - $total_pagar_mes;
$total_saldo_mesF = number_format($total_saldo_mes, 2, ',', '.');

if($total_saldo_mes < 0){
	$classe_saldo = 'user1';
}else{
	$classe_saldo = 'dollar2';
}



//totalizar estoque baixo
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


//Saldo do dia
$total_receber_dia = 0;
$query = $pdo->query("SELECT * FROM receber where data_pgto = curDate() and pago = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_dia += $res[$i]['valor'];
}


$total_pagar_dia = 0;
$query = $pdo->query("SELECT * FROM pagar where data_pgto = curDate() and pago = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_pagar_dia += $res[$i]['valor'];
}

$total_saldo_dia = $total_receber_dia - $total_pagar_dia;
$total_saldo_diaF = number_format($total_saldo_dia, 2, ',', '.');

if($total_saldo_dia < 0){
	$classe_saldo_dia = 'user1';
}else{
	$classe_saldo_dia = 'dollar2';
}


//recebimentos vencidos
$total_receber_vencidas = 0;
$query = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and empresa = '$id_empresa' order by data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contas_receber_venc = @count($res);
for($i=0; $i < @count($res); $i++){	
$total_receber_vencidas += $res[$i]['valor'];
}
$total_receber_vencidasF = number_format($total_receber_vencidas, 2, ',', '.');


//pagamentos vencidos
$total_pagar_vencidas = 0;
$query = $pdo->query("SELECT * FROM pagar where data_venc < curDate() and pago != 'Sim' and empresa = '$id_empresa' order by data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_contas_pagar_venc = @count($res);
for($i=0; $i < @count($res); $i++){	
$total_pagar_vencidas += $res[$i]['valor'];
}
$total_pagar_vencidasF = number_format($total_pagar_vencidas, 2, ',', '.');



//total de contas vencidas
$total_contas_vencidas = $total_contas_receber_venc + $total_contas_pagar_venc;


//vendas no dia
$total_vendas_dia = 0;
$query = $pdo->query("SELECT * FROM receber where data_pgto = curDate() and pago = 'Sim' and empresa = '$id_empresa' and tipo = 'Venda'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_vendas_dia += $res[$i]['valor'];
}
$total_vendas_diaF = number_format($total_vendas_dia, 2, ',', '.');




//totalizar dados do gráfico
$dados_meses_despesas =  '';
$dados_meses_recebimentos =  '';
$total_saldo_grafico = '';
        //ALIMENTAR DADOS PARA O GRÁFICO
        for($i=1; $i <= 12; $i++){

            if($i < 10){
                $mes_atual = '0'.$i;
            }else{
                $mes_atual = $i;
            }

        if($mes_atual == '4' || $mes_atual == '6' || $mes_atual == '9' || $mes_atual == '11'){
            $dia_final_mes = '30';
        }else if($mes_atual == '2'){
            $dia_final_mes = '28';
        }else{
            $dia_final_mes = '31';
        }

         $data_mes_inicio_grafico = $ano_atual."-".$mes_atual."-01";
        $data_mes_final_grafico = $ano_atual."-".$mes_atual."-".$dia_final_mes;


         //DESPESAS
        $total_mes_despesa = 0;
        $query = $pdo->query("SELECT * FROM pagar where pago = 'Sim' and data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' and empresa = '$id_empresa' ORDER BY id asc");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_reg = @count($res);
        if($total_reg > 0){
            for($i2=0; $i2 < $total_reg; $i2++){
                foreach ($res[$i2] as $key => $value){}
            $total_mes_despesa +=  $res[$i2]['valor'];
        }
        }

        $dados_meses_despesas = $dados_meses_despesas. $total_mes_despesa. '*';




          //recebimentos
        $total_mes_receb = 0;
        $query = $pdo->query("SELECT * FROM receber where pago = 'Sim' and data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' and empresa = '$id_empresa' ORDER BY id asc");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_reg = @count($res);
        if($total_reg > 0){
            for($i2=0; $i2 < $total_reg; $i2++){
                foreach ($res[$i2] as $key => $value){}
            $total_mes_receb +=  $res[$i2]['valor'];
        }
        }

        $dados_meses_recebimentos = $dados_meses_recebimentos. $total_mes_receb. '*';



        //totalizar o saldo de cada mes do ano

$total_receber_mes = 0;
$query = $pdo->query("SELECT * FROM receber where data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' and pago = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i3=0; $i3 < @count($res); $i3++){	
$total_receber_mes += $res[$i3]['valor'];
}


$total_pagar_mes = 0;
$query = $pdo->query("SELECT * FROM pagar where data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' and pago = 'Sim' and empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i3=0; $i3 < @count($res); $i3++){	
$total_pagar_mes += $res[$i3]['valor'];
}

$total_saldo_mes = $total_receber_mes - $total_pagar_mes;


$total_saldo_grafico = $total_saldo_grafico. $total_saldo_mes. '*';

    }


 ?>


<div class="main-page">

  <input type="hidden" id="dados_grafico_despesa">
   <input type="hidden" id="dados_grafico_recebimento">
     <input type="hidden" id="dados_grafico_saldo">

	<div class="col_3">

		<a href="index.php?pagina=empresas">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_empresas ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Total de Clientes</span></div>
			</div>
		</div>
		</a>

<a href="index.php?pagina=receber">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-usd dollar2 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_receber_hojeF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Total à receber Hoje</span></div>
			</div>
		</div>
	</a>

	<a href="index.php?pagina=pagar">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money user1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_pagar_hojeF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Total à pagar Hoje</span></div>
			</div>
		</div>
	</a>

<a href="index.php?pagina=vendas">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money dollar2 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big> <?php echo @$total_vendas_diaF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Vendas Hoje</span></div>
			</div>
		</div>
	</a>


		<div class="col-md-3 widget">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-usd <?php echo $classe_saldo_dia ?> icon-rounded"></i>
				<div class="stats">
					<h5><strong><big> <?php echo @$total_saldo_diaF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Saldo Hoje</span></div>
			</div>
		</div>


		<div class="clearfix"> </div>
	</div>








	<div class="col_3" style="margin-top: 15px">

		<a href="index.php?pagina=estoque">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-shopping-cart dollar1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo $estoque_baixo ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Estoque Baixo</span></div>
			</div>
		</div>
		</a>

<a href="index.php?pagina=pagar">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-usd dollar1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_pagar_vencidasF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Pagamentos Vencidos</span></div>
			</div>
		</div>
	</a>

	
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-calendar-o user1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_contas_vencidas ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Contas Vencidas</span></div>
			</div>
		</div>
	

<a href="index.php?pagina=receber">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-money dollar1 icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo $total_receber_vencidasF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Recebimentos Vencidos</span></div>
			</div>
		</div>
	</a>


		<div class="col-md-3 widget">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-usd <?php echo $classe_saldo ?> icon-rounded"></i>
				<div class="stats">
					<h5><strong><big> <?php echo @$total_saldo_mesF ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Saldo Mês</span></div>
			</div>
		</div>


		<div class="clearfix"> </div>
	</div>
	
	<div class="row-one widgettable">
		<div class="col-md-12 content-top-2 card">
			<div class="agileinfo-cdr">
				<div class="card-header">
					<h3>Faturamento Anual</h3>
				</div>
				
				<div id="Linegraph" style="width: 98%; height: 350px">
				</div>
				
			</div>
		</div>
		


		<div class="clearfix"> </div>
	</div>






	<div class="row-one widgettable">
		<div class="col-md-12 content-top-2 card" style="padding:20px">
			<div class="card-header">
				<h3>Entradas e Saídas</h3>
			</div>			
				<canvas id="canvas" style="width: 100%; height:450px;"></canvas>
				
		</div>	
</div>
	
	
	

	
</div>




<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>
<script>

	
			$('#dados_grafico_saldo').val('<?=$total_saldo_grafico?>'); 
		 var dados = $('#dados_grafico_saldo').val();
        saldo_mes = dados.split('*');

	var graphdata1 = {
		linecolor: "#04ba41",
		title: "Saldo Mês",
		values: [
		{ X: "Janeiro", Y: parseFloat(saldo_mes[0]) },
		{ X: "Fevereiro", Y: parseFloat(saldo_mes[1]) },
		{ X: "Março", Y: parseFloat(saldo_mes[2]) },
		{ X: "Abril", Y: parseFloat(saldo_mes[3]) },
		{ X: "Maio", Y: parseFloat(saldo_mes[4]) },
		{ X: "Junho", Y: parseFloat(saldo_mes[5]) },
		{ X: "Julho", Y: parseFloat(saldo_mes[6]) },
		{ X: "Agosto", Y: parseFloat(saldo_mes[7]) },
		{ X: "Setembro", Y: parseFloat(saldo_mes[8]) },
		{ X: "Outubro", Y: parseFloat(saldo_mes[9]) },
		{ X: "Novembro", Y: parseFloat(saldo_mes[10]) },
		{ X: "Dezembro", Y: parseFloat(saldo_mes[11]) },
		
		]
	};
		
	
	$(function () {		

		
		
		$("#Linegraph").SimpleChart({
			ChartType: "Line",
			toolwidth: "50",
			toolheight: "25",
			axiscolor: "#E6E6E6",
			textcolor: "#6E6E6E",
			showlegends: true,
			data: [graphdata1],
			legendsize: "30",
			legendposition: 'bottom',
			xaxislabel: '',
			title: 'Saldo Mês',
			yaxislabel: ''
		});
		
	});

</script>
<!-- //for index page weekly sales java script -->







		<!-- GRAFICO DE BARRAS -->
	<script type="text/javascript">
		$(document).ready(function() {

			$('#dados_grafico_despesa').val('<?=$dados_meses_despesas?>'); 
		 var dados = $('#dados_grafico_despesa').val();
        total_saidas = dados.split('*');

		 $('#dados_grafico_recebimento').val('<?=$dados_meses_recebimentos?>'); 
		  var dados_rec = $('#dados_grafico_recebimento').val();
        total_entradas = dados_rec.split('*'); 


				var color = Chart.helpers.color;
				var barChartData = {
					labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
					datasets: [{
						label: 'Entradas',
						backgroundColor: color('green').alpha(0.5).rgbString(),
						borderColor: 'green',
						borderWidth: 1,
						data: [
						total_entradas[0],
						total_entradas[1],
						total_entradas[2],
						total_entradas[3],
						total_entradas[4],
						total_entradas[5],
						total_entradas[6],
						total_entradas[7],
						total_entradas[8],
						total_entradas[9],
						total_entradas[10],
						total_entradas[11],
						total_entradas[12],
						]
					}, {
						label: 'Despesas',
						backgroundColor: color('red').alpha(0.5).rgbString(),
						borderColor: 'red',
						borderWidth: 1,
						data: [
						total_saidas[0],
						total_saidas[1],
						total_saidas[2],
						total_saidas[3],
						total_saidas[4],
						total_saidas[5],
						total_saidas[6],
						total_saidas[7],
						total_saidas[8],
						total_saidas[9],
						total_saidas[10],
						total_saidas[11],
						total_saidas[12],
						]
					}]

				};

			var ctx = document.getElementById("canvas").getContext("2d");
					window.myBar = new Chart(ctx, {
						type: 'bar',
						data: barChartData,
						options: {
							responsive: true,
							legend: {
								position: 'top',
							},
							title: {
								display: true,
								text: 'Comparativo de Movimentações'
							}
						}
					});

	})
	
	</script>