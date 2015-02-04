<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	switch ($tela) {
		
		case 'incluir':
			
			if (isset($_POST['cadastrar'])):
				
				$inicio = $_POST['start'];
				$inicio = DateTime::createFromFormat('d/m/Y H:i', $inicio);
				$inicio = $inicio->format('Y-m-d H:i');
				
				$termino = $_POST['end'];
				$termino = DateTime::createFromFormat('d/m/Y H:i', $termino);
				$termino = $termino->format('Y-m-d H:i');

				$reuniao = new reuniao(array(
					"title" => $_POST['title'],
					"start" => $inicio,
					"end" => $termino,
					"url" => '',
					"allDay" => 'false',
				));
				
				$pessoas = $_POST['pessoas'];
											
				$duplicado = FALSE;
				
				if ($reuniao->existeRegistro('title',$_POST['title'])):
					printMsg('Este reuniao já existe!', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$reuniao->inserir($reuniao);
					if($reuniao->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=reuniao&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".reuniaoform").validate({
							rules:{
								title:{required:true, minlength:5}
							}
						});
						
					});
				</script>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Agendamento de Reunião</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="reuniaoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Para</label>
									<select name="pessoas[]" class="select2" multiple>
									<?php 
										$usuarios = new usuarios();
										$usuarios->selecionaTudo($usuarios);
										while ($res = $usuarios->retornaDados()):
											printf('<option value="%d">%s</option>',$res->id, $res->nome.' ('.$res->email.')');
										endwhile;
									 ?>
									</select>
								
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Título: <b>O que</b></label>
								<input type="text" name="title" class="form-control" data-validate="required" 
									data-message-required="Informe a sigla do reuniao." placeholder="Título..."
									value="<?php echo isset($_POST['title'])? $_POST['title']:""?>" 
								/>
							
							</div>
							<div class="col-sm-10">
								<label class="control-label">Objetivo: <b>Para que</b></label>
								<input type="text" name="title" class="form-control" data-validate="required" 
									data-message-required="Informe a sigla do reuniao." placeholder="Objetivo..."
									value="<?php echo isset($_POST['title'])? $_POST['title']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Início</label>
								<input type="text" name="start" class="form-control" data-mask="datetime" 
								value="<?php echo isset($_POST['start'])? $_POST['start']:""?>" />
							</div>
							
							<div class="col-sm-5">
								<label class="control-label">Término</label>
								<input type="text" name="end" class="form-control" data-mask="datetime" 
								value="<?php echo isset($_POST['end'])? $_POST['end']:""?>" />
							</div>
							
							
							
							<div class="col-sm-10">
								<label class="control-label">Sala</label>
									<select name="test2" class="select2">
									<?php 
										$sala = new sala();
										$sala->selecionaTudo($sala);
										while ($res = $sala->retornaDados()):
											printf('<option value="%d">%s</option>',$res->id, $res->nome);
										endwhile;
									 ?>
									</select>
								
							</div>
							
							<?php printf("\n"); ?>
							<div class="col-sm-5">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<label class="control-label">Anexos</label>
									<span class="btn btn-info btn-file">
										<span class="fileinput-new">Anexar Arquivo</span>
										<span class="fileinput-exists">Anexar novamente</span>
										<input type="file" name="...">
									</span>
									<span class="fileinput-filename"></span>
									<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
								</div>
							</div>
														
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Enviar Convite"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=reuniao&t=listar'" value="Cancelar"/>
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
					$("#listareuniao").dataTable({
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
				<input type="button" name="Novo" onclick="location.href='?m=reuniao&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listareuniao">
				<thead>
					<tr>
						<th>#</th><th>Título</th><th>Início</th><th>Fim</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$reuniao = new reuniao();
						$reuniao->selecionaTudo($reuniao);
						while ($res = $reuniao->retornaDados()):
							echo '<tr>';
							printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->title);
							printf('<td>%s</td>', $res->start);
							printf('<td>%s</td>', $res->end);
							printf('<td class="center">
									<a href="?m=reuniao&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=reuniao&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=reuniao&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
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
						$reuniao = new reuniao();
						$reuniao->valorpk = $id;
						$reuniao->deletar($reuniao);
						if($reuniao->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=reuniao&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=reuniao&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$reuniaobd = new reuniao();
					$reuniaobd->extras_select = " WHERE id=$id";
					$reuniaobd->selecionaTudo($reuniaobd);
					$resbd = $reuniaobd->retornaDados();
				else:
					printMsg('reuniao não definido, <a href="?m=reuniao&t=listar"> escolha um reuniao para excluir</a>', 'erro');
				endif;
			?>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Exclusão de Reuniões</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="reuniaoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Título</label>
								<input type="text" name="title" class="form-control" disabled="disabled" 
									value="<?php if (isset($resbd)) echo $resbd->title;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Data-Hora Inicial</label>
								<input type="text" name="start" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->start;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Data-Hora Final</label>
								<input type="text" name="end" class="form-control" disabled="disabled" 
									   value="<?php if (isset($resbd)) echo $resbd->end;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=reuniao&t=listar'" value="Cancelar"/>
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
						$reuniao = new reuniao(array(
							'title'=>$_POST['title'],
							'start'=>$_POST['start'],
							'end'=>$_POST['end'],
						));
						$reuniao->valorpk = $id;
						$reuniao->extras_select = " WHERE id=$id";
						$reuniao->selecionaTudo($reuniao);
						$res = $reuniao->retornaDados();
						$duplicado = FALSE;
						
						if(!$duplicado):
							$reuniao->atualizar($reuniao);
							if($reuniao->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=reuniao&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=reuniao&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$reuniaobd = new reuniao();
					$reuniaobd->extras_select = " WHERE id=$id";
					$reuniaobd->selecionaTudo($reuniaobd);
					$resbd = $reuniaobd->retornaDados();
				else:
					printMsg('Reunião não definida, <a href="?m=reuniao&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".reuniaoform").validate({
							rules:{
								nome:{required:true, minlength:3},
							}
						});
						
					});
				</script>
			
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Alteração de reuniao</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="reuniaoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Título</label>
								<input type="text" name="title" class="form-control" data-validate="required" 
									data-message-required="Informe o título." placeholder="Título..."
									value="<?php if (isset($resbd)) echo $resbd->title;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Data-Hora Inicial</label>
								<input type="text" name="start" class="form-control" data-validate="required" 
									data-message-required="Informe a data e a hora de início." placeholder="Data-Hora início..."
									value="<?php if (isset($resbd)) echo $resbd->start;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<label class="control-label">Data-Hora Final</label>
								<input type="text" name="end" class="form-control" data-validate="required" 
									data-message-required="Informe a data e a hora final." placeholder="Data-Hora final..."
									value="<?php if (isset($resbd)) echo $resbd->end;?>" 
								/>
							
							</div>
							
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="editar" class="btn btn-success" value="Salvar Alterações"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=reuniao&t=listar'" value="Cancelar"/>
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

<script src="assets/js/jquery.inputmask.bundle.min.js"></script>
  












