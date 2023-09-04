<?php 
include '../../barras/barcode128.php';
echo bar128(stripcslashes($_POST['codigo']));
 ?>