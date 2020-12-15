<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
	
			<div class="box_adc" id="todas">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i> <?php echo $this->lg->_("Como você deseja criar seu novo template?"); ?></span>
				</div>
			
				<h3 class="cor_font_c"><?php echo $this->lg->_("Meus templates"); ?></h3>
				<p><?php echo $this->lg->_("Acesse seus templates salvos"); ?></p>
			
				<ul class="categorias">
				
					<li>
						<span class="img" style="background:url(assets/home/images/cat/meu-template.png) center no-repeat;"></span>
						<span class="titulo"><?php echo $this->lg->_("Meus Templates"); ?></span>
						<span class="descricao"><?php echo $this->lg->_("Criar a partir dos meus templates"); ?></span>
						<a href="/<?php echo $this->baseModule; ?>/templates/meus-templates" class="cor_c_hover"><?php echo $this->lg->_("Acessar"); ?></a>
					</li>
					
				</ul>
				
				<h3 class="cor_font_c"><?php echo $this->lg->_("Templates por categoria"); ?></h3>
				<p><?php echo $this->lg->_("O que você deseja obter com a sua campanha? Nosso sistema oferece templates pré-prontos para você alcançar os melhores resultados seja qual for seu objetivo."); ?></p>
			
				<ul class="categorias">
				
					<?php foreach($this->categorias as $row){?>
					<li>
						<span class="img" style="background:url(<?php echo str_replace('site', 'home', $row->imagem);?>) center no-repeat;"></span>
						<span class="titulo"><?php echo $row->categoria;?></span>
						<span class="descricao"><?php echo $row->descricao;?></span>
						<a href="/<?php echo $this->baseModule; ?>/templates/categoria/<?php echo !$row->id_gerenciador ? 'id' : 'id_template'; ?>/<?php echo $row->id_categoria; ?>" class="cor_c_hover"><?php echo $this->lg->_("Acessar"); ?></a>
					</li>
					<?php } ?>
					
				</ul>
				
			</div>
		
		</div>
		
	</div>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php';?>