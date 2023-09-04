<?php 
//totalizar as empresas
$query = $pdo->query("SELECT * FROM empresas where ativo = 'Sim'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_empresas = @count($res);

//receber hoje
$total_receber_hoje = 0;
$query = $pdo->query("SELECT * FROM receber where data_venc = curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_hoje += $res[$i]['valor'];
}
$total_receber_hojeF = number_format($total_receber_hoje, 2, ',', '.');

//pagar hoje
$total_pagar_hoje = 0;
$query = $pdo->query("SELECT * FROM pagar where data_venc = curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_pagar_hoje += $res[$i]['valor'];
}
$total_pagar_hojeF = number_format($total_pagar_hoje, 2, ',', '.');

//Saldo do Mês
$total_receber_mes = 0;
$query = $pdo->query("SELECT * FROM receber where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' and tipo = 'Empresa' and empresa = '0'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_mes += $res[$i]['valor'];
}


$total_pagar_mes = 0;
$query = $pdo->query("SELECT * FROM pagar where data_pgto >= '$data_inicio_mes' and data_pgto <= '$data_final_mes' and pago = 'Sim' and tipo = 'Empresa' and empresa = '0'");
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


//recebimentos vencidos
$total_receber_vencidas = 0;
$query = $pdo->query("SELECT * FROM receber where data_venc < curDate() and pago != 'Sim' and tipo = 'Empresa' and empresa = '0' order by data_venc asc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
for($i=0; $i < @count($res); $i++){	
$total_receber_vencidas += $res[$i]['valor'];
}
$total_receber_vencidasF = number_format($total_receber_vencidas, 2, ',', '.');





//totalizar dados do gráfico
$dados_meses_despesas =  '';
$dados_meses_recebimentos =  '';
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
        $query = $pdo->query("SELECT * FROM pagar where pago = 'Sim' and data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' and tipo = 'Empresa' and empresa = '0' ORDER BY id asc");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_reg = @count($res);
        if($total_reg > 0){
            for($i2=0; $i2 < $total_reg; $i2++){
                foreach ($res[$i2] as $key => $value){}
            $total_mes_despesa +=  $res[$i2]['valor'];
        }
        }

        $dados_meses_despesas = $dados_meses_despesas. $total_mes_despesa. '-';




          //recebimentos
        $total_mes_receb = 0;
        $query = $pdo->query("SELECT * FROM receber where pago = 'Sim' and data_pgto >= '$data_mes_inicio_grafico' and data_pgto <= '$data_mes_final_grafico' and tipo = 'Empresa' and empresa = '0' ORDER BY id asc");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);
        $total_reg = @count($res);
        if($total_reg > 0){
            for($i2=0; $i2 < $total_reg; $i2++){
                foreach ($res[$i2] as $key => $value){}
            $total_mes_receb +=  $res[$i2]['valor'];
        }
        }

        $dados_meses_recebimentos = $dados_meses_recebimentos. $total_mes_receb. '-';
    }


 ?>


<div class="main-page">

  <input type="hidden" id="dados_grafico_despesa">
   <input type="hidden" id="dados_grafico_recebimento">

	<div class="col_3">

		<a href="index.php?pagina=empresas">
		<div class="col-md-3 widget widget1">
			<div class="r3_counter_box">
				<i class="pull-left fa fa-users icon-rounded"></i>
				<div class="stats">
					<h5><strong><big><?php echo @$total_empresas ?></big></strong></h5>			
				</div>
				 <hr style="margin-top:10px">
                  <div align="center"><span style="color:#6d6d6e !important">Clientes Ativos</span></div>
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
                  <div align="center"><span style="color:#6d6d6e !important">Recebimentos Hoje</span></div>
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
                  <div align="center"><span style="color:#6d6d6e !important">Pagamentos Hoje</span></div>
			</div>
		</div>
	</a>

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
					<h3>Movimentações do Ano</h3>
				</div>
				
				<div id="Linegraph" style="width: 98%; height: 350px">
				</div>
				
			</div>
		</div>
		


		<div class="clearfix"> </div>
	</div>
	
	
	

	
</div>




<!-- for index page weekly sales java script -->
<script src="js/SimpleChart.js"></script>
<script>

	$('#dados_grafico_despesa').val('<?=$dados_meses_despesas?>'); 
		 var dados = $('#dados_grafico_despesa').val();
        saldo_mes = dados.split('-');

		 $('#dados_grafico_recebimento').val('<?=$dados_meses_recebimentos?>'); 
		  var dados_rec = $('#dados_grafico_recebimento').val();
        saldo_mes_rec = dados_rec.split('-'); 

	var graphdata1 = {
		linecolor: "#f2371f",
		title: "Despesas",
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
	var graphdata2 = {
		linecolor: "#04ba41",
		title: "Recebimentos",
		values: [
		{ X: "Janeiro", Y: parseFloat(saldo_mes_rec[0]) },
		{ X: "Fevereiro", Y: parseFloat(saldo_mes_rec[1]) },
		{ X: "Março", Y: parseFloat(saldo_mes_rec[2]) },
		{ X: "Abril", Y: parseFloat(saldo_mes_rec[3]) },
		{ X: "Maio", Y: parseFloat(saldo_mes_rec[4]) },
		{ X: "Junho", Y: parseFloat(saldo_mes_rec[5]) },
		{ X: "Julho", Y: parseFloat(saldo_mes_rec[6]) },
		{ X: "Agosto", Y: parseFloat(saldo_mes_rec[7]) },
		{ X: "Setembro", Y: parseFloat(saldo_mes_rec[8]) },
		{ X: "Outubro", Y: parseFloat(saldo_mes_rec[9]) },
		{ X: "Novembro", Y: parseFloat(saldo_mes_rec[10]) },
		{ X: "Dezembro", Y: parseFloat(saldo_mes_rec[11]) },
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
			data: [graphdata2, graphdata1],
			legendsize: "30",
			legendposition: 'bottom',
			xaxislabel: '',
			title: 'Despesas / Recebimentos',
			yaxislabel: ''
		});
		
	});

</script>
<!-- //for index page weekly sales java script -->
