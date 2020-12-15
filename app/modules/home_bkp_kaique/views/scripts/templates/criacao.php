<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<script src="/assets/home/js/ckeditor/ckeditor.js"></script>
	<script src="/assets/home/js/jssocials.min.js"></script>
	<link rel="stylesheet" href="assets/home/js/scrollbar/jquery.mCustomScrollbar.css" />
	<link rel="stylesheet" href="assets/home/js/jquery-ui/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="assets/home/js/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="assets/home/js/owl-carousel/owl.transitions.css">
    <link rel="stylesheet" type="text/css" href="assets/home/css/jssocials.css" />
    <link rel="stylesheet" type="text/css" href="assets/home/css/jssocials-theme-flat.css" />
    
  	<div id="reload"><?php include 'cores-template.php';?></div>
  	
  	<script>  	

  	function reloadCores(){

  		$(function(){

          	$.ajax({
        
          		url: '/<?php echo $this->baseModule;?>/templates/cores-template',
          		success: function( response ) {
    
          			$('#reload').html(response)
        
          		}
          		
          	})

  		})
  		
  	}

  	reloadCores()
  	
  	function coresTemplate(id, div, aberto){

  		$('.ajax_montagem  #cor').html('<i class="fa fa-spinner fa-spin"></i> carregando cores...');
  		
  		var obj = $('#cor')
  		var cor = $(obj).attr('data-cor')

  		$.ajax({
  			url: '/<?php echo $this->baseModule;?>/templates/cores-json',
  			dataType: 'json',
  			success: function ( response ){

  				var cores  = '<div class="paleta">'

  		    	for ( i in response ){
	    		
	        		if ( response[i].user ){
	        			cores += '<div data-name="'+response[i].nome+'" class="cor-paleta cor-user" id="c-'+response[i].nome+'">#'+response[i].cor+' <a class="fa fa-trash"></a></div>';
					} else {
	        			cores += '<div class="cor-paleta" id="c-'+response[i].nome+'"></div>';
					}
	    		
				}
	    		cores += '</div>';
  		  		
  				var paleta = '<div class="cores-paleta">'
  					paleta += '<a class="choose-color update">Escolha uma cor</a>'
  					paleta += '<span class="cor-atual cor-paleta" id="'+cor+'"></span>'
  					paleta += '<a class="new new-color">Adicionar nova cor</a>'

  					paleta += '<div class="choose-colors-global">'
  					paleta += cores
  					paleta += '</div>'
  						
  					paleta += '</div>'

  				$('.ajax_montagem  #cor').html(paleta)
  				$('.paleta #'+cor).addClass('active')

  				if ( aberto ){
  					$('div#cor .cores-paleta .choose-colors-global').slideDown()
  				}

  			}
  		})
  		
  	}

  	function new_color_final(){

  		var bg = $('.modal-color input[name="bg"]').val()
  		var color = $('.modal-color input[name="font"]').val()
  		
  		$('.bg-modal-color .modal-color .content form button').html('<i class="fa fa-spinner fa-spin"></i>')
  		
		console.log('/<?php echo $this->baseModule;?>/templates/new-color')
		$.ajax({
			url: '/<?php echo $this->baseModule;?>/templates/new-color',
			data: { bg:bg, color:color },
			type: 'POST',
			dataType: 'JSON',
			success: function ( response ) {

				$('.bg-modal-color .modal-color .content form button').html('Adicionar')
				$('.bg-modal-color .modal-color .head a.fa.fa-times').trigger('click')
				
				reloadCores()
				coresTemplate( false, false, true )

			}, error: function ( err ) {

				console.log(err)
				alert('Erro ao salvar.')
				$('.bg-modal-color .modal-color .head a.fa.fa-times').trigger('click')

			}
		})
  		
  	}

  	$(function(){

		$(document).on('click', '.cor-user a', function( e ){

			e.stopPropagation()
			
			var nome = $(this).parent().attr('data-name')
			var mythis = $(this)
			
			mythis.parent().remove()

			$.ajax({

				url: '/<?php echo $this->baseModule;?>/templates/remove-color',
				type: 'POST',
				data: { nome: nome },
				success: function( response ){

					
				}

			})

		})
		
		$(document).on('click', '#cor .cor-paleta', function(){

			var cor = $(this).attr('id')
			
			$('.cor-paleta').removeClass('active')
			$(this).addClass('active')
			
			$('div#cor .cores-paleta > span').attr('id', cor)
			$('.ajax_montagem').attr('id', cor)
			$('#cor').attr('data-cor', cor)
			
		})

		$(document).on('click', '.choose-color', function(){

			$('div#cor .cores-paleta .choose-colors-global').slideToggle()
			
		})

		$(document).on('click', '.new-color, .bg-modal-color .fa-times', function(){

			if ( $(this).parent().hasClass('active') ) {
				alert('Não é possivel deletar uma cor selecionada.');
			} else {
				$('.bg-modal-color').fadeToggle();
			}
			
		})
	
	})
  	
  	</script>
  	
  	<div class="bg-modal-color">
  	
  		<div class="modal-color">
  		
  			<div class="head">
  				Adicionar nova cor
  				<a class="fa fa-times"></a>
  			</div>
  			
  			<div class="content">
  			
  				<form action="javascript:new_color_final();">
  				
  					<label>
  						<span>Cor de fundo</span>
  						<input type="color" name="bg"/>
  					</label>
  					
  					<label>
  						<span>Cor da fonte</span>
  						<input type="color" name="font"/>
  					</label>
  					
  					<button type="submit">Adicionar</button>
  				
  				</form>
  			
  			</div>
  		
  		</div>
  	
  	</div>
  	
  	<?php 
				
		$conteudo = array();

        array_push($conteudo, array(
            'icon'=>'clone',
            'nome'=> $this->lg->_("modal"),
            'duvida'=> $this->lg->_("Adicione um elemento flutuante com texto, com botão para fechar.")
        ));

		array_push($conteudo, array(
			'icon'=>'image',
			'nome'=> $this->lg->_("imagem"),
			'duvida'=> $this->lg->_("Adicione uma imagem ao conteúdo do template da sua campanha.")
		));
		
		array_push($conteudo, array(
				'icon'=>'list-ol',
				'nome'=>$this->lg->_("formulario"),
				'duvida'=> $this->lg->_("Adicione um formulario personalizado.")
		));
		
		array_push($conteudo, array(
				'icon'=>'file-text-o',
				'nome'=>$this->lg->_("texto"),
				'duvida'=> $this->lg->_("Adicione um texto corrido ao conteúdo do seu template, podendo escolher entre diversas opções de formatação (cor, fonte, posicionamento etc.).")
		));
		
		array_push($conteudo, array(
				'icon'=>'clock-o',
				'nome'=>$this->lg->_("contagem"),
				'duvida'=> $this->lg->_("Adicione uma contagem regressiva ao seu template, selecionando o tempo e o design desejados.")
		));
		
		array_push($conteudo, array(
				'icon'=>'clone',
				'nome'=>$this->lg->_("slide"),
				'duvida'=> $this->lg->_("Adicione um slide de imagens ao template da sua campanha.")
		));
		
		array_push($conteudo, array(
				'icon'=>'credit-card',
				'nome'=>$this->lg->_("oferta"),
				'duvida'=> $this->lg->_("Adicione uma oferta ao template da sua campanha, selecionando os valores anterior e atual do produto a ser anunciado.")
		));
		
		array_push($conteudo, array(
				'icon'=>'link',
				'nome'=>$this->lg->_("botão"),
				'duvida'=> $this->lg->_("Adicione um botão clicável ao template da sua campanha.")
		));
		
		array_push($conteudo, array(
				'icon'=>'map',
				'nome'=>$this->lg->_("mapa"),
				'duvida'=> $this->lg->_("Adicione um mapa ao template da campanha, selecionando o endereço desejado para aparecer no mesmo.")
		));
		
		array_push($conteudo, array(
				'icon'=>'youtube',
				'nome'=>$this->lg->_("video"),
				'duvida'=> $this->lg->_("Adicione um vídeo ao template da sua campanha a partir de um vídeo hospedado no Youtube.")
		));
		
		if ( $this->me->login_envio == 'ZZCSUFTP' ){
			
			array_push($conteudo, array(
					'icon'=>'barcode',
					'nome'=>$this->lg->_("boleto"),
					'duvida'=> $this->lg->_("Adicione um boleto ao template da sua campanha a partir de informações dos contatos.")
			));
			
		}
		
	?>

	<div id="menu_lateral" style="width:304px;">
	
		<span id="logo" style="width:304px; background:url(<?php echo $this->GerenciadorCustom->logo;?>) no-repeat 129px center <?php echo $this->GerenciadorCustom->logo_cor;?>; background-size:40% !important;">
		
			<a href="/<?php echo $this->baseModule;?>/">
			
				<i class="fa fa-angle-left" aria-hidden="true"></i>
				<span><?php echo $this->lg->_("Voltar"); ?></span>
			
			</a>
		
		</span>
	
		<div class="nav_menu" id="nav_menu_aberto">
			<i class="fa fa-angle-double-left"></i>
		</div>
		
		<div class="funcoes_land">
			<p><?php echo $this->lg->_("Adicionar seções"); ?></p>
			
			<div class="content-land">
			
    			<div data-refreshDrop="true" data-tipo="coluna" class="drag">
    				<div class="move">
    					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Acrescente colunas ao template da sua campanha. Elas podem funcionar como espaçamento ou separação dos outros elementos."); ?>"></i>
    					<i class="fa fa-stop cor_font_b_hover"></i>
    					<span><?php echo $this->lg->_("Colunas"); ?></span>
    				</div>
    			</div>
    			
			</div>
		
		</div>
		
		<div class="funcoes_land on">
			
			<p class="sconteudo-ico"><?php echo $this->lg->_("Adicionar conteudo"); ?></p>
			
			<div class="content-land">
			
				<?php foreach($conteudo as $row){?>
				<div class="drag" data-tipo="<?php echo $row['nome'];?>">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $row['duvida'];?>"></i>
						<i class="fa fa-<?php echo $row['icon'];?> cor_font_b_hover"></i>
						<span><?php echo $row['nome'];?></span>
					</div>
				</div>
				<?php } ?>
				
			</div>
			
		</div>
		
		<div class="funcoes_land">
			
			<p class="sfuncoes-ico"><?php echo $this->lg->_("Adicionar funções"); ?></p>
			
			<div class="content-land">
				
				<div class="drag" data-tipo="facebook-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário a uma página do Facebook determinada por você."); ?>"></i>
						<i class="fa fa-facebook cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Facebook"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="instagram-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário a uma página do Instagram determinada por você."); ?>"></i>
						<i class="fa fa-instagram cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Instagram"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="telefone-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário a realizar uma chamada para o número determinado por você."); ?>"></i>
						<i class="fa fa-phone cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Telefone"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="email-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário a escrever um e-mail para o endereço determinado por você."); ?>"></i>
						<i class="fa fa-envelope-o cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("E-mail"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="sms-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário a escrever um SMS para o número determinado por você."); ?>"></i>
						<i class="fa fa-comments cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("SMS"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="whatsapp-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário a escrever uma mensagem via WhatsApp para o número determinado por você."); ?>"></i>
						<i class="fa fa-whatsapp cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Whatsapp"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="download-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário para realizar um download."); ?>"></i>
						<i class="fa fa-download cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Download"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="video-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário para um vídeo."); ?>"></i>
						<i class="fa fa-youtube-play cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Video"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="localizacao-funcao">
					<div class="move">
						<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um botão clicável que direcionará o usuário para um endereço no Google Maps."); ?>"></i>
						<i class="fa fa-map cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Localização"); ?></span>
					</div>
				</div>
				
				<div class="drag" data-tipo="compartilhar-funcao">
					<div class="move">
						<i class="fa fa-share cor_font_b_hover"></i>
						<span><?php echo $this->lg->_("Compartilhar"); ?></span>
					</div>
				</div>
				
			</div>
			
		</div>
		
		<script>

			//script menu
			$('.funcoes_land p').bind('click', function(){

				if ( !$(this).parents('.funcoes_land').hasClass('active') ){

    				$('.content-land').slideUp();
    				$('.funcoes_land').removeClass('active');
				
    				$(this).parents('.funcoes_land').find('.content-land').slideDown();
    				$(this).parents('.funcoes_land').addClass('active');

				} else {

					$('.content-land').slideUp();
    				$('.funcoes_land').removeClass('active');

				}

			});			

			setTimeout( function(){
				$('.funcoes_land.on p').trigger('click');
			}, 500 );
			
		</script>
		
		<div class="opcoes_salvar_publicar" style="width:100%; float:left;">
			
			<div style="width:98%; float:right; margin-right:1%;">
				<div class="bt-azul bt-html ativo cor_c_hover" onclick="tipo_pagina('html_pagina')" style="width:46%;"><?php echo $this->lg->_("Página Inicial"); ?></div>
				<div class="bt-azul bt-html-final cor_c_hover" onclick="tipo_pagina('html_final')" style="margin-top:2px; width:46.5%;">
				
					<?php echo $this->lg->_("Página Final"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Por padrão todo formulário respondido será levado a essa página."); ?>"></i>
				
				</div>
				<div class="bt-azul cor_a_hover" onclick="paginas('<?php echo $this->id; ?>');" style="width:96%; margin-top:7px;"><i class="fa fa-clone" aria-hidden="true"></i> <?php echo $this->lg->_("Ver todas páginas"); ?></div>
			</div>
			
			<div data-id="<?php echo $this->id;?>" class="pre_visualizar cor_b_hover" style="background:#666;"><?php echo $this->lg->_("Pré visualizar"); ?></div>
			<div class="salvar_nome cor_b_hover" style="background: #00a78c;" data-id="<?php echo $this->id; ?>"><i class="fa fa-floppy-o"></i> <?php echo $this->lg->_("Salvar"); ?></div>
			
			<button class="resetar cor_a_hover" style="display:none;"><i class="fa fa-warning"></i> <?php echo $this->lg->_("Reiniciar Template"); ?></button>
			
		</div>
		
	</div>

	<?php 
		include 'galeria_home.php';
	?>
		
	<div class="largura_edita" style="width:100%; position:absolute;"></div>
	<div class="altura_edita" style="height:100%; position:fixed;"></div>
	
	<div id="site">
	
		<div id="template_edicao">
		
			<!-- PAGINAÇÃO -->
			<div id="prev-page" class="prev cor_a_hover" style="padding:25px; position:relative; cursor:pointer; font-size:20px; float:left;  color:#FFF; margin-top:200px; margin-left:-100px;"><i class="fa fa-arrow-left"></i></div>
				
			<div class="box-celular-complete prev-tela" style="float:left; margin-left:-110px; background-position:right;">
				<div style="width:100%;height:100%;background: linear-gradient(to right,rgba(234,234,234,1),rgba(234,234,234,0.5));"></div>
			</div>
			
			<div class="box-celular-complete next-tela" style="float:right; margin-right:-108px; background-position:left;">
				<div style="width:100%;height:100%;background: linear-gradient(to left,rgba(234,234,234,1),rgba(234,234,234,0.5));"></div>
			</div>
			
			<div id="next-page" class="next cor_a_hover" style="padding:25px; cursor:pointer; font-size:20px; float:right; color:#FFF; margin-top:200px; margin-right:-100px;"><i class="fa fa-arrow-right"></i></div>
			<!-- PAGINAÇÃO -->
			
			<div class="box-celular" id="<?php echo $this->id;?>" onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..message perso .. '; return true;">
				<div class="celular-scroll">
					<div class="drop-drops drop-drag html_pagina">
						<?php 
						
							if ($this->id_pagina){
								echo $this->paginas_landing[0]->html;
							} else {
								echo $this->landing[0]->html_pagina;
							}
							
						?>
					</div>
					<div class="drop-drops drop-drag html_final" style="display:none;">
						<?php echo $this->landing[0]->html_final; ?>
					</div>
				</div>
			</div>
			
		</div>
				
	</div>
	
	<div class="edicao_box" style="width:418px; float:right;">
		
		<div class="ajax_montagem">
			<img src="/assets/home/images/logo-cinza.png" class="off" style="margin-top:-36.5px; margin-left:-107.5px; left:50%; top:50%; position:absolute;"/>
		</div>
		
	</div>
	
	<div class="html_original" style="display:none">
		<?php echo $this->templates[0]->html; ?>
	</div>
	
	<div class="html_original_final" style="display:none">
		<?php echo $this->templates[0]->html_final; ?>
	</div>
	
	<div class="b_nome_landing_page">
		
		<div class="infos-salvar">
			<p style="margin-top:0px; color:#666;"><?php echo $this->lg->_("Confirme os dados para salvar seu template"); ?></p>
			<p style="margin:0px; font:14px 'Roboto'; color:#666; text-transform:uppercase;"><?php echo $this->lg->_("Nome do template"); ?></p>
			<input class="nome_landing_page" placeholder="Digite aqui" type="text" value="<?php echo $this->landing[0]->nome; ?>"/>
				
			<div class="analytics" style="margin:-8px 0px 5px 0px; width:100%; float:left;">
				<p style="font:14px 'Roboto'; color:#666; cursor:pointer; text-transform:uppercase;"><i class="fa fa-line-chart"></i> Analytics <i class="seta fa fa-chevron-down" style="float:right;"></i></p>
				<div class="open" style="display:none;">
					<p style="margin:0px; font:11px 'Roboto'; color:#666; text-transform:uppercase;">ID Analytics</p>
					<input class="id_analytics" placeholder="Id do analytics" type="text" value="<?php echo $this->landing[0]->analytics; ?>"/>
				</div>
			</div>
				
			<div class="salvar_nome" style="margin-left:0px; width:141px;" data-id="<?php echo $this->id; ?>"><?php echo $this->lg->_("Cancelar"); ?></div>
			<div class="confirmar"><i class="fa fa-floppy-o"></i> <?php echo $this->lg->_("Salvar"); ?></div>
		</div>
			
		<div class="infos-confirmar" style="display:none;">
			<p style="color:#666; width:100%; float:left; color:#666; margin-bottom: 5px;margin-top: 0px;"><i class="fa fa-warning"></i> <?php echo $this->lg->_("Deseja publicar esse template?"); ?></p>
			<div class="salvar" style="margin-left:0px; width:141px;" data-tipo="salvar" data-id="<?php echo $this->id; ?>"><?php echo $this->lg->_("Não"); ?>  </div>
			<div class="salvar" data-tipo="publicar" data-id="<?php echo $this->id; ?>"> <?php echo $this->lg->_("Sim"); ?> </div>
		</div>
		
		</div>
		
		<div class="bg-preto-finalizar" style="width:100%; display:none; z-index:99999999; height:100%; position:fixed; background:rgba(0,0,0,0.7); left:0; top:0;"></div>
		
		<script>
			$('.analytics > p').click(function(){
				$('.open').slideToggle();
				$(this).find('.seta').toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			});
			$('.confirmar').click(function(){
				$('.infos-confirmar').toggle(0);
				$('.infos-salvar').toggle(0);
			});
			$('.salvar_nome').click(function(){
				$('.opcoes_salvar_publicar').slideToggle(0);
				$('.bg-preto-finalizar').fadeToggle();
				$('.sconteudo').slideUp();
				$('.sfuncoes').slideUp();
				$('.b_nome_landing_page').toggleClass('ativo');
			});
			
			window.onbeforeunload = function() {
				return "É possivel que as alterações não sejam salvas.";
			}

			// PAGINAÇÃO
			var atual = <?php echo $this->id_pagina == '' ? '0' : $this->id_pagina; ?>;
			var max = <?php echo count($this->total_paginas); ?>;

			if (atual == max){
				$('.next').removeClass('next').css('opacity','0.5').css('cursor','auto');
				$('.next-tela').hide(0);
			} 
			if (atual == 0){
				$('.prev').removeClass('prev').css('opacity','0.5').css('cursor','auto');
				$('.prev-tela').hide(0);
			}
			
			$('.next').click(function(){
				var next = parseFloat(atual) + parseFloat(1);
				var pagina = $('.selecionar-pagina select').val();
				location.href="/<?php echo $this->baseModule;?>/templates/criacao/id/<?php echo $this->id; ?>/id_pagina/"+next;
			});
			$('.prev').click(function(){
				var next = parseFloat(atual) - parseFloat(1);
				var pagina = $('.selecionar-pagina select').val();
				location.href="/<?php echo $this->baseModule;?>/templates/criacao/id/<?php echo $this->id; ?>/id_pagina/"+next;
			});

			function tipo_pagina(tipo){
				if (tipo == 'html_final'){
					$('.html_final').fadeIn(0);
					$('.html_pagina').fadeOut(0);
					$('.bt-html').removeClass('ativo');
					$('.bt-html-final').addClass('ativo');
				} else {
					$('.html_pagina').fadeIn(0);
					$('.html_final').fadeOut(0);
					$('.bt-html').addClass('ativo');
					$('.bt-html-final').removeClass('ativo');
				}
			}

			$(function(){

				$('.loader').parents().remove();
				
				$('#funcoes_land.secoes .drag').hover(function(){

					var titulo = $(this).data('titulo');
					var frase = $(this).data('frase');

					var tooltip  = '';
						tooltip += '<div class="tooltip-info">'+frase+'</div>';
					
					$(this).append(tooltip);
				}, function(){
					$(this).find('.tooltip-info').remove();
				});
				
			});

			$(function(){

				var larguraSite = $('body').width();
				var larguraLateral = $('#menu_lateral').width();
				$('#site').css('width',larguraSite-larguraLateral+'px');
			
				$('.resetar').click(function(){
					if( confirm("Você tem certeza que deseja reiniciar esse template?") ){
						$.ajax({
							url: '/<?php echo $this->baseModule;?>/templates/resetar/id/<?php echo $this->id; ?>',
							success: function(row){

								console.log(row);
								
								if (row == '1'){
									location.reload();
								} else {
									alert('Ops, parece que aconteceu algum erro interno, tente novamente mais tarde.');
								}
							}
						});
					}
				});
				
				$('.salvar').click(function(){

					tipo_pagina('html_pagina');
					
					$(this).html('<i class="fa fa-spinner fa-spin"></i> Carregando');

					refaz_slide();

					var botao = $(this).data('tipo');
		
					var botao_altera = $(this);
			        var id = $(this).data('id');
			        var html_pagina = $('.html_pagina').html();
			        var html_final = $('.html_final').html();
					var nome = $('.nome_landing_page').val();
					var id_analytics = $('.id_analytics').val();
					var id_pagina = '<?php echo $this->id_pagina; ?>';

				        $.ajax({
				        	url: '/<?php echo $this->baseModule;?>/templates/salvar/id/'+id+'/salva/html_pagina',
				        	type: 'post',
				        	data: {id:id, id_pagina:id_pagina, analytics:id_analytics, nome:nome, html_pagina:html_pagina, html_final:html_final},
				        	success: function(result){

								console.log(result);
								console.log(id_analytics);
					        	
				        		if (result == 'true'){
				        			
				        			window.onbeforeunload = null;
					        		
					        		if (botao == 'publicar'){
				        				location.href='/<?php echo $this->baseModule;?>/campanha/nova-campanha?id=<?php echo $this->id; ?>';
					        		} else {
						        		$('.bg-preto-finalizar').fadeOut(500);
										$(botao_altera).html('<i class="fa fa-floppy-o"></i> Salvar');
		
										$('.opcoes_salvar_publicar').slideToggle();
										$('.b_nome_landing_page').removeClass('ativo');

										location.reload();
					        		}
					        		
				        		} else {
					        		//alert(result);
				        			alert('Erro ao salvar.');
				        		}
				        	}
				        });
			        
			    });

			});
		</script>
		
		<script src="assets/home/js/jquery-ui/jquery-ui.js"></script>
	  	<script src="assets/home/js/jquery.countdown.min.js"></script>
	  	<script src="assets/home/js/owl-carousel/owl.carousel.min.js"></script>
	  	<script src="assets/home/js/funcoes-template.js?v=2"></script>
	  	<script src="assets/home/js/scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	  	
	  	<!-- edição de campos do form -->
	  	<script>

            var campo;
  		
          	//config de campos
        	$(document).on('click', '.my-config', function(){

        		if ( $(this).hasClass('radio') ){
        			campo = $( this );
        			popupForm( 'radio_only' );
        		} else {
        			campo = $( this ).parent().find('.config-campo');
        		}
    			
        		if ( campo.attr('contenteditable') == 'true' ) {

        	        popupForm( 'radio' );
        
        		} else if ( campo.attr('type') == 'text' )  {

        			popupForm( 'input' );
        
        		} else if ( campo.attr('data-tipo') == 'config-form' )  {

        			popupForm( 'config-form' );
        
        		}
        
        
        	});
      	
          	function popupForm( tipo )
        	{
            	
        		if ( campo.val() ) {
        
        			var titulo = campo.val();
        			
        		} else {
        
        			var titulo = campo.text();
        			
        		}
        
        		var htmlPopup  = '<div class="bg-popup">';
        			htmlPopup += '<div class="box-popup">';
        			
        			htmlPopup += '<div class="title-popuo">'+titulo+'</div>';
        			htmlPopup += '<div class="content-popup">';

        			if ( tipo == 'config-form' ) {

						if ( $('.edicao_box form.form-geral input[name="resposta_unica"]').val() ){
							var checked = 'checked="checked"';
						} else {
							var checked = '';
						}

        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="checkbox" value="true" name="op_resp_unica" value="true">';
        				htmlPopup += '<span>Resposta unica</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

                        htmlPopup += '<div class="opcao">';
                        htmlPopup += '<label>';
                        htmlPopup += '<select class="font-size-form">'
                        for (var i = 12; i < 40; i++) {
                            htmlPopup += '<option>'+i+'</option>'
                        }
                        htmlPopup += '</select>'
                        htmlPopup += '<span>Tamanho do texto</span>';
                        htmlPopup += '</label>';
                        htmlPopup += '</div>';

                        htmlPopup += '<div class="opcao">';
                        htmlPopup += '<label>';

                        htmlPopup += '<select class="font-family-form">'
                        htmlPopup += '<option>Roboto</option>'
                        htmlPopup += '<option>Arial</option>'
                        htmlPopup += '<option>Comic Sans MS</option>'
                        htmlPopup += '<option>Courier New</option>'
                        htmlPopup += '<option>Georgia</option>'
                        htmlPopup += '<option>Lucida Sans Unicode</option>'
                        htmlPopup += '<option>Tahoma</option>'
                        htmlPopup += '<option>Times New Roman</option>'
                        htmlPopup += '<option>Trebuchet MS</option>'
                        htmlPopup += '<option>Verdana</option>'
                        htmlPopup += '</select>'

                        htmlPopup += '<span>Fonte</span>';
                        htmlPopup += '</label>';
                        htmlPopup += '</div>';
        				
        			}
        			
					console.log(tipo);
					
        			if ( tipo == 'radio' || tipo == 'input' ) {

						if ( campo.attr('data-required') ){
							var checked = 'checked="checked"';
						} else {
							var checked;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="checkbox" value="true" name="op_required">';
        				htmlPopup += '<span>Campo obrigatório</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
        			}

        			if ( tipo == 'radio_only' ) {

						if ( campo.parent().find('.config-campo').attr('data-required') ){
							var checked = 'checked="checked"';
						} else {
							var checked;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="checkbox" value="true" name="op_required">';
        				htmlPopup += '<span>Campo obrigatório</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
        			}

        			if ( tipo == 'input' ) {

        				if ( campo.attr('data-type') == 'text' || !campo.attr('data-type') ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_text">';
        				htmlPopup += '<span>Liberado</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
        				if ( campo.attr('data-pattern') == '[0-9]+$' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_number">';
        				htmlPopup += '<span>Apenas números</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
        				if ( campo.attr('data-pattern') == '[0-9]{2}\/[0-9]{2}\/[0-9]{4}$' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_data">';
        				htmlPopup += '<span>Data</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
						if ( campo.attr('data-pattern') == '[0-9]{2}:[0-9]{2} [0-9]{2}$' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_hora">';
        				htmlPopup += '<span>Hora</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
        				if ( campo.attr('data-class') == 'telefone' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_telefone">';
        				htmlPopup += '<span>Telefone</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
						if ( campo.attr('data-pattern') == '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_email">';
        				htmlPopup += '<span>Email</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';
        				
						if ( campo.attr('data-class') == 'moeda' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_moeda">';
        				htmlPopup += '<span>Moeda</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

        				if ( campo.attr('data-class') == 'cpf' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_cpf">';
        				htmlPopup += '<span>CPF</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

        				if ( campo.attr('data-class') == 'cnpj' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_cnpj">';
        				htmlPopup += '<span>CNPJ</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

        				if ( campo.attr('data-class') == 'rg' ){
							var checked = 'checked="checked"';
						} else {
							var checked = null;
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<input '+checked+' type="radio" name="type_text" value="op_rg">';
        				htmlPopup += '<span>RG</span>';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

        				if ( campo.attr('data-minlength') ){
							var value = campo.attr('data-minlength');
						} else {
							var value = '';
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<span>Minimo de caracteres <i class="fa fa-question-circle question tooltip" title="Para essa validação funcionar é necessario que esse campo seja obrigatório."></i></span>';
        				htmlPopup += '<input value="'+value+'" type="number" name="minlength">';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

        				if ( campo.attr('data-maxlength') ){
							var value = campo.attr('data-maxlength');
						} else {
							var value = '';
						}
        		        
        				htmlPopup += '<div class="opcao">';
        				htmlPopup += '<label>';
        				htmlPopup += '<span>Máximo de caracteres <i class="fa fa-question-circle question tooltip" title="Para essa validação funcionar é necessario que esse campo seja obrigatório."></i></span>';
        				htmlPopup += '<input value="'+value+'" type="number" name="maxlength">';
        				htmlPopup += '</label>';
        				htmlPopup += '</div>';

        			}

        			htmlPopup += '</div>';
        
        			htmlPopup += '<div class="opcoes_popup">';
        			htmlPopup += '<button type="button" onclick="$(this).parents(\'.bg-popup\').remove();">Cancelar</button>';
        			htmlPopup += '<button type="submit" onclick="javascript:saveEditForm();">Salvar</button>';
        			htmlPopup += '</div>';
        			
        			htmlPopup += '</div>';
        			htmlPopup += '</div>';
        
        		$('body').append( htmlPopup );

        		console.log( $('.edicao_box form').attr('font-size') )

        		$('.font-size-form').val( $('.edicao_box form').attr('font-size') )
                $('.font-family-form').val( $('.edicao_box form').attr('font-family') )

				$('input[name="type_text"]').on('change', function(){

					if ( $(this).val() == 'op_telefone' ) {

						$('.content-popup .opcao input[name="maxlength"]').val('15');
						$('.content-popup .opcao input[name="minlength"]').val('14');

					} else if ( $(this).val() == 'op_cpf' ) {

						$('.content-popup .opcao input[name="minlength"]').val('14');

					} else if ( $(this).val() == 'op_cnpj' ) {

						$('.content-popup .opcao input[name="minlength"]').val('18');

					} else if ( $(this).val() == 'op_rg' ) {

						$('.content-popup .opcao input[name="minlength"]').val('10');

					} else {

						$('.content-popup .opcao input[name="maxlength"]').val('');
						$('.content-popup .opcao input[name="minlength"]').val('');

					}

				});

        		tooltip();

        	}
    
        	function saveEditForm()
        	{

				if ( $('.my-config.radio').length > 0 ) {

					campo = campo.parent().find('.config-campo');

				}
        		
        	    if ( $('input[name="op_required"]:checked').val() == 'true' ) {
            	    
      				campo.attr('data-required', 'required');  	
      				    	
        	    } else {
            	    
					campo.removeAttr('data-required');
					
        	    }
        	    
				/*tipo de campo*/
        	    if ( $('input[name="type_text"]:checked').val() == 'op_text' ) {
            	    
      				campo.attr('data-type', 'text'); 
      					
        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_number' ) {

        	    	campo.attr('data-pattern', '[0-9]+$');  	
        	    	campo.attr('data-type', 'tel'); 
        	    	campo.attr('data-class', 'num');
        	    	
        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_data' ) {

        	    	campo.attr('data-pattern', '[0-9]{2}\/[0-9]{2}\/[0-9]{4}$');  	
        	    	campo.attr('data-type', 'date'); 

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_hora' ) {

        	    	campo.attr('data-pattern', '[0-9]{2}:[0-9]{2} [0-9]{2}$');  	
        	    	campo.attr('data-type', 'time'); 

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_telefone' ) {

        	    	campo.attr('data-class', 'telefone');
        	    	campo.attr('data-type', 'tel'); 

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_email' ) {

        	    	campo.attr('data-pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$');  	
        	    	campo.attr('data-type', 'email'); 

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_moeda' ) {

        	    	campo.attr('data-pattern', '([0-9]{1,3}.)?[0-9]{1,3},[0-9]{2}$');	
        	    	campo.attr('title', 'Formato de moeda. EX: 10,00');	
        	    	campo.attr('data-type', 'tel'); 
        	    	campo.attr('data-class', 'moeda');

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_cpf' ) {

        	    	campo.attr('data-type', 'tel'); 
        	    	campo.attr('data-class', 'cpf');

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_cnpj' ) {

        	    	campo.attr('data-type', 'tel'); 
        	    	campo.attr('data-class', 'cnpj');

        	    } else if ( $('input[name="type_text"]:checked').val() == 'op_rg' ) {

        	    	campo.attr('data-type', 'tel'); 
        	    	campo.attr('data-class', 'rg');

        	    } else {

        	    	campo.attr('data-type', 'text'); 
					campo.removeAttr('data-pattern');
					campo.removeAttr('data-class');
					campo.removeAttr('title');
					
        	    }

        	    if ( $('input[name="maxlength"]').val() ) {

        	    	campo.attr('data-maxlength', $('input[name="maxlength"]').val() );

        	    }

                $('.edicao_box form.form-geral').attr('font-size', $('.font-size-form').val())
                $('.edicao_box form.form-geral').attr('font-family', $('.font-family-form').val())

                $('.edicao_box form.formulario-set label span, .edicao_box form.formulario-set .termos-accept .text-accept span, .edicao_box form.formulario-set .termos-accept .text-accept a, .edicao_box form.formulario-set .termos-accept .text-accept .texto-termos, .edicao_box form.formulario-set label input, .edicao_box form.formulario-set div p, .edicao_box form.formulario-set textarea').css('fontSize', $('.edicao_box form').attr('font-size')+'px').css('font-family', "'"+ $('.edicao_box form').attr('font-family')+"'");

                if ( $('input[name="minlength"]').val() ) {

        	    	campo.attr('data-minlength', $('input[name="minlength"]').val() );

        	    }
         	   
        	    if ( $('input[name="op_resp_unica"]:checked').val() == 'true' ){

        	    	$('.edicao_box form.form-geral').append('<input type="hidden" name="resposta_unica" value="true"/>');
					
				} else {

					$('.edicao_box form.form-geral input[name="resposta_unica"]').remove();
					
				}

        	    pattern="[a-z\s]+$"
        	    
        	    $('.bg-popup .opcoes_popup button[type="button"]').trigger('click');
        		
        	}

	  	</script>
	  	
<?php include_once dirname(__FILE__).'/../layout/footer.php';?>