<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	switch ($tela) {
		
		case 'incluir':
						
			if (isset($_POST['cadastrar'])):
				$tiporecurso = new tiporecurso(array(
					"descricao" => $_POST['descricao'],
				));
				
				$duplicado = FALSE;
				
				if ($tiporecurso->existeRegistro('descricao',$_POST['descricao'])):
					printMsg('Este recurso já existe!', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$tiporecurso->inserir($tiporecurso);
					if($tiporecurso->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=tiporecurso&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".tiporecursoform").validate({
							rules:{
								descricao:{required:true, minlength:2}
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
					
						<form class="tiporecursoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="descricao" class="form-control" data-validate="required" 
									data-message-required="Informe o nome do usuário." placeholder="Nome..."
									value="<?php echo isset($_POST['descricao'])? $_POST['descricao']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Salvar dados"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=tiporecurso&t=listar'" value="Cancelar"/>
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
					$("#listatiporecurso").dataTable({
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
				<input type="button" name="Novo" onclick="location.href='?m=tiporecurso&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listatiporecurso">
				<thead>
					<tr>
						<th>#</th><th>Nome</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$tiporecurso = new tiporecurso();
						$tiporecurso->selecionaTudo($tiporecurso);
						while ($res = $tiporecurso->retornaDados()):
							echo '<tr>';
							printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->descricao);
							printf('<td class="center">
									<a href="?m=tiporecurso&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=tiporecurso&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=tiporecurso&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
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
						$tiporecurso = new tiporecurso();
						$tiporecurso->valorpk = $id;
						$tiporecurso->deletar($tiporecurso);
						if($tiporecurso->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=tiporecurso&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=tiporecurso&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$tiporecursobd = new tiporecurso();
					$tiporecursobd->extras_select = " WHERE id=$id";
					$tiporecursobd->selecionaTudo($tiporecursobd);
					$resbd = $tiporecursobd->retornaDados();
				else:
					printMsg('Usuário não definido, <a href="?m=tiporecurso&t=listar"> escolha um usuário para excluir</a>', 'erro');
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
					
						<form class="tiporecursoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="descricao" class="form-control" disabled="disabled" 
									data-message-required="Informe o nome do usuário." placeholder="Nome..."
									value="<?php if (isset($resbd)) echo $resbd->descricao;?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=tiporecurso&t=listar'" value="Cancelar"/>
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
						$tiporecurso = new tiporecurso(array(
							'descricao'=>$_POST['descricao'],
						));
						$tiporecurso->valorpk = $id;
						$tiporecurso->extras_select = " WHERE id=$id";
						$tiporecurso->selecionaTudo($tiporecurso);
						$res = $tiporecurso->retornaDados();
						$duplicado = FALSE;
						
						if(!$duplicado):
							$tiporecurso->atualizar($tiporecurso);
							if($tiporecurso->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=tiporecurso&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=tiporecurso&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$tiporecursobd = new tiporecurso();
					$tiporecursobd->extras_select = " WHERE id=$id";
					$tiporecursobd->selecionaTudo($tiporecursobd);
					$resbd = $tiporecursobd->retornaDados();
				else:
					printMsg('Tipo de Recurso não definido, <a href="?m=tiporecurso&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".tiporecursoform").validate({
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
					
						<form class="tiporecursoform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="descricao" class="form-control" data-validate="required" 
									data-message-required="Informe o nome." placeholder="Nome..."
									value="<?php if (isset($resbd)) echo $resbd->descricao;?>" 
								/>
							
							</div>

							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="editar" class="btn btn-success" value="Salvar Alterações"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=tiporecurso&t=listar'" value="Cancelar"/>
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

  












