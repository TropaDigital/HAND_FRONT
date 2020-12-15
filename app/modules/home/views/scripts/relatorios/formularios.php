<?php include_once dirname(__FILE__).'/../layout/header.php';?>
	
	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i> Formulário respondidos</span>
				</div>
				
				<div class="options">
					<a class="bt_verde cor_c_hover" style="float:left; margin-left:20px;" href="<?php echo $this->baseModule;?>/relatorios/formularios-download/id/<?php echo $this->id;?>">Fazer Download</a>
				</div>
				
				<div class="contatos_lista">
			  				
			  		<table>
			  		
			  			<?php if (count($this->relatorio) == 0){?>
						
							<tr>
								<th>Mensagem</th>
							</tr>
							
							<tr>
								<td>Nenhum registro encontrado.</td>
							</tr>
						
						<?php } else { ?>
						
				  			<tr>
				  				<th style="width:200px;">Celular</th>
				  				<th style="width:92%;">Formulario</th>
				  			</tr>
				  			
				  			<?php foreach($this->relatorio as $row){?>
				  			
				  			<tr>
				  				<td>
				  					<span class="cel"><i class="fa fa-phone"></i> <?php echo $row->celular; ?></span>
				  				</td>
				  				<td>
				  				
				  					<?php 
				  					
					  					$json = $row->campos;
					  					$array = json_decode($json);
					  					$total = count($array) - 1;
					  					
					  					for ($i = 0; $i <= $total; $i++) {
					  						echo '<span class="pergunta">';
					  						foreach($array[$i] as $key => $row){
					  							
					  							echo '<span class="one">'.$key.'</span>';
					  							
					  							if (is_array($row)){
					  									
					  								foreach($row as $rara){
					  									
					  									if (is_array($rara)){
					  										
					  										foreach($row as $rere){
					  											
					  											echo '<span class="checkbox">'.$rere[0].'</span>';
					  											
					  										}
					  										
					  									} else {
					  										
					  										echo '<span class="checkbox">'.$rara.'</span>';
					  										
					  									}					  									
					  									
					  								}
					  									
					  							} else {
					  									
					  								echo '<span class="second">'.$row.'</span>';
					  									
					  							}
					  						}
					  						echo '</span>';
					  					}
				  					
				  					?>
				  				
				  				</td>
				  			</tr>
				  			<?php } ?>
				  			
			  			<?php } ?>
			  		</table>
			  		
			  		<?php echo $this->paginacao; ?>
			  			
				</div>
				
			</div>
			
		</div>
	</div>

	<script>
	function atu(id){
		$.ajax({
			url: '/rotina/campanha/id/'+id,
			success: function(){
				$('.tr_'+id).animate({'opacity':'1'});
			}, beforeSend: function(){
				$('.tr_'+id).animate({'opacity':'0.5'});
			}
		});
	}
	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>