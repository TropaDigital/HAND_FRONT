<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i> Relatório de templates comprados</span>
				</div>
				
				<div class="contatos_lista">
					
					<table style="border-radius:0px;">
					
						<tr>
						
							<th>Template</th>
							<th>Valor</th>
							<th>Data</th>
							
						</tr>
						
						<?php if ( count($this->result) == 0 ) {?>
						
							<tr>
							
								<td colspan="3">Nenhum registro encontrado.</td>
							
							</tr>
						
						<?php } else { ?>
							
							<?php foreach( $this->result as $row ){?>
							<tr>
							
								<td><?php echo $row->nome; ?></td>
                                <td><?php echo $row->valor; ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row->criado)) ?></td>
							
							</tr>
							<?php } ?>
						
						<?php } ?>
					
					</table>
					
				</div>
				
			</div>
			
		</div>
	</div>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php';?>