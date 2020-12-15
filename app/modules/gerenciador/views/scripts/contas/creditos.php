<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
		<form class="div_content" method="post">
			
			<table class="table-edicao">
					
				<tr class="cor_b">
					<th width="220">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
					<td>
						Adicionar créditos
					</td>
					<td>
					
						<input type="text" name="creditos" value="<?php echo $this->row->creditos; ?>"/>
						<button class="cor_c_hover">Adicionar</button>
						
					</td>
				</tr>
				
			</table>
			
			<h3 style="width:100%; float:left;">Histórico de créditos</h3>
			
			<table class="table-edicao">
				
    			<tr class="cor_b">
    				<th>Créditos</th>
    				<th>Data</th>
    			</tr>
    		
    		
    			<?php $total = 0; foreach ( $this->creditos as $row ){ $total = $total + $row->creditos;?>
    			<tr>
    				<td><?php echo $row->creditos;?></td>
    				<td><?php echo date('d/m/Y H:i:s', strtotime( $row->criado ));?></td>
    			</tr>
    			<?php } ?>
    			
    			
    		</table>
    		
    		<h3 style="width:100%; float:left;">Saldo disponível</h3>
    		
    		<table class="table-edicao">
    		
    			<tr class="cor_c">
    				<th colspan="1">Saldo disponível</th>
    			</tr>
    			
    			<tr>
    				<td><?php echo $this->creditos_restante['credits'];?></td>
    			</tr>
				
			</table>
		</form>
	</div>	

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>