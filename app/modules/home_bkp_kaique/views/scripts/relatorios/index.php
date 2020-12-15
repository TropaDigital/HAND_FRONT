<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i> Relatório de campanha</span>
				</div>
				
				<div class="filtro-pag">
					<form class="filter">
					
						<input type="text" name="data_i_c" class="picker" placeholder="Data de criação (data inicial)" value="<?php echo $_GET['data_i_c']?>"/>
						<input type="text" name="data_f_c" class="picker" placeholder="Data de criação (data final)" value="<?php echo $_GET['data_f_c']?>"/>
					
						<input type="text" name="data_i_e" class="picker" placeholder="Data de envio (data inicial)" value="<?php echo $_GET['data_i_e']?>"/>
						<input type="text" name="data_f_e" class="picker" placeholder="Data de envio (data final)" value="<?php echo $_GET['data_f_e']?>"/>
					
						<input name="campanha" placeholder="Campanha" type="text" value="<?php echo $_GET['campanha']?>"/>
						
						<button type="submit"><i class="fa fa-search"></i></button>
					
					</form>
				
				</div>
				
				<div class="contatos_lista">
				
					<table style="width:100%;">
					
						<tr>
							<th>Campanha</th>
							<th>Mensagem</th>
							<th>Status</th>
							<th>Formularios respondido</th>
							<th>Cliques por função</th>
							<th>Aberturas do template</th>
							<th>Data de criação</th>
						</tr>
						
						<?php 
						
							$i=0;
							$ids = NULL;
							foreach($this->campanhas as $row){ 
							
							if ($i == 0):
							
								$ids .= $row->id_campanha;
							
							else:
							
								$ids .= ','.$row->id_campanha;
							
							endif;
								
							$i++;
								
						?>
						
							<?php if (!$id[$row->id_campanha]){ ?>
							
							<?php $id[$row->id_campanha] = $row->id_campanha;?>
							<tr class="registro" data-id="<?php echo $row->id_campanha;?>">
								<td><?php echo $row->campanha;?></td>
								<td><?php echo $row->mensagem;?></td>
								<td><?php echo $row->status;?></td>
								<td>
									<a href="/<?php echo $this->baseModule; ?>/relatorios/formularios/id/<?php echo $row->id_campanha;?>">Respostas</a>
								</td>
								<td>
									<a href="/<?php echo $this->baseModule; ?>/relatorios/click/id/<?php echo $row->id_campanha; ?>" class="click"><i class="fa fa-cog fa-spin"></i></a>
								</td>
								<td>
									<a href="/<?php echo $this->baseModule; ?>/relatorios/abertura/id/<?php echo $row->id_campanha; ?>" class="visu"><i class="fa fa-cog fa-spin"></i></a>
								</td>
								<td><?php echo date('d/m/Y', strtotime($row->criado));?></td>
							</tr>
							
							<?php } ?>
							
						<?php } ?>
					
					</table>
					
					<div class="paginacao">
						<?php echo $this->paginationControl($this->campanhas, 'Sliding', 'layout/paginacao.php'); ?>
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

	$('.picker').datepicker({
		dateFormat: 'yy-mm-dd'
	});

	<?php if (count($this->campanhas) > 0){?>
	$.ajax({
		url: '/<?php echo $this->baseModule; ?>/relatorios/geral-id/id/<?php echo $ids; ?>',
		dataType: 'JSON',
		success: function(row){

			$('.registro').each(function(){

				var id = $(this).data('id');
				//$(this).find('.total-contatos').html(row[id].total);
				$(this).find('.visu').html(row[id].aberturas);
				$(this).find('.click').html(row[id].cliques);
				
			});

			loadPage('false');
			
		}, beforeSend: function(){

			loadPage('true');
			
		}
	});
	<?php } ?>
	
</script>