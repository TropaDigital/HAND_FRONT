<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
			
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-users"></i> Editar lista</span>
				</div>
				
				<script>
					$(function(){
					
						$('.editaveis label').each(function(){
							var place = $(this).find('input, select').attr('placeholder');
							$(this).append('<p>'+place+'</p>');
						});

					});
				</script>
				
				<form method="post" action="<?php echo $this->baseModule;?>/contatos/update-lista/id/<?php echo $this->id;?>" class="lista_contatos_lista editaveis">
					
					<label>	
						<input type="text" name="lista" placeholder="Nome do grupo" value="<?php echo $this->lista_contatos[0]->lista; ?>"/>
					</label>
					
					<input type="submit" class="bt_verde cor_c_hover" value="Salvar alterações" style="margin-left:15px;"/>
		
				</form>
			</div>
			
		</div>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>