<?php 
	if ( $this->slug ) {
		$module = $this->baseModule.'/'.$this->slug;
	} else {
		$module = $this->baseModule;
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	
	<?php $versao = '2.1';?>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=320px, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="mobile-web-app-status-bar-style" content="black-translucent" />
	<base href="/"/>
	<title><?php echo $this->tituloPag; ?></title>
	<link rel="stylesheet" type="text/css" href="assets/home/css/criacao-itens.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" type="text/css" href="assets/home/css/templateView.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" type="text/css" href="assets/home/css/animate.css?v=<?php echo $versao;?>">
	<link rel="stylesheet" type="text/css" href="assets/home/js/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="assets/home/js/owl-carousel/owl.transitions.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/home/js/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/jssocials.css" />
    <link rel="stylesheet" type="text/css" href="assets/home/css/jssocials-theme-flat.css" />
	
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="/assets/home/js/jquery.maskedinput.min.js?v=1.21"></script>
	<script src="/assets/home/js/jquery.maskMoney.js?v=1.21"></script>
	<script src="/assets/home/js/jquery-ui/jquery-ui.js"></script>
	<script src="/assets/home/js/jssocials.min.js"></script>
	
	<script>

		$( function () {

			$('input[data-class="telefone"]').mask("(99) 9999-99999");
			$('input[data-class="cpf"]').mask("999.999.999-99");
			$('input[data-class="cnpj"]').mask("99.999.999/9999-99");
			$('input[data-class="rg"]').mask("99.999.999-9");
			$('input[data-class="telefone"]').mask("(99) 9999-99999");
			$('input[data-class="num"]').mask("99999999999999999");
			$('input[data-class="moeda"]').maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

			var modalClosed = false

            if ( $('.modal-template').length > 0 ) {

                window.onscroll = function (oEvent) {

                    $('body').trigger('click')

                }

                $('body').bind('click', function () {

                    if (modalClosed == false) {

                        modalClosed = true

                        $('.modal-template').slideUp().addClass('closed')

                        <?php if ($this->campanhas[0]->id_usuario){?>
                        var url = '<?php echo $this->backend;?>/api/relatorios/new-confirm'

                        $.ajax({
                            url: url,
                            data: {
                                titulo: $('.modal-template h3').text(),
                                texto: $('.modal-template .texto').text(),
                                shorturl: $('body').attr('data-shorturl'),
                                id_usuario: <?php echo $this->campanhas[0]->id_usuario;?>,
                                id_campanha: <?php echo $this->campanhas[0]->id_campanha;?>,
                                celular: '<?php echo $this->celularUser; ?>'
                            },
                            type: 'GET',
                            success: function (row) {
                                console.log(row)
                            }
                        })

                        <?php } ?>

                    }

                })
            }
			
		});

	</script>
	
	<?php include 'cores-template.php';?>
  	
  	<script type="text/javascript">

	 	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	 	//N
	 	ga('create', 'UA-124195776-8', 'auto');
  		ga('send', 'pageview');
		
  		<?php if ($this->analytics):?>
	 	//C
	  	ga('create', '<?php echo $this->analytics; ?>', 'auto','clientTracker');
	    ga('clientTracker.send', 'pageview');
	    <?php endif; ?>
	    
	</script>
  	
</head>
<body 
	data-pag="<?php echo $this->tituloPagInterna == '' ? 'home' : $this->tituloPagInterna; ?>" <?php echo $this->shorturl != '' ? 'data-shorturl="'.$this->shorturl.'"' : ' data-shorturl="'.$_GET['short'].'"'; ?> 
	data-module="home/zink" data-user="<?php echo $this->campanhas[0]->id_usuario;?>">

	<script>

		var mobile = navigator.appVersion.split('iPhone');

		$(function(){

			$('div[data-fixed="top"], div[data-fixed="bottom"]').each(function(){

				var altura = $(this).find('.drop-drag').height()
				var style = $(this).find('.drop-drag').attr('style')
				
				$(this).after('<div style="'+style+'; height:'+altura+'px;  float:left;"></div>')
				

			})
			
			$(".share").jsSocials("destroy");
			
			$(".share").jsSocials({
	            shares: ["email", "twitter", "facebook", "googleplus", "linkedin", "whatsapp"],
	            showLabel: false,
	            showCount: false,
	            shareIn: "popup",

	            on: {
	                click: function(e) {

	                	console.log( e );
	                	var share = e.currentTarget.firstChild.classList[1].replace('fa-', '');
	                	urlBotao('', 'Compartilhar '+share, 'funcao-click');

    	                
    	            }
	            }

	        });
			
			if (mobile.length > 1){
	
				$('#landing-page').attr('style','height:calc(100vh - 75px); padding-bottom:75px');
	
			} else {
	
				$('#landing-page').attr('style', 'height:100vh; padding-bottom:0px');
				
			}

			

		});
			
	</script>
	
	<div id="landing-page" data-id="<?php echo $this->id;?>">
	
		<?php if ( !empty($this->e) ): ?>
		<div id="message" style="display:none;" class="error <?php echo is_array($this->e) ? key($this->e) : NULL; ?> animated fadeInDown">
			
			<?php if ($this->bloqueio->tipo == 'v'):?>
				<i class="fa fa-warning"></i> <?php echo $this->senha_tipo;?>
			<?php endif; ?>
			
			<?php echo is_array($this->e) ? implode(', ', $this->e) : $this->e; ?>
			
		</div>
		
		<script>alert('Dados incorretos.');</script>
		
		<?php endif; ?>
	
		<?php if ($this->bloqueio->bloquear == 's' && $_GET['pag'] != 'final'):?>
	
		<div id="senha-layout">
		<form method="post" action="/zink/templates/submit-senha">
			
			<style>
				#senha-layout {
				    width: 100%;
				    height: 100%;
				    position: absolute;
				    background: <?php echo $this->bloqueio->bg;?>;
				    box-sizing:border-box;
				}
				#senha-layout form {
					width:100%;
					height:220px;
					position:absolute;
					top:50%;
					margin-top:-110px;
					box-sizing:border-box;
					padding:0px 20px;
					text-align:center;
				}
				#senha-layout input[type="text"] {
				    background:#FFF;
				    border:1px solid rgba(0,0,0,0.2);
				    border-radius:100px;
				    padding:10px;
				    font-size:15px;
				    outline:none;
				    width:100%;
				    box-sizing:border-box;
				    float:left;
				    height:40px;
				    text-align:center;
				}
				#senha-layout input[type="submit"],
				a.bt_cancel {
				    margin-top:20px;
				    padding:10px 20px;
				    cursor:pointer;
				    display:inline-block;
				    vertical-align:middle;
				    text-decoration:none;
				    background:rgba(0,0,0,0.5);
				    border:none;
				    outline:none;
				    border-radius:5px;
				    color:#FFF;
				    font-size:12px;
				    text-transform:uppercase;
				}
				#senha-layout h1 {
					font-size:20px;
					color:#FFF;
					text-align:center;
				}
			</style>
			
			<?php if ($this->errorLogin):?>
			
				<?php echo $this->errorLogin; ?>
			
			<?php endif; ?>
			
			<img style="max-width: 160px;max-height: 65px;" src="<?php echo $this->bloqueio->img;?>"/>
			
			<input type="hidden" name="shorturl" value="<?php echo $this->shorturl;?>"/>
			<input type="hidden" name="url" value="<?php echo $_SERVER['REQUEST_URI'];?>"/>
			<h1><?php echo $this->bloqueio->titulo_block;?></h1>
			<input type="hidden" name="senha_correct" value="<?php echo $this->bloqueio->senha;?>"/>
			<input type="text" maxlength="<?php echo $this->bloqueio->total_senha;?>" name="mysenha" placeholder="<?php echo $this->bloqueio->titulo_block;?>"/>
			<input type="submit" value="Enviar"/>
			
			<?php if ($this->bloqueio->botao_cancel == 'sim'):?>
				
				<?php if ( !empty($this->bloqueio->nome_botao_cancel) ){?>
    				<a href="<?php echo $this->bloqueio->tipo_cancel == 'url' ? $this->bloqueio->url_botao_cancel : '/m/'.$this->shorturl.'?pag=final';?>" class="bt_cancel">
    					<?php echo $this->bloqueio->nome_botao_cancel; ?>
    				</a>
				<?php } ?>
				
			<?php endif;?>
			
		</form>
		</div>
		<?php exit; ?>
	
	<?php endif; ?>
	
		<?php 
		
			if ( date('Y-m-d H:i') <= $this->status ) {
				
			    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			    
				$template = $this->template;			
				$template = str_replace(' ui-sortable-handle', '', $template);
				$template = str_replace(' ui-sortable', '', $template);
				$template = str_replace('class="addthis_inline_share_toolbox" style="clear: both;" data-url="', 'class="addthis_inline_share_toolbox" data-url="'.$url.'" data-create-url="', $template);
				$template = str_replace('class="addthis_inline_share_toolbox" data-url="', 'class="addthis_inline_share_toolbox" data-url="'.$url.'" data-create-url="', $template);
				$template = str_replace('data-title="', 'data-title="'.$this->tituloPag.'" data-create-title="', $template);
				echo $template;
				
			} else {
				
				echo 'Campanha inativa.';
				
			}
			
		?>
	
	</div>
	
	<script src="assets/home/js/template.js?v=<?php echo $versao;?>""></script>
	<script src="assets/home/js/jquery.countdown.min.js"></script>
	<script src="assets/home/js/owl-carousel/owl.carousel.min.js"></script>
	<script src="assets/home/js/funcoes-template.js?v=<?php echo $versao;?>""></script>
	
</body>
</html>