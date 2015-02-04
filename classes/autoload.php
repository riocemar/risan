<?php
	$pathlocal = dirname(__FILE__);
	require_once(dirname($pathlocal)."/funcoes.php");
	
	//echo "dirname(__FILE__): ".dirname(__FILE__)." \n";
	//echo "dirname($pathlocal)".dirname($pathlocal)."/funcoes.php \n";
	
	function __autoload($classe){
		$classe = str_replace('..', '', $classe);
		require_once(dirname(__FILE__)."\\"."$classe.class.php");
//		require_once("$pathlocal"."$classe.class.php");
	}
?>