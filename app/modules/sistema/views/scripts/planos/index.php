<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
	
		<table class="table-edicao">
			<tr class="cor_b">
				<th width="90">Edição</th>
				<th>Plano</th>
				<th>Quantidade de Contas</th>
				<th>Quantidade de Campanhas</th>
				<th>Quantidade de SMS</th>
				<th>Valor</th>
			</tr>
					
			<?php foreach($this->planos as $row){?>
			<tr>
				<td>
					<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/editar/id/<?php echo $row->id_plano; ?>"><i class="pe-7s-pen" ></i> EDITAR</a>
				</td>
				<td><?php echo $row->plano; ?></td>
				<td><?php echo $row->contas; ?></td>
				<td><?php echo $row->campanhas; ?></td>
				<td><?php echo $row->sms; ?></td>
				<td><?php echo $row->valor; ?></td>
			</tr>
			<?php } ?>
		</table>
		
		<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController; ?>/cadastrar" class="new-bt cor_c_hover">Adicionar novo</a>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>