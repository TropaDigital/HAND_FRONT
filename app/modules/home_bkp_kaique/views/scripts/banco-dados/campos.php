<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content_select">
		<div class="box_conteudo">
		
			<div class="box_adc">
				<div class="top">
					<span class="titulo"><i class="fa fa-upload"></i> <?php echo $this->lg->_("Importação de CSV • Selecione as colunas"); ?></span>
				</div>
					
				<div class="contatos_novo">
					
					<form method="post" id="geraImportacao" action="<?php echo $this->backend; ?>api/importacao/send">
						
						<?php 
			  				$protocolo = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS']=="on") ? "https" : "http");
                            $url = '://'.$_SERVER['HTTP_HOST'];
                         ?>
                         
						<input type="hidden" name="basemodule" value="<?php echo $this->baseModule;?>"/>
						<input type="hidden" name="id_lista" value="<?php echo $this->lista;?>"/>
						<input type="hidden" name="tipo" value="<?php echo $this->tipo;?>"/>
						<input type="hidden" name="diretorio" value="<?php echo $this->diretorio;?>"/>
						<input type="hidden" name="diretorio_old" value="<?php echo $this->diretorio_old;?>"/>
						<input type="hidden" name="cabecalho" value="<?php echo $this->cabecalho;?>"/>
						<input type="hidden" name="url_old" value="<?php echo $protocolo.$url;?>/"/>
						<textarea style="display:none;" name="topo"><?php echo json_encode($this->topo);?></textarea>
						
						<table style="width:100%" class="restaurados">
								
							<?php $campos_nome = array('referencia'=>'Referencia','nome'=>'Nome', 'sobrenome'=>'Sobrenome', 'data_nascimento'=>'Data de nascimento', 'email'=>'Email', 'celular'=>'Celular', 'campo1'=>'CPF','campo2'=>'Empresa','campo3'=>'Cargo','campo4'=>'Telefone comercial','campo5'=>'Telefone Residencial','campo6'=>'Pais','campo7'=>'Estado','campo8'=>'Cidade','campo9'=>'Bairro','campo10'=>'Endereço','campo11'=>'Cep', 'editavel_1'=>'Editavel 1', 'editavel_2'=>'Editavel 2', 'editavel_3'=>'Editavel 3', 'editavel_4'=>'Editavel 4', 'editavel_5'=>'Editavel 5', 'editavel_6'=>'Editavel 6', 'editavel_7'=>'Editavel 7', 'editavel_8'=>'Editavel 8', 'editavel_9'=>'Editavel 9', 'editavel_10'=>'Editavel 10', 'editavel_11'=>'Editavel 11', 'editavel_12'=>'Editavel 12', 'editavel_13'=>'Editavel 13', 'editavel_14'=>'Editavel 14', 'editavel_15'=>'Editavel 15', 'editavel_16'=>'Editavel 16', 'editavel_17'=>'Editavel 17', 'editavel_18'=>'Editavel 18', 'editavel_19'=>'Editavel 19', 'editavel_20'=>'Editavel 20', 'editavel_21'=>'Editavel 21', 'editavel_22'=>'Editavel 22', 'editavel_23'=>'Editavel 23', 'editavel_24'=>'Editavel 24', 'editavel_25'=>'Editavel 25', 'editavel_26'=>'Editavel 26', 'editavel_27'=>'Editavel 27', 'editavel_28'=>'Editavel 28', 'editavel_29'=>'Editavel 29', 'editavel_30'=>'Editavel 30', 'editavel_31'=>'Editavel 31', 'editavel_32'=>'Editavel 32', 'editavel_33'=>'Editavel 33', 'editavel_34'=>'Editavel 34', 'editavel_35'=>'Editavel 35', 'editavel_36'=>'Editavel 36', 'editavel_37'=>'Editavel 37', 'editavel_38'=>'Editavel 38', 'editavel_39'=>'Editavel 39', 'editavel_40'=>'Editavel 40');?>
						
							<?php for($a = 0; $a < count($this->topo); $a++){ ?>
							<tr>
								<td>
									<?php echo $this->lg->_($this->topo[$a]); ?>
								</td>
								<td>
									<select name="<?php echo $this->topo[$a]; ?>" required>
										
										<option value="" selected disabled><?php echo $this->lg->_("Selecione um campo"); ?></option>
										
										<?php foreach($this->campos as $row){?>
										<option value="<?php echo $row; ?>"><?php echo $this->lg->_($campos_nome[$row]); ?></option>
										<?php } ?>
										
									</select>
									
									<label>
									
										<input type="checkbox" class="del"/><?php echo $this->lg->_("Excluir esse campo"); ?> 
									
									</label>
									
								</td>
							</tr>
							<?php } ?>
								
							<tr>
								<td colspan="2">
									<a href="/<?php echo $this->baseModule; ?>/banco-dados/index" class="bt_verde cor_b_hover"><?php echo $this->lg->_("Voltar"); ?> </a>
									<button type="submit" class="bt_verde cor_c_hover"><?php echo $this->lg->_("Avançar"); ?> </button>
								</td>
							</tr>
										
						</table>
						
					</form>
					
				</div>
			</div>
			
			<div class="box_adc box-deletados" style="display:none;">
				<div class="top">
					<span class="titulo"><?php echo $this->lg->_("Campos excluidos"); ?></span>
				</div>
					
				<div class="contatos_novo deletados">
					
					<table style="width:100%"></table>
					
				</div>
			</div>
		
		</div>
	</div>
	
	<script>

		$(document).on('click', '.del', function(){

			var txt;
			var r = confirm("Você tem certeza que deseja remover esse campo?");
			if (r == true) {

				var htmlTr = $(this).parents('tr').html();
					htmlTr = htmlTr.replace('Excluir', 'Restaurar');
					htmlTr = htmlTr.replace('del', 'rest');
				
				var content = '<tr>'+ htmlTr +'</tr>';
				$('.deletados table').append( content );
				$(this).parents('tr').remove();

				if ( $('.box-deletados table tr').length == 0 ){
					$('.box-deletados').hide(0);
				} else {
					$('.box-deletados').show(0);
				}
				
			} else {
				
				$(this).removeAttr("checked");
				
			}
			
		});

		$(document).on('click', '.rest', function(){

			var txt;
			var r = confirm("Você tem certeza que deseja restaurar esse campo?");
			if (r == true) {

				var htmlTr = $(this).parents('tr').html();
					htmlTr = htmlTr.replace('Restaurar', 'Excluir');
					htmlTr = htmlTr.replace('rest', 'del');
				
				var content = '<tr>'+ htmlTr +'</tr>';
				$('.restaurados tr:nth-child(1)').after( content );
				$(this).parents('tr').remove();

				if ( $('.box-deletados table tr').length == 0 ){
					$('.box-deletados').hide(0);
				} else {
					$('.box-deletados').show(0);
				}
				
			} else {
				
				$(this).removeAttr("checked");
				
			}
			
		});

	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>