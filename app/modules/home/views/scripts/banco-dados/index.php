<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content_select">
		<div class="box_conteudo">
		
				<div class="box_adc">
					<div class="top">
						<span class="titulo"><i class="fa fa-upload"></i> <?php echo $this->lg->_("Importação de CSV • Confirmar/editar contatos"); ?></span>
					</div>
					
					<div class="contatos_novo">
						<form id="myformsfafa" method="post" onsubmit="javascript:validaImporta();" action="<?php echo $this->backend;?>api/importacao/upload-arquivo" enctype="multipart/form-data">
			  				
			  				<?php 
    			  				$protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
                                $url = '://'.$_SERVER['HTTP_HOST'];
                             ?>
			  				
			  				<input type="hidden" name="basemodule" value="<?php echo $this->baseModule;?>"/>
			  				<input type="hidden" name="upload" value="novo">
			  				<input type="hidden" name="fase" value="1">
			  				<input type="hidden" name="url_old" value="<?php echo $protocolo.$url;?>/"/>
			  				
			  				<table>
			  				
			  					<tr>
									<td>
										<?php echo $this->lg->_("Lista"); ?>
									</td>
									
									<td>
										<select name="lista">
											<?php foreach($this->lista_contatos as $row){?>
											<option <?php echo $row->id_lista == $_GET['il'] ? "selected" : "";?> value="<?php echo $row->id_lista; ?>"><?php echo $row->lista; ?></option>
											<?php } ?>
										</select>
									</td>
								</tr>
			  				
			  					<tr>
			  						<td style="width:150px;"><?php echo $this->lg->_("Separador"); ?></td>
			  						<td>
						  				<select name="tipo">
						  					<option value=";">;</option>
						  					<option value=",">,</option>
						  				</select>
				  					</td>
				  				</tr>
				  				
				  				<tr>
			  						<td><?php echo $this->lg->_("Arquivo"); ?><br/><?php echo $this->lg->_("Formato permitido: "); ?><i><?php echo $this->lg->_("csv"); ?></i></td>
			  						<td>
			  							<button class="abrir_arquivo bt_vermelho" type="button"><i class="fa fa-cloud-upload"></i> <?php echo $this->lg->_("Escolher arquivo"); ?></button>
						  				<input style="display:none" class="escolher_csv" type="file" name="uploadfile" />
				  						<script>
											$('.abrir_arquivo').click(function(){
												$('.escolher_csv').trigger('click');
											});
											$('.escolher_csv').on('change', function(){

												var arquivo = $(this).val();
													arquivo = arquivo.substring(arquivo.lastIndexOf('\\'));
													
												$('.fakepath').remove();
												$('.abrir_arquivo').after('<div class="fakepath" style="float:left; width:100%; padding:0px 13px;">'+arquivo+'</div>');

												var arquivoSplit = arquivo.split('csv');

												if (arquivoSplit.length < 2 && arquivo){
													alert('Arquivo inválido.');
													$('.escolher_csv').val('');
													$('.fakepath').remove();
												}
												
											});
			  							</script>
				  					</td>
				  				</tr>
				  				
				  				<tr>
			  						<td><?php echo $this->lg->_("Contém cabeçalho?"); ?></td>
			  						<td class="campos-import">
			  							<label style="display:block;">
			  								<input type="radio" name="topo" checked value="sim"/> <?php echo $this->lg->_("Sim"); ?>
			  								<i style="font-size:15px; margin:-34px -15px 0px 0px; float:right;" class="fa fa-question-circle tooltip" data-titulo="<?php echo $this->lg->_("Quando selecionado, a primeira linha é ignorada e é utilizada apenas referência."); ?>"></i>
			  							</label>
			  							
			  							<label style="display:block;">
			  								<input type="radio" name="topo" value="nao"/> <?php echo $this->lg->_("Não"); ?>
			  								<i style="font-size:15px; margin:-34px -15px 0px 0px; float:right;" class="fa fa-question-circle tooltip" data-titulo="<?php echo $this->lg->_("Quando selecionado, a primeira linha é inserida e é utilizada para referência."); ?>"></i>
			  							</label>
			  						</td>
			  					</tr>
				  				
				  				<tr>
			  						<td><?php echo $this->lg->_("Selecione os campos"); ?></td>
			  						<td>
			  							
			  							<div class="campos-import">
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="referencia"/> <?php echo $this->lg->_("Referencia"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="nome"/> <?php echo $this->lg->_("Nome"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="sobrenome"/> <?php echo $this->lg->_("Sobrenome"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="data_nascimento"/> <?php echo $this->lg->_("Data de nascimento"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="email"/> <?php echo $this->lg->_("E-mail"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="celular" required/> <?php echo $this->lg->_("Celular"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo1"/> <?php echo $this->lg->_("CPF"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo2"/> <?php echo $this->lg->_("Empresa"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo3"/> <?php echo $this->lg->_("Cargo"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo4"/> <?php echo $this->lg->_("Telefone Comercial"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo5"/> <?php echo $this->lg->_("Telefone Residencial"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo6"/> <?php echo $this->lg->_("Pais"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo7"/> <?php echo $this->lg->_("Estado"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]"value="campo8"/> <?php echo $this->lg->_("Cidade"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo9"/> <?php echo $this->lg->_("Bairro"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo10"/> <?php echo $this->lg->_("Endereço"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="campo11"/> <?php echo $this->lg->_("Cep"); ?>
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_1"/> <?php echo $this->lg->_("Campo editavel"); ?> 1
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_2"/> <?php echo $this->lg->_("Campo editavel"); ?> 2
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_3"/> <?php echo $this->lg->_("Campo editavel"); ?> 3
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_4"/> <?php echo $this->lg->_("Campo editavel"); ?> 4
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_5"/> <?php echo $this->lg->_("Campo editavel"); ?> 5
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_6"/> <?php echo $this->lg->_("Campo editavel"); ?> 6
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_7"/> <?php echo $this->lg->_("Campo editavel"); ?> 7
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_8"/> <?php echo $this->lg->_("Campo editavel"); ?> 8
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_9"/> <?php echo $this->lg->_("Campo editavel"); ?> 9
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_10"/> <?php echo $this->lg->_("Campo editavel"); ?> 10
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_11"/> <?php echo $this->lg->_("Campo editavel"); ?> 11
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_12"/> <?php echo $this->lg->_("Campo editavel"); ?> 12
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_13"/> <?php echo $this->lg->_("Campo editavel"); ?> 13
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_14"/> <?php echo $this->lg->_("Campo editavel"); ?> 14
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_15"/> <?php echo $this->lg->_("Campo editavel"); ?> 15
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_16"/> <?php echo $this->lg->_("Campo editavel"); ?> 16
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_17"/> <?php echo $this->lg->_("Campo editavel"); ?> 17
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_18"/> <?php echo $this->lg->_("Campo editavel"); ?> 18
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_19"/> <?php echo $this->lg->_("Campo editavel"); ?> 19
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_20"/> <?php echo $this->lg->_("Campo editavel"); ?> 20
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_21"/> <?php echo $this->lg->_("Campo editavel"); ?> 21
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_22"/> <?php echo $this->lg->_("Campo editavel"); ?> 22
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_23"/> <?php echo $this->lg->_("Campo editavel"); ?> 23
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_24"/> <?php echo $this->lg->_("Campo editavel"); ?> 24
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_25"/> <?php echo $this->lg->_("Campo editavel"); ?> 25
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_26"/> <?php echo $this->lg->_("Campo editavel"); ?> 26
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_27"/> <?php echo $this->lg->_("Campo editavel"); ?> 27
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_28"/> <?php echo $this->lg->_("Campo editavel"); ?> 28
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_29"/> <?php echo $this->lg->_("Campo editavel"); ?> 29
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_30"/> <?php echo $this->lg->_("Campo editavel"); ?> 30
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_31"/> <?php echo $this->lg->_("Campo editavel"); ?> 31
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_32"/> <?php echo $this->lg->_("Campo editavel"); ?> 32
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_33"/> <?php echo $this->lg->_("Campo editavel"); ?> 33
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_34"/> <?php echo $this->lg->_("Campo editavel"); ?> 34
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_35"/> <?php echo $this->lg->_("Campo editavel"); ?> 35
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_36"/> <?php echo $this->lg->_("Campo editavel"); ?> 36
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_37"/> <?php echo $this->lg->_("Campo editavel"); ?> 37
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_38"/> <?php echo $this->lg->_("Campo editavel"); ?> 38
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_39"/> <?php echo $this->lg->_("Campo editavel"); ?> 39
			  								</label>
			  								
			  								<label>
			  									<input type="checkbox" name="campos[]" value="editavel_40"/> <?php echo $this->lg->_("Campo editavel"); ?> 40
			  								</label>
			  							
			  							</div>
			  							
				  					</td>
				  				</tr>
				  				
				  				<tr>
			  						<td><?php echo $this->lg->_("Concluir"); ?></td>
			  						<td>
						  				<input class="bt_verde cor_c_hover" type="submit" value="<?php echo $this->lg->_("ENVIAR"); ?>" />
				  					</td>
				  				</tr>
				  				
				  
			  				</table>
			  				
						</form>
						
						<div style="width:100%; overflow:auto;">
							<table class="excel">
								<tr class="linhacima">
								
									<td><i class="fa fa-caret-square-o-down"></i></td>
									
								</tr>
								
								<tr class="linhabaixo">
								
									<th>1</th>
									
								</tr>
							</table>
						</div>
						
					</div>
				</div>
				
				<script>

					$('#myformsfafa').submit(function(ev) {

					    if ( $('.escolher_csv').val() ) {

					    	 this.submit();
					    	
					    } else {

					    	 ev.preventDefault();
					    	 alert('Selecione um arquivo para prosseguir.');
					    	
					    }

					    
					});
				
					$(function(){
						$('label > input[type="checkbox"]').click(function(){

							var nome = $(this).attr('value');

							var nometd = $(this).parent().html().split('">');
							
							var linhacima = '<th class="linhacima_'+nome+'">'+nometd[1]+'</th>';
							var linhabaixo = '<td class="linhabaixo_'+nome+'"></td>';

							var linhacimatotal = $('.linhacima_'+nome).length;
							var linhabaixototal = $('.linhabaixo_'+nome).length;
							
							if (linhacimatotal == 0 || linhabaixototal == 0){
								$('.linhacima').append(linhacima);
								$('.linhabaixo').append(linhabaixo);
							} else {
								$('.linhacima_'+nome).remove();
								$('.linhabbaixo_'+nome).remove();
							}
							
						});
					});
				</script>
			
		
		</div>
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>