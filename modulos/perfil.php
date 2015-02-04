<?php
	
	require_once(dirname(dirname(__FILE__))."/funcoes.php");
	protegeArquivo(basename(__FILE__));
	loadJS('jquery-validate');
	loadJS('jquery-validate-messages');
	switch ($tela) {
		
		case 'incluir':
						
			if (isset($_POST['cadastrar'])):
				$perfil = new perfil(array(
					"descricao" => $_POST['descricao'],
				));
				
				$duplicado = FALSE;
				
				if ($perfil->existeRegistro('descricao',$_POST['descricao'])):
					printMsg('Este perfil já existe!', 'erro');
					$duplicado = TRUE;
				endif;
				
				if (!$duplicado):
					$perfil->inserir($perfil);
					if($perfil->linhasafetadas==1):
						printMsg('Dados inseridos com sucesso. <a href="'.ADMURL.'?m=perfil&t=listar"> Exibir Cadastro</a>');
						unset($_POST);
					endif;
				endif;
				
			endif; 
			
			?>
				<script type="text/javascript">
					$(document).ready(function(){
						$(".perfilform").validate({
							rules:{
								descricao:{required:true, minlength:5}
							}
						});
						
					});
				</script>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Cadastro de Perfil</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="perfilform" method="post" action="" class="validate">
														
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="descricao" class="form-control" data-validate="required" 
									data-message-required="Informe o nome do perfil." placeholder="Nome..."
									value="<?php echo isset($_POST['descricao'])? $_POST['descricao']:""?>" 
								/>
							
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="cadastrar" class="btn btn-success" value="Salvar dados"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=perfil&t=listar'" value="Cancelar"/>
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
					$("#listaperfil").dataTable({
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
				<input type="button" name="Novo" onclick="location.href='?m=perfil&t=incluir'" class="btn btn-success" value="Novo"/>
				<br/>
			</div>							
			<table cellspacing="0" cellpadding="0" border="0" class="display" id="listaperfil">
				<thead>
					<tr>
						<th>#</th><th>Nome</th><th>Ações</th>
					</tr>
				</thead>
				<tbody>
					
					<?php 
						$perfil = new perfil();
						$perfil->selecionaTudo($perfil);
						while ($res = $perfil->retornaDados()):
							echo '<tr>';
							printf('<td class="center">%s</td>', $res->id);
							printf('<td>%s</td>', $res->descricao);
							printf('<td class="center">
									<a href="?m=perfil&t=editar&id=%s" title="Editar"><img src="images/edit.png" alt="Editar"/></a>
									<a href="?m=perfil&t=excluir&id=%s" title="Deletar"><img src="images/delete.png" alt="Deletar"/></a>
									<a href="?m=perfil&t=senha&id=%s" title="Mudar Senha"><img src="images/pass.png" alt="Mudar Senha"/></a>
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
						$perfil = new perfil();
						$perfil->valorpk = $id;
						$perfil->deletar($perfil);
						if($perfil->linhasafetadas == 1):
							printMsg('Registro excluído com sucesso! <a href=?m=perfil&t=listar>Exibir cadastro</a>');
							unset($_POST);
						else:
							printMsg('Nenhum dado foi excluído! <a href=?m=perfil&t=listar>Exibir cadastro</a>', 'alerta');
						endif;
						
					endif;
					
					$perfilbd = new perfil();
					$perfilbd->extras_select = " WHERE id=$id";
					$perfilbd->selecionaTudo($perfilbd);
					$resbd = $perfilbd->retornaDados();
				else:
					printMsg('perfil não definido, <a href="?m=perfil&t=listar"> escolha um perfil para excluir</a>', 'erro');
				endif;
			?>
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Exclusão de Perfil</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="perfilform" method="post" action="" class="validate">
							
							<div class="col-sm-10">
								<label class="control-label">Nome</label>
								<input type="text" name="descricao" class="form-control" disabled="disabled" 
									value="<?php if (isset($resbd)) echo $resbd->descricao;?>" 
								/>
							</div>
							
							<div class="col-sm-10">
								<br/>
								<input type="submit" name="excluir" class="btn btn-success" value="Confirmar Exclusão"/>
								<input type="button" class="btn btn-app" onclick="location.href='?m=perfil&t=listar'" value="Cancelar"/>
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
						$perfil = new perfil(array(
							'descricao'=>$_POST['descricao'],
						));
						$perfil->valorpk = $id;
						$perfil->extras_select = " WHERE id=$id";
						$perfil->selecionaTudo($perfil);
						$res = $perfil->retornaDados();
						$duplicado = FALSE;
						
						if(!$duplicado):
							$perfil->atualizar($perfil);
							if($perfil->linhasafetadas == 1):
								printMsg('Dados alterados com sucesso! <a href=?m=perfil&t=listar>Exibir cadastro</a>');
								unset($_POST);
							else:
								printMsg('Nenhum dado foi alterado! <a href=?m=perfil&t=listar>Exibir cadastro</a>', 'alerta');
							endif;
						endif;
							
					endif;
					
					$perfilbd = new perfil();
					$perfilbd->extras_select = " WHERE id=$id";
					$perfilbd->selecionaTudo($perfilbd);
					$resbd = $perfilbd->retornaDados();
				else:
					printMsg('Perfil não definido, <a href="?m=perfil&t=listar"> escolha um usuário para alterar</a>', 'erro');
				endif;
			?>
			
			<script type="text/javascript">
					$(document).ready(function(){
						$(".perfilform").validate({
							rules:{
								descricao:{required:true, minlength:3},
							}
						});
						
					});
				</script>
			
				<!-- Form Neon Início-->
				
				<div class="panel panel-primary">

					<div class="panel-heading">
						<div class="panel-title">Alteração de perfil</div>
						
						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
					
					<div class="panel-body">
					
						<form class="perfilform" method="post" action="" class="validate">
							
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
								<input type="button" class="btn btn-app" onclick="location.href='?m=perfil&t=listar'" value="Cancelar"/>
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

  












