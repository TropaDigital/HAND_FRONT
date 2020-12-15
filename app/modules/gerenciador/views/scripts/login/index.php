<?php include_once dirname(__FILE__).'/../layout/header.php';?>
	
	<style>
		
		body {
			background:url(<?php echo $this->GerenciadorCustom->background;?>);
			background-size:cover !important;
		}
	
	</style>
	
	<form class="box-login animated fadeInDown" method="post" style="display: block; background:<?php echo $this->GerenciadorCustom->cor_c;?>">
	
		<div style="width:100%; position:relative; padding:15px 0px; box-sizing:border-box; float:left; background:<?php echo $this->GerenciadorCustom->logo_cor;?>; max-height:80px; background-size: auto;margin: 0px 0px 25px 0px;border-radius: 4px 4px 0px 0px;">
			<img style="max-height:51px" src="<?php echo $this->GerenciadorCustom->logo;?>"/>
		</div>
		
		<input type="text" class="lg animated bounceIn" name="login" placeholder="EMAIL" required style="display: inline-block;">
		<input type="password" class="pw animated bounceIn" name="senha" placeholder="SENHA" required style="display: inline-block;">
		
		<label class="animated bounceIn" style="display: inline;">
			<button type="submit">ENTRAR</button>
		</label>
		
	</form>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>