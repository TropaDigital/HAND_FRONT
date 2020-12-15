<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i> Relatório de cliques</span>
				</div>
				
				<div class="filtro-pag">
					<form class="filter">
					
						<input type="hidden" name="p" value="1" />
						<input type="hidden" name="limit" value="100" />
					
						<label class="checkbox cor_c_hover">
							<input onchange="javascript:$(this).parents('form').submit();" type="checkbox" name="unique" <?php echo $_GET['unique'] != NULL ? 'checked' : '';?>/>
							Unicos
						</label>
					
						<input name="d_i" class="d_i" placeholder="Periodo inicial" type="text" value="<?php echo $_GET['d_i']?>"/>
						<input name="d_f" <?php echo $_GET['d_f'] == NULL ? 'disabled' : ''; ?> class="d_f" placeholder="Periodo final" type="text" value="<?php echo $_GET['d_f']?>"/>
					
						<select name="id_campanha" onchange="javascript:$(this).parent().submit();">
                            <option value="">Todas campanhas</option>
							<?php foreach ( $this->campanhas as $row ){?>
							<option <?php echo $_GET['id_campanha'] == $row->id_campanha ? 'selected' : ''; ?> value="<?php echo $row->id_campanha;?>"><?php echo $row->campanha;?> - #<?php echo $row->id_campanha;?></option>
							<?php } ?>
						</select>
						
						<select name="acao" onchange="javascript:$(this).parent().submit();">
							<option value="">Todas ações</option>
							<option <?php echo $_GET['acao'] == 'interno' ? 'selected' : ''; ?> value="interno">Link interno</option>
							<option <?php echo $_GET['acao'] == 'externo' ? 'selected' : ''; ?> value="externo">Link externo</option>
							<option <?php echo $_GET['acao'] == 'facebook' ? 'selected' : ''; ?> value="facebook">Facebook</option>
							<option <?php echo $_GET['acao'] == 'telefone' ? 'selected' : ''; ?> value="telefone">Telefone</option>
							<option <?php echo $_GET['acao'] == 'email' ? 'selected' : ''; ?> value="email">E-mail</option>
							<option <?php echo $_GET['acao'] == 'sms' ? 'selected' : ''; ?> value="sms">SMS</option>
							<option <?php echo $_GET['acao'] == 'whatsapp' ? 'selected' : ''; ?> value="whatsapp">Whatsapp</option>
							<option <?php echo $_GET['acao'] == 'download' ? 'selected' : ''; ?> value="download">Download</option>
							<option <?php echo $_GET['acao'] == 'video' ? 'selected' : ''; ?> value="video">Video</option>
							<option <?php echo $_GET['acao'] == 'localizacao' ? 'selected' : ''; ?> value="localizacao">Localização</option>
						</select>
						
						<input name="contato" placeholder="Celular" type="text" value="<?php echo $_GET['celular']?>"/>
						
						<button type="submit"><i class="fa fa-search"></i></button>
						
						<a href="javascript:downloadPag();" class="download-page cor_font_a_hover">
						
							<span>
								<i class="fa fa-download" aria-hidden="true"></i>
							</span>
							
							Download
							
							<i class="fa fa-question-circle question tooltip left"  title="Download do resultado no formato CSV separado por ponto e virgula."></i>
						
						</a>
					
					</form>
				
				</div>
				
				<div class="contatos_lista">
				
					<fieldset class="mostrar_quanto">
					
						<span style="float:left; margin-left:0px;">Resultados por página</span>
						<select>
							<option <?php echo $_GET['limit'] == 10 ? 'selected' : '';?> <?php echo $_GET['limit'] == NULL ? 'selected' : '';?> value="10">10</option>
							<option <?php echo $_GET['limit'] == 25 ? 'selected' : '';?> value="25">25</option>
							<option <?php echo $_GET['limit'] == 50 ? 'selected' : '';?> value="50">50</option>
							<option <?php echo $_GET['limit'] == 100 ? 'selected' : '';?> value="100">100</option>
							<option <?php echo $_GET['limit'] == 250 ? 'selected' : '';?> value="250">250</option>
							<option <?php echo $_GET['limit'] == 500 ? 'selected' : '';?> value="500">500</option>
						</select>
						
						<a class="cor_a_hover">
							<i class="fa fa-list-ul" aria-hidden="true"></i>
							Paginação
						</a>
						
						<span class="total_registros">
						
							<b><?php echo $this->result->total_registros;?></b> registros encontrados.
						
						</span>
						
						<span>
						
							<b><?php echo count ( (array)$this->result->registros );?></b> registros listados.
						
						</span>
					
					</fieldset>
					
					<div class="paginacao top-pag" style="display:none; border-radius: 0px 0px 8px 8px; margin-top: -3px;margin-bottom: 20px;padding: 15px;border: none;background: #c6c6c6;"></div>
					
					<table style="border-radius:0px;">
					
						<tr>
						
							<th>Celular</th>
							<th>Campanha</th>
							<th>Ação</th>
							<th>Referência</th>
							<th>Data</th>
							
						</tr>
						
						<?php if ( $this->result->total_registros == 0 ) {?>
						
							<tr>
							
								<td colspan="8">Nenhum registro encontrado.</td>
							
							</tr>
						
						<?php } else { ?>
							
							<?php foreach( $this->result->registros as $row ){?>
							<tr>
							
								<td>
									<?php echo $row->contato; ?>
									<?php echo $row->nome != NULL ? '<br/>'.$row->nome : ''; ?>
								</td>
								<td>
                                    <a href="javascript:relatorioCampanha(<?php echo $row->id_campanha;?>);"><?php echo $this->campanhaNome[$row->id_campanha];?></a>
								</td>
								<td>
								
									<?php echo $row->tipo_acao; ?>
									<?php echo $row->acao != NULL ? '<br/>'.$row->acao : '';?>
								
								</td>
								<td><?php echo $row->referencia; ?></td>
								<td><?php echo str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->criado ) ) );?></td>
							
							</tr>
							<?php } ?>
						
						<?php } ?>
					
					</table>
					
					<div class="paginacao bottom-pag">
					
						<div class="pages">
							<?php if ( $_GET['p'] > 6 ) {?>
								<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=1">Primeira página</a>
							<?php } ?>
							
							<?php foreach($this->result->paginacao as $row):?>
							<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=<?php echo $row;?>" <?php echo $_GET['p'] == $row ? 'class="inativo"' : '';?>><?php echo $row;?></a>
							<?php endforeach;?>
							
							<?php if ( $_GET['p'] != $this->result->total_page ) {?>
								<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=<?php echo $this->result->total_page?>">Ultíma página</a>
							<?php } ?>
						</div>
						
						<div class="ir_para">
						
							Ir para página	
							<input type="number" max="<?php echo $this->result->total_page; ?>" class="ir_para_pagina" value="<?php echo $_GET['p'] == NULL ? '1' : $_GET['p'];?>"/>
						
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div>
	</div>
	
<?php include_once dirname(__FILE__).'/../layout/footer.php';?>