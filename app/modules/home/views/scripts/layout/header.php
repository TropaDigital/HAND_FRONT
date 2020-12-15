<!DOCTYPE html>
<html lang="pt-br">
<head>

	<?php 
	
		$versao = '4.2';
		$concatenaUrl = explode( '?', $_SERVER ['REQUEST_URI'] );
	
	?>

	<base href="/"/>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=320px, user-scalable=0, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-status-bar-style" content="black-translucent" />
    
	<link rel="icon" href="<?php echo $this->GerenciadorCustom->favicon;?>" type="image/x-icon" />
	
	<?php echo $this->metaPag; ?>
	<title><?php echo $this->GerenciadorCustom->nome;?> • <?php echo $this->tituloPag; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/home/css/main.css?v=<?php echo $versao;?>">
	
	<?php
	
		$this->cssPag = str_replace('site','home',str_replace('/'.$this->GerenciadorCustom->slug, '', $this->cssPag)); 
		$this->cssPag = str_replace('view/'.$this->me->id_usuario, 'home', $this->cssPag);
		echo str_replace('.css', '.css?v='.$versao, $this->cssPag);
		
	?>
	
<!-- 	<link rel="stylesheet" type="text/css" href="assets/home/css/normalize.css?v=<?php echo $versao;?>"> -->
	<link rel="stylesheet" type="text/css" href="assets/home/css/animate.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" type="text/css" href="assets/home/js/scroll/css/lionbars.css?v=<?php echo $versao;?>" />
	<link rel="stylesheet" type="text/css" href="assets/home/css/escolher.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" type="text/css" href="/assets/home/js/datetimepicker-gh/css/bootstrap-material-datetimepicker.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,400italic,500,700,700italic,900,300,300italic">
	<link rel="stylesheet" type="text/css" href="assets/home/css/calendario.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css?v=<?php echo $versao;?>" />
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="/assets/home/js/tooltipster-master/dist/css/tooltipster.bundle.min.css" />

  	<script src="/assets/home/js/jquery-1.11.0.min.js?v=<?php echo $versao;?>"></script>
  	<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js?v=<?php echo $versao;?>"></script>
    <script src="assets/home/js/jquery.maskedinput.min.js?v=<?php echo $versao;?>"></script>
    <script type="text/javascript" src="/assets/home/js/tooltipster-master/dist/js/tooltipster.bundle.min.js"></script>
    <script type="text/javascript" src="http://momentjs.com/downloads/moment-with-locales.min.js"></script>
    <script src="/assets/home/js/datetimepicker-gh/js/bootstrap-material-datetimepicker.js"></script>
 
    
</head>
<body 
	data-ids="<?php echo $this->me->id_usuario;?>" 
	data-module="<?php echo $this->baseModule;?>" 
	data-controller="<?php echo $this->baseController;?>" 
	data-action="<?php echo $this->baseAction;?>"
	data-url="http://<?php echo $_SERVER['SERVER_NAME']; echo $_SERVER ['REQUEST_URI'];?>"
	data-url-donwload="<?php echo $_SERVER ['REQUEST_URI'];?><?php echo count( $concatenaUrl ) > 1 ? '&' : '?';?>download=true">
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
    
    	.box_adc .top {
    		background:<?php echo $cores[1]['bg']; ?>;
    		color:rgba(255,255,255,1);
    	}
    	.contatos_lista table th {
    		background:<?php echo $cores[1]['bg']; ?>;
    		color:rgba(255,255,255,1);
    	}
    	#conteudo .passo.ativo .status {
    		background:<?php echo $cores[2]['bg']; ?>;
    	}
    	#conteudo .passo.ativo .status .num {
    		border: 3px solid <?php echo $cores[2]['bg']; ?>
    	}
    	#conteudo .passo.ativo b,
    	#conteudo .passo.ativo .atual {
    		color:<?php echo $cores[2]['bg']; ?>;
    	}
    	
    	#conteudo .passo .status {
    		background:<?php echo $cores[1]['bg']; ?>;
    	}
    	#conteudo .passo .status .num {
    		border: 3px solid <?php echo $cores[1]['bg']; ?>
    	}
    	#conteudo .passo b,
    	#conteudo .passo .atual {
    		color:<?php echo $cores[1]['bg']; ?>;
    	}
    	.select2-container--default .select2-selection--multiple .select2-selection__choice {
    		background:<?php echo $cores[2]['bg']; ?> !important;
    	}
    	
    	.filtro_campanha.ativo {
    		color:<?php echo $cores[0]['bg']; ?>;
			border-bottom: 3px solid <?php echo $cores[0]['bg']; ?>;
    	}
    	
    	input[type="text"]:focus,
    	input[type="password"]:focus,
    	input[type="tel"]:focus,
    	input[type="email"]:focus,
    	select:focus {
    		box-shadow:0px 0px 0px 1px <?php echo $cores[0]['bg']; ?>;
    		outline:none;
    	}
    	
    	.contatos_lista table td a {
    		color:<?php echo $cores[0]['bg']; ?>;
    		text-decoration:none;
    	}
    	.contatos_lista table td a:hover {
			text-decoration:underline;    	
    	}
    </style>
    
    <div id="loadingbar-frame"></div>

	<div class="ajax-preview"></div>

	<?php if ( !empty($this->e) ): ?>
	<div id="message" class="error <?php echo is_array($this->e) ? key($this->e) : NULL; ?>">
		<?php echo is_array($this->e) ? implode(', ', $this->e) : $this->e; ?>
	</div>
	<?php endif; ?>
	
	<div id="menu_lateral">
	
		<div class="nav_menu" id="nav_menu_aberto">
			<i class="fa fa-angle-double-left"></i>
		</div>
		
		<?php include_once dirname(__FILE__).'/../layout/menu_index.php';?>

	</div>
	
	<?php if ($this->baseAction != 'criacao'):?>
		<?php include_once dirname(__FILE__).'/../layout/menu_topo.php';?>
	
		<ul id="funcoes" class="cor_b">
			<li class="title no-shadow" data-ripple="rgba(255,255,255,0.4)">
				<a href="/<?php echo $this->baseModule;?>/">
					<i class="fa fa-home"></i> <?php echo $this->lg->_("Início2"); ?>
				</a>
			</li>
			
			<?php if ($this->tituloPag != 'Início'):?>
			<li class="title" style="padding-left:0px; padding-right:0px;">
				<i class="fa fa-angle-double-right" style="margin-right:0px;"></i>
			</li>
			
			<li class="title no-shadow" data-ripple="rgba(255,255,255,0.4)">
				<i class="fa fa-file-text-o" aria-hidden="true"></i> <?php echo $this->lg->_($this->tituloPag); ?>
			</li>
			<?php endif; ?>
			
		</ul>
	
	<?php endif; ?>
