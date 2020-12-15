	<header>
	
		<a class="logo" style="background:url(<?php echo $this->GerenciadorCustom->logo;?>) left no-repeat; background-size:cover;" href="/<?php echo $this->baseModule;?>/"></a>
		
		<ul>
		
			<li>
				<a>
					<i class="pe-7s-user"></i><?php echo $this->me->nome; ?>
				</a>
				<ul>
					<li><a href="/<?php echo $this->baseModule;?>/user/editar/id/<?php echo $this->me->id_usuario;?>">Meus dados</a></li>
				</ul>
			</li>
			
			
			<li>
				<a href="/<?php echo $this->baseModule;?>/login/sair"><i class="pe-7s-power"></i> Logout</a>
			</li>
		
		</ul>
	
	</header>
	
	<section>
		<ul class="navegacao">
		
			<li><a href="/<?php echo $this->baseModule;?>/"><i class="pe-7s-home"></i> Home</a></li>
			
			<?php if ($this->baseController != 'index'):?>
				
				<li><a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/"><?php echo str_replace('-', ' ', $this->baseController);?></a></li>
				
				<?php if ($this->baseAction != 'index'):?>
					<li><a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>"><?php echo str_replace('-', ' ', $this->baseAction);?></a></li>
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
			
			<li style="display:none">
				<b>Campanhas ativas</b>
				<span><?php echo $this->minhasCampanhas->total_campanha; ?>/<?php echo $this->GerenciadorCustom->campanhas;?></span>
				<progress max="<?php echo $this->GerenciadorCustom->campanhas;?>" value="<?php echo $this->minhasCampanhas->total_campanha; ?>"></progress>
			</li>
			
			<li class="sms_relatorio" style="display:none">
				<b>SMS</b>
				<span><i class="fa fa-spin fa-spinner"></i>/<?php echo $this->GerenciadorCustom->sms;?></span>
				<progress max="<?php echo $this->GerenciadorCustom->sms;?>" value="0"></progress>
			</li>
			
			<li style="display:none">
				<b>Contas</b>
				<span><?php echo count($this->relatorioMeusUsuarios);?>/<?php echo $this->GerenciadorCustom->contas;?></span>
				<progress max="<?php echo $this->GerenciadorCustom->contas;?>" value="<?php echo count($this->relatorioMeusUsuarios);?>"></progress>
			</li>
			
		</ul>
		
	
	</div>
	
	<script>

		var id_usuario = $('body').data('usuarios');
		$.ajax({

			url: '<?php echo $this->backend?>api/sms/get-enviados-retorno/?status=CL&id_usuario='+id_usuario,
			type: 'GET',
			dataType: 'JSON',
			success: function(row){
				$('.sms_relatorio i').before(row.total_registros);
				$('.sms_relatorio i').remove();
				$('.sms_relatorio progress').attr('value', row.total_registros);
			}

		});

	</script>
		
