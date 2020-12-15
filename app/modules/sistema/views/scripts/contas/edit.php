<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	<div id="central">
		<form method="post" enctype="multipart/form-data" action="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/action/id/<?php echo $this->id;?>">
			
			<table>
					
				<tr class="cor_b">
					<th width="50">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
					<td>
						Status*
					</td>
					<td>
						<select name="ativo" required>
							<option value="1" <?php echo $this->row->ativo == '1' ? 'selected' : '';?>>Ativo</option>
							<option value="0" <?php echo $this->row->ativo == '0' ? 'selected' : '';?>>Inativo</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Vendedor*
					</td>
					<td>
						<select name="id_vendedor">
							<option value="0" selected>Selecione um vendedor</option>
							<?php foreach ( $this->vendedores as $row ){?>
							<option value="<?php echo $row->id_vendedor; ?>" <?php echo $this->row->id_vendedor == $row->id_vendedor ? 'selected' : '';?>><?php echo $row->vendedor; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Login*
					</td>
					<td>
						<input name="login" required type="text" value="<?php echo $this->row->login;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Senha*
					</td>
					<td>
						<input name="senha" required type="password" value="<?php echo $this->row->senha;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Nome*
					</td>
					<td>
						<input name="nome" required type="text" value="<?php echo $this->row->nome;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						E-mail*
					</td>
					<td>
						<input name="email" required type="text" value="<?php echo $this->row->email;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Dominio*
					</td>
					<td>
						<input name="dominio" required type="text" value="<?php echo $this->row->dominio;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						ShortUrl*
					</td>
					<td>
						<input name="shorturl" required type="text" value="<?php echo $this->row->shorturl;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Favicon<br/>
						<small>30x30</small>
					</td>
					<td>
						<input type="file" name="favicon" value="<?php echo $this->row->favicon; ?>" style="display:block;"/>
						<?php if ($this->id){?>
						<a href="<?php echo $this->row->favicon; ?>" target="_blank" style="display:block; margin-top:10px; cursor:pointer;">
						
							<img src="<?php echo $this->row->favicon; ?>" style="max-width:120px;"/>
						
						</a>
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<td>
						Background login*<br/>
						<small>1920x1080</small>
					</td>
					<td>
						<input type="file" name="background" value="<?php echo $this->row->background; ?>" style="display:block;"/>
						<?php if ($this->id){?>
						<a href="<?php echo $this->row->background; ?>" target="_blank" style="display:block; margin-top:10px; cursor:pointer;">
						
							<img src="<?php echo $this->row->background; ?>" style="max-width:120px;"/>
						
						</a>
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<td>
						Logo*<br/>
						<small>Até 220x50</small>
					</td>
					<td>
						<input type="file" name="logo" value="<?php echo $this->row->logo; ?>" style="display:block;"/>
						<?php if ($this->id){?>
						<a style="background:<?php echo $this->row->logo_cor;?>; float:left; padding:20px; margin-top:10px; " href="<?php echo $this->row->logo; ?>" target="_blank" style="display:block; margin-top:10px; cursor:pointer;">
						
							<img src="<?php echo $this->row->logo; ?>" style="max-width:120px;"/>
						
						</a>
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<td>
						Logotipo*<br/>
						<small>255x160</small>
					</td>
					<td>
						<input type="file" name="logotipo" value="<?php echo $this->row->logotipo; ?>" style="display:block;"/>
						<?php if ($this->id){?>
						<a style="float:left; padding:20px; margin-top:10px; " href="<?php echo $this->row->logotipo; ?>" target="_blank" style="display:block; margin-top:10px; cursor:pointer;">
						
							<img src="<?php echo $this->row->logotipo; ?>" style="max-width:120px;"/>
						
						</a>
						<?php } ?>
					</td>
				</tr>
				
				<tr>
					<td>
						Logo Cor*
					</td>
					<td>
						<input name="logo_cor" required type="text" class="cp-full" value="<?php echo $this->row->logo_cor;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Cor 1
					</td>
					<td>
						<div class="cores">
							
							<fieldset>
								<legend>Cor normal</legend>
								<input data-cor="cor_a" name="cor_a" required type="text" class="cp-full" value="<?php echo $this->row->cor_a;?>"/>
							</fieldset>
							<fieldset>
								<legend>Cor ao passar o mouse</legend>
								<input data-cor="cor_a:hover" name="cor_a_hover" required type="text" class="cp-full" value="<?php echo $this->row->cor_a_hover;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor da font</legend>
								<input data-cor="cor_a_font" name="cor_a_font" required type="text" class="cp-full" value="<?php echo $this->row->cor_a_font;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor da font ao passar o mouse</legend>
								<input data-cor="cor_a_font:hover" name="cor_a_font_hover" required type="text" class="cp-full" value="<?php echo $this->row->cor_a_font_hover;?>"/>
							</fieldset>
							
							<div class="example" id="cor_a"></div>
							
						</div>
					</td>
				</tr>
				
				<tr>
					<td>
						Cor 2
					</td>
					<td>
						<div class="cores">
							
							<fieldset>
								<legend>Cor normal</legend>
								<input data-cor="cor_b" name="cor_b" required type="text" class="cp-full" value="<?php echo $this->row->cor_b;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor ao passar o mouse</legend>
								<input data-cor="cor_b:hover" name="cor_b_hover" required type="text" class="cp-full" value="<?php echo $this->row->cor_b_hover;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor da font</legend>
								<input data-cor="cor_b_font" name="cor_b_font" required type="text" class="cp-full" value="<?php echo $this->row->cor_b_font;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor da font ao passar o mouse</legend>
								<input data-cor="cor_b_font:hover" name="cor_b_font_hover" required type="text" class="cp-full" value="<?php echo $this->row->cor_b_font_hover;?>"/>
							</fieldset>
							
							<div class="example" id="cor_b"></div>
							
						</div>
					</td>
				</tr>
				
				<tr>
					<td>
						Cor 3
					</td>
					<td>
						<div class="cores">
							
							<fieldset>
								<legend>Cor normal</legend>
								<input data-cor="cor_c" name="cor_c" required type="text" class="cp-full" value="<?php echo $this->row->cor_c;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor ao passar o mouse</legend>
								<input data-cor="cor_c:hover" name="cor_c_hover" required type="text" class="cp-full" value="<?php echo $this->row->cor_c_hover;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor da font</legend>
								<input data-cor="cor_c_font" name="cor_c_font" required type="text" class="cp-full" value="<?php echo $this->row->cor_c_font;?>"/>
							</fieldset>
							
							<fieldset>
								<legend>Cor da font ao passar o mouse</legend>
								<input data-cor="cor_c_font:hover" name="cor_c_font_hover" required type="text" class="cp-full" value="<?php echo $this->row->cor_c_font_hover;?>"/>
							</fieldset>
							
							<div class="example" id="cor_c"></div>
							
						</div>
					</td>
				</tr>
				
				<tr>
					<td>
						Categorias*
					</td>
					<td>
						
						<?php foreach($this->categorias as $row){?>
						<label class="categorias">
							
							<span><?php echo $row->categoria; ?></span>
							<img src="<?php echo $row->imagem;?>"/>
							<input <?php if (@in_array($row->id_categoria, $this->usuarios_categorias)) { echo 'checked';}?> type="checkbox" name="id_template[]" value="<?php echo $row->id_categoria;?>"/>
						
						</label>
						<?php } ?>
						
					</td>
				</tr>
				
				<tr>
					<td colspan="2" align="right">
					
						<a href="/<?php echo $this->baseModule; echo '/'; echo $this->baseController; ?>" class="edicao-false-bt cor_c_hover">VOLTAR</a>
						<button class="cor_c_hover">CONCLUIR</button>
						
					</td>
				</tr>
					
			</table>
		</form>
	</div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
	<script src="assets/admin/js/colorpick/jquery.colorpicker.js"></script>
	<link href="assets/admin/js/colorpick/jquery.colorpicker.css" rel="stylesheet" type="text/css"/>
	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css"/>
	
	<script>
	$(function(){

		$('.cp-full').colorpicker({
			alpha: true,
			colorFormat: 'RGBA'
		});

		$('.cores fieldset input').on('blur', function(){
			var cor = $(this).val();
			$(this).parent().attr('style','background:'+cor+'');
		});

		$('.cores fieldset input').each(function(){
			var cor = $(this).val();
			$(this).parent().attr('style','background:'+cor+'');
		});

	});

	</script>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>