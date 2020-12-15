<!DOCTYPE html>
<html lang="pt-br">
<head>
	<base href="/">
	
	<meta charset="UTF-8">
	<title>HANDMKT - Sistema</title>
	<link rel="stylesheet" type="text/css" href="assets/admin/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/admin/css/spinner.css">
	<?php echo $this->cssPag; ?>
	<link rel="stylesheet" type="text/css" href="assets/home/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/calendario.css">
	<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,700,700italic,900,300,300italic' type='text/css'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />
  	<link rel="stylesheet" href="assets/admin/css/pe-icon-7-stroke.css" rel="stylesheet" />
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="/assets/admin/js/funcoes.js" type="text/javascript"></script>
    <script src="/assets/admin/js/planos.js" type="text/javascript"></script>
    <script src="/assets/home/js/jquery.maskedinput.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <?php echo $this->jsPag; ?>
    <script>
    
	    $(function(){
			$("#message").delay("6000").fadeOut();
			$("#message").click( function(){ $("#message").stop().fadeOut(); });

			$('.calendario').datepicker({
				dateFormat: 'yy-mm-dd'
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
    
    <?php 
	
		$cores = array();
		array_push($cores, array(
				'indice'=>'a',
				'bg'=>'#666',
				'bg_hover'=>'rgba(100, 211, 236, 0.8)',
				'color'=>'rgba(255, 255, 255, 1)',
				'color_hover'=>'rgba(255, 255, 255, 1)'
			)
		);
		
		array_push($cores, array(
				'indice'=>'b',
				'bg'=>'rgba(39, 152, 216, 1)',
				'bg_hover'=>'rgba(39, 152, 216, 0.8)',
				'color'=>'rgba(255, 255, 255, 1)',
				'color_hover'=>'rgba(255, 255, 255, 1)'
			)
		);
		
		array_push($cores, array(
				'indice'=>'c',
				'bg'=>'rgba(0, 167, 140, 1)',
				'bg_hover'=>'rgba(0, 167, 140, 0.8)',
				'color'=>'rgba(255, 255, 255, 1)',
				'color_hover'=>'rgba(255, 255, 255, 1)'
			)
		);
		
	?>
	
	<style type="text/css">
    	
    	<?php foreach($cores as $row):?>
    	
    	.cor_<?php echo $row['indice'];?> {
    		background:<?php echo $row['bg']; ?> !important;
    		color:<?php echo $row['color'];?> !important;
    		text-decoration:none;
    	}
    	.cor_<?php echo $row['indice'];?>_hover {
    		background:<?php echo $row['bg']; ?> !important;
    		color:<?php echo $row['color'];?> !important;
    		text-decoration:none;
    	}
    	.cor_<?php echo $row['indice'];?>_hover:hover {
    		background:<?php echo $row['bg_hover']; ?> !important;
    		color:<?php echo $row['color_hover'];?> !important;
    		text-decoration:none;
    	}
    	
    	.cor_font_<?php echo $row['indice'];?> {
    		color:<?php echo $row['bg']; ?> !important;
    		text-decoration:none;
    	}
    	.cor_font_<?php echo $row['indice'];?>_hover {
    		color:<?php echo $row['bg']; ?> !important;
    		text-decoration:none;
    	}
    	.cor_font_<?php echo $row['indice'];?>_hover:hover {
    		color:<?php echo $row['bg_hover']; ?> !important;
    		text-decoration:none;
    	}
    	
    	<?php endforeach; ?>
    	
    </style>
    
</head>
<body>

	<?php if ( !empty($this->e) ): ?>
	<div id="message" class="error <?php echo is_array($this->e) ? key($this->e) : NULL; ?>">
		<i class="pe-7s-info"></i> <?php echo is_array($this->e) ? implode(', ', $this->e) : $this->e; ?>
	</div>
	<?php endif; ?>