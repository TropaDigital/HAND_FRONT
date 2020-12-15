<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	<div id="central">
		<form method="post" action="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/action/id/<?php echo $this->id;?>">
			
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
						Login/Email*
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
						Email*
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
						<input class="telefone" name="telefone" required type="text" value="<?php echo $this->row->telefone;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Celular*
					</td>
					<td>
						<input class="celular" name="celular" required type="text" value="<?php echo $this->row->celular;?>"/>
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
<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>