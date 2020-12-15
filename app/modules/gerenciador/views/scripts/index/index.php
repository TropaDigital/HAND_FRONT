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
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/contas/index">
						<i class="pe-7s-users cor_c_hover"></i>
						<span>Contas cadastradas</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/contas/novo-usuario">
						<i class="pe-7s-add-user cor_c_hover"></i>
						<span>Cadastrar nova conta</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/templates-contas">
						<i class="pe-7s-display2 cor_c_hover"></i>
						<span>Transferir templates</span>
					</a>
					
					<!-- 
					<?php if (count($this->contas) > 0):?>
					<span class="subtitulo">Contas existentes</span>
					<?php endif; ?>
					
					<?php foreach($this->contas as $row){?>					
					<div class="contas-edit">
						<i class="pe-7s-user cor_c_hover"></i>
						<b><?php echo $row->empresa;?></b>
						<div class="opcoes">
						
							<a href="<?php echo $this->baseModule;?>/contas/editar-usuario/id/<?php echo $row->id_usuario;?>/id_login/<?php echo $row->id_login?>">Editar usuario</a>
							<a target="_blank" href="/view/<?php echo $row->id_usuario;?>/<?php echo $this->GerenciadorCustom->slug;?>">Visualizar usuario</a>
						
						</div>
					</div>
					<?php } ?>
					 -->
					
				</div>
			
			</div>
			
			<div class="box" style="display: none;">
			
				<div class="titulo cor_b">
					<i class="pe-7s-users"></i>
					<span>Contas de integração</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/contas-integracao/index">
						<i class="pe-7s-users cor_c_hover"></i>
						<span>Contas cadastradas</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/contas-integracao/novo-usuario">
						<i class="pe-7s-add-user cor_c_hover"></i>
						<span>Cadastrar nova conta</span>
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
					<span>Relatório</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios">
						<i class="pe-7s-users cor_c_hover"></i>
						<span>Relatório de SMS Analítico</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios/sintetico">
						<i class="pe-7s-users cor_c_hover"></i>
						<span>Relatório de SMS Sintético</span>
					</a>

                    <a class="item-central" href="/<?php echo $this->baseModule;?>/relatorios/form">
                        <i class="pe-7s-users cor_c_hover"></i>
                        <span>Relatório de Formulários</span>
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