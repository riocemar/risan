<?php
	require_once("funcoes.php");
	protegeArquivo(basename(__FILE__));
	
?>

<div class="sidebar-menu">
			
		<header class="logo-env">
			
			<!-- logo -->
			<div class="logo">
					<img class="radius5" width="250" height="50" src="images/logo_side_bar.png"/>
				
			</div>
			
			<!-- logo collapse icon -->
			<div class="sidebar-collapse">
				<a href="#" class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
									
			
			<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
			<div class="sidebar-mobile-menu visible-xs">
				<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
					<i class="entypo-menu"></i>
				</a>
			</div>
			
		</header>
				
				
		<ul id="main-menu" class="">
			<!-- add class "multiple-expanded" to allow multiple submenus to open -->
			<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
			<!-- Search Bar -->
			<li id="search">
				<form method="get" action="">
					<input type="text" name="q" class="search-input" placeholder="Search something..."/>
					<button type="submit">
						<i class="entypo-search"></i>
					</button>
				</form>
			</li>
			<li>
				<a href="">
					<i class="entypo-layout"></i>
					<span>Cadastro</span>
				</a>
				<ul>
					<li>
						<a href="?m=usuarios&t=listar">
							<span class="entypo-user"> Usuários</span>
						</a>
					</li>
					<li>
						<a href="?m=perfil&t=listar">
							<span class="entypo-key"> Perfil</span>
						</a>
					</li>
					<li>
						<a href="?m=cargo&t=listar">
							<span class="entypo-doc-text"> Cargos</span>
						</a>
					</li>
					<li>
						<a href="?m=departamento&t=listar">
							<span class="entypo-doc-text"> Departamentos</span>
						</a>
					</li>
					<li>
						<a href="?m=tiporecurso&t=listar">
							<span class="entypo-monitor"> Tipos de Recursos</span>
						</a>
					</li>
					<li>
						<a href="?m=sala&t=listar">
							<span class="entypo-window"> Salas</span>
						</a>
					</li>
					<li>
						<a href="?m=funcionario&t=listar">
							<span class="entypo-users"> Funcionários</span>
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#">
					<i class="entypo-calendar"></i>
					<span>Reuniões</span>
				</a>
				<ul>
					<li>
						<a href="?m=reuniao&t=listar">
							<span class="entypo-search"> Agendamento</span>
						</a>
					</li>
					<li>
						<a href="?m=ata&t=listar">
							<span class="entypo-search"> Ata de Reunião</span>
						</a>
					</li>
					<li>
						<a href="?m=wdcalendario&t=listar">
							<span class="entypo-search"> Visualizar</span>
						</a>
					</li>
					<li>
						<a href="?m=calendario&t=incluir">
							<span class="entypo-user-add"> Convite</span>
						</a>
					</li>
					<li>
						<a href="?m=tiporeuniaociclica&t=listar">
							<span class="entypo-cw"> Reuniões Cíclicas</span>
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="?">
					<i class="entypo-login"></i>
					<span>Fórum</span>
				</a>
				<ul>
					<li>
						<a href="#">
							<span class="entypo-search"> Tópicos</span>
						</a>
					</li>
					<li>
						<a href="#">
							<span class="entypo-user-add"> Chat</span>
						</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="?logoff=true">
					<i class="entypo-login"></i>
					<span>Sair</span>
				</a>
			</li>
			
		</ul>
				
	</div>