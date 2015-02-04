<?php
	
	require_once("classes/sala.class.php");
	
	$sala = new sala();
	
	$sala->setValor("nome", "Sala DF");
	$sala->setValor("numero", "100");
	$sala->setValor("capacidade", "100");
	$sala->valorpk = 14;
	//$sala->inserir($sala);
	//$sala->atualizar($sala);
	//$sala->deletar($sala);
	
	$sala->selecionaTudo($sala);
	$i = 1;
	while($res = $sala->retornaDados()):
		echo $i++.'/'.$res->id . '/' . $res->nome . '/'. $res->capacidade.'<br/>';
	endwhile;
	
	echo '<pre>';
	print_r($sala);
	echo '</pre>';
?>