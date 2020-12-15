<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
		
	<section>
	
		<div id="central">
		
			<div class="box">
		
    			<div class="titulo cor_b">
    				<i class="pe-7s-users"></i>
    				<span>Vendedores</span>
    			</div>
    			
    			<div class="box-padding">
    			
    				<a class="item-central" href="/<?php echo $this->baseModule;?>/vendedores/index">
    					<i class="pe-7s-users cor_c_hover"></i>
    					<span>Todos vendedores</span>
    				</a>
    				
    				<a class="item-central" href="/<?php echo $this->baseModule;?>/vendedores/cadastrar">
    					<i class="pe-7s-add-user cor_c_hover"></i>
    					<span>Cadastrar vendedor</span>
    				</a>
    				
    			</div>
				
			</div>
		
			<div class="box">
			
				<div class="titulo cor_b">
					<i class="pe-7s-users"></i>
					<span>Contas</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/administradores/index">
						<i class="pe-7s-users cor_c_hover"></i>
						<span>Todos administradores</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/administradores/cadastrar">
						<i class="pe-7s-add-user cor_c_hover"></i>
						<span>Cadastrar administrador</span>
					</a>
				
					<span class="subtitulo">Whitelabel existentes</span>
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/contas/index">
						<i class="pe-7s-users cor_c_hover"></i>
						<span>Contas cadastradas</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/contas/cadastrar">
						<i class="pe-7s-add-user cor_c_hover"></i>
						<span>Cadastrar nova conta</span>
					</a>
				
					<span class="subtitulo">Contas existentes</span>
					
					<?php foreach($this->contas as $row){?>					
					<div class="contas-edit">
						<i class="pe-7s-user cor_c_hover"></i>
						<b><?php echo $row->nome;?></b>
						<div class="opcoes">
						
							<a href="<?php echo $this->baseModule;?>/contas/editar/id/<?php echo $row->id_usuario;?>">Editar usuario</a>
							<a target="_blank" href="/view-gerenciador/<?php echo $row->id_usuario;?>/true/<?php echo $row->slug;?>">Visualizar usuario</a>
						
						</div>
					</div>
					<?php } ?>
					
				</div>
			
			</div>
			
			<div class="box" style="display:none;">
			
				<div class="titulo cor_b">
					<i class="pe-7s-display2"></i>
					<span>Planos</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/planos">
						<i class="pe-7s-display2 cor_c_hover"></i>
						<span>Ver todos planos</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/planos/cadastrar">
						<i class="pe-7s-display2 cor_c_hover"></i>
						<span>Adicionar novo plano</span>
					</a>
				
				</div>
			
			</div>
			
			<div class="box">
			
				<div class="titulo cor_b">
					<i class="pe-7s-display2"></i>
					<span>Templates</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/templates">
						<i class="pe-7s-news-paper cor_c_hover"></i>
						<span>Ver todos templates</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/templates/novo">
						<i class="pe-7s-news-paper cor_c_hover"></i>
						<span>Adicionar novo template</span>
					</a>
					
					<span class="subtitulo">Categorias</span>
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/templates-categorias">
						<i class="pe-7s-ribbon cor_c_hover"></i>
						<span>Ver todas categorias</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/templates-categorias/cadastrar">
						<i class="pe-7s-ribbon cor_c_hover"></i>
						<span>Adicionar nova categoria</span>
					</a>
				
				</div>
			
			</div>
			
			<div class="box">
			
				<div class="titulo cor_b">
					<span>Relatórios</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios">
						<i class="pe-7s-news-paper cor_c_hover"></i>
						<span>Relatório de Envios Analitico</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios/sintetico">
						<i class="pe-7s-news-paper cor_c_hover"></i>
						<span>Relatório de Envios Sintético</span>
					</a>

                    <a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios/form">
                        <i class="pe-7s-news-paper cor_c_hover"></i>
                        <span>Relatório de Formularios</span>
                    </a>

                    <a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios/templates-comprados">
                        <i class="pe-7s-users cor_c_hover"></i>
                        <span>Templates Analítico</span>
                    </a>

                    <a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios/templates-comprados-sintetico">
                        <i class="pe-7s-users cor_c_hover"></i>
                        <span>Templates Sintético</span>
                    </a>
				
				</div>
			
			</div>
		
		</div>
	</section>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>