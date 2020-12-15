<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
	
			<div class="box_adc" id="todas">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i> <?php echo $this->lg->_("Como você deseja criar seu novo template?"); ?></span>
				</div>
				
				<div class="filtro-pag">
				
					<div class="info-categoria">
						
						<?php if ($_GET['categoria'] != 'lixeira'){?>
						<span class="img" style="background:url(assets/home/images/cat/meu-template.png) center no-repeat;"></span>
						<span class="titulo"><?php echo $this->lg->_("MEUS TEMPLATES"); ?></span>
						<span class="descricao"><?php echo $this->lg->_("Criar a partir dos meus templates"); ?></span>
						<?php } else { ?>
						<span class="img" style="background:url(assets/home/images/cat/lixeira.png) center no-repeat;"></span>
						<span class="titulo"><?php echo $this->lg->_("Lixeira"); ?></span>
						<span class="descricao"><?php echo $this->lg->_("Templates excluidos"); ?></span>
						<?php } ?>
					
					</div>
					
					<form id="busca" style="float:right; width: 100%; margin-top:20px;">
					
						<input type="hidden" name="busca" value="1"/>
									
						<select onchange="javascript:submitForm();" name="categoria">
							<option value=""><?php echo $this->lg->_("Categorias"); ?></option>
							<option <?php echo $_GET['categoria'] == 'lixeira' ? 'selected' : ''; ?> value="lixeira"><?php echo $this->lg->_("Lixeira"); ?></option>
						</select>
									
						<input name="data_i" value="<?php echo $this->d_i;?>" placeholder="<?php echo $this->lg->_("Data inicial"); ?>" style="width:65px;" type="text" class="picker"/> 
						<?php echo $this->lg->_("até "); ?>
						<input name="data_f" value="<?php echo $this->d_f;?>" placeholder="<?php echo $this->lg->_("Data final"); ?>" style="width:65px;" type="text" class="picker"/>
						<input name="nome" value="<?php echo $_GET['nome'];?>" placeholder="<?php echo $this->lg->_("Nome do template"); ?>" style="padding-right:35px;" type="text"/>
						<button type="submit"><i class="fa fa-search"></i></button>
						
						<fieldset>
						
							<legend><?php echo $this->lg->_("Usuarios"); ?></legend>
							
							<?php $_GET['id_usuario'] = $_GET['id_usuario'] == NULL ? array('0'=>'0') : $_GET['id_usuario']; ?>
							<?php foreach( $this->familia as $row ){?>
							<label>
							
								<input onchange="javascript:$(this).parents('form').submit();" type="checkbox" name="id_usuario[]" value="<?php echo $row->id_usuario;?>" <?php if ( in_array( $row->id_usuario, $_GET['id_usuario'] ) ) { echo 'checked'; }?> />
								<span><?php echo $row->name_user;?></span>
							
							</label>
							<?php }?>
						
						</fieldset>
						
						<!-- CHECKBOX -->
						<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
						<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
						<script>
							$('input[type="checkbox"]').checkboxradio();;
						</script>
						
					</form>
				
				</div>
				
				<ul class="meus-templates">
				
					<?php foreach($this->landing_page as $row){?>
					<li class="box-<?php echo $row->id_landing_page;?>">
						
						<div class="left">
						
							<a data-ripple="rgba(0,0,0,0.1)" title="<?php echo $this->lg->_("Nome do template"); ?>" class="cor_font_b tooltip box" href="/<?php echo $this->baseModule;?>/templates/criacao/id/<?php echo $row->id_landing_page;?>">
								<i class="fa fa-star"></i>
								<?php echo $row->nome; ?>
							</a>
						
							<span class="box tooltip" title="<?php echo $this->lg->_("Data de criação"); ?>">
								<i class="fa fa-calendar"></i>
								<?php echo date('d/m/Y', strtotime($row->criado)); ?>
							</span>
							
							<span class="box tooltip" title="<?php echo $this->lg->_("Autor do template"); ?>">
								<i class="fa fa-user"></i>
								<?php echo $row->nome_user;?>
							</span>
							
							<span class="box tooltip" title="<?php echo $this->lg->_("Referencia do template, para campanhas em FTP."); ?>">
								<i class="fa fa-cog"></i>
								<?php echo $row->id_landing_page; ?>
							</span>
							
						</div>
						
						<a data-ripple="rgba(0,0,0,0.4)" class="cor_b_hover preview" href="/<?php echo $this->baseModule;?>/templates/criacao/id/<?php echo $row->id_landing_page;?>">
						
							<?php echo $this->lg->_("Editar"); ?>
							<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Edite este template, incluindo novas funções e seções."); ?>"></i>
						
						</a>
						<?php if($row->status != 'excluido'){?>
						<a data-ripple="rgba(0,0,0,0.4)" class="cor_b_hover preview" onclick="del('<?php echo $row->id_landing_page; ?>');">
						
							<i class="fa fa-trash"></i>
							<?php echo $this->lg->_("Excluir"); ?>
							<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Clique para excluir este template. Clicando nesta opção, ele poderá ser recuperado futuramente."); ?>"></i>
						
						</a>
						<?php } else {?>
						
						<a data-ripple="rgba(0,0,0,0.4)" class="cor_b_hover preview" onclick="restore('<?php echo $row->id_landing_page; ?>');">
						
							<i class="fa fa-arrow-circle-up"></i> 
							<?php echo $this->lg->_("Resturar"); ?>
							
						</a>
						
						<?php } ?>
						<a data-ripple="rgba(0,0,0,0.4)" onclick="preview('<?php echo $row->id_landing_page;?>');" class="cor_b_hover preview">
						
							<?php echo $this->lg->_("Pré-visualizar"); ?>
							<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Clique para visualizar o template antes de selecioná-lo."); ?>"></i>
							
						</a>
						
						<a data-ripple="rgba(0,0,0,0.4)" href="/<?php echo $this->baseModule;?>/campanha/nova-campanha?id=<?php echo $row->id_landing_page;?>" class="cor_b_hover preview">
						
							<?php echo $this->lg->_("Criar campanha"); ?>
							
						</a>
						
						<a data-ripple="rgba(0,0,0,0.4)" onclick="duplicar('<?php echo $row->id_landing_page; ?>');" class="cor_c_hover preview">
						
							<?php echo $this->lg->_("Criar a partir deste "); ?>
							<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Crie a sua campanha a partir deste template que já foi desenvolvido por você."); ?>"></i>
							
						</a>
					</li>
					<?php } ?>
				</ul>
				
			</div>
	
		</div>
		
	</div>
	
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$('.picker').datepicker({
			dateFormat: 'yy-mm-dd'
		});

		function submitForm(){
			$('#busca').submit();
		}

		function restore(id){
			$.ajax({
				url: '/<?php echo $this->baseModule;?>/templates/meus-templates/restore/true/id/'+id,
				type: 'GET',
				success: function(row){
					if (row == 'true'){
						
						$('.box-'+id).addClass('animated bounceOut');

						setTimeout(function(){
							$('.box-'+id).delay(350).fadeOut(0);
						},300);
						
					} else {
						alert('Erro ao restaurar modelo.');
						$('.box-'+id).animate({'opacity':'1'},500);
					}
					console.log(row);
				}, beforeSend: function(){
					$('.box-'+id).animate({'opacity':'0.8'},500);
				}
			});
		}
		
		function del(id){
			
			$.ajax({
				url: '/<?php echo $this->baseModule;?>/templates/meus-templates/del/true/id/'+id,
				type: 'GET',
				success: function(row){
					if (row == 'true'){

						$('.box-'+id).addClass('animated bounceOut');

						setTimeout(function(){
							$('.box-'+id).delay(350).fadeOut(0);
						},300);
						
					} else {
						alert('Erro ao remover template.');
						$('.box-'+id).animate({'opacity':'1'},5000);
					}
					console.log(row);
				}, beforeSend: function(){
					$('.box-'+id).animate({'opacity':'0.8'},500);
				}
			});
			
		}
	</script>
	

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>