<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
			
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-users"></i> Editar contato</span>
				</div>
				
				<script>
					$(function(){
					
						$('.editaveis label').each(function(){
							var place = $(this).find('input, select').attr('placeholder');

							$(this).find('input').removeAttr('placeholder');
							
							$(this).prepend('<p>'+place+'</p>');
						});

						setTimeout(function(){

							$('select').select2('destroy');

						},500);
						
					});
				</script>
				
				<form method="post" action="/<?php echo $this->baseModule;?>/contatos/update/id/<?php echo $this->id;?>/il/<?php echo $_GET['il'];?>" class="contatos_lista editaveis">
				
					<label>
						<select name="id_lista" placeholder="Lista de contatos" style="width:322px;">
							<?php foreach($this->listas as $row){?>
							<option <?php echo $this->contatos->id_lista == $row->id_lista ? "selected" : ""; ?> value="<?php echo $row->id_lista;?>"><?php echo $row->lista;?></option>
							<?php } ?>
						</select>
					</label>
					
					<label>	
						<input type="text" name="referencia" placeholder="Referencia" value="<?php echo $this->contatos->referencia; ?>"/>
					</label>
					
					<label>	
						<input type="text" name="celular" placeholder="Celular" value="<?php echo $this->contatos->celular; ?>"/>
					</label>
					
					<label>
						<input type="text" name="nome" placeholder="Nome" value="<?php echo $this->contatos->nome; ?>"/>
					</label>
					
					<label>
						<input type="text" name="sobrenome" placeholder="Sobrenome" value="<?php echo $this->contatos->sobrenome; ?>"/>
					</label>
						
					<label>	
						<input class="data" type="text" name="data_nascimento" placeholder="Data de nascimento" value="<?php echo $this->contatos->data_nascimento; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="email" placeholder="Email" value="<?php echo $this->contatos->email; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo1" placeholder="CPF" value="<?php echo $this->contatos->campo1; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo2" placeholder="Empresa" value="<?php echo $this->contatos->campo2; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo3" placeholder="Cargo" value="<?php echo $this->contatos->campo3; ?>"/>
					</label>
						
					<label>	
						<input class="telefone" type="text" name="campo4" placeholder="Telefone Comercial" value="<?php echo $this->contatos->campo4; ?>"/>
					</label>
						
					<label>	
						<input class="telefone" type="text" name="campo5" placeholder="Telefone Residencial" value="<?php echo $this->contatos->campo5; ?>">
					</label>
						
					<label>	
						<input type="text" name="campo6" placeholder="Pais" value="<?php echo $this->contatos->campo6; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo7" placeholder="Estado" value="<?php echo $this->contatos->campo7; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo8" placeholder="Cidade" value="<?php echo $this->contatos->campo8; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo9" placeholder="Bairro" value="<?php echo $this->contatos->campo9; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo10" placeholder="Endereço" value="<?php echo $this->contatos->campo10; ?>"/>
					</label>
						
					<label>	
						<input type="text" name="campo11" placeholder="Cep" value="<?php echo $this->contatos->campo11; ?>"/>
					</label>
					
					<div>
					
						<a class="cor_a_hover open_editavel" style="margin: 7px 1%;display: inline-block;padding:10px 15px;border-radius: 3px;color:#FFF;font-size:13px;">
						
							Campos editaveis
							<i class="fa fa-plus"></i>
						
						</a>
					
					</div>
					
					<div class="camp_editaveis" style="display:none; width:100%; float:left;">
						<?php $contatos = (array)$this->contatos; ?>
						<?php for ($i = 1; $i <= 40; $i++) {?>
						<label>	
							<input type="text" name="editavel_<?php echo $i;?>" placeholder="Editavel <?php echo $i;?>" value="<?php echo $contatos['editavel_'.$i]; ?>"/>
						</label>
						<?php } ?>
					</div>
					
					<script>

						$('.open_editavel').bind('click', function(){

							$('.camp_editaveis').slideToggle();

							$(this).toggleClass('active');

							if (  $( this ).hasClass('active') ) {

								$( this ).find('.fa-plus').removeClass('fa-plus').addClass('fa-minus');

							} else {

								$( this ).find('.fa-minus').removeClass('fa-minus').addClass('fa-plus');
								
							}
							
						});

					</script>
					
					<div style="width:100%;float:left;padding: 0px 1%;box-sizing: border-box;">
						<button onclick="location.href='/<?php echo $this->baseModule;?>/contatos?t=c&id_lista=<?php echo $_GET['il']; ?>';" type="button" class="bt_verde cor_b_hover">Voltar</button>
						<input type="submit" class="bt_verde cor_c_hover" value="Salvar alterações"/>
					</div>
		
				</form>
			</div>
			
		</div>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>