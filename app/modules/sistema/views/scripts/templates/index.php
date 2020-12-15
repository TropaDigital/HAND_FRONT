<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">

		<table class="table-edicao">
				
			<tr class="cor_b">
				<th width="90">Edição</th>
				<th width="90">Visualizar</th>
				<th width="70">Status</th>
				<th>Template</th>
				<th>Categoria</th>
			</tr>
					
			<?php foreach($this->result as $row){?>
			<tr>
				<td><a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/editar/id/<?php echo $row->id_template; ?>" class="edicao-bt"><i class="pe-7s-pen" ></i> EDITAR</a></td>
				<td><a target="_blank" href="/l/<?php echo $row->id_landing_page;?>" class="edicao-bt"><i class="pe-7s-look"></i> Visualizar</a></td>
				<td>
					<?php echo $row->status == 1 ? 'Ativo' : 'Inativo';?>
				</td>
				<td><?php echo $row->template; ?></td>
				<td><?php echo $row->categoria; ?></td>
			</tr>
			<?php } ?>
					
		</table>
		
		<div id="control-bottom">
			<a class="new-bt cor_c_hover" href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/novo">Adicionar Novo</a>
		</div>
		
	</div>
		

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>