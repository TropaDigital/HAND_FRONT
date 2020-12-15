<?php include 'topo_painel.php'; ?>
	
	<div class="div_content">
	
		<form id="control-top">
			
			<label class="text">
				<input name="c" type="text" value="<?php echo $_GET['c'];?>"/>
				<span>Campanha</span>
			</label>
			
			<label class="calendario">
				<input name="pi" class="calendario" type="text" value="<?php echo $_GET['pi'];?>"/>
				<span>Periodo inicial</span>
			</label>
			
			<label class="calendario">
				<input name="pf" class="calendario" type="text" value="<?php echo $_GET['pf'];?>"/>
				<span>Periodo final</span>
			</label>
			
			<label>
				<input type="submit" value="Buscar"/>
			</label>
					
		</form>
		
		<table class="table-edicao">
				
			<tr>
				<th width="100">Template</th>
				<th>Campanha</th>
				<th width="90">Status</th>
				<th width="90">Status envio</th>
				<th width="90">Somente SMS</th>
				<th width="140">Data de agendamento</th>
				<th width="40">Cliques</th>
				<th width="40">Visualizações</th>
				<th width="80">Envios</th>
				<th width="120"><i class="fa fa-calendar"></i> Data de criação</th>
			</tr>
					
			<?php foreach($this->result as $row){?>
			<tr class="registro" data-id="<?php echo $row->id_campanha;?>">
				<td><a onclick="preview('<?php echo $row->id_landing_page;?>', this);" class="edicao-bt">Visualizar</a></td>
				<td><?php echo $row->campanha;?></td>
				<td><?php echo $row->status;?></td>
				<td><?php echo $row->status_enviado;?></td>
				<td><?php echo $row->somente_sms;?></td>
				<td><?php echo $row->agenda == '' ? 'Não agendada' : $row->agenda;?></td>
				<td><a href="/painel/relatorios/abertura/id/<?php echo $row->id_campanha;?>" class="visu"></a></td>
				<td><a href="/painel/relatorios/click/id/<?php echo $row->id_campanha;?>" class="click"></a></td>
				<td>
				
					<a href="/painel/relatorios/sms-geral/id/<?php echo $row->id_campanha;?>" class="view-sms">
						<i class="fa fa-paper-plane" aria-hidden="true"></i> Visualizar
						
						<span class="box">
						
							<span class="erro">
								erro
								<b></b>
							</span>
							<span class="pendente">
								pendente	
								<b></b>
							</span>
							<span class="enviado">
								enviado
								<b></b>
							</span>
							
						</span>
						
					</a>
					
				
				</td>
				<td><i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($row->criado)); ?></td>
			</tr>
			<?php } ?>
					
		</table>
		
		<script src="assets/site/js/campanha.js"></script>
		<script>

			$('tr.registro').each(function(){
	
				var id = $(this).data('id');
				var tr = $(this);
	
				$(this).find('.fa-line-chart').attr('onclick','getGraficos('+id+');').attr('style','cursor:pointer');
	
				setCampanha(id);
				getDados(id, 'sucesso','.enviado b',tr);
				getDados(id, 'erro','.erro b',tr);
				getDados(id, 'pendentes', '.pendente b',tr);
				getDados(id, 'aberturas','.visu',tr);
				getDados(id, 'cliques','.click',tr);
			});

		</script>
		
		<div id="control-bottom">
		
			<a href="/painel/usuarios" class="bt-cinza"><i class="fa fa-arrow-left" aria-hidden="true"></i> VOLTAR</a>
		
		</div>
		
	</div>		

<?php include 'rodape_painel.php'; ?>