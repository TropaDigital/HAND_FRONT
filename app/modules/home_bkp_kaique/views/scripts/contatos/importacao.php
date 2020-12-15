<?php include_once dirname(__FILE__).'/../layout/header.php';?>

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
			<i class="fa fa-users"></i> Contatos
		</li>
	</ul>
	
	<div class="div_content">
		<div class="box_conteudo">
		
		<?php if ($_POST['fase'] == ''){ ?>
				<div class="box_adc" style="width:95%; margin-bottom:0px;">
					<div class="top" style="background:#64BE59">
						<span class="titulo"><i class="fa fa-upload"></i> Importação de CSV • Confirmar/editar contatos</span>
					</div>
					
					<div class="contatos_novo">
						<form method="post" action="/contatos/importacao" enctype="multipart/form-data">
			  				<input type="hidden" name="upload" value="novo">
			  				<input type="hidden" name="fase" value="1">
			  				
			  				<table>
			  				
			  					<tr>
			  						<td>Separador</td>
			  						<td>
						  				<select name="tipo">
						  					<option value=";">;</option>
						  					<option value=",">,</option>
						  				</select>
				  					</td>
				  				</tr>
				  				
				  				<tr>
			  						<td>Arquivo</td>
			  						<td>
			  							<button class="abrir_arquivo bt_vermelho" type="button"><i class="fa fa-cloud-upload"></i> Escolher arquivo</button>
						  				<input style="display:none" class="escolher_csv" type="file" name="uploadfile" />
				  						<script>
											$('.abrir_arquivo').click(function(){
												$('.escolher_csv').trigger('click');
											});
			  							</script>
				  					</td>
				  				</tr>
				  				
				  				<tr>
			  						<td>Concluir</td>
			  						<td>
						  				<input class="bt_verde" type="submit" value="Enviar" />
				  					</td>
				  				</tr>
				  				
				  
			  				</table>
			  				
						</form>
					</div>
				</div>
		<?php } ?>
			
			<?php if ($_POST['fase'] == '1'){ ?>
				<div class="box_adc" style="width:94%;">
					<div class="top" style="background:#64BE59">
						<span class="titulo"><i class="fa fa-upload"></i> Importação de CSV • Selecione as colunas</span>
					</div>
					
					<div class="contatos_novo">
						<?php
						$open = fopen($this->diretorio, 'r');
						if ($open){
							$delimitador = $this->tipo;
							$cerca = '"';
						
							$cabecalho = fgetcsv($open, 0, $delimitador, $cerca);
							if (count($cabecalho) > 1){
							?>
								<form method="post">
									<table width="100%">
										<?php while(list($key, $val) = each($cabecalho) ){ ?>
										<tr>
											<th><?php echo utf8_encode($val); ?></th>
											<td>
												<label>
													<input name="nome" class="label_input" value="<?php echo utf8_encode($val); ?>" type="radio"> Nome
												</label>
												
												<label>
													<input name="celular" class="label_input" value="<?php echo utf8_encode($val); ?>" type="radio"> Celular
												</label>
												
												<label>
													<input name="email" class="label_input" value="<?php echo utf8_encode($val); ?>" type="radio"> Email
												</label>
											</td>
										</tr>
										<?php } ?>
										
										<tr>
											<th>
												Lista
											</th>
											<td>
												<select name="lista">
													<?php foreach($this->lista_contatos as $row){?>
													<option value="<?php echo $row->id_lista; ?>"><?php echo $row->lista; ?></option>
													<?php } ?>
												</select>
											</td>
										</tr>
										
										<tr>
											<th>
												<input type="hidden" name="tipo" value="<?php echo $this->tipo; ?>">
												<input type="hidden" name="arquivo" value="<?php echo $this->diretorio; ?>">
												<input type="hidden" name="fase" value="2">
											</th>
											<td>
												<a href="/contatos/importacao"><input type="button" class="bt_vermelho" value="Voltar" style="width:100px;"></a>
												<input type="submit" class="bt_verde" value="Avançar" style="width:100px;">
											</td>
										</tr>
										
									</table>
									
								</form>
							<?php
							}
							fclose($open);
						}
						?>
					</div>
				</div>
				
			<?php } elseif ($_POST['fase'] == '2') { ?>
			
				<div class="box_adc" style="width:94%;">
					<div class="top" style="background:#64BE59">
						<span class="titulo"><i class="fa fa-upload"></i> Importação de CSV • Confirmar/editar contatos</span>
					</div>
					
					<div class="contatos_novo">
						
						<form method="post">
							
							<table width="100%" align="left">
								<tr>
									<?php if ($_POST['nome']){ ?>
									<th>Nome - <i><?php echo $_POST['nome']; ?></i></th>
									<?php } ?>
									
									<?php if ($_POST['email']){ ?>
									<th>Email - <i><?php echo $_POST['email']; ?></i></th>
									<?php } ?>
									
									<?php if ($_POST['celular']){ ?>
									<th>Celular - <i><?php echo $_POST['celular']; ?></i></th>
									<?php } ?>
								</tr>
								
								<tr>
									<?php 
										// NOME
										if ($_POST['nome']){
											echo '<td>';
											$nome = fopen($this->diretorio, 'r');
											if ($nome) {
												$delimitador = $this->tipo;
												$cerca = '"';
												$cabecalho = fgetcsv($nome, 0, $delimitador, $cerca);
												$i = 1;
												while (!feof($nome)) {
													$linha = fgetcsv($nome, 0, $delimitador, $cerca);
													$registro = array_combine($cabecalho, $linha);
													echo '<input name="id[]" id="id[]" type="hidden" value=\''.$i.'\'>';
													echo '<input style="width:96%;" name="nome[]" id="nome[]" type="text" value=\''.utf8_encode($registro[$_POST[nome]]).'\'>';
													$i ++;
												}
												fclose($nome);
											}
											echo '</td>';
										}
										
										//EMAIL
										if ($_POST['email']){
											echo '<td>';
											$email = fopen($this->diretorio, 'r');
											if ($email) {
												$delimitador = $this->tipo;
												$cerca = '"';
												$cabecalho = fgetcsv($email, 0, $delimitador, $cerca);
												while (!feof($email)) {
													$linha = fgetcsv($email, 0, $delimitador, $cerca);
													$registro = array_combine($cabecalho, $linha);
													echo '<input style="width:96%;" name="email[]" id="email[]" type="text" value=\''.utf8_encode($registro[$_POST[email]]).'\'>';
												}
												fclose($email);
											}
											echo '</td>';
										}
										
										// CELULAR
										if ($_POST['celular']){
											echo '<td>';
											$celular = fopen($this->diretorio, 'r');
											if ($celular) {
												$delimitador = $this->tipo;
												$cerca = '"';
												$cabecalho = fgetcsv($celular, 0, $delimitador, $cerca);
												while (!feof($celular)) {
													$linha = fgetcsv($celular, 0, $delimitador, $cerca);
													$registro = array_combine($cabecalho, $linha);
													echo '<input style="width:96%;" name="celular[]" id="celular[]" type="text" value=\''.utf8_encode($registro[$_POST[celular]]).'\'>';
												}
												fclose($celular);
											}
											echo '</td>';
										}
										
									?>
								</tr>
								
								<tr>
									<td>
										<input type="hidden" name="lista" value="<?php echo $_POST['lista']; ?>">
										<input type="hidden" name="fase" value="3">
										<input type="hidden" name="arquivo" value="<?php echo $this->diretorio; ?>">
										<input type="submit" class="bt_verde" value="Salvar" style="width:100px;">
									</td>
									<td></td>
									<td></td>
								</tr>
								
							</table>
							
						</form>
						
					</div>
					
				</div>
			
			<?php } ?>
			
		</div>
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>