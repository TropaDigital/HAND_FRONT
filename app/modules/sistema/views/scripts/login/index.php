<?php include_once dirname(__FILE__).'/../layout/header.php';?>
	
	<form class="box-login animated fadeInDown" method="post" style="display: block;">
	
		<img class="logo animated bounceIn" src="assets/home/images/logo-login.png" style="display: inline;">
		
		<input type="text" class="lg animated bounceIn" name="login" placeholder="EMAIL" required style="display: inline-block;">
		<input type="password" class="pw animated bounceIn" name="senha" placeholder="SENHA" required style="display: inline-block;">
		
		<label class="animated bounceIn" style="display: inline;">
			<button type="submit">ENTRAR</button>
		</label>
		
	</form>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>