	<header class="cor_a">
	
		<a class="logo" style="background:url(<?php echo $this->me->gCores->logo;?> ) center left no-repeat;" href="/<?php echo $this->baseModule;?>/"></a>
		
		<ul>
			
			<li>
				<a href="/<?php echo $this->baseModule;?>/<?php echo $this->gerenciadorName; ?>/login/sair"><i class="pe-7s-power"></i> Logout</a>
			</li>
		
		</ul>
	
	</header>
	
	<section>
		<ul class="navegacao">
		
			<li><a href="/<?php echo $this->baseModule;?>/<?php echo $this->gerenciadorName;?>/"><i class="pe-7s-home"></i> Home</a></li>
			
			<?php if ($this->baseController != 'index'):?>
				
				<li><a href="/<?php echo $this->baseModule;?>/<?php echo $this->gerenciadorName;?>/<?php echo $this->baseController;?>/"><?php echo str_replace('-', ' ', $this->baseController);?></a></li>
				
				<?php if ($this->baseAction != 'index'):?>
					<li><a href="/<?php echo $this->baseModule;?>/<?php echo $this->gerenciadorName;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>"><?php echo str_replace('-', ' ', $this->baseAction);?></a></li>
				<?php endif; ?>
			
			<?php endif; ?>
			
		</ul>
	</section>
	
	<div id="lateral">
	
		<div class="titulo cor_b">
		
			<i class="pe-7s-info"></i> <span>Informações gerais</span>
			
			<a class="pe-7s-left-arrow window"></a>
			
		</div>
		
		<ul>
			<li>
				<b>Usuário Atual</b>
				<span><?php echo $this->me->login; ?></span>
			</li>
		</ul>
	
	</div>