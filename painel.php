
	<?php 
	 
	  include('_header.php');
	  if (isset($_GET['m'])) $modulo =$_GET['m'];
	  if (isset($_GET['t'])) $tela =$_GET['t'];
	  
	?>
	<?php include('_sidebar.php');?>

		<div class="main-content">
			<?php 
			if (isset($modulo) && isset($tela)):
				loadModulo($modulo, $tela);
			else:
				echo '<p>Escolha uma opção de menu para iniciar</p>';
			?>	
				
				<div class="row">
				<div class="col-sm-3">
				
					<div class="tile-stats tile-red">
						<div class="icon"><i class="entypo-users"></i></div>
						<div class="num" data-start="0" data-end="10" 
							 data-postfix="" data-duration="1500" data-delay="0">0</div>
						
						<h3>Salas Disponíveis para reunião</h3>
						<a href="#"> <p>clique aqui para visualizar</p> </a>
					</div>
					
				</div>
				
				<div class="col-sm-3">
				
					<div class="tile-stats tile-green">
						<div class="icon"><i class="entypo-chart-bar"></i></div>
						<div class="num" data-start="0" data-end="15" data-postfix="" data-duration="1500" data-delay="600">0</div>
						
						<h3>Tasks Pendentes</h3>
						<a href="#"> <p>clique aqui para visualizar</p> </a>
					</div>
					
				</div>
				
				<div class="col-sm-3">
				
					<div class="tile-stats tile-aqua">
						<div class="icon"><i class="entypo-mail"></i></div>
						<div class="num" data-start="0" data-end="25" data-postfix="" data-duration="1500" data-delay="1200">0</div>
						
						<h3>Reuniões realizadas</h3>
						<a href="#"> <p>clique aqui para visualizar</p> </a>
					</div>
					
				</div>
				
				<div class="col-sm-3">
				
					<div class="tile-stats tile-blue">
						<div class="icon"><i class="entypo-rss"></i></div>
						<div class="num" data-start="0" data-end="52" data-postfix="" data-duration="1500" data-delay="1800">0</div>
						
						<h3>Mensagens no Fórum</h3>
						<a href="#"> <p>clique aqui para visualizar</p> </a>
					</div>
					
				</div>
			</div>
				
			<?php	
			endif;
			
			?>
			<br />
	
			<!-- lets do some work here... --><!-- Footer -->
			<footer class="main">
				
					
				&copy; 2014 <strong>EasySolutions</strong> <a href="http://laborator.co" target="_blank">EasyMeeting</a>
				
			</footer>	
		</div>

<?php include('_footer.php');?>