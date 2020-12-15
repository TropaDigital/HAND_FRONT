<?php include_once dirname(__FILE__).'/../layout/header.php';?>
	
	<style>
        body {
        	background:<?php echo $this->result->background == NULL ? '#EAEAEA' : 'url('.$this->result->background.') center top; background-size:cover;';?>;
        }
    </style>
	
	<form class="box-login animated fadeInDown" method="post" style="display: block; background:<?php echo $this->result->cor_c;?>">
	
		<div style="width:100%; position:relative; padding:15px 0px; box-sizing:border-box; float:left; background:<?php echo $this->result->logo_cor == NULL ? '#FFF' : $this->result->logo_cor;?>; max-height:80px; background-size: auto;margin: 0px 0px 25px 0px;border-radius: 4px 4px 0px 0px;">
			<img style="max-height:51px" src="<?php echo $this->result->logo == NULL ? 'assets/home/images/logo-login.png' : $this->result->logo; ?>"/>
		</div>
		
		<input type="text" class="lg animated bounceIn" name="login" placeholder="EMAIL" required style="display: inline-block;">
		<input type="password" class="pw animated bounceIn" name="senha" placeholder="SENHA" required style="display: inline-block;">
		
		<label class="animated bounceIn" style="display: inline;">
			<button type="submit">ENTRAR</button>
		</label>
		
	</form>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>