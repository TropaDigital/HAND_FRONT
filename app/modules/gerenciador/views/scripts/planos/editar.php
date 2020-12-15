<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
		<form class="div_content" method="post">
			
			<input type="hidden" name="id" value="<?php echo $this->id; ?>"/>
		
			<table class="table-edicao edit">
					
				<tr class="cor_b">
					<th width="220">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
					<td>
						Caixa entrada
					</td>
					<td>
						<select name="caixa_entrada" required>
							<option value="1" <?php echo $this->row->caixa_entrada == '1' ? 'selected' : '';?>>Sim</option>
							<option value="0" <?php echo $this->row->caixa_entrada == '0' ? 'selected' : '';?>>Não</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Plano
					</td>
					<td>
						<input name="plano" type="text" required value="<?php echo $this->row->plano;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Valor
					</td>
					<td>
						<input name="valor" type="text" required value="<?php echo $this->row->valor;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Quantidade de SMS
					</td>
					<td>
						<input name="num_sms" type="text" required value="<?php echo $this->row->num_sms;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Campanhas ativas
					</td>
					<td>
						<input name="campanhas_ativa" required type="tel" value="<?php echo $this->row->campanhas_ativa;?>"/>
					</td>
				</tr>
				
				<tr>
					<td colspan="2" align="right">
					
						<a href="/<?php echo $this->baseModule; echo '/'; echo $this->baseController; ?>" class="cor_c_hover edicao-false-bt">VOLTAR</a>
						<button class="cor_c_hover">CONCLUIR</button>
						
					</td>
				</tr>
					
			</table>
		</form>
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>