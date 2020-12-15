<?php include_once dirname(__FILE__).'/../layout/header.php';?>
	
	<div class="div_content">
	
		<div class="filtro-pag" style="margin-top:108px; margin-bottom:0px;">
		
			<form action="/<?php echo $this->baseModule;?>/index" method="get" class="busca-periodo">
				
				<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione o intervalo de tempo no qual deseja realizar a sua pesquisa"); ?>"></i>
				
				<i class="fa fa-calendar"></i>
				<input readonly type="text" placeholder="Data inicial" name="d_i" class="data_inicio" value="<?php echo $_GET['d_i'] != '' ? $_GET['d_i'] : date('d-m-Y');?>"/>
				
				<i class="fa fa-calendar"></i>
				<input readonly type="text" placeholder="Data final" name="d_f" class="data_final" value="<?php echo $_GET['d_f'] != '' ? $_GET['d_f'] : date('d-m-Y');?>"/>
				
				<button type="submit"><i class="fa fa-search"></i></button>
			</form>
		
		</div>
	
		<div class="box_conteudo conteudo" style="margin-top:-10px;">
		
			<div class="box-geral">
			
				<a class="box cor_a_hover">
					<span class="total"><?php echo $this->campanhas_ativas; ?></span>
					<span class="name"><i class="fa fa-comments-o"></i> <?php echo $this->lg->_("Campanhas ativas"); ?></span>
				</a>
			
				<a class="box cor_a_hover">
					<span class="total"><?php echo $this->campanhas;?></span>
					<span class="name"><i class="fa fa-paper-plane"></i> <?php echo $this->lg->_("Campanhas enviadas"); ?></span>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Campanhas que já foram enviadas para os contatos selecionados"); ?>"></i>
				</a>
				
				<a class="box cor_a_hover">
					<span class="total"><?php echo $this->creditos_usados == NULL ? 0 : $this->creditos_usados;?></span>
					<span class="name"><i class="fa fa-credit-card"></i> <?php echo $this->lg->_("Créditos utilizados"); ?></span>
					<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Créditos que já foram gastos com envios de campanhas"); ?>"></i>
				</a>
				
				<a class="box cor_a_hover">
					<span class="total"><?php echo $this->aberturas; ?></span>
					<span class="name"><i class="fa fa-eye"></i> <?php echo $this->lg->_("Visualizações"); ?></span>
					<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Links de campanhas abertas"); ?>"></i>
				</a>
			
			</div>
			
			<div class="box-bg-white">
    			
    			
    			<div class="graph-index">
    			
        			<table class="table-index">
        					
        				<tr>
        					<td width="110"><b><?php echo $this->lg->_("Fila"); ?></b></td>
        					<td><?php echo $this->sintetico_current->fila;?></td>
        				</tr>
        				
        				<tr>
        					<td><b><?php echo $this->lg->_("Erros"); ?></b></td>
        					<td><?php echo $this->sintetico_current->erros;?></td>
    					</tr>
    					
    					<tr>
        					<td><b><?php echo $this->lg->_("Enviados"); ?></b></td>
        					<td><?php echo $this->sintetico_current->envios;?></td>
        					
    					</tr>
    					
    					<tr>
        					<td><b><?php echo $this->lg->_("Confirmados"); ?></b></td>
        					<td><?php echo $this->sintetico_current->entregues;?></td>
    					</tr>
    					
    					<tr>
        					<td><b><?php echo $this->lg->_("Não entregues"); ?></b></td>
        					<td><?php echo $this->sintetico_current->nao_entregues;?></td>
    					</tr>
        					
        			</table>
    			
    			</div>
    			
    			<div class="graph-index">
    			
    				<div id="graph"></div>
    			
    			</div>
    			
    			<div class="graph-index">
    			
    				<div class="head">
        				<div class="title"><?php echo $this->lg->_("Caixa de entrada"); ?></div>
        				<div class="subtitle"><?php echo $this->caixa_entrada->total_registros;?> <?php echo $this->lg->_("msgs"); ?></div>
        			</div>
        			
    				<table class="table-index">
    				
    					<?php foreach ( $this->caixa_entrada->registros as $row ){?>
    					<tr>
    						<td width="20"><?php echo date('d/m/Y H:i:s', strtotime($row->criado));?></td>
    						<td width="80"><?php echo $row->celular; ?></td>
    						<td><?php echo $row->msg_resp; ?></td>
    					</tr>
    					<?php } ?>
    				
    				</table>
    			
    			</div>
			
			</div>
	
		</div>
		
	</div>

    <script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>

	$(function () {

		<?php if ( $this->sintetico_current->fila > 0 || $this->sintetico_current->erros || $this->sintetico_current->envios ) {?>
		Highcharts.chart('graph', {
			credits: {
						enabled: false
		    },
		    exporting: {
		         enabled: false
		    },
		    chart: {
		        plotBackgroundColor: null,
		        plotBorderWidth: null,
		        plotShadow: false,
		        type: 'pie',
		    },
		    title: {
		        text: ''
		    },
		    tooltip: {
		        pointFormat: '{series.name}: <b>{point.y}</b>'
		    },
		    plotOptions: {
		        pie: {
		            allowPointSelect: true,
		            cursor: 'pointer',
		            dataLabels: {
		                enabled: true
		            },
		            showInLegend: true
		        }
		    },
		    series: [{
		    		colors:["#2196f3","#f44336","#4caf50"],
		        name: 'SMS',
		        colorByPoint: true,
		        data: [{
		            name: '<?php echo $this->lg->_("Fila"); ?>',
		            y: <?php echo $this->sintetico_current->fila == NULL ? '0' : $this->sintetico_current->fila;?>,
		        }, {
		            name: '<?php echo $this->lg->_("Erros"); ?>',
		            y: <?php echo $this->sintetico_current->erros == NULL ? '0' : $this->sintetico_current->erros;?>
		        }, {
		            name: '<?php echo $this->lg->_("Envios"); ?>',
		            y: <?php echo $this->sintetico_current->envios == NULL ? '0' : $this->sintetico_current->envios;?>
		        }]
		    }]
		});
		<?php } ?>
		
		// calendar date
		$('.data_inicio, .data_final').datepicker({
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

	});

	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>