		<ul id="funcoes_index">
		
		
			<?php foreach($this->menus as $row):?>
			
				<?php if ($row->id_permissao_pai == 0):?>
				
					<?php if ($row->link != 'javascript:;'):?>
					<li class="menu_comum">
						<a data-ripple="rgba(0,0,0, 0.4)" href="/<?php echo $this->baseModule;?>/<?php echo $row->link;?>">
							<?php echo $row->icone;?> <?php echo $this->lg->_($row->nome);?>
						</a>
					</li>
					<?php else: ?>
					
					<li class="menu_comum">
						<a><?php echo $row->icone;?> <?php echo $this->lg->_($row->nome);?> <i class="fa fa-angle-down seta"></i></a>
						
						<ul>
							<?php foreach($this->menus as $rew):?>
								<?php if ($rew->id_permissao_pai == $row->id_permissao):?>
									<li><a href="/<?php echo $this->baseModule;?>/<?php echo $rew->link;?>"><?php echo $this->lg->_($rew->nome);?></a></li>
								<?php endif; ?>
							<?php endforeach;?>
						</ul>
					</li>
					
					<?php endif;?>
					
				<?php else :?>
				
				<?php endif; ?>
		
			<?php endforeach; ?>
			
			<li class="menu_comum">
				<a href="/<?php echo $this->baseModule;?>/login/sair"><i class="fa fa-power-off"></i> <?php echo $this->lg->_("Sair"); ?></a>
			</li>

		</ul>
		
		<div class="fixed-bottom">
		<?php 
		  /*
		   * coloquei visibility: hidden a pedido da Anna pois a conta não estava batendo * @capetão
		   */
		?>
			<a class="celular-lateral cor_b">
				<img class="animated fadeInRight" src="assets/home/images/icons/creditos-restantes.png"/>
				<span><?php echo $this->lg->_("Créditos restantes "); ?><span><?php echo $this->sms_disponivel; ?></span></span>
			</a>
			
			<a class="celular-lateral cor_c" style="display:none;">
				<img class="animated fadeInRight" src="assets/home/images/icons/creditos-restantes.png"/>
				<span><?php echo $this->lg->_("Créditos bloqueados "); ?><span><?php echo $this->sms_bloq; ?></span></span>
			</a>
		</div>
		
