<?php 

include_once dirname(__FILE__).'/../layout/header.php';
include_once dirname(__FILE__).'/../layout/section.php';

function randString($length) {
    $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $char = str_shuffle($char);
    for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
        $rand .= $char{mt_rand(0, $l)};
    }
    return $rand;
}

?>
	
	<div id="central">
		<form class="div_content" method="post">
			
			<input type="hidden" name="id" value="<?php echo $this->id; ?>"/>
			<input type="hidden" name="id_zoug" value="<?php echo $this->row->id_zoug; ?>"/>
			
			<table class="table-edicao">
					
				<tr class="cor_b">
					<th width="220">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
					<td>
						Status*
					</td>
					<td>
						<input type="hidden" name="ativo_old" value="<?php echo $this->row->ativo; ?>"/>
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
				
				<tr style="display:none;">
					<td>
						Login envio*
					</td>
					<td>
						<input maxlength="8" name="login_envio" required type="text" value="<?php echo $this->row->login_envio == NULL ? randString(8) : $this->row->login_envio;?>"/>
					</td>
				</tr>
				
				<tr style="display:none;">
					<td>
						Senha envio*
					</td>
					<td>
						<input maxlength="8" name="senha_envio" required type="text" value="<?php echo $this->row->senha_envio == NULL ? randString(8) : $this->row->senha_envio;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Empresa*
						<br/><span style="font-size:10px;">Nome da Empresa que será cadastrada.</span>
					</td>
					<td>
						<input name="empresa" required type="text" value="<?php echo $this->row->empresa;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Email da empresa*
						<br/><span style="font-size:10px;">E-mail da Empresa que será cadastrada.</span>
					</td>
					<td>
						<input name="email" required type="text" value="<?php echo $this->row->email;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Telefone*
					</td>
					<td>
						<input class="celular" name="telefone" required type="text" value="<?php echo $this->row->telefone;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						CNPJ*
						<br/><span style="font-size:10px;">Cnpj da empresa que será cadastrada.</span>
					</td>
					<td>
						<input name="cnpj" required type="text" value="<?php echo $this->row->cnpj;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Login user*
						<br/><span style="font-size:10px;">Login para a nova Empresa cadastrada.</span>
					</td>
					<td>
						
						<?php if (!$this->id){ ?>
						<div class="label-100-left">
							<input maxlength="8" class="validaLogin" required type="text" value="<?php echo $this->row->login;?>"/>
						</div>
						<?php } ?>
						
						<div class="label-100-left">
							<input class="auto-preenche" style="background:none; border:none;" disabled="disabled" type="text" value="<?php echo $this->row->login;?>"/>
						</div>
						
						<input class="auto-preenche" name="login_user" required type="hidden" value="<?php echo $this->row->login;?>"/>
					
						<script>
							$('.validaLogin').bind('change blur', function(){
	
								var login = $(this).val();
								
								$.ajax({
									url: '/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/valida-login',
									type: 'POST',
									data: {login: login},
									success: function(row){
										console.log(row)
										$('.auto-preenche').val(row);
									}
								});
							});
						</script>
					
					</td>
				</tr>
				
				<tr>
					<td>
						Senha user*
						<br/><span style="font-size:10px;">Senha para a Nova Empresa cadastrada.</span>
					</td>
					<td>
						<input maxlength="8" name="pass_user" required type="password" value="<?php echo $this->row->senha;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Nome user*
						<br/><span style="font-size:10px;">Nome do Usuário que irá usar o login da Nova Empresa.</span>
					</td>
					<td>
						<input name="name_user" required type="text" value="<?php echo $this->row->name_user;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Permissões*
					</td>
					<td>
						
						<label class="categorias">
							
							<span>Selecionar todos</span>
							<input class="all" type="checkbox"/>
						
						</label>
						
						<?php foreach($this->permissoes as $row){?>
						<label class="categorias cat_permissao">
							
							<span><?php echo $row->nome; ?></span>
							<input <?php if (@in_array($row->id_permissao, $this->permissao_user)) { echo 'checked';}?> type="checkbox" name="permissoes[]" value="<?php echo $row->id_permissao;?>"/>
						
						</label>
						<?php } ?>
						
						<script>

							$('.all').bind('click', function(){
								$('.cat_permissao input').prop('checked', true);
							});

						</script>
						
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

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>