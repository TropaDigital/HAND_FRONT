<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
				
		<div class="top">
			<span class="titulo"><i class="fa fa-bars"></i><?php echo $this->lg->_("Relatório de SMS Analitico"); ?> </span>
		</div>
		
		<div class="filtro-pag">
			<form class="filter">
			
				<input type="hidden" name="p" value="1" />
				<input type="hidden" name="limit" value="100" />
			
				<input name="d_i" class="d_i" placeholder="<?php echo $this->lg->_("Periodo inicial"); ?>" type="text" value="<?php echo $_GET['d_i'] == NULL ? date('Y-m-d') : $_GET['d_i']; ?>"/>
				<input name="d_f" class="d_f" placeholder="<?php echo $this->lg->_("Periodo final"); ?>" type="text" value="<?php echo $_GET['d_f'] == NULL ? date('Y-m-d') : $_GET['d_f']; ?>"/>
			
				<select name="id_usuario" onchange="javascript:$(this).parent().submit();">
					<option value=""><?php echo $this->lg->_("Todos whitelabel"); ?></option>
					<?php foreach ( $this->usuarios as $row ){?>
					<option <?php echo $_GET['id_usuario'] == $row->id_usuario ? 'selected' : ''; ?> value="<?php echo $row->id_usuario;?>"><?php echo $row->nome;?></option>
					<?php } ?>
				</select>
				
				<select name="id_usuario_unico" onchange="javascript:$(this).parent().submit();">
					<option value=""><?php echo $this->lg->_("Todos usuarios"); ?></option>
					<?php foreach ( $this->usuarios_unicos as $row ){?>
					<option <?php echo $_GET['id_usuario_unico'] == $row->id_usuario ? 'selected' : ''; ?> value="<?php echo $row->id_usuario;?>"><?php echo $row->empresa;?></option>
					<?php } ?>
				</select>
				
				<select name="status" onchange="javascript:$(this).parent().submit();">
					<option value=""><?php echo $this->lg->_("Todos status"); ?></option>
					<option <?php echo $_GET['status'] == 'PEND' ? 'selected' : ''; ?> value="PEND"><?php echo $this->lg->_("Pendente"); ?></option>
					<option <?php echo $_GET['status'] == 'enviada' ? 'selected' : ''; ?> value="enviada"><?php echo $this->lg->_("Enviada"); ?></option>
					<option <?php echo $_GET['status'] == 'entregue' ? 'selected' : ''; ?> value="entregue"><?php echo $this->lg->_("Entregue"); ?></option>
					<option <?php echo $_GET['status'] == 'não entregue' ? 'selected' : ''; ?> value="não entregue"><?php echo $this->lg->_("Não entregue"); ?></option>
					<option <?php echo $_GET['status'] == 'aceita' ? 'selected' : ''; ?> value="aceita"><?php echo $this->lg->_("Aceita"); ?></option>
					<option <?php echo $_GET['status'] == 'expirada' ? 'selected' : ''; ?> value="expirada"><?php echo $this->lg->_("Expirada"); ?></option>
					<option <?php echo $_GET['status'] == 'erro ao enviar' ? 'selected' : ''; ?> value="erro ao enviar"><?php echo $this->lg->_("Erro ao enviar"); ?></option>
				</select>
				
				<input name="mensagem" placeholder="<?php echo $this->lg->_("Mensagem"); ?>" type="text" value="<?php echo $_GET['mensagem']?>"/>
				<input name="celular" placeholder="<?php echo $this->lg->_("Celular"); ?>" type="text" value="<?php echo $_GET['celular']?>"/>
				<button type="submit"><i class="fa fa-search"></i></button>
				
			</form>
		
		</div>
		
		<div class="listagem">
		
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
				
					<th><?php echo $this->lg->_("#ID Campanha"); ?></th>
					<th><?php echo $this->lg->_("Celular"); ?></th>
					<th><?php echo $this->lg->_("Campanha"); ?></th>
					<th><?php echo $this->lg->_("Mensagem"); ?></th>
					<th><?php echo $this->lg->_("Status"); ?></th>
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
						$status['REJECTED'] = 'Não aberto';
						$status['ESME_RINVDSTADR'] = $status['ERROR'];
						
					
					?>
					<tr>
					
						<td>
							<?php echo $row->id_campanha; ?><br/>
						</td>
						<td>
							<?php echo $row->celular; ?><br/>
						</td>
												<td>
							<?php if ( $row->id_campanha == '0' ){?>
    							<span style="border:1px solid rgba(0,0,0,0.1); padding:5px 10px; text-transform:uppercase; background:rgba(0,0,0,0.1); border-radius:5px; display: inline-block;">Envio de teste</span>
    							<?php } else {?>
    							<?php echo $row->campanha; ?>
							<?php } ?>
						</td>
						<td><?php echo str_replace('[zig=interrogazao]', '?', $row->mensagem);?></td>
						<td><?php echo $status[$row->status];?></td>
						<td>
						
							<?php 
							
								if ( date('Y-m-d H:i') < $row->data_lote ) {
									echo 'Agendado para: '.str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
								} else {
									echo str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
								}
							
							?>
						
						</td>
						<td><?php echo $row->data_recibo; ?></td>
					
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
	
	<script>
	
    	// functions visual page
    	$('.mostrar_quanto a').bind('click', function(){
    	
    		$('.paginacao.top-pag').slideToggle();
    		
    	});
    	
    	var paginacao_bottom = $('.paginacao.bottom-pag').html();
    	$('.paginacao.top-pag').html(paginacao_bottom);
    	
    	setTimeout(function(){
    		
    		$('.mostrar_quanto select').select2("destroy");
    		
    	}, 10);
    	
    	$(document).on('change', '.mostrar_quanto select', function(){
    	
    		$('input[name="limit"]').val( $(this).val() );
    	
    		setTimeout( function () {
    	
    			$('.filter').submit();
    			
    		}, 500);
    		
    	});
    	
    	$(document).on('change', '.ir_para_pagina', function(){
    	
    		var p = $(this).val();
    		var max = $(this).attr('max');
    	
    		if ( parseFloat( p ) > parseFloat( max ) ) {
    	
    			p = max;
    	
    		}
    		
    		$('input[name="p"]').val( p );
    	
    		setTimeout( function () {
    	
    			$('.filter').submit();
    			
    		}, 500);
    		
    	});
    	
    	// set calendario for class .d_i and .d_f
    	calendarioPorPeriodo('.d_i', '.d_f', 60);

    	function calendarioPorPeriodo ( d_i, d_f, max ){
    		
    		var dataInicio = $(d_i).val();
    		
    		var time = new Date(dataInicio);
    		var outraData = new Date();
    		outraData.setDate(time.getDate() + parseFloat(max) );
    		
    		$( d_f ).datepicker({ 
    			
    			minDate: dataInicio, 
    			maxDate: outraData,
    			dateFormat: 'yy-mm-dd',
    			dayNames: ['Domingo','Segunda','TerÃ§a','Quarta','Quinta','Sexta','SÃ¡bado'],
    		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','SÃ¡b','Dom'],
    		    monthNames: ['Janeiro','Fevereiro','MarÃ§o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    		    nextText: 'Prox',
    		    prevText: 'Ant'
    				
    		});
    		
    		$( d_i ).datepicker({
    		
    			dateFormat: 'yy-mm-dd',
    		
    			dayNames: ['Domingo','Segunda','TerÃ§a','Quarta','Quinta','Sexta','SÃ¡bado'],
    		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','SÃ¡b','Dom'],
    		    monthNames: ['Janeiro','Fevereiro','MarÃ§o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    		    nextText: 'Prox',
    		    prevText: 'Ant',
    			
    			onSelect: function() {
    		
    				var dataInicio = $(d_i).val();
    				
    				var time = new Date(dataInicio);
    				var outraData = new Date();
    				outraData.setDate(time.getDate() + max);
    		
    				$( d_f ).datepicker("destroy");
    				$( d_f ).datepicker({ 
    					
    					minDate: dataInicio, 
    					maxDate: outraData,
    					dateFormat: 'yy-mm-dd',
    					dayNames: ['Domingo','Segunda','TerÃ§a','Quarta','Quinta','Sexta','SÃ¡bado'],
    				    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    				    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','SÃ¡b','Dom'],
    				    monthNames: ['Janeiro','Fevereiro','MarÃ§o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    				    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    				    nextText: 'Prox',
    				    prevText: 'Ant'
    						
    				});
    		
    		
    				setTimeout( function(){
    		
    					console.log( dataInicio );
    					
    					$(d_f).val('');
    		
    					console.log(dataInicio.length );
    					
    					if ( parseFloat(dataInicio.length) > 1 ) {
    		
    						$( d_f ).removeAttr('disabled');
    						$( d_f ).focus();
    						
    					} else {
    		
    						$( d_f ).attr('disabled','true');
    						
    					}
    		
    				},500 );
    				
    			}
    			
    		});
    		
    	}
    	
	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>