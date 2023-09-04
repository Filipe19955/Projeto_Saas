<?php 
$tabela = 'empresas';
require_once("../../../conexao.php");
$data_hoje = date('Y-m-d');
$data_hojeF = implode('/', array_reverse(explode('-', $data_hoje)));

$data_2anos = date('Y-m-d', strtotime("+2 years",strtotime($data_hoje)));
$data_2anosF = implode('/', array_reverse(explode('-', $data_2anos)));

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
$data_extenso = utf8_encode(strftime('%A, %d de %B de %Y', strtotime('today')));

//trazer os dados da empresa sas
$query = $pdo->query("SELECT * FROM config WHERE empresa = 0");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_sistema = $res[0]['nome_sistema'];
$email_sistema = $res[0]['email_sistema'];
$telefone_sistema = $res[0]['telefone_sistema'];
$dias_bloqueio = $res[0]['dias_bloqueio'];


$id_empresa = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela where id = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
$nome = $res[0]['nome'];
$telefone = $res[0]['telefone'];
$email = $res[0]['email'];
$cpf = $res[0]['cpf'];
$cnpj = $res[0]['cnpj'];
$ativo = $res[0]['ativo'];
$data_cad = $res[0]['data_cad'];
$data_pgto = $res[0]['data_pgto'];
$valor = $res[0]['valor'];
$endereco = $res[0]['endereco'];

$valorF = number_format($valor, 2, ',', '.');	
$data_sep = explode("-", $data_pgto);
$dia_pgto = $data_sep[2];

if($cnpj != ""){
	$texto_cnpj = 'inscrita no CNPJ '.$cnpj;
}else{
	$texto_cnpj = 'inscrito no CPF '.$cpf;
}

$query = $pdo->query("SELECT * FROM contratos where empresa = '$id_empresa'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	echo $res[0]['texto'];
	exit();
}

 echo <<<HTML
<div align="center"><h4>CONTRATO PARTICULAR DE LOCAÇÃO DE SOFTWARE</h4></div>
<br>
<p>
Por este instrumento particular, a saber de um lado <b>{$nome}</b>, localizado em {$endereco}, {$texto_cnpj}, por seu representante legal ao final assinado, ora denominada de contratante e de outro lado a empresa {$nome_sistema}, com sede na cidade de Belo Horizonte, Rua A, Número 50, Bairro Centro, por seu representante legal, ora denominada de contratada, tem entre si, justo e contratado o seguinte:
</p>
<br>
<p>
<b>CLÁUSULA 1º </b>- A contratante nesta oportunidade contrata os serviços da contratada, para a locação, instalação e manutenção de software composto de (Sistema Gerenciamento de Vendas), da qual a mesma é detentora dos direitos autorais.
<br><br>
<p>
<b>CLÁUSULA 2º </b>- O período de uso será de vinte e quatro (24) horas por dia, exceto quando ocorrer interrupções por falta de energia, manutenção, casos fortuitos ou ação de terceiros sobre o software.
<br><br>
<b>CLÁUSULA 3º </b>- Que o uso do software é para a empresa contratante, não podendo essa ceder ou transferir para outrem sua utilização.
<br><br>
<p>
<b>CLÁUSULA 4º </b>- Que a contratada se responsabiliza pela legalidade do produto alugado, ficando responsável pelo fornecimento de atualizações quando essas forem realizadas, sem qualquer custo adicional.
<br><br>
<p>
<b>CLÁUSULA 5º </b>- Que a manutenção do software objeto do presente contrato só poderá ser realizado pela contratada, ficando essa responsável pelo fornecimento gratuito de suporte técnico no horário comercial, via telefone ou e-mail, de modo a resolver problemas operacionais.
<p>
<br>
<b>CLÁUSULA 6º </b>- Que a contratada tendo ciência de informações tidas como confidenciais da contratante, obriga-se a manter sigilo sobre as mesmas.
<br><br>
<p>
<b>CLÁUSULA 7º </b>- Que a contratante se obriga a não efetuar alterações no software, sem autorização por escrito da contratada.
<br><br>
<p>
<b>CLÁUSULA 8º </b>- Que combinam o aluguel do software da ordem de <b>R$ {$valorF}</b> (REAIS) por mês, a ser pago todo dia {$dia_pgto}, mediante pagamento Pix, ficando estabelecido que após o vencimento incidirão juros moratórios à razão de TAL e multa de 2% sobre o aluguel mensal.
<br><br>
<p>
<b>CLÁUSULA 9º </b>- Que no caso de inadimplemento de três meses de aluguel, o presente será rescindido de pleno direito, ficando suspenso o serviço objeto deste contrato, com a cobrança dos valores e acréscimos ora estabelecidos.
<br><br>
<p>
<b>CLÁUSULA 10º </b>- Que o presente contrato é feito pelo prazo de <b>vinte e quatro (24) meses</b>, a iniciar-se em data {$data_hojeF} e a findar-se em data {$data_2anosF}, cujo prazo poderá ser prorrogado de comum acordo, desde que haja comunicação prévia entre as partes com o mínimo de trinta (30) dias antes do vencimento.
<br><br>
<p>

<b>CLÁUSULA 11º </b>- Que no caso de inadimplemento de {$dias_bloqueio} dias, o contratante poderá retirar o acesso dos usuários da contratada deixando assim inativo até que o pagamento de todas as parcelas inadimplentes sejam quitadas.
<br><br>
<p>


<b>CLÁUSULA 12º </b>- Este contrato não obriga o contratante a efetuar implementações no sistema, toda e qualquer implementação desejada pelo contratado deverá ser acordada como um serviço externo ao que foi definido neste contrato, podendo gerar assim custos ao contratado.
<br><br>
<p>

<b>CLÁUSULA 13º </b>- O contratado confirma ter acompanhado a apresentação do sistema e ter entendido todos os recursos e funcionalidades do mesmo, sendo assim está de acordo com o que foi proposto pelo software e confirma a utilização do mesmo nos moldes apresentados.
<br><br>
<p>

<b>CLÁUSULA 14º </b>- Elegem o foro da Comarca de Belo Horizonte MG para dirimirem eventuais dúvidas oriundas do presente contrato.

<br><br>
<p>
E por estarem assim, justas e contratadas assinam o presente em duas (2) vias de igual teor e forma na presença de duas testemunhas, para que surta seus efeitos de direito.
<br><br><br>
<p>
<div align="center">
Belo Horizonte, {$data_extenso}
</div>
<br><br>

<div align="center">
____________________________________________________________________________<br>
CONTRATANTE
</div>
<br><br>

<div align="center">
____________________________________________________________________________<br>
CONTRATADA
</div>
<br><br>

<div align="center">
____________________________________________________________________________<br>
TESTEMUNHA
</div>
<br><br>

<div align="center">
____________________________________________________________________________<br>
TESTEMUNHA
</div>
HTML;

  ?>