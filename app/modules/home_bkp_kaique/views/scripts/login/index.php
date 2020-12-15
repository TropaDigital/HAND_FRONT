<!DOCTYPE html>
<html lang="pt-br">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<?php echo $this->metaPag; ?>
	<title>Faça seu login</title>
	<?php echo $this->cssPag; ?>
	<link rel="stylesheet" type="text/css" href="assets/home/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/login.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	
  	<style>
		
		body {
			background:url(<?php echo $this->GerenciadorCustom->background;?>);
			background-size:cover !important;
		}
	
	</style>
  	
</head>
<body>
	
	<?php if ( !empty($this->e) ): ?>
	<div id="message" class="error <?php echo is_array($this->e) ? key($this->e) : NULL; ?>">
		<i class="pe-7s-info"></i> <?php echo is_array($this->e) ? implode(', ', $this->e) : $this->e; ?>
	</div>
	<?php endif; ?>
	
	<script>
		$(function(){
			$('.box-login > .checkbox').click(function(){
				$('.checked').fadeToggle(0);
				$('.remember').trigger('click');
			});

			
		});

		function esqueciSenha(){

			$('.div-esqueci').toggleClass('ativo');
			$('.box-login').toggleClass('ativo');
			$('.aviao-logo').toggleClass('on');
			$('.esqueci-senha').fadeToggle(0);
			
		}

		function recuperarSenha(){

			var login = $('.login').val();
			var email = $('.email').val();

			$('.bt-recuperar').html('<i class="fa fa-spin fa-spinner"></i>');

			$.ajax({
				url: '/home/<?php echo $this->GerenciadorCustom->slug; ?>/login/recuperar',
				data: {login:login, email:email},
				type: 'POST',
				success: function(row){
					
					$('.bt-recuperar').html('ENVIAR');
					$('.erro_login').slideDown().html(row);		

					console.log( row );
						
				}
			});
			
		}
	</script>

	
	<form style="background:<?php echo $this->GerenciadorCustom->cor_c;?>" class="box-login animated fadeInDown" method="post" action="/home/<?php echo $this->GerenciadorCustom->slug;?>/login">
	
		<div style="width:100%; position:relative; padding:15px 0px; box-sizing:border-box; float:left; background:<?php echo $this->GerenciadorCustom->logo_cor;?>; max-height:80px; background-size: auto;margin: 0px 0px 25px 0px;border-radius: 4px 4px 0px 0px;">
			<img style="max-height:51px" src="<?php echo $this->GerenciadorCustom->logo;?>"/>
		</div>
		
		<input type="text" class="lg animated bounceIn" name="login" placeholder="EMAIL" required>
		<input type="password" class="pw animated bounceIn" name="senha" placeholder="SENHA" required>
		
		<a class="checkbox animated bounceIn" style="text-align:left; width:50%; float:left; margin-top:14px; display:none;">
		
			<span class="check">
				<span class="checked animated bounceIn"></span>
			</span>
			
			<span class="lembrar">Lembrar-me </span>
		</a>
		
		<input style="display:none;" type="checkbox" class="remember" name="remember" value="1"/>
		
		<label class="animated bounceIn">
			<button type="submit">ENTRAR</button>
		</label>
		
		<a class="esqueci-senha animated fadeInUp" style="color:<?php echo $this->GerenciadorCustom->cor_c;?>" href="javascript:esqueciSenha();"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Esqueci a senha</a>
		
	</form>
	
	<div class="div-esqueci">
		<form class="box-login box-esqueci animated fadeInRight" action="javascript:recuperarSenha();" style="background:<?php echo $this->GerenciadorCustom->cor_c;?>;">
		
			<i class="fa fa-times" onclick="esqueciSenha();" style="border:4px solid <?php echo $this->GerenciadorCustom->cor_c;?>; color:<?php echo $this->GerenciadorCustom->cor_c;?>;"></i>
		
			<h2><i class="fa fa-unlock-alt" aria-hidden="true"></i> Esqueci a senha</h2>
		
			<input type="text" class="animated flipInX login" placeholder="LOGIN"/>
			<input type="text" class="animated flipInX email" placeholder="E-MAIL"/>
			
			<label class="animated flipInY" style="float:right;">
				<button type="submit" class="bt-recuperar">ENVIAR</button>
			</label>
			
			<div class="erro_login"></div>
		
		</form>
	</div>

</body>
</html>