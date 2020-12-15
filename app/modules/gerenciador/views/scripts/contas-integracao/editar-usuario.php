<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
		<form class="div_content" method="post">
			
			<input type="hidden" name="id" value="<?php echo $this->id; ?>"/>
			
			<table class="table-edicao">
					
				<tr class="cor_b">
					<th width="220">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
					<td>
						LOGIN*
					</td>
					<td>
						<input name="login_envio_old" required type="hidden" value="<?php echo $this->row->login_envio;?>"/>
						<input name="login_envio" required type="text" value="<?php echo $this->row->login_envio;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						SENHA*
					</td>
					<td>
						<input name="senha_envio" required type="text" value="<?php echo $this->row->senha_envio;?>"/>
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