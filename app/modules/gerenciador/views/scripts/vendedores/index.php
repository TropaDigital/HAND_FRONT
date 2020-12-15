<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
	
		<form action="/<?php echo $this->baseModule;?>/<?php echo $this->baseController; ?>/excluir" method="post">
	
			<table class="table-edicao">
				<tr class="cor_b">
					<th width="10"><i class="pe-7s-trash"></i></th>
					<th width="90">Edição</th>
					<th>Vendedor</th>
				</tr>
						
				<?php foreach($this->result as $row){?>
				<tr>
					<td>
						<input type="checkbox" name="id[]" value="<?php echo $row->id_vendedor;?>"/>
					</td>
					<td>
						<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/editar/id/<?php echo $row->id_vendedor; ?>"><i class="pe-7s-pen" ></i> EDITAR</a>
					</td>
					<td><?php echo $row->vendedor; ?></td>
				</tr>
				<?php } ?>
			</table>
			
			<button class="excluir cor_c_hover">Excluir registros selecionados</button>
			<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController; ?>/cadastrar" class="new-bt cor_c_hover">Adicionar nova</a>
		
		</form>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>