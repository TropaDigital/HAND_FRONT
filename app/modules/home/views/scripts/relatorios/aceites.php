<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-bars"></i> Relatório de campanha</span>
				</div>
				
				<div class="filtro-pag">
					<form class="filter">
					
						<input type="hidden" name="p" value="1" />
						<input type="hidden" name="limit" value="100" />
					
						<input name="d_i" class="d_i" placeholder="Periodo inicial" type="text" value="<?php echo $_GET['d_i']?>"/>
						<input name="d_f" <?php echo $_GET['d_f'] == NULL ? 'disabled' : ''; ?> class="d_f" placeholder="Periodo final" type="text" value="<?php echo $_GET['d_f']?>"/>
					
						<select name="id_campanha" onchange="javascript:$(this).parent().submit();">
                            <option value="">Todas campanhas</option>
							<?php foreach ( $this->campanhas as $row ){?>
							<option <?php echo $_GET['id_campanha'] == $row->id_campanha ? 'selected' : ''; ?> value="<?php echo $row->id_campanha;?>"><?php echo $row->campanha;?></option>
							<?php echo $_GET['id_campanha'].' == '.$row->id_campanha; ?>
							<?php } ?>
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
							<th>Titulo</th>
                            <th>Texto</th>
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
									<?php echo $row->celular; ?><?php print_r($row->id_campanha);?>
								</td>
								<td>
									<a href="javascript:relatorioCampanha(<?php echo $row->id_campanha;?>);"><?php echo $this->campanhaNome[$row->id_campanha];?></a>
								</td>
								<td><?php echo $row->titulo; ?></td>
                                <td><?php echo $row->texto; ?></td>
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