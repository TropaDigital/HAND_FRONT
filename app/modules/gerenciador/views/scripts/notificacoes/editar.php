<?php include 'topo_painel.php'; ?>
	
	<form class="div_content" method="post">
		
		<input type="hidden" name="id" value="<?php echo $this->id; ?>"/>
	
		<table class="table-edicao edit">
				
			<tr>
				<th width="220">Campos</th>
				<th>Edição</th>
			</tr>
			
			<tr>
				<td>
					Usuario
				</td>
				<td>
					<select class="select" name="id_usuario" required>
						<option value="0">Geral</option>
						<?php foreach($this->usuarios as $row){?>
						<option value="<?php echo $row->id_usuario;?>"><?php echo $row->name_user; ?></option>
						<?php } ?>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					Nivel
				</td>
				<td>
					<label class="label-100-left">
						<input type="radio" name="nivel" value="alto" required <?php echo $this->row->nivel == 'alto' ? 'checked' : '';?>/> Alto
					</label>
					
					<label class="label-100-left">
						<input type="radio" name="nivel" value="medio" required <?php echo $this->row->nivel == 'medio' ? 'checked' : '';?>/> Médio
					</label>
					
					<label class="label-100-left">
						<input type="radio" name="nivel" value="baixo" required <?php echo $this->row->nivel == 'baixo' ? 'checked' : '';?>/> Baixo
					</label>
				</td>
			</tr>
			
			<tr>
				<td>
					Mensagem
				</td>
				<td>
					<textarea name="mensagem"><?php echo $this->row->mensagem;?></textarea>
				</td>
			</tr>
			
			<tr>
				<td colspan="2" align="right">
				
					<a href="/<?php echo $this->baseModule; echo '/'; echo $this->baseController; ?>" class="edicao-false-bt">VOLTAR</a>
					<button class="edicao-bt">CONCLUIR</button>
					
				</td>
			</tr>
				
		</table>
	</form>
		

<?php include 'rodape_painel.php'; ?>