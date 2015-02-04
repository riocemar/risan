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
		
		<div class="form-box" id="login-box">
            <div class="header bg-navy"><i>E a s y M e e t i n g</i></div>
            <form class="userform" method="post" action="">
                <div class="body bg-gray">
                    <div class="form-group">
                    	<input type="text" size="35" name="usuario" class="form-control" placeholder="User ID" 
							value="<?php echo isset($_POST['usuario'])?$_POST['usuario']:"";?>"/>
                    </div>
                    <div class="form-group">
                        <input type="password" size="35" name="senha" class="form-control" placeholder="Password"
							value="<?php echo isset($_POST['senha'])?$_POST['senha']:"";?>"/>
                    </div>          
                    
                </div>
                <div class="footer bg-navy" align="center">                                                               
                    <input class="btn bg-black  btn-flickr" type="submit" name="logar" value="Login"/>
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