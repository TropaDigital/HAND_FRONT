<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i> Caixa de entrada</span>
				</div>
				
				<div class="filtro-pag">
					<form class="filter">
				
						<input type="text" name="data_i_c" class="picker" placeholder="Periodo (data inicial)" value="<?php echo $_GET['data_i_c']?>"/>
						<input type="text" name="data_f_c" class="picker" placeholder="Periodo (data final)" value="<?php echo $_GET['data_f_c']?>"/>
						
						<input name="campanha" placeholder="Buscar por campanha" type="text" value="<?php echo $_GET['campanha']?>"/>
						<input name="celular" placeholder="Buscar por celular" type="text" value="<?php echo $_GET['celular']?>"/>
						
						<input type="submit" class="cor_c_hover" value="Buscar"/>
					
					</form>
				</div>
				
				<?php 
					foreach($this->campanhas as $row):
						$campanha[$row->id_campanha] = $row->campanha;
					endforeach;
				?>
				
				<div class="contatos_lista">
					<table>
					
						<tr>
							<th>Mensagem</th>
							<th>Campanha</th>
							<th>Celular</th>
							<th>Data</th>
						</tr>
						
						<?php foreach($this->sms as $row){?>
						<tr>
							<td>a<?php echo $row->message; ?></td>
							<td><?php echo $campanha[$row->id_campanha]; ?></td>
							<td><?php echo $row->celular; ?></td>
							<td><?php echo date('d/m/Y H:i', $row->incoming_time); ?></td>
						</tr>
						<?php } ?>
						
						<?php if (count((array)$this->sms) == 0): ?>
						<tr>
							<td colspan="4"><i class="fa fa-warning"></i> Nenhum registro encontrado.</td>
						</tr>
						<?php endif; ?>
						
					</table>
					
					<div class="paginacao">
						<?php //echo $this->paginationControl($this->sms, 'Sliding', 'paginacao_site.php'); ?>
					</div>
					
				</div>
				
			</div>
			
			
		</div>
		
	</div>
	
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script type="text/javascript">
	
		$(function () {
	
			$('.picker').datepicker({
				dateFormat: 'dd-mm-yy'
			});
	
			$.datepicker.regional['pt-BR'] = {
				closeText: 'Fechar',
				prevText: '<i class="fa fa-chevron-left"></i>',
				nextText: '<i class="fa fa-chevron-right"></i>',
				currentText: 'Hoje',
				hideIfNoPrevNext: true,
				monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
				monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
				dayNames: ['Domingo','Segunda-feira','Ter&ccedil;a-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sabado'],
				dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
				dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 0,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: ''
			};
			$.datepicker.setDefaults($.datepicker.regional['pt-BR']);
	
			var data_inicio = $('.data_inicio').val();
			var data_final = $('.data_final').val();
			
			var meses = [];
			var totalsms = [];
			var todosSms = 0;
			
			$.ajax({
				url:'/caixa-entrada/ajax',
				type: 'GET',
				dataType: 'JSON',
				data: { data_inicio:data_inicio, data_final:data_final},
				success: function(row){
	
					console.log(row);
					
					for(var i in row) {
	
						var tr = '';
							tr += '<tr>';
							tr += '<td>aaa</td>';
							tr += '<td>aaa</td>';
							tr += '</str>';
							
						$('.campanhas').append(tr);
						
					}
					
				}, beforeSend: function(){
	
					$('#graph-campanhas').html('<i class="fa fa-spin fa-spinner"></i> Carregando');
					
				}	
			});
		
		});
	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>