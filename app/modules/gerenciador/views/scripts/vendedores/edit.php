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
						Vendedor*
					</td>
					<td>
						<input name="vendedor" required type="text" value="<?php echo $this->row->vendedor;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Login*
					</td>
					<td>
						<input name="login" required type="text" value="<?php echo $this->row->login;?>"/>
						<input name="login_old" type="hidden" value="<?php echo $this->row->login;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Senha*
					</td>
					<td>
						<input name="senha" required type="password" value="<?php echo $this->row->senha;?>"/>
						<input name="senha_old" type="hidden" value="<?php echo $this->row->senha;?>"/>
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