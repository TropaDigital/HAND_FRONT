<script>tooltip();</script>

<div id="bg-black" class="relatorio-campanha-individual animated fadeIn">

	<div id="relatorio-campanha" class="animated fadeInDown">
	
		<div class="topo cor_c">
		
			<a><?php echo $this->row->campanha;?></a>
			<a class="fa fa-times"></a>
		
		</div>
		
		<div class="conteudo">
		
			<div class="infos">
				
				<table>
				
					<tr>
					
						<td>Lista de contatos</td>
						<td>
						
							<?php foreach ( $this->relatorio->contatos as $row ) {?>
							
								<div>
									<?php echo $row->lista;?>
									<b>(<?php echo $row->total;?>)</b>
								</div>
							
							<?php } ?>
						
						</td>
					
					</tr>
				
					<tr>
						<td>Total de SMS</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/envios?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true">
								<?php echo $this->relatorio->envios->total; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>SMS enviados</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/envios?id_campanha=<?php echo $this->relatorio->id_campanha;?>&status=ESME_ROK|ACCEPTD&didf=true">
								<?php echo $this->relatorio->envios->sucesso_enviado; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>SMS não entregues</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/envios?id_campanha=<?php echo $this->relatorio->id_campanha;?>&status=UNDELIV&didf=true">
								<?php echo $this->relatorio->envios->nao_entregues; ?> 
							</a>
						</td>
					</tr>
					
					<tr>
						<td>SMS confirmados</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/envios?id_campanha=<?php echo $this->relatorio->id_campanha;?>&status=DELIVRD&didf=true">
								<?php echo $this->relatorio->envios->sucesso; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>SMS erro ao enviar</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/envios?id_campanha=<?php echo $this->relatorio->id_campanha;?>&status=ERROR&didf=true">
								<?php echo $this->relatorio->envios->erro; ?>
							</a>
						</td>
					</tr>
					
					<tr style="display:none;">
						<td>Não abertos <i class="fa fa-question tooltip" title="Contatos que receberam o SMS mas não abriram o template."></i></td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/envios?id_campanha=<?php echo $this->relatorio->id_campanha;?>&rejeitados=on&didf=true">
								<?php echo $this->relatorio->envios->rejeicoes; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>Envios duplicados</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/duplicados?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true">
								<?php echo $this->relatorio->envios->duplicados; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>Aceites de navegação</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/aceites?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true">
								<?php echo $this->relatorio->aceites->total; ?>
							</a>	
						</td>
					</tr>
					
					<tr>
						<td>Respostas de formulário <i class="fa fa-question tooltip" title="Apenas se houver formulário no template."></i></td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/form?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true">
								<?php echo $this->relatorio->respostas->total; ?>
							</a>
						</td>
					</tr>

                    <tr>
                        <td>Respostas de formulário únicas <i class="fa fa-question tooltip" title="Apenas se houver formulário no template."></i></td>
                        <td>
                            <a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/form?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true&unique=true">
                                <?php echo $this->relatorio->respostas->unicos; ?>
                            </a>
                        </td>
                    </tr>
					
					<tr>
						<td>Primeiro envio</td>
						<td> <?php echo $this->relatorio->envios->inicio; ?> </td>
					</tr>
					
					<tr>
						<td>Ultimo envio</td>
						<td> <?php echo $this->relatorio->envios->fim; ?> </td>
					</tr>
				
					<tr>
						<td colspan="2"><b>Interações</b>  <i class="fa fa-question tooltip" title="Cliques internos/externos dentro do template."></i></td>
					</tr>
					
					<tr>
						<td>Interações unicas</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/cliques?id_campanha=<?php echo $this->relatorio->id_campanha;?>&unique=on&didf=true">
								<?php echo $this->relatorio->cliques->unicos; ?>
							</a>	
						</td>
					</tr>
					
					<tr>
						<td>Interações totais</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/cliques?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true">
								<?php echo $this->relatorio->cliques->total; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>Primeira Interação</td>
						<td> <?php echo $this->relatorio->cliques->primeiro; ?> </td>
					</tr>
					
					<tr>
						<td>Ultima Interação</td>
						<td> <?php echo $this->relatorio->cliques->ultimo; ?> </td>
					</tr>
					
					<tr>
						<td colspan="2"><b>Aberturas</b> <i class="fa fa-question tooltip" title="Aberturas do template."></i></td>
					</tr>
					
					<tr>
						<td>Aberturas unicas</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/aberturas?id_campanha=<?php echo $this->relatorio->id_campanha;?>&unique=true&didf=true">
								<?php echo $this->relatorio->aberturas->unicos; ?> 
							</a>
						</td>
					</tr>
					
					<tr>
						<td>Aberturas totais</td>
						<td>
							<a class="cor_font_c_hover" href="<?php echo $this->baseModule;?>/relatorios/aberturas?id_campanha=<?php echo $this->relatorio->id_campanha;?>&didf=true">
								<?php echo $this->relatorio->aberturas->total; ?>
							</a>
						</td>
					</tr>
					
					<tr>
						<td>Primeira abertura</td>
						<td> <?php echo $this->relatorio->aberturas->primeiro; ?> </td>
					</tr>
					
					<tr>
						<td>Ultíma abertura</td>
						<td> <?php echo $this->relatorio->aberturas->ultimo; ?> </td>
					</tr>
				
				</table>
						
			</div>
			
			<div class="relative-absolute">
				
				<div class="template ld">
				
					<i class="fa fa-cog fa-spin load"></i>
				
				</div>
				
				<div class="template">
				
					<div class="mensagem animated fadeInUp">
					
						<?php echo $this->row->mensagem;?> <?php echo $this->GerenciadorCustom->shorturl;?>/l/<?php echo $this->row->id_landing_page;?>
					
					</div>
				
				</div>
			
			</div>
		
		</div>
	
	</div>

</div>

<script>

	setTimeout(function(){
		$('.mensagem').show(0);
	},500);

	setTimeout(function(){
		$('.ld').html('<iframe src="http://<?php echo $this->GerenciadorCustom->shorturl;?>/l/<?php echo $this->row->id_landing_page;?>"></iframe>');
	},1000);
	
</script>