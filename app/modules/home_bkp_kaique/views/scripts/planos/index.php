<?php include 'layout_'.$this->baseModule.'/header.php'; ?>

	<ul id="funcoes">
		<li class="title">
			<a href="/">
				<i class="fa fa-home"></i> Início
			</a>
		</li>
		
		<li class="title">
			<i class="fa fa-angle-double-right" style="margin-right:0px;"></i>
		</li>
		
		<li class="title">
			<i class="fa fa-database"></i> Planos
		</li>
	</ul>
	
	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc" style="width:95%; margin-bottom:0px;">
				<div class="top" style="background:#64BE59">
					<span class="titulo"><i class="fa fa-bar-chart"></i> Meu Plano - <?php echo $this->planos[0]->plano; ?></span>
				</div>
					
				<div class="contatos_novo">
					
					<table>
						<tr>
							<th>Preço</th>
							<th class="left">QTD. SMS</th>
							<th class="left" style="text-align:center;">Campanhas ativa</th>
							<th class="left" style="text-align:center;">Caixa de entrada</th>
							<th class="left" style="text-align:center;">CSS Customizavel</th>
							<th class="left" style="text-align:center;">JS Customizavel</th>
							<th class="left" style="text-align:center;">Landing Pages</th>
						</tr>
						
						<tr>
							<td>R$ <?php echo $this->planos[0]->valor; ?><span>/mês</span></td>
							<td class="left"><?php echo $this->planos[0]->num_sms; ?></td>
							<td class="left"><?php echo $this->planos[0]->campanhas_ativa; ?></td>
							
							<td class="left" style="text-align:center;">
							
								<?php if ($this->planos[0]->caixa_entrada == '0'){?>
									<i class="fa fa-square-o"></i>
								<?php } else {?>
									<i class="fa fa-check-square-o"></i>
								<?php }?>
								
							</td>
							
							<td class="left" style="text-align:center;">
							
								<?php if ($this->planos[0]->valor == '0'){?>
									<i class="fa fa-square-o"></i>
								<?php } else {?>
									<i class="fa fa-check-square-o"></i>
								<?php }?>
								
							</td>
							
							<td class="left" style="text-align:center;">
							
								<?php if ($this->planos[0]->valor == '0'){?>
									<i class="fa fa-square-o"></i>
								<?php } else {?>
									<i class="fa fa-check-square-o"></i>
								<?php }?>
								
							</td>
							<td class="left" style="text-align:center;">
							
								<?php if ($this->planos[0]->valor == '0'){?>
									<i class="fa fa-square-o"></i>
								<?php } else {?>
									<i class="fa fa-check-square-o"></i>
								<?php }?>
								
							</td>
						</tr>
					</table>
					
				</div>
				
			</div>
		</div>
		
		<div class="planos">
			<hr/>
			<h2><i class="fa fa-list-alt"></i> Planos ZigZag</h2>
			
			<div style="width:100%; margin-top:20px; margin-bottom:20px; float:left;">
				<div class="m_t_a ativo">
					<div class="tipo">Mensal</div>
					<div class="desconto">x% off</div>
				</div>
				
				<div class="m_t_a">
					<div class="tipo">Trimestral</div>
					<div class="desconto">x% off</div>
				</div>
				
				<div class="m_t_a">
					<div class="tipo">Semestral</div>
					<div class="desconto">x% off</div>
				</div>
				
				<div class="m_t_a">
					<div class="tipo">Anual</div>
					<div class="desconto">x% off</div>
				</div>
			</div>
			
		</div>
		
		<div class="box_conteudo" style="margin-top:0px; margin-bottom:5px;">
		
		<script>
			function abrir_paga(div){
				var planos = $(div).parent().parent().find('.dados_planos');
				$(planos).slideToggle();
			}
		</script>
		
		<?php foreach($this->lista_planos as $row){?>
		
			<div class="box_adc" style="width:95%; margin-bottom:0px;">
				<div class="top">
					<span class="titulo"><?php echo $row->plano; ?></span>
					<button class="bt_contrata" onclick="abrir_paga(this);" type="button">CONTRATAR</button>
				</div>
					
				<div class="contatos_novo">
					
					<table>
						<tr>
							<th>Preço</th>
							<th class="left">QTD. SMS</th>
							<th class="left" style="text-align:center;">Campanhas ativa</th>
							<th class="left" style="text-align:center;">Caixa de entrada</th>
							<th class="left" style="text-align:center;">CSS Customizavel</th>
							<th class="left" style="text-align:center;">JS Customizavel</th>
							<th class="left" style="text-align:center;">Landing Pages</th>
						</tr>
						
						<tr>
							<td>R$ <?php echo $row->valor; ?><span>/mês</span></td>
							<td class="left"><?php echo $row->num_sms; ?></td>
							<td class="left"><?php echo $row->campanhas_ativa; ?></td>
							<td class="left" style="text-align:center;">
								<?php if ($row->caixa_entrada == '1'){?>
									<i class="fa fa-check-square-o"></i>
								<?php } else {?>
									<i class="fa fa-square-o"></i>
								<?php }?>
							</td>
							<td class="left" style="text-align:center;"><i class="fa fa-check-square-o"></i></td>
							<td class="left" style="text-align:center;"><i class="fa fa-check-square-o"></i></td>
							<td class="left" style="text-align:center;"><i class="fa fa-check-square-o"></i></td>
						</tr>
					</table>
					
				</div>
				
				<div class="dados_planos">
					<img src="/assets/<?php echo $this->baseModule;?>/images/bandeiras-cartao.png"/>
					<button class="bt_contrata" style="margin-top:15px; font-size:16px; border:2px solid #FFF; -webkit-box-shadow: 0px 22px 48px 0px rgba(0,0,0,0.24);-moz-box-shadow: 0px 22px 48px 0px rgba(0,0,0,0.24);box-shadow: 0px 22px 48px 0px rgba(0,0,0,0.24);"><i class="fa fa-credit-card"></i> PAGAR AGORA</button>
				</div>
				
			</div>
			
		<?php } ?>
		
		</div>
		
	</div>

<?php include 'layout_'.$this->baseModule.'/footer.php'; ?>