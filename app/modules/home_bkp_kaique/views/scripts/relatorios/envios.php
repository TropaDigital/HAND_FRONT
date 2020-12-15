<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i><?php echo $this->lg->_("Relatorio de Envio Analitico"); ?> </span>
				</div>
				
				<div class="filtro-pag">
					<form class="filter">
					
						<input type="hidden" name="p" value="1" />
						<input type="hidden" name="limit" value="100" />
					
						<input name="d_i" class="d_i" placeholder="<?php echo $this->lg->_("Periodo inicial"); ?>" type="text" value="<?php echo $_GET['d_i'] == NULL ? date('Y-m-d') : $_GET['d_i']; ?>"/>
						<input name="d_f" <?php echo $_GET['d_f'] == NULL ? 'disabled' : ''; ?> class="d_f" placeholder="<?php echo $this->lg->_("Periodo final"); ?>" type="text" value="<?php echo $_GET['d_f'] == NULL ? date('Y-m-d') : $_GET['d_f']; ?>"/>
					
						<select name="id_campanha" onchange="javascript:$(this).parent().submit();">
							<option value=""><?php echo $this->lg->_("Todas campanhas"); ?></option>
							<?php foreach ( $this->campanhas as $row ){?>
							<option <?php echo $_GET['id_campanha'] == $row->id_campanha ? 'selected' : ''; ?> value="<?php echo $row->id_campanha;?>"><?php echo $row->campanha;?></option>
							<?php } ?>
						</select>
						
						<select name="status" onchange="javascript:$(this).parent().submit();">
							<option value=""><?php echo $this->lg->_("Todos status"); ?></option>
							<option <?php echo $_GET['status'] == 'PEND' ? 'selected' : ''; ?> value="PEND"><?php echo $this->lg->_("Pendente"); ?></option>
							<option <?php echo $_GET['status'] == 'ESME_ROK|ACCEPTD' ? 'selected' : ''; ?> value="ESME_ROK|ACCEPTD"><?php echo $this->lg->_("Enviada"); ?></option>
							<option <?php echo $_GET['status'] == 'DELIVRD' ? 'selected' : ''; ?> value="DELIVRD"><?php echo $this->lg->_("Entregue"); ?></option>
							<option <?php echo $_GET['status'] == 'UNDELIV' ? 'selected' : ''; ?> value="UNDELIV"><?php echo $this->lg->_("Não entregue"); ?></option>
							<option <?php echo $_GET['status'] == 'EXPIRED' ? 'selected' : ''; ?> value="EXPIRED"><?php echo $this->lg->_("Expirada"); ?></option>
							<option <?php echo $_GET['status'] == 'ERROR' ? 'selected' : ''; ?> value="ERROR|REJECTED"><?php echo $this->lg->_("Erro ao enviar"); ?></option>
						</select>
						
						
						<select name="rejeitados" onchange="javascript:$(this).parent().submit();">
							<option value=""><?php echo $this->lg->_("Abertos/Não abertos"); ?></option>
							<option <?php echo $_GET['rejeitados'] == 'on' ? 'selected' : ''; ?> value="on"><?php echo $this->lg->_("Aberto"); ?></option>
							<option <?php echo $_GET['rejeitados'] == 'off' ? 'selected' : ''; ?> value="off"><?php echo $this->lg->_("Não aberto"); ?></option>
						</select>
					
						<input name="mensagem" placeholder="<?php echo $this->lg->_("Mensagem"); ?>" type="text" value="<?php echo $_GET['mensagem']?>"/>
						
						<input name="celular" placeholder="<?php echo $this->lg->_("Celular"); ?>" type="text" value="<?php echo $_GET['celular']?>"/>
						
						<button type="submit"><i class="fa fa-search"></i></button>
						
						<a href="javascript:downloadPag();" class="download-page cor_font_a_hover">
						
							<span>
								<i class="fa fa-download" aria-hidden="true"></i>
							</span>
							
							<?php echo $this->lg->_("Download"); ?>
							
							<i class="fa fa-question-circle question tooltip left"  title="<?php echo $this->lg->_("Download do resultado no formato CSV separado por ponto e virgula."); ?>"></i>
						
						</a>
						
						<fieldset>
						
							<legend><?php echo $this->lg->_("Usuarios"); ?></legend>
							
							<?php $_GET['id_usuario'] = $_GET['id_usuario'] == NULL ? array('0'=>'0') : $_GET['id_usuario']; ?>
							<?php foreach( $this->familia as $row ){?>
							<label>
							
								<input onchange="javascript:$(this).parents('form').submit();" type="checkbox" name="id_usuario[]" value="<?php echo $row->id_usuario;?>" <?php if ( in_array( $row->id_usuario, $_GET['id_usuario'] ) ) { echo 'checked'; }?> />
								<span><?php echo $row->name_user;?></span>
							
							</label>
							<?php }?>
						
						</fieldset>
						
						<!-- CHECKBOX -->
						<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
						<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
						<script>
							$('input[type="checkbox"]').checkboxradio();;
						</script>
					
					</form>
				
				</div>
				
				<div class="contatos_lista">
				
					<fieldset class="mostrar_quanto">
					
						<span style="float:left; margin-left:0px;"><?php echo $this->lg->_("Resultados por página"); ?></span>
						<select>
							<option <?php echo $_GET['limit'] == 10 ? 'selected' : '';?> <?php echo $_GET['limit'] == NULL ? 'selected' : '';?> value="10">10</option>
							<option <?php echo $_GET['limit'] == 25 ? 'selected' : '';?> value="25">25</option>
							<option <?php echo $_GET['limit'] == 50 ? 'selected' : '';?> value="50">50</option>
							<option <?php echo $_GET['limit'] == 100 ? 'selected' : '';?> value="100">100</option>
							<option <?php echo $_GET['limit'] == 250 ? 'selected' : '';?> value="250">250</option>
							<option <?php echo $_GET['limit'] == 500 ? 'selected' : '';?> value="500">500</option>
						</select>
						
						<a class="cor_a_hover">
							<i class="fa fa-list-ul" aria-hidden="true"></i>
							<?php echo $this->lg->_("Paginação"); ?>
						</a>
						
						<span class="total_registros">
						
							<b><?php echo $this->result->total_registros;?></b> <?php echo $this->lg->_("registros encontrados."); ?>
						
						</span>
						
						<span>
						
							<b><?php echo count ( (array)$this->result->registros );?></b> <?php echo $this->lg->_("registros listados."); ?>
						
						</span>
					
					</fieldset>
					
					<div class="paginacao top-pag" style="display:none; border-radius: 0px 0px 8px 8px; margin-top: -3px;margin-bottom: 20px;padding: 15px;border: none;background: #c6c6c6;"></div>
					
					<table style="border-radius:0px;">
					
						<tr>
						
							<th><?php echo $this->lg->_("#ID campanha"); ?></th>
							<th><?php echo $this->lg->_("Celular"); ?></th>
							<th><?php echo $this->lg->_("Campanha"); ?></th>
							<th><?php echo $this->lg->_("Mensagem"); ?></th>
							<th><?php echo $this->lg->_("Status"); ?></th>
							<th style="display: none;"><?php echo $this->lg->_("Texto status"); ?></th>
							<th style="display: none;"><?php echo $this->lg->_("Operadora"); ?></th>
							<th><?php echo $this->lg->_("Aberto"); ?> <i class="fa fa-question-circle question tooltip left"  title="<?php echo $this->lg->_("Contatos que receberam o SMS mas não abriram o template."); ?>"></i></th>
							<th><?php echo $this->lg->_("Referencia"); ?></th>
							<th><?php echo $this->lg->_("Data de envio"); ?></th>
							<th><?php echo $this->lg->_("Data de status"); ?></th>
							
						</tr>
						
						<?php if ( $this->result->total_registros == 0 ) {?>
						
							<tr>
							
								<td colspan="10"><?php echo $this->lg->_("Nenhum registro encontrado."); ?></td>
							
							</tr>
						
						<?php } else { ?>
							
							<?php 
							
								foreach( $this->result->registros as $row ){
									
								$horas = NULL;
								$datatime1 = new DateTime( $row->data_lote );
								$datatime2 = new DateTime( date('Y-m-d H:i:s') );
								
								$data1  = $datatime1->format('Y-m-d');
								$data2  = $datatime2->format('Y-m-d');
								
								$diff = $datatime1->diff($datatime2);
								$horas = $diff->h + ($diff->days * 24);
								
								$status = [];
								$status[''] = 'Pendente';
								$status['ESME_ROK'] = 'Enviada';
								$status['ACCEPTD'] = 'Enviada';
								$status['DELIVRD'] = 'Entregue';
								$status['UNDELIV'] = 'Não entregue';
								$status['EXPIRED'] = 'Expirada';
								$status['REJECTED'] = 'Erro ao enviar';
								$status['REJECTD'] = 'Erro ao enviar';
								$status['ERROR'] = 'Erro ao enviar';
								$status['ESME_RINVDSTADR'] = $status['ERROR'];
								
							?>
							<tr>
							
								<td><?php echo $row->id_campanha; ?></td>
								<td>
								
									<?php echo $row->celular; ?><br/>
									
									<?php if ( $row->id_lista != NULL ) {?>
										<a target="_blank" href="<?php echo $this->baseModule;?>/contatos/editar/id/<?php echo $row->id_contato;?>?il=<?php echo $row->id_lista;?>"><i class="fa fa-external-link" aria-hidden="true"></i><?php echo $this->lg->_(" Ir para o contato"); ?></a>
									<?php } else { ?>
										<a style="cursor:auto"><?php echo $this->lg->_("Contato não encontrado. "); ?><i class="fa fa-question-circle question tooltip"  title="<?php echo $this->lg->_("Pode ser que esse contato tenha sido excluido."); ?>"></i></a>
									<?php } ?>
									
								</td>
								<td>
								
									<?php if ( $row->id_campanha == '0' ){?>
									<span style="border:1px solid rgba(0,0,0,0.1); padding:5px 10px; text-transform:uppercase; background:rgba(0,0,0,0.1); border-radius:5px; display: inline-block;">Envio de teste</span>
									<?php } else {?>
									<a href="javascript:relatorioCampanha(<?php echo $row->id_campanha;?>);"><?php echo $row->campanha;?></a>
									<?php } ?>
									
								
								</td>
								<td><?php echo str_replace('[zig=interrogazao]', '?', $row->mensagem);?></td>
								<td>
								
									<?php echo $status[$row->status]; ?>
								
								</td>
								<td>
									<?php echo $row->rejeicao_data == NULL ? 'Não' : 'Sim';?>
								</td>
								<td><?php echo $row->referencia == '' ? 'N/A' : $row->referencia; ?></td>
								<td>
								
									<?php 
									
										if ( date('Y-m-d H:i') < $row->data_lote ) {
											echo 'Agendado para: '.str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
										} else {
											echo str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
										}
									
									?>
								
								</td>
								<td>
									<?php 
									
										if ( $row->data_recibo == NULL && $horas >= 24 ) {

											if ( date('Y-m-d H:i') < $row->data_lote ) {
												echo 'Agendado para: '.str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
											} else {
												echo str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
											}
											
										} else {
											
											echo $row->data_recibo == NULL ? 'Sem informações' : str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_recibo ) ) );
											
										}
										
									?>
								</td>
							
							</tr>
							<?php } ?>
						
						<?php } ?>
					
					</table>
					
					<div class="paginacao bottom-pag">
					
						<div class="pages">
							<?php if ( $_GET['p'] > 6 ) {?>
								<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=1"><?php echo $this->lg->_("Primeira página"); ?></a>
							<?php } ?>
							
							<?php foreach($this->result->paginacao as $row):?>
							<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=<?php echo $row;?>" <?php echo $_GET['p'] == $row ? 'class="inativo"' : '';?>><?php echo $row;?></a>
							<?php endforeach;?>
							
							<?php if ( $_GET['p'] != $this->result->total_page ) {?>
								<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=<?php echo $this->result->total_page?>"><?php echo $this->lg->_("Ultíma página"); ?></a>
							<?php } ?>
						</div>
						
						<div class="ir_para">
						
							<?php echo $this->lg->_("Ir para página"); ?>	
							<input type="number" max="<?php echo $this->result->total_page; ?>" class="ir_para_pagina" value="<?php echo $_GET['p'] == NULL ? '1' : $_GET['p'];?>"/>
						
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php';?>