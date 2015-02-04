<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	switch ($tela) {
		
		case 'incluir':
						
			if (isset($_POST['cadastrar'])):
				$sala = new sala(array(
					"nome" => $_POST['nome'],
					"numero" => $_POST['numero'],
					"capacidade" => $_POST['capacidade'],
					"ramal" => $_POST['ramal'],
					"localizacao" => $_POST['localizacao'],
					"observacao" => $_POST['observacao'],
				));
				
				$duplicado = FALSE;
				
				if ($sala->existeRegistro('nome',$_POST['nome'])):
					printMsg('Esta sala já existe!', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$sala->inserir($sala);
					if($sala->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=sala&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".salaform").validate({
							rules:{
								nome:{required:true, minlength:5}
							}
						});
						
					});
				</script>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Cadastro de salas</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="salaform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome da sala." placeholder="Nome..."
									value="<?php echo isset($_POST['nome'])? $_POST['nome']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nº da Sala</label>
								<input type="text" name="numero" class="form-control" data-validate="required" 
									data-message-required="Informe o nº da sala." placeholder="Nº..."
									value="<?php echo isset($_POST['numero'])? $_POST['numero']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Ramal</label>
								<input type="text" name="ramal" class="form-control" data-validate="required" 
									data-message-required="Informe o ramal da sala." placeholder="Ramal..."
									value="<?php echo isset($_POST['ramal'])? $_POST['ramal']:""?>" 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Capacidade</label>
								<input type="text" name="capacidade" class="form-control" data-validate="required" 
									data-message-required="Informe a capacidade da sala." placeholder="Capacidade..."
									value="<?php echo isset($_POST['capacidade'])? $_POST['capacidade']:""?>" 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Localização</label>
								<input type="text" name="localizacao" class="form-control" data-validate="required" 
									data-message-required="Informe a localizacao da sala." placeholder="Localizacao..."
									value="<?php echo isset($_POST['localizacao'])? $_POST['localizacao']:""?>" 
								/>
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Recursos da Sala</label>
									<select name="test" class="select2" multiple>
										
									<?php 
										$tiporecurso = new tiporecurso();
										$tiporecurso->selecionaTudo($tiporecurso);
										while ($res = $tiporecurso->retornaDados()):
											printf('<option value="%d">%s</option>',$res->id, $res->descricao);
										endwhile;
									 ?>
									</select>
								
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Salvar dados"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=sala&t=listar'" value="Cancelar"/>
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
					$("#listasala").dataTable({
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
				<input type="button" name="Novo" onclick="location.href='?m=sala&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listasala">
				<thead>
					<tr>
						<th>#</th><th>Nome</th><th>Nº</th><th>capacidade</th><th>Localizacao</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$sala = new sala();
						$sala->selecionaTudo($sala);
						while ($res = $sala->retornaDados()):
							echo '<tr>';
							printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->nome);
							printf('<td>%s</td>', $res->numero);
							printf('<td>%s</td>', $res->capacidade);
							printf('<td>%s</td>', $res->localizacao);
							printf('<td class="center">
									<a href="?m=sala&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=sala&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=sala&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
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
						$sala = new sala();
						$sala->valorpk = $id;
						$sala->deletar($sala);
						if($sala->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=sala&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=sala&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$salabd = new sala();
					$salabd->extras_select = " WHERE id=$id";
					$salabd->selecionaTudo($salabd);
					$resbd = $salabd->retornaDados();
				else:
					printMsg('Usuário não definido, <a href="?m=sala&t=listar"> escolha um usuário para excluir</a>', 'erro');
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
					
						<form class="salaform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" disabled="disabled" 
									value="<?php if (isset($resbd)) echo $resbd->nome;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">#</label>
								<input type="text" name="id" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->id;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nº da Sala</label>
								<input type="text" name="numero" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->numero;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Capacidade</label>
								<input type="text" name="capacidade" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->capacidade;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Localizacao</label>
								<input type="text" name="localizacao" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->localizacao;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=sala&t=listar'" value="Cancelar"/>
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
						$sala = new sala(array(
							'nome'=>$_POST['nome'],
							'numero'=>$_POST['numero'],
							'capacidade'=>$_POST['capacidade'],
							'ramal'=>$_POST['ramal'],
							'localizacao'=>$_POST['localizacao'],
						));
						$sala->valorpk = $id;
						$sala->extras_select = " WHERE id=$id";
						$sala->selecionaTudo($sala);
						$res = $sala->retornaDados();
						$duplicado = FALSE;
						
						if(!$duplicado):
							$sala->atualizar($sala);
							if($sala->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=sala&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=sala&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$salabd = new sala();
					$salabd->extras_select = " WHERE id=$id";
					$salabd->selecionaTudo($salabd);
					$resbd = $salabd->retornaDados();
				else:
					printMsg('Tipo de Recurso não definido, <a href="?m=sala&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".salaform").validate({
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
					
						<form class="salaform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="nome" class="form-control" data-validate="required" 
									data-message-required="Informe o nome."
									value="<?php if (isset($resbd)) echo $resbd->nome;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Nº da Sala</label>
								<input type="text" name="numero" class="form-control" data-validate="required" 
									data-message-required="Informe o número da sala."
									value="<?php if (isset($resbd)) echo $resbd->numero;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Capacidade</label>
								<input type="text" name="capacidade" class="form-control" data-validate="required" 
									data-message-required="Informe o nome."
									value="<?php if (isset($resbd)) echo $resbd->capacidade;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Ramal</label>
								<input type="text" name="ramal" class="form-control" data-validate="required" 
									data-message-required="Informe o ramal."
									value="<?php if (isset($resbd)) echo $resbd->ramal;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Localizacao</label>
								<input type="text" name="localizacao" class="form-control" data-validate="required" 
									data-message-required="Informe a localizacao."
									value="<?php if (isset($resbd)) echo $resbd->localizacao;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="editar" class="btn btn-success" value="Salvar Alterações"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=sala&t=listar'" value="Cancelar"/>
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

  












