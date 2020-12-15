<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		
		<div class="box_conteudo">
		
			<div class="box_adc"id="todas">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i><?php echo $this->lg->_("Minhas campanhas"); ?> </span>
				</div>
				
				<div class="filtro-pag">
						
					<form id="busca">
						
						<input type="hidden" name="busca" value="1"/>
						<input type="hidden" name="pagina" class="pagina" value=""/>
						
						<input name="data_i" class="data_i picker" value="<?php echo $_GET['data_i'];?>" placeholder="Data inicial" style="width:65px;" type="text" class="picker"/> 
						<?php echo $this->lg->_("até"); ?> 
						<input name="data_f" value="<?php echo $_GET['data_f'];?>" placeholder="Data final" style="width:65px;" type="text" class="picker d_f"/>
						
						
						<select name="tipo_status" onchange="$(this).parent().submit();">
							<option disabled selected><?php echo $this->lg->_("Tipo de envio"); ?></option>
							<option value=""><?php echo $this->lg->_("Todos status"); ?></option>
							<option <?php echo $_GET['tipo_status'] == 'Não selecionado' ? 'selected' : '';?>><?php echo $this->lg->_("Não selecionado"); ?></option>
							<option <?php echo $_GET['tipo_status'] == 'Lotes' ? 'selected' : '';?>><?php echo $this->lg->_("Lotes"); ?></option>
							<option <?php echo $_GET['tipo_status'] == 'Agendada' ? 'selected' : '';?>><?php echo $this->lg->_("Agendada"); ?></option>
							<option <?php echo $_GET['tipo_status'] == 'Enviar agora' ? 'selected' : '';?>><?php echo $this->lg->_("Enviar agora"); ?></option>
						</select>
						
						<select name="status" onchange="$(this).parent().submit();">
							<option disabled selected><?php echo $this->lg->_("Status da campanha"); ?></option>
							<option value=""><?php echo $this->lg->_("Todos status"); ?></option>
							<option <?php echo $_GET['status'] == 'Preparando campanha' ? 'selected' : '';?>><?php echo $this->lg->_("Preparando campanha"); ?></option>
							<option <?php echo $_GET['status'] == 'Campanha preparada' ? 'selected' : '';?>><?php echo $this->lg->_("Campanha preparada"); ?></option>
							<option <?php echo $_GET['status'] == 'Enviando campanha' ? 'selected' : '';?>><?php echo $this->lg->_("Enviando campanha"); ?></option>
							<option <?php echo $_GET['status'] == 'Campanha enviada' ? 'selected' : '';?>><?php echo $this->lg->_("Campanha enviada"); ?></option>
						</select>
						
						<input name="nome" value="<?php echo $_GET['nome'];?>" placeholder="<?php echo $this->lg->_("Nome da campanha"); ?>" style="padding-right:35px;" type="text"/>
						<button type="submit"><i class="fa fa-search"></i></button>
					
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
					
				<div class="container">
						
					<div class="periodo">
					
						<?php if (count($this->campanhas) == 0){?>
						<h2><?php echo $this->lg->_("Nenhuma campanha encontrada."); ?></h2>
						<?php } ?>
					
						<table class="minhas-campanhas">
						
						<?php foreach($this->campanhas as $row){ $row = (object)$row; ?>
							
							<?php 
							
							    $statusForm = array();
							    $statusForm['0'] = 'Preparando campanha';
							    $statusForm['1'] = 'Campanha preparada';
							    $statusForm['2'] = 'Campanha pausada';
							    $statusForm['3'] = 'Campanha cancelada';
							    $statusForm['4'] = 'Campanha enviada';
							    $statusForm['7'] = 'Sem Saldo';
							    $statusForm['8'] = 'Campanha mal formatada';
							    
							    $statusForm['cancel'] = 'Campanha cancelada';
							    $statusForm['pause'] = 'Envio pausado';
							    
							    if ( $this->production != 'test' ){
							         $statusRedis = $this->redisCampanha->hmget($row->id_campanha, array('status') );
							    }
							    
							    $post = array();
							    $post['status'] = $statusForm[$statusRedis[0]];
							    
							    if ( $row->status_envio_redis == 'cancel' ){
							         $statusRedis[0] = 'cancel';
							    }
							    
							    if ( $row->status_envio_redis == 'pause' ){
							         $statusRedis[0] = 'pause';
							    }
							    
							    if ( $post['status'] ){
							        //print_r( $post );
							        $edt = $this->data->edit($row->id_campanha,$post,NULL,1);
							    }
							    
							    $row->status_enviado = $post['status'];
							    
							    if ( $statusForm[$statusRedis[0]] == 'Campanha preparada' || $statusForm[$statusRedis[0]] == 'Envio pausado' ) {
						            $control = true;
							    } else {
							        $control = false;
							    }
							    
								$bloq = json_decode( $row->bloqueio );
							
								$horas = NULL;
								$datatime1 = new DateTime( $row->modificado );
								$datatime2 = new DateTime( date('Y-m-d H:i:s') );
								
								$data1  = $datatime1->format('Y-m-d');
								$data2  = $datatime2->format('Y-m-d');
								
								$diff = $datatime1->diff($datatime2);
								$horas = $diff->h + ($diff->days * 24);
							
							?>
							
							<tr class="camp-<?php echo $row->id_campanha;?>">
							
								<td>
								
									<div class="submenu-list">
									
										<button class="cor_a_hover">
											<a class="fa fa-info-circle question tooltip" title="<?php echo $this->lg->_("Informações da campanha."); ?>"></a>
										</button>
										
										<ul>
											
											<?php if ( $row->tipo_status == 'Selecionar' || $row->tipo_status == NULL ){ ?>
											<li><a href="javascript:delCamp('<?php echo $row->id_campanha;?>');"><?php echo $this->lg->_("Apagar campanha"); ?></a></li>
											<?php } else { ?>
											<li>
											
												<a><?php echo $this->lg->_("Periodo de envio da campanha"); ?></a>
												<nav>
													<ul>
														<?php foreach ( $this->camp_periodo[$row->id_campanha] as $per ){?>
														
														<li>
														
															<i style="font-weight:bold;"><?php echo $this->lg->_("Início"); ?>:</i> <?php echo date('d/m/Y H:i', strtotime($per['data_i']));?><br/>
															<i style="font-weight:bold;"><?php echo $this->lg->_("Fim"); ?>:</i> <?php echo date('d/m/Y H:i', strtotime($per['data_f']));?><br/>
															<i style="font-weight:bold;"><?php echo $this->lg->_("Quantidade"); ?>:</i> <?php echo $per['qtdade'];?>
														
														</li>
														
														<?php } ?>
													</ul>
												</nav>
											
											</li>
											
											<?php } ?>
											
											<li>
											
												<a><?php echo $this->lg->_("Mensagem da campanha"); ?></a>
												<nav>
													<ul>
														<li><?php echo $row->mensagem;?></li>
													</ul>
												</nav>
											
											</li>
											<li><a href="javascript:preview('<?php echo $row->id_landing_page;?>');"><?php echo $this->lg->_("Template da campanha"); ?></a></li>
										
										</ul>
										
									</div>
									
									<?php if ( $bloq->bloqueio == 's' ){?>
									<div class="submenu-list" style="right:36px;">

										<button class="cor_b_hover">
											<a class="fa fa-lock question tooltip" title="<?php echo $this->lg->_("Campanha bloqueada por senha."); ?>"></a>
										</button>
										
										<ul>
											<li>
												<nav>
												
													<ul>
													
														<li><?php echo $this->lg->_("Nome do botão"); ?>: <?php echo $bloq->nome_botao_cancel == NULL ? 'Não preenchido' : $bloq->nome_botao_cancel;?></li>
														<li><?php echo $this->lg->_("URL do botão"); ?>: <?php echo $bloq->url_botao_cancel == NULL ? 'Não preenchido' : $bloq->url_botao_cancel;?></li>
													
													</ul>
												
												</nav>
												
											</li>
											
											<li><a><?php echo $this->lg->_("Pergunta"); ?>: <?php echo $bloq->titulo_block;?></a></li>
											<li><a><?php echo $this->lg->_("Senha"); ?>: <?php echo $bloq->senha;?></a></li>
										</ul>
										
									</div>
									<?php } ?>
								
									<span title="<?php echo $this->lg->_("Autor da campanha"); ?>" class="cor_font_b tooltip"><i class="fa fa-user"></i> <?php echo $row->nome; ?></span>
									
									<div style="clear:both"></div>
									
									<span title="<?php echo $this->lg->_("Nome da campanha"); ?>" class="cor_font_c tooltip"><i class="fa fa-paper-plane"></i> <?php echo $row->campanha;?></span>
									
									<div style="clear:both"></div>
									
									<span title="<?php echo $this->lg->_("Data de criação"); ?>" class="cor_font_c tooltip"><i class="fa fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($row->criado));?></span>
									
								</td>
							
								<td>
									<b><?php echo $this->lg->_("Link do template"); ?>:</b>
									
									<?php if ( $row->periodo_inicio ) { ?>
									
										<?php 
										
											$pfe = explode(' ', $row->periodo_final);
											$pfi = explode(' ', $row->periodo_inicio);
										
										?>
									
										<?php $row->periodo_final = date('H:i', strtotime( $row->periodo_final ) ) > '23:59' ? '23:59' : $row->periodo_final; ?>
									
										<span><?php echo $this->lg->_("Periodo:"); ?><?php echo date('d/m/Y H:i', strtotime( $row->periodo_inicio )); ?> à <?php echo date('d/m/Y H:i', strtotime( $row->periodo_final )); ?></span>
										
										<a style="margin-top:9px; padding:7px 10px; margin-right:6px;" class="edit-periodo bt-relatorio cor_b_hover tooltipstered tooltip" title="Editar periodo da campanha">
											<i class="fa fa-edit"></i> Editar periodo
										</a>
										
										<form class="change-periodo" action="javascript:changePeriodo('<?php echo $row->id_campanha;?>')">
										
											<a class="fa fa-times edit-periodo"></a>
										
											<div class="start">
    											<label>
                        							<span><?php echo $this->lg->_("Periodo início"); ?></span>
                        							<input required="required" type="text" value="<?php echo explode(' ', $row->periodo_inicio)[0]; ?>" placeholder="Periodo início" name="data-inicio" class="calendario-inicio"/>	
                        						</label>	
                        						
                        						<label>
                        							<span><?php echo $this->lg->_("Horario"); ?></span>
                        							<input required="required" type="text" placeholder="hh:mm" name="hora-inicio" class="horario hora_inicio" value="<?php echo explode(' ', $row->periodo_inicio)[1]; ?>"/>	
                        							<i class="fa fa-clock-o open-time"></i>
                        						</label>	
                    						</div>
                    						
                    						<div class="end">
                    							<label>
                        							<span><?php echo $this->lg->_("Periodo final"); ?></span>
                        							<input required="required" type="text" value="<?php echo explode(' ', $row->periodo_final)[0]; ?>" placeholder="Periodo final" name="data-final" class="calendario-sobre-inicio"/>
                        						</label>	
                        						
                        						<label>
                        							<span><?php echo $this->lg->_("Horario"); ?></span>
                        							<input required="required" type="text" placeholder="hh:mm" name="hora-final" class="horario hora_final" value="<?php echo explode(' ', $row->periodo_final)[1]; ?>"/>	
                        							<i class="fa fa-clock-o open-time"></i>
                        						</label>
                    						</div>
                    						
                    						<div class="end" style="margin-top:0px;">
                    							<button class="cor_a_hover">Atualizar</button>
											</div>
											
										</form>
										
										<?php if ( $row->tipo_status == 'Selecionar' || $row->tipo_status == NULL ){ ?>
										
											<?php 
												$postStatus['status'] = 'inativo'; 
												$edt = $this->dataCamp->edit($row->id_campanha, $postStatus, NULL, 1); 
											?>
											
											<span class="incompleto"><?php echo $this->lg->_("Status: Incompleto"); ?></span>
										
										<?php } else { ?>
										
											<?php 
												if ( date('Y-m-d H:i') > $row->periodo_final ) {
													$postStatus['status'] = 'inativo'; 
													$edt = $this->dataCamp->edit($row->id_campanha,$postStatus,NULL,1); 
												?>
												
												<span class="inativo"><?php echo $this->lg->_("Status: Inativo"); ?></span>
												
											<?php } else { ?>
											
												<?php $postStatus['status'] = 'ativo'; $edt = $this->dataCamp->edit($row->id_campanha,$postStatus,NULL,1); ?>
												<span class="ativo"><?php echo $this->lg->_("Status: Ativo"); ?></span>
											
											<?php } ?>
											
										<?php } ?>
										
									<?php } else {?>
									
										<span><?php echo $this->lg->_("Sem informações."); ?></span>
									
									<?php } ?>
								</td>
								
								<td>
								
									<b><?php echo $this->lg->_("Método de envio:"); ?></b>
									<?php if ( $row->tipo_status == 'Selecionar' || $row->tipo_status == NULL ){ ?>
									
									<select onchange="enviarAction(this, <?php echo $row->id_campanha;?>);">
										<option selected disabled><?php echo $this->lg->_("Selecione"); ?></option>
										<option value="enviar-lote"><?php echo $this->lg->_("Enviar por lotes"); ?></option>
										<option value="enviar"><?php echo $this->lg->_("Enviar agora"); ?></option>
										<option value="agendar"><?php echo $this->lg->_("Agendar envio"); ?></option>
									</select>
									
									<?php } else {?>
									
										<span><?php echo $this->lg->_($row->tipo_status) ;?></span>
										
									<?php } ?>
									
								</td>
							
								<td>
								
									<b><?php echo $this->lg->_("Status de envio"); ?>:</b>
									
									<?php if ( $row->tipo_status == 'Selecionar' || $row->tipo_status == NULL ){ ?>
									
										<span><?php echo $this->lg->_("Campanha incompleta"); ?></span>
									
									<?php } else {?>
									
										<span class="status-campanha">
											<?php echo $statusRedis[0] == NULL ? $this->lg->_('Preparando campanha') : $this->lg->_($statusForm[$statusRedis[0]]); ?>
										</span>
									
									<?php } ?>
									
									<?php if ( $horas < 24 ){ ?>
										<i style="position:absolute; right:10px; top:10px;" class="fa fa-exclamation-circle question tooltip left" title="<?php echo $this->lg->_("Os relatórios dessa campanha podem sofrer alterações no prazo de 24 horas."); ?>"></i>
									<?php } ?>

									<?php if ( $statusRedis[0] == 4 || $statusRedis[0] == 'cancel' ||  $statusRedis[0] == 'pause' || $statusRedis[0] == '1' ) {?>
    									<a class="bt-relatorio cor_c_hover" href="javascript:relatorioCampanha(<?php echo $row->id_campanha;?>);">
    										<?php echo $this->lg->_("Visualizar relatórios"); ?>
    									</a>
									<?php } ?>
									
									<div style="position:absolute; bottom:10px; right:10px; font-size:13px;">
										#<?php echo $row->id_campanha;?>
									</div>
									
									<?php if ( $control && ( $row->tipo_status != 'Selecionar' && $row->tipo_status != NULL ) ){?>
									<div class="control-campgain" data-id="<?php echo $row->id_campanha; ?>">
										
										<a data-status="resume" class="<?php echo $row->status_envio_redis == 'resume' ? 'active' : ''; ?> cor_font_a fa fa-play tooltip" title="Play"></a>
										
										<a data-status="pause" class="<?php echo $row->status_envio_redis == 'pause' ? 'active' : ''; ?> cor_font_a fa fa-pause tooltip" title="Pause"></a>
										
										<?php if ( $row->status_envio_redis == 'resume' || $row->status_envio_redis == 'pause' ){?>
										<a data-status="cancel" class="cor_font_a fa fa-stop tooltip" title="Cancelar"></a>
										<?php } ?>
										
									</div>
									<?php } ?>
									
								</td>
								
							</tr>
							
						<?php } ?>
						
						</table>
						
					</div>
						
					<div class="paginacao">
						<?php echo $this->paginationControl((object)$this->campanhas, 'Sliding', 'layout/paginacao.php'); ?>
				 	</div>
						
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>


		$('.control-campgain a').bind('click', function(){

			if ( !$(this).hasClass('active') ){
			
    			var id = $(this).parent().data('id')
    			var status = $(this).data('status')

				$('.status-campanha').html('<i class="fa fa-spin fa-spinner"></i>')
    
    			console.log( id, status )
    			
    			$('.control-campgain a').removeClass('active')
    			$(this).addClass('active')
    			
    			$.ajax({
    				url: '<?php echo $this->baseModule;?>/campanha/status-envio?id='+id,
    				data: { status_envio_redis: status },
    				type: 'post',
    				dataType: 'json',
    				success: function ( response ){

    					console.log(response)
    				    location.reload()
    				    
    				}, error: function( err ){
    
    					alert('Erro, tente novamente mais tarde.')
    					console.log(err)
    
    				}
    			})

			}
			
		})
	
		function enviarAction (mythis, id){

			var op = $(mythis).val();
			location.href='<?php echo $this->baseModule;?>/campanha-gerenciamento/'+op+'/id/'+id;

		}

		function changePeriodo(id){

			$('.change-periodo button').html('<i class="fa fa-spin fa-spinner"></i>')
			
			var data = $('.camp-'+id+' .change-periodo').serialize()
			
			$.ajax({
				
				url: '<?php echo $this->baseModule;?>/campanha/campanha-periodo?id='+id,
				data: data,
				type: 'post',
				success: function(row){

					console.log(row)
					alert('Periodo atualizado com sucesso.')
					location.reload()
					
				}

			})

		}
		
		function delCamp(id){

			var c = confirm("Tem certeza que deseja apagar essa campanha?");

			if ( c ) {

				$.ajax({
	
					url: '<?php echo $this->baseModule;?>/campanha/campanha-apagar',
					data: {id:id},
					success: function(row){
		
						$('.camp-'+id).remove();
						
					}
	
				});

			}
			
			
		}
	
		$(function(){
	
			$('.picker').datepicker({
				dateFormat: 'yy-mm-dd'
			});

			window.setTimeout(function(){
				$('select').select2('destroy');
			}, 100);

			$('.edit-periodo, .change-periodo .fa-times').bind('click', function(){

				var tr = $(this).parents('tr').attr('class')
				$('.'+tr+' .change-periodo').slideToggle()

			})
			
		});

		$( '.calendario-inicio' ).datepicker({
			
			dateFormat: 'yy-mm-dd',

			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		    nextText: 'Prox',
		    prevText: 'Ant',
			
			onSelect: function() {

				var dataInicio = $('.calendario-inicio').val();
				
				var time = new Date(dataInicio);
				var outraData = new Date();
				outraData.setDate(time.getDate() + 60);

				console.log( outraData );
				
				$( '.calendario-sobre-inicio' ).datepicker("destroy");
				$( '.calendario-sobre-inicio' ).datepicker({ 
					
					minDate: dataInicio, 
					maxDate: outraData,
					dateFormat: 'yy-mm-dd',
					dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
				    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
				    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
				    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
				    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
				    nextText: 'Prox',
				    prevText: 'Ant'
						
				});

				setTimeout( function(){
					
					$('.calendario-sobre-inicio').val('');
		
					console.log(dataInicio.length );
					
					if ( parseFloat(dataInicio.length) > 1 ) {
		
						$( '.calendario-sobre-inicio' ).focus();
						
					} else {
		
						
					}
		
				},500 );
				
			}
			
		});
	</script>

	<?php include_once dirname(__FILE__).'/../layout/footer.php';?>