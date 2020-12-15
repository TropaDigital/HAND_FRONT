<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
				
		<div class="top cor_b">
			<span class="titulo"><i class="fa fa-bars"></i><?php echo $this->lg->_("Relatório de templates comprados"); ?> </span>
		</div>
		
		<div class="filtro-pag">
			<form class="filter">
			
				<input type="hidden" name="p" value="1" />
				<input type="hidden" name="limit" value="100" />
			
				<input name="d_i" class="d_i" placeholder="<?php echo $this->lg->_("Periodo inicial"); ?>" type="text" value="<?php echo $_GET['d_i'] == NULL ? date('Y-m-d') : $_GET['d_i'];?>"/>
				<input name="d_f" <?php echo $_GET['d_f'] == NULL ? 'disabled' : ''; ?> class="d_f" placeholder="<?php echo $this->lg->_("Periodo final"); ?>" type="text" value="<?php echo $_GET['d_f'] == NULL ? date('Y-m-d') : $_GET['d_f']; ?>"/>

                <select name="id_gerenciado" onchange="javascript:$(this).parent().submit();">
                    <option value=""><?php echo $this->lg->_("Todos whitelabel"); ?></option>
                    <?php foreach ( $this->usuarios as $row ){?>
                        <option <?php echo $_GET['id_gerenciado'] == $row->id_usuario ? 'selected' : ''; ?> value="<?php echo $row->id_usuario;?>"><?php echo $row->nome;?></option>
                    <?php } ?>
                </select>

                <select name="id_usuario" onchange="javascript:$(this).parent().submit();">
                    <option value=""><?php echo $this->lg->_("Todos usuarios"); ?></option>
                    <?php foreach ( $this->usuarios_unicos as $row ){?>
                        <option <?php echo $_GET['id_usuario'] == $row->id_usuario ? 'selected' : ''; ?> value="<?php echo $row->id_usuario;?>"><?php echo $row->empresa;?></option>
                    <?php } ?>
                </select>
				
				<button type="submit"><i class="fa fa-search"></i></button>
				
			</form>
		
		</div>
		
		<div class="listagem">
			
			<table style="border-radius:0px;">
					
				<tr>
				
					<th>Cliente</th>
					<th>Usuário</th>
                    <th>Whitelabel</th>
                    <th>Valor</th>
					
				</tr>
				
				<?php if ( count($this->result) == 0 ) {?>
				
					<tr>
					
						<td colspan="3"><?php echo $this->lg->_("Nenhum registro encontrado."); ?></td>
					
					</tr>
				
				<?php } else { ?>
					
				<?php 

				    foreach( $this->result as $row ){ ?>
				
					<tr>
					
						<td><?php echo $row->empresa; ?></td>
						<td><?php echo $row->name_user; ?></td>
                        <td><?php echo $row->whitelabel; ?></td>
                        <td><?php echo $row->valor;?></td>
					
					</tr>
					<?php } ?>
				
				<?php } ?>
			
			</table>
			
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