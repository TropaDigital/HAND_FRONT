<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
		<form class="div_content" method="post" action="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/remover">
		
			<table class="table-edicao">
					
				<tr class="cor_b">
					<th width="10"><i class="fa fa-trash"></i></th>
					<th width="90">Edição</th>
					<th>Plano</th>
					<th>Caixa de entrada</th>
					<th>Quantidade de Campanhas</th>
					<th>Quantidade de SMS</th>
					<th>Valor</th>
				</tr>
						
				<?php foreach($this->result as $row){?>
				<tr>
					<td><input value="<?php echo $row->id_plano; ?>" type="checkbox" name="id[]"/></td>
					<td><a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/editar/id/<?php echo $row->id_plano; ?>" class="edicao-bt"><i class="fa fa-pencil-square-o" ></i> EDITAR</a></td>
					<td><?php echo $row->plano; ?></td>
					<td><?php echo $row->caixa_entrada == 1 ? 'Sim' : 'Não'; ?></td>
					<td><?php echo $row->campanhas_ativa; ?></td>
					<td><?php echo $row->num_sms; ?></td>
					<td><?php echo $row->valor; ?></td>
				</tr>
				<?php } ?>
						
			</table>
			
			<div id="control-bottom">
				<button type="submit" class="excluir cor_c_hover"><i class="fa fa-trash"></i> Excluir</button>
				<a class="new-bt cor_c_hover" href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/novo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Novo plano</a>
			</div>
		
		</form>
	</div>
		
<?php include_once dirname(__FILE__).'/../layout/footer.php';?>