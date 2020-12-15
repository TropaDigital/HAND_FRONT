<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
			
			<div class="box_adc"id="todas">
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i> Minhas campanhas</span>
				</div>
				
				<div class="filtro-pag">
						
					<form id="busca">
						
						<input type="hidden" name="busca" value="1"/>
						<input type="hidden" name="pagina" class="pagina" value=""/>
						<input name="data_i" class="data_i picker" value="<?php echo $_GET['data_i'];?>" placeholder="Data inicial" style="width:65px;" type="text" class="picker"/> 
						até 
						<input name="data_f" value="<?php echo $_GET['data_f'];?>" placeholder="Data final" style="width:65px;" type="text" class="picker d_f"/>
						<input name="nome" value="<?php echo $_GET['nome'];?>" placeholder="Nome da campanha" style="padding-right:35px;" type="text"/>
						<button type="submit"><i class="fa fa-search"></i></button>
						<input style="width:0px; height:0px; padding:0px; visibility:hidden; opacity:0;" type="text" name="status" class="status_enviado" value="<?php echo $_GET['status'];?>"/>
					</form>
					
					<span data-d_i="0000-00-00" data-d_f="<?php echo date('Y-m-d');?>" class="filtro_campanha <?php echo $_GET['status'] == 'finalizado' ? 'ativo' : '';?>" data-status="finalizado">Finalizadas</span>
					<span data-d_i="0000-00-00" data-d_f="<?php echo date('Y-m-d');?>" class="filtro_campanha <?php echo $_GET['status'] == 'agendado' ? 'ativo' : '';?>" data-status="agendado">Agendadas</span>
					<span data-d_i="0000-00-00" data-d_f="<?php echo date('Y-m-d');?>" class="filtro_campanha <?php echo $_GET['status'] == 'incompleto' ? 'ativo' : '';?>" data-status="incompleto">Incompletas</span>
					<span data-d_i="0000-00-00" data-d_f="<?php echo date('Y-m-d');?>" class="filtro_campanha <?php echo $_GET['status'] == 'processando' ? 'ativo' : '';?>" data-status="processando">Processando/Enviando</span>
					<span data-d_i="0000-00-00" data-d_f="<?php echo date('Y-m-d');?>" class="filtro_campanha <?php echo $_GET['status'] == 'all' ? 'ativo' : '';?> <?php echo $_GET['status'] == '' ? 'ativo' : '';?>" data-status="all">Todas</span>
					<span data-d_i="0000-00-00" data-d_f="<?php echo date('Y-m-d');?>" class="filtro_campanha <?php echo $_GET['status'] == 'ativas' ? 'ativo' : '';?>" data-status="ativas">Todas ativas</span>
					<span data-d_i="<?php echo date('Y-m-00');?>" data-d_f="<?php echo date('Y-m-t');?>" class="filtro_campanha <?php echo $_GET['status'] == 'mes' ? 'ativo' : '';?>" data-status="mes">Esse mês</span>
					
				</div>
					
				<div class="contatos_lista">
						
					<div class="periodo">
					
						<?php if (count($this->campanhas) == 0){?>
						<h2>Nenhuma campanha encontrada.</h2>
						<?php } ?>
					
						<?php 
						
							$i=0;
							$id = NULL;
							foreach($this->campanhas as $row){ 
								
							$row = (object)$row;
						
							if ($i == 0):
							
								$id .= $row->id_campanha;
							
							else:
							
								$id .= ','.$row->id_campanha;
							
							endif;
								
							$i++;
								
						?>
						
						<div id="minha-campanha-<?php echo $row->id_campanha;?>" data-id="<?php echo $row->id_campanha;?>" class="box-campanha">
							
							<?php if ($row->status_enviado == 'agendado'){?>
							<div class="enviado_em">Agendada para: <b><?php echo $row->data_agenda; ?></b></div>
							<?php } elseif ($row->status_enviado == 'finalizado'){ ?>
							<div class="enviado_em">Enviada em: <b><?php echo $row->data_envio; ?></b></div>
							<?php } else { ?>
							<div class="enviado_em">Criada em: <b><?php echo date('d/m/Y H:i', strtotime($row->criado)); ?></b></div>
							<?php } ?>
							
							<input type="hidden" name="id_campanha" value="<?php echo $row->id_campanha; ?>">
							
							<div class="table cor_font_c">
								<div class="ico"><i class="fa fa-paper-plane"></i></div>
								<div class="nome"><?php echo $row->campanha;?></div>
							</div>
							
							<div class="contatos cor_font_c contatos_<?php echo $row->id_campanha; ?>">
								<div class="nome">Contatos (<span class="total-contatos"><i class="fa fa-spin fa-cog"></i></span>)</div>
								<div class="grupos"></div>
							</div>
								
							<div class="table" style="margin-top:10px;">
								
								<div class="status">
									<span>LINK TEMPLATE</span>
									<div data-id="<?php echo $row->id_campanha;?>">
										<span id="ati-<?php echo $row->id_campanha;?>" data-status="ativo" <?php echo $row->link == 'ativo' ? 'class="active"' : '';?>>ATIVO</span>
										<span id="ina-<?php echo $row->id_campanha;?>" data-status="inativo" <?php echo $row->link == 'inativo' ? 'class="active"' : '';?>>INATIVO</span>
									</div>
								</div>
								
							</div>
							
							<div class="dados_campanha_<?php echo $row->id_campanha;?> dados-campanha">
								
								<a href="/<?php echo $this->baseModule; ?>/relatorios/abertura/id/<?php echo $row->id_campanha; ?>">
									<span title="Visualizações"><i class="fa fa-eye"></i> Visualizações: <b class="visu"><i class="fa fa-spin fa-cog"></i></b></span>
								</a>
								
								<a href="/<?php echo $this->baseModule; ?>/relatorios/click/id/<?php echo $row->id_campanha; ?>">
									<span title="Cliques"><i class="fa fa-mouse-pointer"></i> Cliques por ação: <b class="clique"><i class="fa fa-spin fa-cog"></i></b></span>
								</a>
	
							</div>
							
							<?php if ($row->status_enviado == 'agendado' || $row->status_enviado == 'incompleto'){ ?>
							
							<div class="status_enviado">
								<a href="/<?php echo $this->baseModule; ?>/campanha-gerenciamento/enviar/id/<?php echo $row->id_campanha; ?>" class="bt_enviar">ENVIAR AGORA</a> 
								<a href="/<?php echo $this->baseModule; ?>/campanha-gerenciamento/agendar/id/<?php echo $row->id_campanha; ?>" class="bt_enviar"><?php echo $row->status_enviado == 'agendado' ? 'REAGENDAR' : 'AGENDAR';?></a> 
							</div>
							
							<?php } elseif ($row->status_enviado == 'processando'){ ?>
							
							<div class="status_enviado">
								<a><i class="fa fa-cog fa-spin"></i> PROCESSANDO ENVIO</a>
							</div>
							
							<?php } elseif ($row->status_enviado == 'lote'){ ?>
							
							<div class="status_enviado">
								<a><i class="fa fa-calendar"></i> AGENDADO POR LOTES</a>
								<a onclick="javascript:delLote('<?php echo $row->id_campanha;?>');"><i class="fa fa-times"></i> CANCELAR</a>
							</div>
							
							<?php } elseif ($row->status_enviado == 'cancelado'){ ?>
							
							<div class="status_enviado">
								<a>Cancelada</a>
							</div>
							
							<?php } elseif ($row->status_enviado == 'finalizado'){ ?>
							
							<div class="status_enviado cor_c">
								<?php echo $row->status_enviado; ?>
								<?php echo $row->status_enviado == "finalizado" ? '<i class="fa fa-paper-plane"></i>' : '';?>
							</div>
							
							<?php } ?>
						
						</div>
							
						<?php } ?>
					</div>
						
					<div class="paginacao">
						<?php echo $this->paginationControl((object)$this->campanhas, 'Sliding', 'layout/paginacao.php'); ?>
				 	</div>
						
				</div>
				
			</div>
		</div>
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

	function delLote(id){

		$(function(){
	
			$.ajax({
		
				url: '<?php echo $this->baseModule;?>/campanha-gerenciamento/del-lote/id_campanha/'+id+'',
				dataType: 'JSON',
				success: function(row){
		
					if (row.total_registros > 0){
	
						delLote(id);
	
					} else {
	
						alert('Campanha cancelada.');
						$('#ina-'+id).trigger('click');
						$('#minha-campanha-'+id).find('.status_enviado').html('<a>Cancelada</a>');
	
					}
					
				}, beforeSend: function(){
	
					$('#minha-campanha-'+id).find('.status_enviado').html('<a><i class="fa fa-cog fa-spin"></i> Carregando</a>');
					
				}
				
			});

		});
		
	}

	$('.status > div > span').click(function(){

		var id = $(this).parent().data('id');
		var status = $(this).data('status');
		var classe = $(this).attr('class');
		var statusClick = $(this).html();
		var bt = $(this);

		if (classe != 'active'){
			$.ajax({

				url: '<?php echo $this->baseModule;?>/campanha-gerenciamento/altera-campanha',
				type: 'POST',
				data: {id:id, status:status},
				dataType: 'JSON',
				success:function(row){

					$(bt).animate({'opacity':'1'});
					
					if (row.erro == 'true'){
						$(bt).parent().parent().find('span').removeClass('active');
						$(bt).addClass('active');
					} else {
						alert(row.retorno);
					}
					console.log(row);
					
				}, beforeSend: function(){

					$(bt).animate({'opacity':'0.4'});
					
				}
				
			});
		}
		
	});

	<?php if (count($this->campanhas) > 0){?>
	$.ajax({
		url: '/<?php echo $this->baseModule; ?>/relatorios/geral-id/id/<?php echo $id; ?>',
		dataType: 'JSON',
		success: function(row){

			$('.box-campanha').each(function(){

				var id = $(this).data('id');
				$(this).find('.total-contatos').html(row[id].total);
				$(this).find('.visu').html(row[id].aberturas);
				$(this).find('.clique').html(row[id].cliques);
				
			});

			loadPage('false');
			
		}, beforeSend: function(){

			loadPage('true');
			
		}
	});
	<?php } ?>

	$('.picker').datepicker({
		dateFormat: 'yy-mm-dd'
	});

	$(function(){

		
		$('.filtro_campanha').click(function(){

			var status = $(this).data('status');
			var d_i = $(this).data('d_i');
			var d_f = $(this).data('d_f');

			$('.data_i').val(d_i);
			$('.d_f').val(d_f);
			
			$('.status_enviado').val(status);

			setTimeout(function(){
				$('#busca').submit();
			},500);
			
			
		});

	});

</script>