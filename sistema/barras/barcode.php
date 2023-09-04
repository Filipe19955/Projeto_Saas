<html>
<head>
<style>
p.inline {display: inline-block; border:1px solid #000; padding:5px;}
span { font-size: 15px;}
</style>
<style type="text/css" media="print">
    @page 
    {
        size: auto;   /* auto is the initial value */
        margin: 0mm;  /* this affects the margin in the printer settings */

    }
    body {
    	background-color: white !important;
    -webkit-print-color-adjust: exact;
}
</style>
</head>
<body onload="window.print();">
	<div style="margin-left: 5%; text-align: center">
		<?php
		include 'barcode128.php';
		$nome = $_POST['nome'];
		$id = $_POST['id'];
		$valor = $_POST['valor'];
		$codigo = $_POST['codigo'];
		$quantidade = $_POST['quantidade'];

		for($i=1;$i<=$quantidade;$i++){
			echo "<p class='inline'><span style='font-size:10px';><small>".mb_strtoupper($nome)."</small></span><br><span>".bar128(stripcslashes($codigo))."</span><span style='background:#232222; color:#FFF; padding:0px 25px;' >R$".$valor." <span></p>&nbsp&nbsp&nbsp&nbsp";
		}

		?>
	</div>
</body>
</html>