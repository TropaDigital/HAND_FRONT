<!DOCTYPE html>
<html lang="pt-br">
<head>
	<base href="/">
	<meta charset="UTF-8">
	<?php echo $this->metaPag; ?>
	<title>ZIGZAG</title>
	<?php echo $this->cssPag; ?>
	<link rel="stylesheet" type="text/css" href="assets/home/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/home/css/login.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	
</head>
<body style="background:url(<?php echo $this->GerenciadorCustom->background;?>); background-size:cover !important;">

	<?php if ( !empty($this->e) ): ?>
	<div id="message" class="error <?php echo is_array($this->e) ? key($this->e) : NULL; ?>">
		<i class="pe-7s-info"></i> <?php echo is_array($this->e) ? implode(', ', $this->e) : $this->e; ?>
	</div>
	<?php endif; ?>

	<?php if ($this->result['senha_envio']){?>
	
		<form class="mytoken" method="post" action="<?php echo $this->baseModule;?>/login/">
			<i class="fa fa-cog fa-spin"></i>
			<input type="hidden" name="login" value="<?php echo $this->result['login'];?>" placeholder="EMAIL">
			<input type="hidden" name="senha" value="<?php echo $this->result['senha_original'];?>" placeholder="SENHA">
		</form>
		<script>
			setTimeout(function(){
				$('form').submit();
			}, 1000);
		</script>
	<?php } else { ?>
	
		<form class="mytoken" method="post" action="<?php echo $this->baseModule;?>/login/set-senha?<?php echo http_build_query($_GET);?>">
			<input type="hidden" name="login" value="<?php echo $this->result['login'];?>" placeholder="EMAIL" required>
			<input type="hidden" name="senha" value="<?php echo $this->result['senha_original'];?>" placeholder="SENHA" required>
			<input type="text" name="senha_envio" placeholder="Senha">
			<input type="submit" value="Confirmar"/>
		</form>
	
	<?php } ?>

</body>
</html>