	<script>

		function totalNotifica(){

			$.ajax({
				url: '/<?php echo $this->baseModule;?>/index/total-notificacoes',
				success: function(row){

					setTimeout(function(){
						totalNotifica();
					}, 60000);

					if (row > 0){
						$('.total-notifica').removeClass('zoomOut').addClass('animated zoomIn').html(row).show(0);
					}
					
					
				}
			});
			
		}

		totalNotifica();
	
		function openNotifica(botao){

			$(botao).parent().toggleClass('active');
			var active = $(botao).parent().attr('class');

			if (active != 'active'){
				$(botao).find('.total-notifica').addClass('animated zoomOut');
				totalNotifica();
			}

			$('.box-notifica').slideToggle();
			$('.box-notifica').html('<li class="load"><span><i class="fa fa-warning fa-spinner"></i> Carregando</span></li>');

			$.ajax({

				url: '/<?php echo $this->baseModule;?>/index/notificacoes?active='+active,
				dataType: 'JSON',
				success: function(row){
					
					console.log(row);
					
					// LIMPA NOTIFICAÇÕES
					$('.box-notifica').html('');

					if (row.length == 0){
						$('.box-notifica').html('<li class="load"><span><i class="fa fa-warning fa-smile-o"></i> Nenhuma notificação</span></li>');
					}
					
					for(var i in row) {

						var box  = '';
							box += '<li class="'+row[i].nivel+'">';
							box += '<span>';
							box += '<i class="fa fa-warning"></i>';
							box += row[i].mensagem;
							box += '<b style="display:block;font-size: 11px;padding-top: 4px;font-weight: normal;"><a class="fa fa-calendar"></a> '+row[i].criado+'</b>';
							box += '</span>';
							box += '</li>';

						$('.box-notifica').append(box);
						
					}
					
				}

			});
			
			
		}

		$('.box-notifica li span').click(function(event){
			event.stopPropagation();
		});

		
	</script>
	
	<script>

		function enviarContato(){

			var nome = '<?php echo $this->me->login;?>';
			var assunto = '[Deixe uma mensagem]';
			var email = $('.email').val();
			var mensagem = $('.msg').val();
			var modal = 'on';

			$('#box-fale-conosco button').html('<i class="fa fa-spin fa-spinner"></i>');
			
			$.ajax({
				url: '<?php echo $this->baseModule;?>/contato/enviar',
				type: 'POST',
				data: {nome:nome, email:email, mensagem:mensagem, modal:modal, assunto:assunto},
				success: function(row){

					$('#box-fale-conosco button').html('Enviar');

					console.log(row);

					if (row == 'true'){

						$('#box-fale-conosco').removeClass('ative');
						
						alert('Contato enviado com sucesso.');
						$('.email').val('');
						$('.msg').val('');
						
					} else {
						alert('Erro ao enviar contato, tente novamente mais tarde.');
					}
				}, beforeSend: function ( error ) {


				}
			});
			
		}

		$(function(){

			$('.open-box-msg').click(function(){
				
				$('#box-fale-conosco').toggleClass('ative');
				
			});
			
		});
	
	</script>
	
	<div id="box-fale-conosco">
		
		<div class="top cor_c">
		
			 <?php echo $this->lg->_("Deixe uma mensagem"); ?>
			<i class="fa fa-times open-box-msg"></i>
			
			
		</div>
		<form action="javascript:enviarContato();">
		
			<label>
				 <?php echo $this->lg->_("Seu e-mail"); ?>
				<input type="text" class="email"/>
			</label>
			
			<label>
				 <?php echo $this->lg->_("Mensagem"); ?>
				<textarea class="msg"></textarea>
			</label>
			
			<label>
				<button class="bt_verde cor_c_hover" type="submit"> <?php echo $this->lg->_("Enviar"); ?></button>
			</label>
			
		</form>
		
	</div>
	
	<ul id="topo" class="cor_a">

		<li onclick="location.href='/<?php echo $this->baseModule;?>/';" id="logo" style="padding:0px; background:url(<?php echo $this->GerenciadorCustom->logo;?>) center no-repeat; background-size:50%; background-color:<?php echo $this->GerenciadorCustom->logo_cor;?>;" class="no-shadow" data-ripple="rgba(0,0,0,0.4)"></li>
		
		<li onclick="location.href='/<?php echo $this->baseModule;?>/';" class="no-shadow" data-ripple="rgba(0,0,0,0.4)"><i class="fa fa-home"></i> Home</li>
		<li class="open-box-msg no-shadow" data-ripple="rgba(0,0,0,0.4)">
		
			<i class="fa fa-paper-plane"></i>  <?php echo $this->lg->_("DEIXE UMA MENSAGEM"); ?>
			<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Precisa de ajuda? Clique aqui e entre em contato com o suporte!"); ?>"></i>
		
		</li>
		<li style="display: none;" onclick="location.href='/<?php echo $this->baseModule;?>/contato';"><i class="fa fa-phone"></i><?php echo $this->lg->_("Fale conosco"); ?> </li>
		<?php if ($this->me->nivel == 1 || $this->me->nivel == 4){?>
		<li style="display:none;" onclick="location.href='/<?php echo $this->baseModule;?>/planos';"><i class="fa fa-cart-plus" aria-hidden="true"></i> <?php echo $this->lg->_("Planos e Faturas"); ?></li>
		<?php } ?>
		
		<li class="no-shadow" data-ripple="rgba(0,0,0,0.4)">
			
			<a onclick="openNotifica(this);">
				<span class="total-notifica">3</span>
				<i class="fa fa-bell-o notificacoes" aria-hidden="true"></i>
			</a>
			
			<ul class="box-notifica"></ul>
			
		</li>
		
		<li style="float:right; padding-left:0px; padding-right:1%;">
		
			<div class="ico_user" style="margin-left:10px;">
				<?php echo strtoupper(substr($this->me->name_user, 0, 1)); ?>
			</div>
			
			<div class="user_name" style="margin-right:20px;"><?php echo $this->me->name_user; ?></div>
			
			<div class="user_submenu submenu">
			
				<?php foreach($this->menus as $row):?>
					
					<?php if ($row->link != 'javascript:;'):?>
						<a href="/<?php echo $this->baseModule;?>/<?php echo $row->link;?>"><?php echo $this->lg->_($row->nome);?></a>
					<?php endif; ?>
					
				<?php endforeach;?>
				
				<a href="<?php echo $this->baseModule;?>/login/sair"> <?php echo $this->lg->_("Sair"); ?></a>
			</div>

		</li>
		
		<li class="linguagens">
			<a href="<?php echo $this->baseModule;?>?lg=pt_br" class="language" style="background-image:url(/assets/home/images/bandeira_brasil.png);"></a>
		</li>
		
		<li class="linguagens">
			<a href="<?php echo $this->baseModule;?>?lg=en_us" class="language" style="background-image:url(/assets/home/images/bandeira_usa.jpg);"></a>
		</li>

	</ul>