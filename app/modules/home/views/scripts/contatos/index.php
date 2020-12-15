<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
			
			<?php if ($_GET['t'] == 'g'){ ?>
			<div class="box_adc">
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i> <?php echo $this->lg->_("Minhas listas"); ?></span>
				</div>
				
				<div class="options">
					<button onclick="modal('novo-grupo');" class="bt_verde bt-refresh cor_c_hover"><?php echo $this->lg->_("Adicionar nova lista de contatos"); ?></button>
				</div>
				
				<div class="contatos_lista">
					
					<table id="listas" width="100%" cellpadding="0" border="0" cellspacing="0">
						
						<?php foreach($this->result as $row){  ?>
						<tr data-user="<?php echo $row->id_usuario;?>" class="lista_<?php echo $row->id_lista; ?>" style="border-bottom:1px dashed rgba(0,0,0,0.05);">
							<td width="170" valign="top">
							
							
							
								<h2><?php echo $row->total_contatos; ?></h2>
								<a href="/<?php echo $this->baseModule;?>/contatos?t=c&id_lista=<?php echo $row->id_lista; ?>" class="ver-contatos cor_c_hover">
								
									<?php echo $this->lg->_("Ver contatos"); ?>
									<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Visualize os contatos selecionados para esta campanha."); ?>"></i>
								
								</a>
								
								<span class="user tooltip" title="<?php echo $this->lg->_("Autor da lista"); ?>">
								
									<i class="fa fa-cog fa-spin"></i>
								
								</span>
							
							</td>
							<td>
							
								<span class="titulo">
									<?php echo $row->lista; ?>
									
									<?php if ( $row->id_usuario == $this->me->id_usuario ){?>
									<span onclick="deletar_lista('<?php echo $row->id_lista;?>', '<?php echo $this->me->id_usuario;?>');" style="cursor:pointer; float:right;">
										<?php echo $this->lg->_("APAGAR LISTA"); ?>
										<i class="fa fa-times"></i>
									</span>
									<?php } ?>
									
								</span>
								
								<span class="left">
									<a href="/<?php echo $this->baseModule;?>/banco-dados?il=<?php echo $row->id_lista; ?>">
									
										<i class="fa fa-cloud-upload"></i> <?php echo $this->lg->_("Importar"); ?>
										<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Importe listas de contatos em formato CSV."); ?>"></i>
									
									</a>
									<a href="/<?php echo $this->baseModule;?>/contatos?t=c&id_lista=<?php echo $row->id_lista; ?>&export=true">
									
										<i class="fa fa-cloud-download"></i> <?php echo $this->lg->_("Exportar"); ?>
										<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Faça dowload da lista selecionada para esta campanha."); ?>"></i>
										
									</a>
									
									<a href="/<?php echo $this->baseModule;?>/campanha/nova-campanha?il=<?php echo $row->id_lista; ?>">
										
										<i class="fa fa-paper-plane"></i> <?php echo $this->lg->_("Enviar Campanha"); ?>
										<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Envie a campanha para os contato selecionados."); ?>"></i>
										
									</a>
										
										
									<a href="/<?php echo $this->baseModule;?>/contatos/lista-editar/id/<?php echo $row->id_lista; ?>">
									
										<i class="fa fa-pencil-square-o"></i> <?php echo $this->lg->_("Editar"); ?>
										<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Edite a lista de contatos selecionada para a campanha."); ?>"></i>
									
									</a>
								</span>
								
								<span class="right">
									<a style="cursor:pointer;" onclick="modal('adicionar-contatos', '<?php echo $row->id_lista;?>');">
									
										<i class="fa fa-user"></i> <?php echo $this->lg->_("Adicionar Contato"); ?>
										<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Adicione contatos individualmente, independente da lista."); ?>"></i>
									
									</a>
									<a href="/<?php echo $this->baseModule;?>/contatos?t=c&id_lista=<?php echo $row->id_lista; ?>&des=editar">
									
										<i class="fa fa-user"></i> <?php echo $this->lg->_("Editar Contatos"); ?>
										<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Edite individualmente os contatos da lista selecionada."); ?>"></i>
										
									</a>
								</span>
							
							</td>
						</tr>
						<?php } ?>
					</table>
					
				</div>
				
			</div>
			
			<?php } elseif ($_GET['t'] == 'c'){?>
			
			<?php if ($_GET['duplicados'] == 'true' && $this->duplicados->total_registros > 0){?>
			
				<div class="bg-black-duplicados animated fadeIn">
				
					<form action="javascript:passo('prox'); javascript:fechaDuplicados();" class="box-duplicados animated bounceInDown">
						<h2 style="text-align:center;"><i class="fa fa-warning"></i> <?php echo $this->duplicados->total_registros;?> <?php echo $this->lg->_("Celulares duplicados"); ?></h2>
						<h3 style="text-align:center;"><?php echo $this->lg->_("Parece que você tem alguns celulares duplicados, precisamos que você decida oque vai fazer com eles."); ?></h3>
						<div class="opcoes" style="text-align: center;">
							<button type="button" class="cor_b_hover" onclick="javascript:$('.bg-black-duplicados').fadeOut();">
							
								<?php echo $this->lg->_("Quero decidir depois"); ?>
								<i class="fa fa-question-circle tooltip" title="<?php echo $this->lg->_("Como padrão, iremos enviar todos os contatos inclusive os duplicados."); ?>" aria-hidden="true"></i>
							
							</button>
							<button type="button" class="cor_b_hover" onclick="javascript:location.href='<?php echo $this->baseModule;?>/contatos/duplicados/acao/manter/token/<?php echo base64_encode($_GET['id_lista']);?>';">
							
								<?php echo $this->lg->_("Quero mante-los"); ?>
								<i class="fa fa-question-circle tooltip" title="<?php echo $this->lg->_("Iremos manter todos os contatos da lista."); ?>" aria-hidden="true"></i>
							
							</button>
							<button type="submit" class="cor_c_hover" onclick="javascript:location.href='<?php echo $this->baseModule;?>/contatos/duplicados/acao/descartar/token/<?php echo base64_encode($_GET['id_lista']);?>';">
							
								<?php echo $this->lg->_("Quero excluir todos contatos duplicados"); ?>
								<i class="fa fa-question-circle tooltip" title="<?php echo $this->lg->_("Iremos excluir apenas os contatos duplicados e deixar sua lista com contatos unicos."); ?>" aria-hidden="true"></i>
								
							</button>
						</div>
					</form>
					
				</div>
			
			<?php } ?>
			
			<div class="box_adc">
			
				<div class="top">
					<span class="titulo"><i class="fa fa-users"></i><?php echo $this->lg->_("Meus contatos"); ?> </span>
				</div>
				
				<div class="filtro-pag">
				
					<form class="filter">
						<input type="hidden" name="p" value="1" />
						<input type="hidden" name="limit" value="10" />
						
						<input type="hidden" name="t" value="<?php echo $_GET['t'];?>"/>
						<input type="hidden" name="id_lista" value="<?php echo $_GET['id_lista'];?>"/>
						<input type="hidden" name="des" value="editar"/>
						<input type="hidden" name="buscar" value="1"/>
						<input name="celular" value="<?php echo $_GET['celular'];?>" placeholder="<?php echo $this->lg->_("Buscar por celular"); ?>" style="padding-right:35px;" type="text"/>
						<button type="submit"><i class="fa fa-search"></i></button>
						
						<a href="javascript:downloadPag();" class="download-page cor_font_a_hover">
						
							<span>
								<i class="fa fa-download" aria-hidden="true"></i>
							</span>
							
							<?php echo $this->lg->_("Download"); ?>
							
							<i class="fa fa-question-circle question tooltip left"  title="<?php echo $this->lg->_("Download do resultado no formato CSV separado por ponto e virgula."); ?>"></i>
						
						</a>
						
						<?php if ( $_GET['export'] ) { ?>
						
							<script>

								$(function(){

									setTimeout(function(){
										downloadPag();
									},500);
									
								});
							
							</script>
						
						<?php } ?>
						
						<div style="float:right; width:610px; margin-top:-15px;">
							<button type="button" onclick="location.href='/<?php echo $this->baseModule;?>/contatos?t=g';" class="bt_verde cor_c_hover"><?php echo $this->lg->_("Minhas listas"); ?></button>
							<button type="button" onclick="modal('adicionar-contatos', '<?php echo $_GET['id_lista'];?>');" class="bt_verde cor_c_hover"><?php echo $this->lg->_("Adicionar contato novo"); ?></button>
							<button type="button" onclick="location.href='/<?php echo $this->baseModule;?>/banco-dados?il=<?php echo $_GET['id_lista'];?>';" class="bt_verde cor_c_hover"><?php echo $this->lg->_("Importar contatos"); ?></button>
						</div>
						
					</form>
					
				</div>
				
				<div class="contatos_lista">
				
					<fieldset class="mostrar_quanto">
					
						<span style="float:left; margin-left:0px;"><?php echo $this->lg->_("Resultados por página"); ?></span>
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
							<?php echo $this->lg->_("Paginação"); ?>
						</a>
						
						<span class="total_registros">
						
							<b><?php echo $this->result->total_registros;?></b> <?php echo $this->lg->_("registros encontrados."); ?>
						
						</span>
						
						<span>
						
							<b><?php echo count ( (array)$this->result->registros );?></b> <?php echo $this->lg->_("registros listados."); ?>
						
						</span>
					
					</fieldset>
					
					<div class="paginacao top-pag" style="display:none; border-radius: 0px 0px 8px 8px; margin-top: -3px;margin-bottom: 20px;padding: 15px;border: none;background: #c6c6c6;"></div>
					
					<form id="mydel" method="post" action="/<?php echo $this->baseModule;?>/contatos/del/id_lista/<?php echo $_GET['id_lista'];?>">
					
						<table width="100%" cellpadding="0" border="0" cellspacing="0">
							<tr>
								<th width="1">
									<input type="checkbox" class="select_all"/>
								</th>
								<th width="1"><i class="fa fa-pencil"></i></th>
								<th><?php echo $this->lg->_("Celular"); ?></th>
								<th><?php echo $this->lg->_("Nome"); ?></th>
							</tr>
							
							<?php if (count($this->result->registros) > 0):?>
							
								<?php foreach($this->result->registros as $row){?>
								<tr class="contato_<?php echo $row->id_contato;?>">
						    		<td width="1">
						    		
						    			<input type="checkbox" name="id[]" value="<?php echo $row->id_contato;?>"/>
						    		
						    		</td>
						    		<td width="1" class="edit"><a style="color:#666;" href="/<?php echo $this->baseModule;?>/contatos/editar/id/<?php echo $row->id_contato;?>?il=<?php echo $row->id_lista; ?>"><i style="cursor:pointer;" class="fa fa-pencil"></i></a></td>
						    		<td><?php echo $row->celular;?></td>
						    		<td><?php echo $row->nome;?></td>
					    		</tr>
					    		<?php } ?>
				    		
				    		<?php else: ?>
				    		
				    			<tr>
				    				<td colspan="4"><?php echo $this->lg->_("Não existe nenhum registro para ser mostrado."); ?></td>
				    			</tr>
				    		
				    		<?php endif; ?>
						</table>
						
						<button class="cor_c_hover bt_verde"> <i class="fa fa-trash"></i> <?php echo $this->lg->_("Apagar selecionados"); ?></button>
						
					</form>
					
					<script>

						$('#mydel').submit(function() {
						    var c = confirm("Tem certeza que deseja excluir esses contatos?");
						    return c;
						});
					
						$('.select_all').bind('click', function(){

							$(this).toggleClass('active');

							if ( $(this).hasClass('active') ) {

								$(this).parents('form').find('input[type="checkbox"]').prop('checked', true);
								console.log('checked');

							} else {

								$(this).parents('form').find('input[type="checkbox"]').prop('checked',false);
								console.log('unchecked');
								
							}
							
						});

					</script>
					
					<div class="paginacao bottom-pag">
					
						<div class="pages">
							<?php if ( $_GET['p'] > 6 ) {?>
								<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=1"><?php echo $this->lg->_("Primeira página"); ?></a>
							<?php } ?>
							
							<?php foreach($this->result->paginacao as $row):?>
							<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=<?php echo $row;?>" <?php echo $_GET['p'] == $row ? 'class="inativo"' : '';?>><?php echo $row;?></a>
							<?php endforeach;?>
							
							<?php if ( $_GET['p'] != $this->result->total_page ) {?>
								<a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/<?php echo $this->baseAction;?>?<?php echo http_build_query( $_GET ); ?>&p=<?php echo $this->result->total_page?>"><?php echo $this->lg->_("Ultíma página"); ?></a>
							<?php } ?>
						</div>
						
						<div class="ir_para">
						
							<?php echo $this->lg->_("Ir para página"); ?>	
							<input type="number" max="<?php echo $this->result->total_page; ?>" class="ir_para_pagina" value="<?php echo $_GET['p'] == NULL ? '1' : $_GET['p'];?>"/>
						
						</div>
						
					</div>
				
				</div>
			</div>
			<?php } ?>
			
		</div>
		
	</div>
	
	<input type="hidden" class="refresh" value="true"/>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>