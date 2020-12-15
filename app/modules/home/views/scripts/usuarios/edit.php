<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
			
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-users"></i><?php echo $this->lg->_("Editar contato"); ?> </span>
				</div>
				
				<form method="post" action="/<?php echo $this->baseModule;?>/usuarios/update/id/<?php echo $this->id;?>" class="contatos_lista editaveis">
				
					<label>
						<input type="text" name="login" placeholder="Login" value="<?php echo $this->usuario[0]->login; ?>"/>
					</label>
					
					<label>
						<input type="password" name="senha" placeholder="<?php echo $this->lg->_("Senha"); ?>" value="<?php echo $this->usuario[0]->senha; ?>"/>
						<input type="hidden" name="senha_atual" placeholder="<?php echo $this->lg->_("Senha"); ?>" value="<?php echo $this->usuario[0]->senha; ?>"/>
					</label>
					
					<label>
						<input type="text" name="email" placeholder="E-mail" value="<?php echo $this->usuario[0]->email; ?>"/>
					</label>
					
					<?php if ( $this->id != 'me' ){?>
					<label>
						<select name="ativo">
							<option  value="1"><?php echo $this->lg->_("Ativo"); ?></option>
							<option value="0"><?php echo $this->lg->_("Inativo"); ?></option>
						</select>
					</label>
					
					<div>
					
						<?php foreach($this->permissoes as $row){?>
						<label class="categorias cat_permissao">
							
							<input <?php if (@in_array($row->id_permissao, $this->permissao_user)) { echo 'checked';}?> type="checkbox" name="permissoes[]" value="<?php echo $row->id_permissao;?>"/>
							<span><?php echo $this->lg->_($row->nome); ?></span>
						
						</label>
						<?php } ?>
					
					</div>
					<?php } ?>
					
					<button onclick="location.href='<?php $_SERVER['HTTP_REFER']?>';" type="button" class="bt_verde cor_b_hover"><?php echo $this->lg->_("Voltar"); ?></button>
					<input type="submit" class="bt_verde cor_c_hover" value="<?php echo $this->lg->_('Salvar alterações'); ?>"/>
		
				</form>
			</div>
			
		</div>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>