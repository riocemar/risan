<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	switch ($tela) {
		
		case 'incluir':
						
			if (isset($_POST['cadastrar'])):
				$cargo = new cargo(array(
					"sigla" => $_POST['sigla'],
					"nome" => $_POST['nome'],
					"nivel" => $_POST['nivel'],
					
				));
				
				$duplicado = FALSE;
				
				if ($cargo->existeRegistro('sigla',$_POST['sigla'])):
					printMsg('Este cargo já existe!', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$cargo->inserir($cargo);
					if($cargo->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=cargo&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".cargoform").validate({
							rules:{
								nome:{required:true, minlength:5}
							}
						});
						
					});
				</script>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Cadastro de Cargos</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="cargoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Sigla</label>
								<input type="text" name="sigla" class="form-control" data-validate="required" 
									data-message-required="Informe a sigla do cargo." placeholder="Sigla..."
									value="<?php echo isset($_POST['sigla'])? $_POST['sigla']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome do usuário." placeholder="Nome..."
									value="<?php echo isset($_POST['nome'])? $_POST['nome']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nível</label>
								<select name="nivel" id="nivel" class="select2" data-allow-clear="true" 
								value="<?php echo isset($_POST['nivel'])? $_POST['nivel']:""?>" 
								data-placeholder="Nível do Cargo">
									<option></option>
										<option value="Fundamental">Fundamental</option>
										<option value="Medio">Médio</option>
										<option value="Superior">Superior</option>
								</select>
								<br/>
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Salvar dados"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=cargo&t=listar'" value="Cancelar"/>
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
					$("#listacargo").dataTable({
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
				<input type="button" name="Novo" onclick="location.href='?m=cargo&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listacargo">
				<thead>
					<tr>
						<th>#</th><th>Sigla</th><th>Nome</th><th>Nivel</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$cargo = new cargo();
						$cargo->selecionaTudo($cargo);
						while ($res = $cargo->retornaDados()):
							echo '<tr>';
							printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->sigla);
							printf('<td>%s</td>', $res->nome);
							printf('<td>%s</td>', $res->nivel);
							printf('<td class="center">
									<a href="?m=cargo&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=cargo&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=cargo&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
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
						$cargo = new cargo();
						$cargo->valorpk = $id;
						$cargo->deletar($cargo);
						if($cargo->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=cargo&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=cargo&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$cargobd = new cargo();
					$cargobd->extras_select = " WHERE id=$id";
					$cargobd->selecionaTudo($cargobd);
					$resbd = $cargobd->retornaDados();
				else:
					printMsg('Cargo não definido, <a href="?m=cargo&t=listar"> escolha um cargo para excluir</a>', 'erro');
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
					
						<form class="cargoform" method="post" action="" class="validate">
							
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
								<label class="control-label">Nível</label>
								<input type="text" name="nivel" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->nivel;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=cargo&t=listar'" value="Cancelar"/>
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
						$cargo = new cargo(array(
							'sigla'=>$_POST['sigla'],
							'nome'=>$_POST['nome'],
							'nivel'=>$_POST['nivel'],
						));
						$cargo->valorpk = $id;
						$cargo->extras_select = " WHERE id=$id";
						$cargo->selecionaTudo($cargo);
						$res = $cargo->retornaDados();
						$duplicado = FALSE;
						
						if(!$duplicado):
							$cargo->atualizar($cargo);
							if($cargo->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=cargo&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=cargo&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$cargobd = new cargo();
					$cargobd->extras_select = " WHERE id=$id";
					$cargobd->selecionaTudo($cargobd);
					$resbd = $cargobd->retornaDados();
				else:
					printMsg('Tipo de Recurso não definido, <a href="?m=cargo&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".cargoform").validate({
							rules:{
								nome:{required:true, minlength:3},
							}
						});
						
					});
				</script>
			
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Alteração de Cargo</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="cargoform" method="post" action="" class="validate">
							
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
								<label class="control-label">Nível</label>
								<select name="nivel" id="nivel" class="select2" data-allow-clear="true" 
								value="<?php if (isset($resbd)) echo $resbd->nivel;?>" 
								data-placeholder="Nível do Cargo">
									<option></option>
										<option value="Fundamental">Fundamental</option>
										<option value="Medio">Médio</option>
										<option value="Superior">Superior</option>
								</select>
								<br/>
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="editar" class="btn btn-success" value="Salvar Alterações"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=cargo&t=listar'" value="Cancelar"/>
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

  












