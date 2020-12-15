<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i><?php echo $this->lg->_("Relatórios Aberturas"); ?> </span>
				</div>
				
				<div class="contatos_lista">
					
					<table class="ajax_campanha">
						
						<tr>
							<th width="10"></th>
							<th><?php echo $this->lg->_("E-mail"); ?></th>
							<th><?php echo $this->lg->_("Login"); ?></th>
							<th><?php echo $this->lg->_("Status"); ?></th>
							<th><?php echo $this->lg->_("Data de criação"); ?></th>
						</tr>
						
						<?php 
							foreach ($this->result as $row){
						?>
						
						<tr>
							<td>
							
								<a class="fa fa-edit" href="<?php echo $this->baseModule;?>/usuarios/edit/id/<?php echo $row->id_login;?>"></a>
							
							</td>
							<td><?php echo $row->email; ?></td>
							<td><?php echo $row->login; ?></td>
							<td><?php echo $row->ativo == 1 ? 'Ativo' : 'Inativo';?></td>
							<td><?php echo date('d/m/y H:i', strtotime($row->criado));?></td>
						</tr>
						
						<?php } ?>
						
					</table>
					
					<?php echo $this->paginacao; ?>
					
				</div>
						
			</div>
			
		</div>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>