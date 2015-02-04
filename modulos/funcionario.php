<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	//include dirname(dirname(__FILE__))."\\"."classes\\"."cargo.class.php";
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	
	switch ($tela) {
		
		case 'incluir':
						
			if (isset($_POST['cadastrar'])):
				$funcionario = new funcionario(array(
					"nome" => $_POST['nome'],
					"email" => $_POST['email'],
					"telefone" => $_POST['telefone'],
					"celular" => $_POST['celular'],
					"id_usuarios" => $_POST['id_usuarios'],
					"id_departamento" => $_POST['id_departamento'],
					"id_cargo" => $_POST['id_cargo'],
				));
				
				$duplicado = FALSE;
				
				if ($funcionario->existeRegistro('nome',$_POST['nome'])):
					printMsg('Este funcionario já existe!', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$funcionario->inserir($funcionario);
					if($funcionario->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=funcionario&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".funcionarioform").validate({
							rules:{
								nome:{required:true, minlength:5}
							}
						});
						
					});
				</script>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Cadastro de Pessoas</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="funcionarioform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome do funcionario." placeholder="Nome..."
									value="<?php echo isset($_POST['nome'])? $_POST['nome']:""?>" 
								/>
								<br/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Email</label>
								<input type="text" name="email" class="form-control" data-validate="email" 
									data-message-required="Informe o email do usuário." placeholder="funcionario@empresa.com..."
									value="<?php echo isset($_POST['email'])? $_POST['email']:""?>" 
								/>
								<br/>
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Ramal</label>
								<input type="text" name="telefone" class="form-control" data-validate="required" 
									data-message-required="Informe o ramal do funcionario." placeholder="Ramal..."
									value="<?php echo isset($_POST['telefone'])? $_POST['telefone']:""?>" 
								/>
								<br/>
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Celular</label>
								<input type="text" name="celular" class="form-control"  placeholder="Celular..."
									value="<?php echo isset($_POST['celular'])? $_POST['celular']:""?>" 
								/>
								<br/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Cargo</label>
								<select name="id_cargo" id="id_cargo" class="select2" data-allow-clear="true" 
								value="<?php echo isset($_POST['id_cargo'])? $_POST['id_cargo']:""?>" 
								data-placeholder="Selecione um cargo...">
									<option></option>
									<optgroup label="Lista de Cargos">
										
									<?php 
										$cargo = new cargo();
										$cargo->selecionaTudo($cargo);
										while ($res = $cargo->retornaDados()):
											printf('<option value="%d">%s</option>',$res->id, $res->nome);
										endwhile;
									 ?>
										
									</optgroup>
								</select>
								<br/>
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Login</label>
								<select name="id_usuarios" class="select2" data-allow-clear="true" 
								value="<?php echo isset($_POST['id_usuarios'])? $_POST['id_usuarios']:""?>"
								data-placeholder="Selecione um usuário...">
									<option></option>
									<optgroup label="Lista de logins">
										<?php 
											$usuarios = new usuarios();
											$usuarios->selecionaTudo($usuarios);
											while ($res = $usuarios->retornaDados()):
												printf('<option value="%d">%s</option>',$res->id, $res->login);
											endwhile;
										 ?>
									</optgroup>
								</select>
								
							</div>
							
							<div class="col-sm-5">
								
								<label class="control-label">Departamento</label>
								<select name="id_departamento" class="select2" data-allow-clear="true" 
								value="<?php echo isset($_POST['id_departamento'])? $_POST['id_departamento']:""?>"
								data-placeholder="Selecione um departamento...">
									<option></option>
									<optgroup label="Lista de Departamentos">
										<?php 
											$departamento = new departamento();
											$departamento->selecionaTudo($departamento);
											while ($res = $departamento->retornaDados()):
												printf('<option value="%d">%s</option>',$res->id, $res->sigla);
											endwhile;
										 ?>
									</optgroup>
								</select>
								
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Salvar dados"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=funcionario&t=listar'" value="Cancelar"/>
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
					$("#listafuncionario").dataTable({
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
				<input type="button" name="Novo" onclick="location.href='?m=funcionario&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listafuncionario">
				<thead>
					<tr>
						<th>#</th><th>Nome</th><th>Email</th><th>Ramal</th><th>Celular</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$funcionario = new funcionario();
						$funcionario->selecionaTudo($funcionario);
						while ($res = $funcionario->retornaDados()):
							echo '<tr>';
							printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->nome);
							printf('<td>%s</td>', $res->email);
							printf('<td>%s</td>', $res->telefone);
							printf('<td>%s</td>', $res->celular);
							printf('<td class="center">
									<a href="?m=funcionario&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=funcionario&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=funcionario&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
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
						$funcionario = new funcionario();
						$funcionario->valorpk = $id;
						$funcionario->deletar($funcionario);
						if($funcionario->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=funcionario&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=funcionario&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$funcionariobd = new funcionario();
					$funcionariobd->extras_select = " WHERE id=$id";
					$funcionariobd->selecionaTudo($funcionariobd);
					$resbd = $funcionariobd->retornaDados();
				else:
					printMsg('Usuário não definido, <a href="?m=funcionario&t=listar"> escolha um usuário para excluir</a>', 'erro');
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
					
						<form class="funcionarioform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Sigla</label>
								<input type="text" name="sigla" class="form-control" disabled="disabled" 
									value="<?php if (isset($resbd)) echo $resbd->sigla;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="descricao" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->nome;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=funcionario&t=listar'" value="Cancelar"/>
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
						$funcionario = new funcionario(array(
							'sigla'=>$_POST['sigla'],
							'nome'=>$_POST['nome'],
						));
						$funcionario->valorpk = $id;
						$funcionario->extras_select = " WHERE id=$id";
						$funcionario->selecionaTudo($funcionario);
						$res = $funcionario->retornaDados();
						$duplicado = FALSE;
						
						if(!$duplicado):
							$funcionario->atualizar($funcionario);
							if($funcionario->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=funcionario&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=funcionario&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$funcionariobd = new funcionario();
					$funcionariobd->extras_select = " WHERE id=$id";
					$funcionariobd->selecionaTudo($funcionariobd);
					$resbd = $funcionariobd->retornaDados();
				else:
					printMsg('Tipo de Recurso não definido, <a href="?m=funcionario&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".funcionarioform").validate({
							rules:{
								descricao:{required:true, minlength:3},
							}
						});
						
					});
				</script>
			
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Alteração de Tipo de Recurso</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="funcionarioform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Sigla</label>
								<input type="text" name="sigla" class="form-control" data-validate="required" 
									data-message-required="Informe o nome." placeholder="Nome..."
									value="<?php if (isset($resbd)) echo $resbd->sigla;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome." placeholder="Nome..."
									value="<?php if (isset($resbd)) echo $resbd->nome;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="editar" class="btn btn-success" value="Salvar Alterações"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=funcionario&t=listar'" value="Cancelar"/>
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

  












