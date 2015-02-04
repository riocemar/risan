
<?php 
	 
	  include('header.php');
	  if (isset($_GET['m'])) $modulo =$_GET['m'];
	  if (isset($_GET['t'])) $tela =$_GET['t'];
	  
?>

<div class="bg-navy" id="content">
	<?php 
		if (isset($modulo) && isset($tela)):
			loadModulo($modulo, $tela);
		else:
			echo '<p>Escolha uma opção de menu para iniciar</p>';
		endif;
		
	?>
</div>

<?php include('sidebar.php');?>

<?php include('footer.php');?>