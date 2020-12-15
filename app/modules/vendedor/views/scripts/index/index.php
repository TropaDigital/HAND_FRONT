<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
		
	<section>
		<div id="central">
		
			<div class="box">
			
				<div class="titulo cor_b">
					<i class="pe-7s-users"></i>
					<span>Contas</span>
				</div>
				
				<div class="box-padding">
				
					<?php foreach($this->me->familia as $row){?>					
					<div class="contas-edit">
						<i class="pe-7s-user cor_c_hover"></i>
						<b><?php echo $this->me->nivel == 5 ? $row->gerenciador.' - ' : ''; echo $row->name_user;?></b>
					</div>
					<?php } ?>
					
				</div>
			
			</div>
			
			<div class="box">
			
				<div class="titulo cor_b">
					<span>Relatórios</span>
				</div>
				
				<div class="box-padding">
				
					<a class="item-central" href="/<?php echo $this->baseModule;?>/<?php echo $this->gerenciadorName;?>/relatorios">
						<i class="pe-7s-news-paper cor_c_hover"></i>
						<span>Relatório de Envios Analitico</span>
					</a>
					
					<a class="item-central" href="/<?php echo $this->baseModule;?>/<?php echo $this->gerenciadorName;?>/relatorios/sintetico">
						<i class="pe-7s-news-paper cor_c_hover"></i>
						<span>Relatório de Envios Sintético</span>
					</a>
				
				</div>
			
			</div>
		
		</div>
	</section>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>