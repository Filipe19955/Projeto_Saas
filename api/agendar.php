<?php
  $url = "http://api.enviame.com.br/agendar-text";
  $data = array('instance' => $whatsapp,
                'to' => $cliente,
                'token' => $token,
                'message' => $mensagem),
                'data' => $data_agendamento);


  $options = array('http' => array(
                 'method' => 'POST',
                 'content' => http_build_query($data)
  ));

  $stream = stream_context_create($options);

  $result = file_get_contents($url, false, $stream);

  echo $result;
?>
  
  