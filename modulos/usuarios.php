<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	switch ($tela) {
		case 'login': 
			include 'login/tela_login.php';	
		break;
		
		case 'incluir':
						
			if (isset($_POST['cadastrar'])):
				$user = new usuarios(array(
					"nome" => $_POST['nome'],
					"email" => $_POST['email'],
					"login" => $_POST['login'],
					"senha" => codificaSenha($_POST['senha']) ,
					"administrador" => $_POST['adm']=='on'?'S':'N',
				));
				
				$duplicado = FALSE;
				
				if ($user->existeRegistro('login',$_POST['login'])):
					printMsg('Já existe um usuário cadastrado para este login.', 'erro');
					$duplicado = TRUE;
				endif;
				
				if ($user->existeRegistro('email',$_POST['email'])):
					printMsg('Já existe um usuário cadastrado para este email.', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$user->inserir($user);
					if($user->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=usuarios&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".userform").validate({
							rules:{
								nome:{required:true, minlength:3},
								email:{required:true, email:true},
								login:{required:true, minlength:5},
								senha:{required:true, rangelength:[4, 10]},
								senhaconf:{required:true, equalTo:"#senha"}
							}
						});
						
					});
				</script>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Cadastro de Usuários</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="userform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome do usuário." placeholder="Nome..."
									value="<?php echo isset($_POST['nome'])? $_POST['nome']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Login</label>
								<input type="text" name="login" value="<?php echo isset($_POST['login'])? $_POST['login']:""?>" 
									class="form-control" data-validate="required" 
									placeholder="Login..." 
								/>
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Email</label>
								<input type="text" name="email" value="<?php echo isset($_POST['email'])? $_POST['email']:""?>"
									class="form-control" data-validate="email" placeholder="Email..." 
								/>
							</div>
							
							
							
							<div class="col-sm-5">
								<label class="control-label">Senha</label>
								<input type="password" id="senha" name="senha" value="<?php echo isset($_POST['senha'])? $_POST['senha']:""?>" 
								 	class="form-control" data-validate="required" 
								 />
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Repita a Senha</label>
								<input type="password" id="senha" name="senhaconf" value="<?php echo isset($_POST['senhaconf'])? $_POST['senhaconf']:""?>" 
								 	class="form-control" data-validate="required" 
								 />
							</div>
							
							<div class="col-sm-10">
								</br>
								<div class="checkbox checkbox-replace color-primary">
									<input type="checkbox" id="adm">
									<label>Administrador</label>
								</div>
							</div>
							
							<div class="col-sm-10">
								</br>
								<div class="checkbox checkbox-replace color-primary">
									<input type="checkbox" id="ativo">
									<label>Ativo</label>
								</div>
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Salvar dados"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
							</div>
						
						</form>
					
					</div>
				
				</div><!-- Footer -->
				
				<!-- Form Neon Fim-->
							
			<?php
			break;
		
		case 'listar':
						
			loadCSS('data-table');
			loadJS('jquery-datatable');
			
			?>	
			
			<script type="text/javascript">
				$(document).ready(function(){
					$("#listausers").dataTable({
						"oLanguage":{
							"sZeroRecords": "Nenhum registro encontrado",
							"sSearch": "Pesquisar",
							"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ de registros",
							"sInfoFiltered":"(Filtrado de _MAX_ registros no total)",
						},
						"sScrollY":"400px",
						"bPaginate": true,
						"aaSorting":[[0, "desc"]]
					});
				});
			</script>
			
			<div>
				<input type="button" name="Novo" onclick="location.href='?m=usuarios&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listausers">
				<thead>
					<tr>
						<th>Login</th><th>Nome</th><th>Email</th><th>Ativo/Adm</th><th>Cadastro</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$user = new usuarios();
						$user->selecionaTudo($user);
						while ($res = $user->retornaDados()):
							echo '<tr>';
							//printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->login);
							printf('<td>%s</td>', $res->nome);
							printf('<td>%s</td>', $res->email);
							printf('<td class="center">%s/%s</td>', strtoupper($res->ativo),  strtoupper($res->administrador));
							printf('<td class="center">%s</td>', date("d/m/Y",strtotime($res->datacad)));
							printf('<td class="center">
									<a href="?m=usuarios&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=usuarios&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=usuarios&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
									</td>',$res->id, $res->id, $res->id);
							echo '</tr>';
							
						endwhile;
					 ?> 
					
					</tbody>
				
			</table>
				
			
			<?php			
			break;
		
		
			case 'excluir':
			
				if (isset($_GET['id'])):
					$id = $_GET['id'];
					
					if (isset($_POST['excluir'])):
						$user = new usuarios();
						$user->valorpk = $id;
						$user->deletar($user);
						if($user->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=usuarios&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=usuarios&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$userbd = new usuarios();
					$userbd->extras_select = " WHERE id=$id";
					$userbd->selecionaTudo($userbd);
					$resbd = $userbd->retornaDados();
				else:
					printMsg('Usuário não definido, <a href="?m=usuario&t=listar"> escolha um usuário para excluir</a>', 'erro');
				endif;
			?>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Exclusão de Usuários</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="userform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" disabled="disabled" 
									data-message-required="Informe o nome do usuário." placeholder="Nome..."
									value="<?php if (isset($resbd)) echo $resbd->nome;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Email</label>
								<input type="text" name="email" disabled="disabled" value="<?php if (isset($resbd)) echo $resbd->email;?>"
									class="form-control" data-validate="email" placeholder="Email..." 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Login</label>
								<input type="text" name="login" disabled="disabled" value="<?php if (isset($resbd)) echo $resbd->login;?>" 
									class="form-control" data-validate="required" 
									placeholder="Login..." 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Administrador</label>
								<input type="checkbox" disabled="disabled" id="adm" name="adm" 
									   value="<?php if (strtolower($resbd->administrador) == 's') echo 'checked="checked"';?>" 
								 		  
								 />
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Ativo</label>
								<input type="checkbox" disabled="disabled" id="ativo" name="ativo" 
									   value="<?php if (strtolower($resbd->ativo) == 's') echo 'checked="checked"';?>" 
								 />
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
							</div>
						
						</form>
					
					</div>
				
				</div><!-- Footer -->
				
				<!-- Form Neon Fim-->
			
			<?php
			break;
				 
			
			
			case 'editar':
			
				if (isset($_GET['id'])):
					$id = $_GET['id'];
					
					if (isset($_POST['editar'])):
						$user = new usuarios(array(
							'nome'=>$_POST['nome'],
							'email'=>$_POST['email'],
							'ativo'=>$_POST['ativo'] == 'on' ? 'S':'N',
							'administrador'=>$_POST['administrador'] == 'on' ? 'S':'N',
							
						));
						$user->valorpk = $id;
						$user->extras_select = " WHERE id=$id";
						$user->selecionaTudo($user);
						$res = $user->retornaDados();
						$duplicado = FALSE;
						if($res->email != $_POST['email']):
							if($user->existeRegistro('email', $_POST['email'])):
								printMsg($res->email.'**'.$_POST['email'].'**'.'Este email já existe no sistema. Escolha outro email!', 'erro');
								$duplicado = TRUE;
							endif;
						endif;
						if(!$duplicado):
							$user->atualizar($user);
							if($user->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=usuarios&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=usuarios&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$userbd = new usuarios();
					$userbd->extras_select = " WHERE id=$id";
					$userbd->selecionaTudo($userbd);
					$resbd = $userbd->retornaDados();
				else:
					printMsg('Usuário não definido, <a href="?m=usuario&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".userform").validate({
							rules:{
								nome:{required:true, minlength:3},
								email:{required:true, email:true},
							}
						});
						
					});
				</script>
			
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Alteração de Usuários</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="userform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome do usuário." placeholder="Nome..."
									value="<?php if (isset($resbd)) echo $resbd->nome;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Email</label>
								<input type="text" name="email" value="<?php if (isset($resbd)) echo $resbd->email;?>"
									class="form-control" data-validate="email" placeholder="Email..." 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Login</label>
								<input type="text" name="login" value="<?php if (isset($resbd)) echo $resbd->login;?>" 
									class="form-control" data-validate="required" 
									placeholder="Login..." 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Administrador</label>
								<input type="checkbox" id="adm" name="adm" 
									   value="<?php if (strtolower($resbd->administrador) == 's') echo 'checked="checked"';?>" 
								 		  
								 />
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Ativo</label>
								<input type="checkbox" id="ativo" name="ativo" 
									   value="<?php if (strtolower($resbd->ativo) == 's') echo 'checked="checked"';?>" 
								 />
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="editar" class="btn btn-success" value="Salvar Alterações"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=usuarios&t=listar'" value="Cancelar"/>
							</div>
						
						</form>
					
					</div>
				
				</div><!-- Footer -->
				
				<!-- Form Neon Fim-->
			
			<?php
			break;
			
			default:
				echo '<p>A tela solicitada não existe!</p>';			
			break;
	}
?>

  












