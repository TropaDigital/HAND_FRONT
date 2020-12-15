<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc" id="todas">
			
				<div class="contatos_lista" style="padding:0px;">
						
					<table class="campanha">
						
						<tr>
							<th>Campanha</th>
							<th>Lista</th>
							<th>Qtde/Contatos</th>
							<th>Mensagem</th>
							<th>Referencia</th>
							<th>Bloqueado por senha</th>
							<th>Periodo inicial</th>
							<th>Periodo final</th>
						</tr>
						
						<tr>
							<td><?php echo $this->campanhas[0]->campanha; ?></td>
							<td><?php echo $this->nomeLista;?></td>
							<td><?php echo $this->totalContatos;?></td>
							<td><?php echo $this->campanhas[0]->mensagem; ?></td>
							<td><?php echo $this->campanhas[0]->referencia == 0 ? 'Não' : 'Sim'; ?></td>
							<td><?php echo json_decode($this->campanhas[0]->bloqueio)->bloqueio == 'n' ? 'Não' : 'Sim'; ?></td>
							<td><?php echo date('d/m/Y H:i', strtotime($this->campanhas[0]->periodo_inicio)); ?></td>
							<td><?php echo date('d/m/Y H:i', strtotime($this->campanhas[0]->periodo_final)); ?></td>
						</tr>
					
					</table>
					
				</div>
				
				<div class="envio-lote-div">
				
					<?php if ( $this->totalContatos > $this->sms_disponivel ){?>
					
						<p class="insu">Créditos insuficiente.</p>
					
					<?php } else { ?>
					
					<form action="javascript:valida()" method="post">
						
						<input type="hidden" name="status" value="Enviar Agora"/>
						<input type="hidden" name="id_campanha" value="<?php echo $this->id;?>"/>
						<input type="hidden" name="total" value="" class="total_contatos_sms_input"/>
						<input type="hidden" name="total_contatos_geral" value="<?php echo $this->totalContatos;?>"/>
						
						<a class="del" href="<?php echo $this->baseModule;?>/campanha-gerenciamento/del/id/<?php echo $this->id;?>">Cancelar campanha <i class="fa fa-trash"></i></a>
						<input type="submit" class="salvar-periodo cor_a_hover" value="Enviar agora"/>
					
					</form>
					<?php } ?>
				
				</div>
				
				<div id="nome-lista" class="celulares" style="text-align:center; display:none;">
						
					<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
					<script>
	
						function celular(tipo){
							
							$('.celulares').slideDown(500);
							$('.celulares > div').hide(0);
							$('.celulares > div.'+tipo).show();
		
							var href = $('.celulares > div.'+tipo).find('iframe').attr('src');
							$('.celulares > div.'+tipo).find('iframe').attr('src',href);
		
						}
		
						$(function(){
							$('.fechar-celulares').click(function(){
								$('.celulares').slideUp(500);
							});
						});
	
					
						function newPeriodo(){

							var periodo  = '<fieldset class="periodo-conta" style="display:none;">';
								periodo += '<legend>Periodo <i class="fa fa-times" onclick="delPeriodo(this);"></i></legend>';		
								periodo += '<input required type="text" class="datepicker"  value="<?php echo date('Y-m-d')?>" name="data[0][]" placeholder="Data">';	
								periodo += '<input required type="text" name="hora_i[0][]" value="<?php echo date('H:i')?>" class="horario" placeholder="Hora inicial">';
								periodo += '<input required type="text" name="hora_f[0][]" value="<?php echo date('H:i')?>" class="horario" placeholder="Hora final">';
								periodo += '<input required type="text" name="qtdade[0][]" value="<?php echo $this->totalContatos;?>" class="qtdade" onchange="validaTotal();" placeholder="Qtade sms">';	
								periodo += '</fieldset>';					

							$('.salvar-periodo').before(periodo);

							$(".datepicker").datepicker({
								dateFormat: "yy-mm-dd",
								minDate: 0
							});

							$(".horario").mask("99:99");
							$(".qtdade").mask("9999999999");
								
						}

						function delPeriodo(div){

							$(div).parent().parent().remove();

						}

						function validaTotal(){

							$(function(){
	
								var total = parseInt(0);
								
								$('.qtdade').each(function(){
	
									var myInt = parseInt($(this).val());
									total = total + myInt;
									
								});

								$('.total_contatos_sms_input').val(total);
								
							});

						}

						function valida(){

							var action = '<?php echo $this->baseModule;?>/campanha-gerenciamento/new-lote/';
							var total_periodos = $('.total_contatos_sms_input').val();
							var max_contatos = '<?php echo $this->totalContatos;?>';
							var conta = total_periodos - max_contatos;

							
							if (parseInt(total_periodos) > parseInt(max_contatos)){
								alert('Você selecionou uma quantidade de contatos maior que a sua lista, diminua '+conta+' contatos entre os periodos para avançar.');
							} else {

								$('.envio-lote-div form').attr('action',action);
								$('.envio-lote-div form input[type="submit"]').attr('style','display:none');
								$('.envio-lote-div form').append('<div class="load-send">Carregando <i class="fa fa-spin fa-cog"></i></div>');
								
								setTimeout(function(){

									$('.envio-lote-div form').submit();

								},200);
								
							}
							
						}
						
						newPeriodo();
						
					</script>
					
					<a class="fechar-celulares">FECHAR</a>
						
					<div class="celular-miniatura msg" style="float:none; margin-right:-80px; display:inline-block;">
						<div class="conteudo_cel">
							<div class="topo-sms"><?php echo $this->campanhas[0]->campanha; ?></div>
							<div class="avatar">
								<i class="fa fa-user"></i>
							</div>
							<div class="seta"></div>
							<div class="balao_mensagem" style="text-align:left;"><?php echo $this->campanhas[0]->mensagem; ?></div>
						</div>
					</div>
						
					<div style="display:inline-block; vertical-align:top; width:50px;"></div>
						
				</div>
				
			</div>
		</div>
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>