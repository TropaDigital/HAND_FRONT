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
						Plano
					</td>
					<td>
						<input name="plano" required type="text" value="<?php echo $this->row->plano;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Quantidade de contas*
					</td>
					<td>
						<input name="contas" required type="text" value="<?php echo $this->row->contas;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Quantidade de campanhas*
					</td>
					<td>
						<input name="campanhas" required type="text" value="<?php echo $this->row->campanhas;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Quantidade de SMS*
					</td>
					<td>
						<input name="sms" required type="text" value="<?php echo $this->row->sms;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Valor*
					</td>
					<td>
						<input class="money" name="valor" required type="text" value="<?php echo $this->row->valor;?>"/>
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