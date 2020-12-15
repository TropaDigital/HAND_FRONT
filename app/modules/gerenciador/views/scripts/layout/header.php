<!DOCTYPE html>
<html lang="pt-br">
<head>
	<base href="/">
	
	<meta charset="UTF-8">
	<title><?php echo $this->GerenciadorCustom->nome;?></title>
	<link rel="stylesheet" type="text/css" href="assets/admin/css/main.css">
	<link rel="stylesheet" type="text/css" href="assets/admin/css/spinner.css">
	<?php echo $this->cssPag; ?>
	<link rel="stylesheet" type="text/css" href="assets/home/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/calendario.css">
	<link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,700,700italic,900,300,300italic' type='text/css'>


  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" />
  	<link rel="icon" href="<?php echo $this->GerenciadorCustom->favicon;?>" type="image/x-icon" />
  	<link rel="stylesheet" href="assets/admin/css/pe-icon-7-stroke.css" rel="stylesheet" />
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script src="/assets/admin/js/funcoes.js" type="text/javascript"></script>
    <script src="/assets/admin/js/planos.js" type="text/javascript"></script>
    <script src="/assets/home/js/jquery.maskedinput.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/solid.js" integrity="sha384-P4tSluxIpPk9wNy8WSD8wJDvA8YZIkC6AQ+BfAFLXcUZIPQGu4Ifv4Kqq+i2XzrM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/regular.js" integrity="sha384-BazKgf1FxrIbS1eyw7mhcLSSSD1IOsynTzzleWArWaBKoA8jItTB5QR+40+4tJT1" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/brands.js" integrity="sha384-qJKAzpOXfvmSjzbmsEtlYziSrpVjh5ROPNqb8UZ60myWy7rjTObnarseSKotmJIx" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/fontawesome.js" integrity="sha384-2IUdwouOFWauLdwTuAyHeMMRFfeyy4vqYNjodih+28v2ReC+8j+sLF9cK339k5hY" crossorigin="anonymous"></script>
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
				'bg'=>$this->GerenciadorCustom->cor_a,
				'bg_hover'=>$this->GerenciadorCustom->cor_a_hover,
				'color'=>$this->GerenciadorCustom->cor_a_font,
				'color_hover'=>$this->GerenciadorCustom->cor_a_font_hover
			)
		);
		
		array_push($cores, array(
				'indice'=>'b',
				'bg'=>$this->GerenciadorCustom->cor_b,
				'bg_hover'=>$this->GerenciadorCustom->cor_b_hover,
				'color'=>$this->GerenciadorCustom->cor_b_font,
				'color_hover'=>$this->GerenciadorCustom->cor_b_font_hover
			)
		);
		
		array_push($cores, array(
				'indice'=>'c',
				'bg'=>$this->GerenciadorCustom->cor_c,
				'bg_hover'=>$this->GerenciadorCustom->cor_c_hover,
				'color'=>$this->GerenciadorCustom->cor_c_font,
				'color_hover'=>$this->GerenciadorCustom->cor_c_font_hover
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
    	
    	progress[value]::-webkit-progress-value {
			background-image:
			   -webkit-linear-gradient(-45deg, 
			                           transparent 33%, rgba(0, 0, 0, .1) 33%, 
			                           rgba(0,0, 0, .1) 66%, transparent 66%),
			   -webkit-linear-gradient(top, 
			                           rgba(255, 255, 255, .25), 
			                           rgba(0, 0, 0, .25)),
			   -webkit-linear-gradient(left, <?php echo $this->GerenciadorCustom->cor_a; ?>, <?php echo $this->GerenciadorCustom->cor_c; ?>);
		    background-size: 35px 20px, 100% 100%, 100% 100%;
		}
		
		header {
			background-image:
			   -webkit-linear-gradient(-45deg, 
			                           transparent 33%, rgba(0, 0, 0, .1) 33%, 
			                           rgba(0,0, 0, .1) 66%, transparent 66%),
			   -webkit-linear-gradient(top, 
			                           rgba(255, 255, 255, .25), 
			                           rgba(0, 0, 0, .25)),
			   -webkit-linear-gradient(left, <?php echo $this->GerenciadorCustom->cor_a; ?>, <?php echo $this->GerenciadorCustom->cor_c; ?>);
		    background-size: 535px 80px, 100% 100%, 100% 100%;
		}
    	
    </style>
    
</head>
<body data-module="<?php echo $this->baseModule;?>" data-usuarios="<?php echo $this->meusUsuarios; ?>">

	<?php if ( !empty($this->e) ): ?>
	<div id="message" class="error <?php echo is_array($this->e) ? key($this->e) : NULL; ?>">
		<i class="pe-7s-info"></i> <?php echo is_array($this->e) ? implode(', ', $this->e) : $this->e; ?>
	</div>
	<?php endif; ?>