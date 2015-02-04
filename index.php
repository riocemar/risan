<?php
	
	require_once("funcoes.php");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html class="bg-white" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<title>Painel Administrativo</title>
		
		<?php 
			//loadCSS("reset");
//			loadCSS("style");
//			loadCSS("AdminLTE");
			//loadCSS("bootstrap-min");
			//loadCSS("fontawesome-min");
			loadJS("jquery");
			//loadJS("geral");
			//loadJS("bootstrap-min");
			
		?>
		
		
	</head>
	<br/>
		<?php
			loadModulo("usuarios", "login");
		 ?>
	<body class="page-body login-page login-form-fall boxed-layout">
	
	</body>
	<br/>
	<br/>
	<br/>
	<br/>
	
	
</html>
