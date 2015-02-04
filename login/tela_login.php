	<?php protegeArquivo(basename(__FILE__)); 
		
			$sessao = new sessao();
			if ($sessao->getNvars() > 0 || $sessao->getVar('logado')== TRUE || $sessao->getVar('ip')== $_SERVER['REMOTE_ADDR'])
				redireciona('painel.php');
			if (isset($_POST['logar'])):
				$user = new usuarios();
				$user->setValor('login', $_POST['usuario']);
				$user->setValor('senha', $_POST['senha']);
				if ($user->doLogin($user)):
					redireciona('painel.php');
				else:
					redireciona('?erro=2');
				endif;	
			endif;
			 
		
		?>
		
	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.0.min.js"></script>
	
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-login.js"></script>
	<script src="assets/js/neon-custom.js"></script>
	<script src="assets/js/neon-demo.js"></script>

		<script type="text/javascript">
			$(document).ready(function(){
				$(".userform").validate({
					rules:{
						usuario:{required:true, minlength:3},
						senha:{required:true, rangelength:[4, 10]}
					}
				});
				
			});
		</script>
		
<script type="text/javascript">
var baseurl = '';
</script>


<div class="login-container">
	
	<div class="login-header login-caret">
		
		<div class="login-content">
			
			<!--a href="index.html" class="logo">
				<img src="assets/images/logo@2x.png" width="120" alt="" />
			</a-->
			
			<img class="radius5" width="220" height="50" src="images/logo.png"/>
			<p class="description">
					Porque nunca foi tão <i>fácil</i> fazer reunião!</p>
		</div>
		
	</div>
	
	
	<div class="login-form">
		
		<div class="login-content">
			
			<div class="form-login-error">
				<h3>Invalid login</h3>
				<p>Enter <strong>demo</strong>/<strong>demo</strong> as login and password.</p>
			</div>
			
			<form class="userform" role="form" method="post" action="">
				
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-user"></i>
						</div>
						
						<input type="text" class="form-control" name="usuario" 
						id="username" placeholder="Username" autocomplete="off" 
						value="<?php echo isset($_POST['usuario'])?$_POST['usuario']:"";?>"/>
					</div>
					
				</div>
				
				<div class="form-group">
					
					<div class="input-group">
						<div class="input-group-addon">
							<i class="entypo-key"></i>
						</div>
						
						<input type="password" class="form-control" name="senha" 
						id="password" placeholder="Password" autocomplete="off" 
						value="<?php echo isset($_POST['senha'])?$_POST['senha']:"";?>"/>
					</div>
				
				</div>
				
				 <div class="form-group" align="center">                                                               
                    <button type="submit" class="btn btn-primary btn-block btn-login" name="logar">
						<i class="entypo-login"></i>
						Login In
					</button>
                </div>
				
				<?php
						$erro = 0;	
						if (isset($_GET['erro'])):
							$erro = $_GET['erro'];
						endif;
						
						switch ($erro) {
							case 1:
								echo '<div class="sucesso">Você fez logoff do sistema.</div>';
								break;
							
							case 2:
								echo '<div class="erro">Dados incorretos ou usuário inativo.</div>';
								break;
							
							case 3:
								echo '<div class="erro">Faça login antes de acessar a página solicitada.</div>';
								break;
						}
				?>
							
			</form>
		</div>
		
	</div>
	
</div>