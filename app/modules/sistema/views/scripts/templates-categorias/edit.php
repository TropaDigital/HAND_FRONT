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
						Categoria*
					</td>
					<td>
						<input name="categoria" required type="text" value="<?php echo $this->row->categoria;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Descrição*
					</td>
					<td>
						<input name="descricao" required type="text" value="<?php echo $this->row->descricao;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Status*
					</td>
					<td>
						<select name="status" required="required">
							<option selected value="">Selecione um Status</option>
							<option <?php echo $this->row->status == 1 ? 'selected' : '';?> value="1">Ativo</option>
							<option <?php echo $this->row->status == 0 ? 'selected' : '';?> value="0">Inativo</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Imagem*
					</td>
					<td>
						<input type="file" name="imagem" value="<?php echo $this->row->logo; ?>" style="display:block;"/>
						<?php if ($this->id){?>
						<a style="background:<?php echo $this->row->imagem;?>; float:left; padding:20px; margin-top:10px; " href="<?php echo $this->row->imagem; ?>" target="_blank" style="display:block; margin-top:10px; cursor:pointer;" class="preview-template">
						
							<img src="<?php echo $this->row->imagem; ?>" style="max-width:120px;"/>
						
						</a>
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
<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>