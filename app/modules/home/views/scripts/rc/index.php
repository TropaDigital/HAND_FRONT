<!DOCTYPE html>
<html lang="pt-br">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<?php echo $this->metaPag; ?>
	<title>Recuperar senha</title>
	<?php echo $this->cssPag; ?>
	<link rel="stylesheet" type="text/css" href="/assets/home/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/assets/home/css/animate.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
</head>
<body>
	
	<script>

		$(function(){
			$('.box-login > .checkbox').click(function(){
				$('.checked').fadeToggle(0);
				$('.remember').trigger('click');
			});
	
			$('.box-login').show(0);
	
			setTimeout(function(){
				$('.logo').show(0);
			},800);
	
			setTimeout(function(){
				$('.box-login input[type="text"],.box-login input[type="password"]').show(0);
			},1000);
	
			setTimeout(function(){
				$('label').show(0);
			},1600);
	
		});

		function go(){
			
			var senha = $('.senha').val();
			var repitaSenha = $('.repita-senha').val();

			$('.box-login').animate({'opacity':'0.5'},500);
			
			$.ajax({
				url: '/<?php echo $this->GerenciadorCustom->slug; ?>/rc/index/get/<?php echo $this->get; ?>',
				type: 'POST',
				data: {senha:senha, repitaSenha:repitaSenha},
				success: function(row){

					$('.box-login').animate({'opacity':'1'},500);
					
					console.log(row);
					
					if (row == 'true'){
						alert('Senha alterada com sucesso.');
						location.href='/<?php echo $this->GerenciadorCustom->slug; ?>/login';
					} else {
						$('.erro_login').slideDown().html(row);
					}
					
				}
			});
		}
	
	</script>
	
	<div id="erro_usuario" class="erro_login" style="width:100%; position:fixed; top:0; left:0; background:#2f89a3; display:none; color:#FFF; padding:15px 0px; text-align:center;"></div>
	
	<form class="box-login box-esqueci animated fadeInUp" action="javascript:go();" style="display:block;">
		
		<h2><i class="fa fa-unlock-alt" aria-hidden="true"></i> Recuperar senha</h2>
		
		<input type="password" class="animated flipInX senha" placeholder="NOVA SENHA"/>
		<input type="password" class="animated flipInX repita-senha" placeholder="REPITA SENHA"/>
			
		<label class="animated flipInY" style="float:right;">
			<button type="submit" class="bt-recuperar">ENVIAR</button>
		</label>
		
	</form>

</body>
</html>