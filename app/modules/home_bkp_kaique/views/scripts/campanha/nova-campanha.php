<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

	<div onclick="campanhasAtivas();" class="bg-campanhas-ativas-preto" style="display:none;"></div>

	<div class="bg-campanhas-ativas" style="display:none;">

		<div class="titulo-bg-campanhas-ativas">

			<?php echo $this->lg->_("Você já possuiu"); ?> <b class="total_campanhas">3</b> <?php echo $this->lg->_("campanhas ativas."); ?>

		</div>

		<p><i class="fa fa-warning"></i> <?php echo $this->lg->_("Desative uma campanha ou faça um upgrade do seu plano."); ?></p>

		<div class="todas-campanhas-ativas">

			<?php foreach($this->campanhas as $row){ ?>

				<div style="margin-top:0px; margin-bottom:15px;" class="box-campanha box-c-<?php echo $row->id_campanha; ?>">

					<div class="table">

						<div class="ico"><i class="fa fa-paper-plane"></i></div>

						<div class="nome"><?php echo $row->campanha;?></div>

					</div>

					<script>

						<?php if ($_GET['tipo'] == 'sms'){?>
						var link = 'false';
						<?php } else { ?>
						var link = 'true';
						<?php } ?>
						var contatosGeral_<?php echo $row->id_campanha; ?> = 0;
						
						$.ajax({

							url: '/<?php echo $this->baseModule; ?>/campanha/quantidade-contatos/id/<?php echo $row->id_campanha; ?>',
							dataType: 'JSON',
							success: function(row){

								for(var i in row) {

									contatosGeral_<?php echo $row->id_campanha; ?> += parseFloat(row[i].total);

									var box  = '';

										box += '<span>'+row[i].grupo+' <b>('+row[i].total+')</b></span>';

									$('.contatos_<?php echo $row->id_campanha; ?> .grupos').append(box);

								}

								$('.contatos_<?php echo $row->id_campanha; ?> .total-contatos').html(contatosGeral_<?php echo $row->id_campanha; ?>);

							}

						});

					</script>

					<div class="contatos contatos_<?php echo $row->id_campanha; ?>">

						<div class="nome"><?php echo $this->lg->_("Contatos"); ?> (<span class="total-contatos"></span>)</div>

					</div>

					<div style="cursor:pointer; display:block !important;" data-status="inativo" onclick="funcCampanhas('<?php echo $row->id_campanha;?>',this);" class="status_enviado <?php echo $row->status_enviado; ?>">

						<?php echo $this->lg->_("DESATIVAR CAMPANHA"); ?>

					</div>

				</div>

			<?php } ?>

		</div>

	</div>

	<script>

		function campanhasAtivas(){

			$('.bg-campanhas-ativas-preto').fadeToggle(500);

			$('.bg-campanhas-ativas').fadeToggle(500);

		}

		function funcCampanhas(id, botao){

			var status = $(botao).data('status');

			$.ajax({
				url: '/<?php echo $this->baseModule; ?>/campanha/desative-ative',
				type: 'POST',
				data: {id: id, status: status},
				success: function(row){
					$(botao).html(row);
					if (status == 'ativo'){
						$(botao).data('status','inativo');
					} else {
						$(botao).data('status','ativo');
					}
				}, beforeSend: function(){
					$(botao).html('CARREGANDO');
				}

			});

		}

		//campanhasAtivas();
	</script>

	<div class="div_content">

		<div class="box_conteudo">

			<div id="conteudo">

				<div class="passo ativo p_passo1">

					<div class="nome">

						<b><?php echo $this->lg->_("NOME2"); ?></b> <?php echo $this->lg->_("DA CAMPANHA2"); ?>

						<i class="fa fa-map-marker atual"></i>

					</div>

					<div class="status">

						<div class="num">1º</div>

					</div>

				</div>

				<?php if ($_GET['tipo'] != 'sms'){?>

				<div class="passo p_passo2">

					<div class="nome">

						<b><?php echo $this->lg->_("CUSTOMIZE"); ?></b>

						<i style="display:none;" class="fa fa-map-marker atual"></i>

					</div>

					<div class="status">

						<div class="num"><?php echo $_GET['tipo'] == 'sms' ? "2" : "2"; ?>º</div>

					</div>

				</div>

				<?php } ?>

				<div class="passo p_passo3">

					<div class="nome">

						<b><?php echo $this->lg->_("ESCOLHA O"); ?></b> <?php echo $this->lg->_("PÚBLICO"); ?>

						<i style="display:none;" class="fa fa-map-marker atual"></i>

					</div>

					<div class="status">

						<div class="num"><?php echo $_GET['tipo'] == 'sms' ? "2" : "3"; ?>º</div>

					</div>

				</div>

				<div class="passo p_passo4">

					<div class="nome">

						<b><?php echo $this->lg->_("CONFIGURE"); ?></b>

						<i style="display:none;" class="fa fa-map-marker atual"></i>

					</div>

					<div class="status">

						<div class="num"><?php echo $_GET['tipo'] == 'sms' ? "3" : "4"; ?>º</div>

					</div>

				</div>

				

				<div class="passo p_passo5">

					<div class="nome">

						<b><?php echo $this->lg->_("PUBLIQUE"); ?></b>

						<i style="display:none;" class="fa fa-map-marker atual"></i>

					</div>

					<div class="status">

						<div class="num"><?php echo $_GET['tipo'] == 'sms' ? "4" : "5"; ?>º</div>

					</div>

				</div>

				<div class="conteudo-passo c_passo1" style="display:block;">

					<form action="javascript:passo('prox');">

						<h2><?php echo $this->lg->_("Para iniciar a criação de sua campanha, preencha o nome da campanha."); ?></h2>

						<input required class="nome_campanha" type="text" placeholder="<?php echo $this->lg->_("Nome da campanha"); ?>">

						

						<div class="botoes">

							<button type="submit" class="cor_c_hover"><?php echo $this->lg->_("Próximo passo"); ?></button>

						</div>

					</form>

				</div>

				<div class="conteudo-passo c_passo<?php echo $_GET['tipo'] == 'sms' ? "null" : "2"; ?>" style="display:none;">

					<form action="javascript:passo('prox');">

						<h2><?php echo $this->lg->_("Selecione o modelo de página que sua campanha precisa."); ?></h2>

						<select <?php echo $_GET['id'] == '' ? '' : 'disabled="disabled"' ?> style="width:200px; text-align:left;" onchange="linkpreview();" class="landing_visu id_landing" required="required">

							<option value=""><?php echo $this->lg->_("Selecione um template"); ?></option>

							<?php foreach($this->landing_page as $row){ ?>

							<option <?php echo $_GET['id'] == $row->id_landing_page ? 'selected' : ''; ?> value="<?php echo $row->id_landing_page; ?>"><?php echo $row->nome; ?></option>

							<?php } ?>

						</select>

						<button type="button" onclick="veragora();"> <i class="fa fa-search-plus"></i> <?php echo $this->lg->_("Visualizar template"); ?> </button>

						<div class="botoes">

							<button onclick="passo('ant');" type="button" class="cor_b_hover"><?php echo $this->lg->_("Passo anterior"); ?></button>

							<button type="submit" class="cor_c_hover"><?php echo $this->lg->_("Próximo passo"); ?></button>

						</div>

					</form>

				</div>

				<div class="conteudo-passo form-avulso c_passo<?php echo $_GET['tipo'] == 'sms' ? "2" : "3"; ?>" style="display:none;">

					<form action="javascript:valida();;">

						<h2><?php echo $this->lg->_("Agora selecione as pessoas ou listas que serão impactados pela campanha."); ?></h2>

						<section class="opcoes">
						
							<script>
							
								setTimeout( function (){
									$('.opcao-envio[data-tipo="<?php echo $_GET['tipo']; ?>"]').trigger('click');
								}, 200);

							</script>
						
							<script>

								$('.opcao-envio').bind('click', function(){

									var tipo = $(this).data('tipo');
									
									$('.opcao-envio').removeClass('active');
									$(this).addClass('active');
									
									$('section.opcao').removeClass('active');
									$('section.opcao.'+tipo).addClass('active');
									$('.referencia-sms').show(0);

								});

							</script>
						
						</section>

						<div style="width:445px; display:inline-block;">

							<p><i class="fa fa-exclamation-circle"></i> <?php echo $this->lg->_("Selecione uma ou mais listas para serem enviados."); ?></p>

							<select onchange="listas_contato(this);" class="grupos id_lista" multiple="multiple" style="width:98%;"></select>

							<div style="width:100%; padding-top:20px;">

								<p><i class="fa fa-exclamation-circle"></i> <?php echo $this->lg->_("Você esqueceu de criar uma lista ou adicionar algum contato?"); ?></p>

								<button type="button" onclick="modal('novo-grupo');" class="bt_verde"><?php echo $this->lg->_("Adicionar nova lista de contatos"); ?></button>

								<button type="button" onclick="modal('adicionar-contatos');" class="bt_verde"><?php echo $this->lg->_("Adicionar contato novo"); ?></button>

								<a target="_blank" href="/<?php echo $this->baseModule; ?>/contatos?t=g"><button type="button" class="bt_verde"><?php echo $this->lg->_("Ver/Editar contatos"); ?></button></a>

								<a target="_blank" href="/<?php echo $this->baseModule; ?>/banco-dados"><button type="button" class="bt_verde"><?php echo $this->lg->_("Importar contatos"); ?></button></a>

							</div>
							
						</div>
						
						<fieldset class="referencia-sms">
					
							<legend><?php echo $this->lg->_("Deseja usar o campo referencia?"); ?></legend>
							
							<label>
								<input checked type="radio" class="referencia" name="referencia" value="0"/>
								<span><?php echo $this->lg->_("Não"); ?></span>
							</label>
							
							<label>
								<input type="radio" class="referencia" name="referencia" value="1"/>
								<span><?php echo $this->lg->_("Sim"); ?></span>
							</label>
						
						</fieldset>

						<div class="botoes">

							<button onclick="passo('ant');" type="button" class="cor_b_hover"><?php echo $this->lg->_("Passo anterior"); ?></button>

							<button type="submit" class="cor_c_hover"><?php echo $this->lg->_("Próximo passo"); ?></button>

						</div>

					</form>

				</div>

				<div class="conteudo-passo c_passo<?php echo $_GET['tipo'] == 'sms' ? "3" : "4"; ?>" style="<?php echo $_GET['display'] == 'true' ? 'display:block' : 'display:none';?>">

					<form action="javascript:passo('prox');">

						<h2><?php echo $this->lg->_("Visualize o link provisório e escreva o texto da Mensagem"); ?></h2>

						<script>
						
							$(function(){

								$('.block').on('change', function(){

									var block = $(this).val();

									if (block == 's'){

										$('.tipo_senha').fadeIn(300);

									} else {

										$('.config-minha-senha').remove();

										$('.tipo_senha').fadeOut(300);

									}

								});

								$('.box-cancel .fa-times, input[type="button"], a').bind('click', function(){

									$('.box-cancel').slideUp();

								});

								$('.cancel').bind('click', function(event){

									event.stopPropagation();

									$('.box-cancel').slideDown();

								});

								$('.nome_botao_cancel').on('keyup', function(){

									var nomeBotao = $(this).val();

									$('.cancel span').html(nomeBotao);

								});

								$('.tipo_cancel').on('change', function(){

									var selecionado = $('.tipo_cancel:checked').val();

									if (selecionado == 'final'){

										$('.url_botao_cancel').attr('disabled','true');

									} else {

										$('.url_botao_cancel').removeAttr('disabled');

									}

								});

								$('.botao_cancel').on('change', function(){

									var selecionado = $('.botao_cancel:checked').val();

									if (selecionado == 'nao'){

										$('.nome_botao_cancel').attr('disabled','true');
										$('.url_botao_cancel').attr('disabled','true');
										$('.tipo_cancel').attr('disabled','true');

									} else {

										$('.nome_botao_cancel').removeAttr('disabled');
										$('.url_botao_cancel').removeAttr('disabled');
										$('.tipo_cancel').removeAttr('disabled');

									}

								});

								$('.types').on('change', function(){

									$('.senha_campanha').show(0);
									$('.senha_campanha input, .senha_campanha select').val('');

									var types = $(this).val();

									if (types == 'f'){

										$('.senha_campanha .input').show(0);
										$('.senha_campanha .select').hide(0);

									} else {

										$('.senha_campanha .input').hide(0);
										$('.senha_campanha .select').show(0);

									}

								});

								$('.fecha_senha').bind('click', function(){

									$('#sem_senha').trigger('click');
									$('.config-minha-senha').remove();

								});

								var form;

								$('#uploadfile').change(function (event) {

									var e = $(this);
									form = new FormData();
									form.append('uploadfile', event.target.files[0]);

									$.ajax({
										url: '/<?php echo $this->baseModule;?>/campanha/upload',
										data: form,
										processData: false,
										//contentType: 'multipart/form-data',
										contentType: false,
										type: 'POST',
										//dataType: 'JSON',
										success: function (data) {
											console.log(data);
											e.parent().find('img').attr('src', data);
										}

									});

								});

								$('.img a').bind('click', function(){

									$('#uploadfile').trigger('click');

								});

								$('#cor_senha').on('change', function(){

									var cor = $(this).val();

									$('.box-senha .box_celular').attr('style','background:'+cor+'');

								});

								$('.titulo_block').on('keyup', function(){

									var e = $(this).val();

									$('.box-senha .box_celular .form .titulo').html(e);

									$('.box-senha .box_celular .form > input[type="text"]').attr('placeholder',e);
									

								});

								$('.submit-senha').bind('click', function(){

									if (!$('.types:checked').val()){

										alert('Preencha um tipo de senha.');

									} else if (!$('.titulo_block').val()){

										alert('Preencha um titulo.');

									} else if (!$('.total_senha'.val)){ 

										alert('Preencha uma quantidade para senha.');

									} else {

										if ($('.types:checked').val() == 'v'){

											if (!$('.senha_variavel').val()){

												alert('Selecione uma variavel para ser a senha.');

											} else {

												sendSenha();

											}

										} else {

											if (!$('.senha_fixa').val()){

												alert('Preencha uma senha.');

											} else {

												sendSenha();

											}

										}

									}

								});

							});

							function sendSenha(){

								if ($('.config-minha-senha').length == 0){

									$('#deseja-senha').append('<a class="config-minha-senha">Configurações da senha.</a>');

								}

								$('.bloqueio .tipo_senha').fadeOut(500);

								$('.config-minha-senha').bind('click', function(){

									$('.bloqueio .tipo_senha').fadeIn(500);

								});

							}

						</script>

						<div class="bloqueio">
							<h2><?php echo $this->lg->_("Deseja bloquear essa campanha por senha?"); ?></h2>

							<div id="deseja-senha">

								<label>
									<input id="com_senha" type="radio" name="block" class="block" value="s"/>
									<?php echo $this->lg->_("Sim	"); ?>					
								</label>

								<label>
									<input id="sem_senha" type="radio" checked name="block" class="block" value="n"/>
									<?php echo $this->lg->_("Não"); ?>						
								</label>

							</div>

							<div class="tipo_senha">
								<div class="box-senha">
									<a class="fa fa-times fecha_senha"></a>
									<div class="box_celular">
										<a class="altera_cor">
											<i class="fa fa-cog"></i> <?php echo $this->lg->_("Alterar cor"); ?>
											<input type="color" id="cor_senha" value="#ff7a08"/>
										</a>
										<div class="img">
											<input style="display:none;" type="file" name="uploadfile" id="uploadfile"/>
											<a class="fa fa-cog"></a>
											<img src="/assets/uploads/contas/logo/logosolo.png"/>
										</div>
										
										<div class="form">
											<div class="titulo"><?php echo $this->lg->_("Titulo da senha"); ?></div>
											<input type="text" placeholder="Titulo da senha"/>
											<input type="button" value="Enviar"/>
											<div class="box-right">
												<div class="box-cancel">
													<a class="fa fa-times"></a>
													<p><?php echo $this->lg->_("Deseja ter botão cancelar?"); ?></p>
													<label>
														<input type="radio" checked name="botao_cancel" class="botao_cancel" value="sim"/> <?php echo $this->lg->_("Sim"); ?>
													</label>

													<label>
														<input type="radio" name="botao_cancel" class="botao_cancel" value="nao"/> <?php echo $this->lg->_("Não"); ?>
													</label>
													
													<input type="text" class="nome_botao_cancel" maxlength="15" placeholder="Nome do botão"/>

													<p><?php echo $this->lg->_("URL do botão voltar"); ?></p>

													<label>
														<input type="radio" checked name="tipo_cancel" class="tipo_cancel" value="url"/> URL
													</label>

													<label>
														<input type="radio" name="tipo_cancel" class="tipo_cancel" value="final"/><?php echo $this->lg->_("Página final"); ?> 
													</label>

													<input type="text" class="url_botao_cancel" placeholder="URL do botão"/>
													<input type="button" value="Salvar"/>

												</div>

												<a class="cancel">
													<span><?php echo $this->lg->_("Cancelar"); ?></span>
													<i class="fa fa-cog"></i>
												</a>
												
											</div>
											
										</div>

										<div class="aviso"><i class="fa fa-warning"></i> <?php echo $this->lg->_("Isso é uma uma pré-visualização!"); ?></div>

									</div>

									<div class="lateral-config">

										<h3><?php echo $this->lg->_("Você deseja uma senha fixa ou uma senha que venha através de uma variavel dos contatos?"); ?></h3>

										<label>
											<input type="radio" name="types" class="types" value="f"/>
											<?php echo $this->lg->_("Fixa"); ?>					
										</label>

										<label>
											<input type="radio" name="types" class="types" value="v"/>
											<?php echo $this->lg->_("Variavel"); ?>						
										</label>

										<div class="senha_campanha">

											<div>
												<input type="text" style="width:340px; text-align:center;" class="total_senha" placeholder="<?php echo $this->lg->_("Quantos digitos tem a senha?"); ?>"/>
											</div>
											
											<div>
												<input type="text" style="width:340px; text-align:center;" class="titulo_block" placeholder="<?php echo $this->lg->_("Preencha um titulo para o pedido de senha."); ?>"/>
											</div>

											<div class="input">
												<input type="text" style="text-align:center; width:340px;" class="senha_fixa" placeholder="<?php echo $this->lg->_("Digite uma senha"); ?>"/>
											</div>

											<div class="select">
												<select style="width:358px;" class="senha_variavel">
													<option selected disabled><?php echo $this->lg->_("Escolha uma variavel para ser a senha."); ?></option>
													<option><?php echo $this->lg->_("[nome]"); ?></option>
													<option><?php echo $this->lg->_("[sobrenome]"); ?></option>
													<option><?php echo $this->lg->_("[numero]"); ?></option>
													<option><?php echo $this->lg->_("[celular]"); ?></option>
													<option><?php echo $this->lg->_("[data_nascimento]"); ?></option>
													<option><?php echo $this->lg->_("[email]"); ?></option>
													<option><?php echo $this->lg->_("[cpf]"); ?></option>
													<option><?php echo $this->lg->_("[empresa]"); ?></option>
													<option><?php echo $this->lg->_("[cargo]"); ?></option>
													<option><?php echo $this->lg->_("[telefone_comercial]"); ?></option>
													<option><?php echo $this->lg->_("telefone_residencial]"); ?>[</option>
													<option><?php echo $this->lg->_("[pais]"); ?></option>
													<option><?php echo $this->lg->_("[estado]"); ?></option>
													<option><?php echo $this->lg->_("[cidade]"); ?></option>
													<option><?php echo $this->lg->_("[bairro]"); ?></option>
													<option><?php echo $this->lg->_("[endereço]"); ?></option>
													<option><?php echo $this->lg->_("[cep]"); ?></option>
													<?php for ($i = 1; $i <= 40; $i++) {?>
													<option><?php echo $this->lg->_("[editavel_"); ?><?php echo $i;?>]</option>
													<?php } ?>
												</select>

											</div>

										</div>

										<div class="config_bt_senha">
											<a class="cancel-senha bt-senha fecha_senha"><?php echo $this->lg->_("CANCELAR"); ?></a>
											<a class="submit-senha bt-senha"><?php echo $this->lg->_("SALVAR"); ?></a>
										</div>

									</div>

								</div>

							</div>

						</div>

						<div style="width:320px; display:inline-block; vertical-align:top; text-align:left;">

							<div class="celular-miniatura">
								<div class="conteudo_cel">

									<div class="topo-sms cor_b"><?php echo $this->lg->_("SMS"); ?></div>
									
									<div class="avatar">
										<i class="fa fa-user"></i>
									</div>

									<div class="seta"></div>
									<div class="balao_mensagem"><?php echo $this->lg->_("Mensagem da campanha..."); ?></div>
									<div class="data-celular"><?php echo $this->lg->_("Enviado agora"); ?></div>

								</div>

							</div>

						</div>

						<div style="width:370px; display:inline-block; vertical-align:top; text-align:left;">

							<div class="variaveis" style="width: 96%; margin-bottom:15px; overflow:auto; height:67px; padding: 2%; float:left;border: 1px solid rgba(255, 0, 0, 0.05); font-size:12px;color: #999; text-align:center;">
								<b class="variavel"><?php echo $this->lg->_("[nome]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[sobrenome]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[numero]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[celular]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[data_nascimento]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[email]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[cpf]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[empresa]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[cargo]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[telefone_comercial]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[telefone_residencial]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[pais]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[estado]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[cidade]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[bairro]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[endereço]"); ?></b>
								<b class="variavel"><?php echo $this->lg->_("[cep]"); ?></b>
								<?php for ($i = 1; $i <= 40; $i++) {?>
									<b class="variavel"><?php echo $this->lg->_("[editavel_"); ?><?php echo $i;?>]</b>
								<?php } ?>
							</div>

							<script>
								$(document).ready( function() {
								  $(".variavel").draggable({helper: 'clone'});
								  $("textarea").droppable({
								  	accept: ".variavel",
								    drop: function(ev, ui) {
								      $(this).insertAtCaret(ui.draggable.text());
								    }
								  });
								});

								$.fn.insertAtCaret = function (myValue) {
								  return this.each(function(){
								  //IE support
								  if (document.selection) {
								    this.focus();
								    sel = document.selection.createRange();
								    sel.text = myValue;
								    this.focus();
								  }

								  //MOZILLA / NETSCAPE support
								  else if (this.selectionStart || this.selectionStart == '0') {

									var startPos = this.selectionStart;
								    var endPos = this.selectionEnd;
								    var scrollTop = this.scrollTop;
								    this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
								    this.focus();
								    this.selectionStart = startPos + myValue.length;
								    this.selectionEnd = startPos + myValue.length;
								    this.scrollTop = scrollTop;

								  } else {

								    this.value += myValue;
								    this.focus();

								  }

								  });

								};

							</script>

							<div style="width:100%; float:left; text-align:left;">

								<span class="restantes"><b>135</b> <?php echo $this->lg->_("caracteres restantes"); ?></span><br/>

								<textarea maxlength="135" required class="mensagem_sms msg" placeholder="<?php echo $this->lg->_("Mensagem da campanha"); ?>"></textarea><br/>

								<?php if ($_GET['tipo'] != 'sms'){ ?>

								<p><i class="fa fa-exclamation-circle"></i> <?php echo $this->lg->_("Não colocar esse link na mensagem, o sistema reconhece o link automaticamente."); ?></p>

								<input style="margin-top:5px; width:95%;" type="text" class="link-preview" disabled value="Carregando...">

								<?php } ?>

							</div>

							<div style="width:100%; float:left; margin-top:20px; text-align:left;">

								<p style="padding:5px 0px; margin:1% 1%;"> <?php echo $this->lg->_("Visualize como sua campanha vai chegar aos seus contatos, envie um <b>SMS</b> exemplar da sua campanha"); ?></p>

								<div style="padding:10px 0px;">

									<input class="celular novo_cel" style="width:251px;" type="text" placeholder="<?php echo $this->lg->_("Celular"); ?>"/>

									<button type="button" onclick="adicionarNumero();" style="margin-left:5px; float:right;"><?php echo $this->lg->_("Adicionar"); ?></button>

									<p class="celulares_geral" style="margin-left:-5px; width:131%;"></p>

								</div>

								<script>

									$(function(){

										$('.mensagem_sms').keyup(function(){

											var texto = $(this).val();
											var link = $('.link-preview').val();

											<?php if($_GET['tipo'] != 'sms'){ ?>

											$('.balao_mensagem').html(texto+'<br/>'+link);

											<?php } else { ?>

											$('.balao_mensagem').html(texto);

											<?php } ?>

										});

									});

									function listas_contato(select){

										var listas = $(select).val();

										$.ajax({
											url: 'campanha/variaveis',
											type: 'POST',
											data: {listas:listas},
											success: function(row){

												for(var i in row) {

													//var box  = '';

														//box += '<span>'+row[i].nome+'</span>';
														
													//$('.variaveis').append(box);


												}


											}

										});

									}
									

									function adicionarNumero(){

										var cel = $('.novo_cel').val();

										var id_cel = cel.replace('(', '').replace(')', '').replace(' ', '').replace('-', '').replace(' ', '');
										
										$('.celulares_geral').append('<span class="cel_'+id_cel+'" style="padding:5px; background:#2798d8; margin:5px; color:#FFF; border-radius:3px; float:left;"><a>'+cel+'</a> <b onclick="delCel(\''+id_cel+'\');" style="cursor:pointer;"><i class="fa fa-times"></i></b></span>');

										$('.novo_cel').val('').focus();

										listaCelulares();

									}

									function delCel(id){

										$('.cel_'+id).remove();

										listaCelulares();

									}

									function listaCelulares(){

										var cel = '';

										var i = 0;

										$('.celulares_geral span').each(function(){

											i += 1;

											if (i != 1){

												cel += ','+$(this).find('a').html();

											} else {

												cel += $(this).find('a').html();

											}

										});

										$('.celular_sms').val(cel);

									}

								</script>

								<input class="celular_sms" type="hidden"/>

								<button type="button" onclick="enviar_sms();" style="margin-left:5px; width:100%; float:right;"><i class="fa fa-mobile"></i> <?php echo $this->lg->_("Enviar mensagem de teste"); ?></button>

							</div>

						</div>

						<div class="botoes">

							<button onclick="passo('ant');" type="button" class="cor_b_hover"><?php echo $this->lg->_("Passo anterior"); ?></button>

							<button type="submit" class="cor_c_hover"><?php echo $this->lg->_("Próximo passo"); ?></button>

						</div>

					</form>

				</div>


				<div class="conteudo-passo c_passo<?php echo $_GET['tipo'] == 'sms' ? "4" : "5"; ?>" style="display:none;">

					<h2><?php echo $this->lg->_("Selecione quando você irá publicar sua campanha."); ?></h2>

					<div style="width:90%; display:inline-block; text-align:center;">

						<h3><?php echo $this->lg->_("Selecione um periodo em que sua campanha vai estar ativa."); ?></h3>

						<form action="javascript:metodoEnvio">
							
							<div class="periodo">
							
								<div class="row">
								
									<label>
										<span><?php echo $this->lg->_("Periodo início"); ?></span>
										<input type="text" placeholder="Periodo início" class="calendario-inicio"/>	
									</label>	
									
									<label>
										<span><?php echo $this->lg->_("Horario"); ?></span>
										<input style="visibility:hidden; opacity:0; width:0px; height:0px;" type="text" placeholder="hh:mm" class="horario hora" value="00:00"/>
										<input type="text" placeholder="hh:mm" class="horario hora_inicio" value="00:00"/>	
										<i class="fa fa-clock-o open-time"></i>
									</label>	
									
									
								</div>
										
								
								<div class="row">		
								
									<label>
										<span><?php echo $this->lg->_("Periodo final"); ?></span>
										<input type="text" placeholder="Periodo final" disabled class="calendario-sobre-inicio"/>
									</label>	
									
									<label>
										<span><?php echo $this->lg->_("Horario"); ?></span>
										<input style="visibility:hidden; opacity:0; width:0px; height:0px;" type="text" placeholder="hh:mm" class="horario hora" value="23:59"/>
										<input type="text" placeholder="hh:mm" class="horario hora_final" value="23:59"/>	
										<i class="fa fa-clock-o open-time"></i>
									</label>
									
								</div>
								
							</div>
						
						</form>

						<div id="formas-envio" style="display:none; margin-top:20px;">
						
							<h3><?php echo $this->lg->_("Selecione um método de envio."); ?></h3>
						
							<button type="button" onclick="salvarCampanha('enviar');" class="bt-enviar-campanha salva-campanha cor_a_hover"><i class="fa fa-paper-plane"></i> <?php echo $this->lg->_("Enviar agora"); ?></button>
							<button type="button" onclick="salvarCampanha('agendar');" class="bt-agendar-campanha salva-campanha cor_a_hover"><i class="fa fa-calendar"></i> <?php echo $this->lg->_("Agendar"); ?></button>
							<button type="button" onclick="salvarCampanha('enviar-lote');" class="bt-agendar-campanha salva-campanha cor_a_hover"><i class="fa fa-calendar"></i> <?php echo $this->lg->_("Fracionar lotes"); ?></button>
						
							<script>

								$( function (){
	
									$('.salva-campanha').bind('click', function(){

										$(this).after('<h3>Carregando..</h3>');
										$('.salva-campanha').remove();
										
									});

								});

							</script>
						
						</div>
						
					</div>

					<div class="botoes">
					
						<button onclick="passo('ant');" type="button" class="cor_b_hover"><?php echo $this->lg->_("Passo anterior"); ?></button>

					</div>

				</div>

			</div>

		</div>

	</div>

	
	<div id="load_ajax_envio_box">

		<div id="titulo"><i class="fa fa-cog"></i> <?php echo $this->lg->_("Logs de envio"); ?> <i class="fa fa-times fecha_logs" style="float:right; cursor:pointer;" title="Fechar logs"></i></div>

		<div id="load_ajax_envio"></div>

	</div>

	<script>
	
		function startMetodo()
		{

			var thisvalue = $('.calendario-sobre-inicio').val();
			var thisvalueIni = $('.calendario-inicio').val();

			if ( thisvalue.length == 10 && thisvalueIni.length == 10 ){

				$('#formas-envio').slideDown();
				
			} else {

				$('#formas-envio').slideUp();

			}

		}

		function retira_acentos(str) {

			com_acento = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝŔÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿŕ\n\r";
			sem_acento = "AAAAAAACEEEEIIIIDNOOOOOOUUUUYRsBaaaaaaaceeeeiiiionoooooouuuuybyr";
			novastr="";
			
			for(i=0; i<str.length; i++) {
				troca=false;
				for (a=0; a<com_acento.length; a++) {
					if (str.substr(i,1)==com_acento.substr(a,1)) {
						novastr+=sem_acento.substr(a,1);
						troca=true;
						break;
					}
				}
				if (troca==false) {
					novastr+=str.substr(i,1);
				}
			}
			
			return novastr;
			
		}
	
		$(function(){

			$('.msg').on('keyup', function(){

				$(this).val( retira_acentos($(this).val()) );
				this.value = this.value.replace(/[^a-zA-Z-0-9.@\[\][/]!?%_$&#*,:; ]/g,'');

			});

			$('.horario').on('change', function(){

				$(this).parent().find('.horario').val( $(this).val() );

			});

			$('.open-time').bind('click', function(){

				$(this).parent().find('.hora').focus();
				
			});
			
			$(".hora").mask("99:99");
			$('.hora').bootstrapMaterialDatePicker({
				
				date: false,
				format : 'HH:mm',
				cancelText: 'Cancelar',
				okText: 'OK',
				switchOnClick: true,
				triggerEvent: 'click'
				
			});
				    
			$( document ).on('change', '.calendario-sobre-inicio', function(){

				startMetodo();

			});

			$( document ).on('change', '.calendario-inicio', function(){

				startMetodo();

			});


			$( '.calendario-inicio' ).datepicker({
				
				dateFormat: 'yy-mm-dd',
		
				dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
			    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			    nextText: 'Prox',
			    prevText: 'Ant',
				
				onSelect: function() {

					var dataInicio = $('.calendario-inicio').val();
					
					var time = new Date(dataInicio);
					var outraData = new Date();
					outraData.setDate(time.getDate() + 60);

					console.log( outraData );
					
					$( '.calendario-sobre-inicio' ).datepicker("destroy");
					$( '.calendario-sobre-inicio' ).datepicker({ 
						
						minDate: dataInicio, 
						maxDate: outraData,
						dateFormat: 'yy-mm-dd',
						dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
					    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
					    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
					    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
					    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
					    nextText: 'Prox',
					    prevText: 'Ant'
							
					});

					setTimeout( function(){
						
						$('.calendario-sobre-inicio').val('');
			
						console.log(dataInicio.length );
						
						if ( parseFloat(dataInicio.length) > 1 ) {
			
							$( '.calendario-sobre-inicio' ).removeAttr('disabled');
							$( '.calendario-sobre-inicio' ).focus();
							
						} else {
			
							$( '.calendario-sobre-inicio' ).attr('disabled','true');
							
						}
			
					},500 );
					
				}
				
			});
			
			$('.fecha_logs').click(function(){
	
				$('#load_ajax_envio_box').slideUp(500);
	
			});
	
		});
	
								
	
		function opcao_enviar(str){
	
			var value = $(str).val();
			$('.agendar_agora').css('display', 'none');
			$('.enviar_agora').css('display', 'none');
			$('.'+value+'_agora').css('display', 'inline-block');
	
		}
	
		function enviar_sms(){
	
			var nome_campanha = $('.nome_campanha').val();
			var celular_sms = $('.celular_sms').val();
			var msg = $('.mensagem_sms').val();
			var id_landing = $('.landing_visu').val();
	
			if (celular_sms.length){
	
				$.ajax({
					url: '/<?php echo $this->baseModule; ?>/campanha/enviarsms',
					type: 'POST',
					data: {nome_campanha:nome_campanha, celular_sms:celular_sms, id_landing:id_landing, msg:msg},
					success: function(row){
	
						console.log(row);
	
						if (row == 'ERR:108'){
	
							alert('Houve alguem erro, tente outro numero ou tente novamente mais tarde.');
	
						} else {
	
							alert('SMS Enviado com sucesso, aguarde alguns minutos.');
	
						}
	
					}
	
				});
	
			} else {
	
				alert('Você não preencheu nenhum numero de exemplo.');
	
			}
	
		}
	
	
	
		function nova_campanha_lista_atualiza(){
	
			$.ajax({
				url: '/<?php echo $this->baseModule; ?>/contatos/lista-atual?il=<?php echo $_GET['il']; ?>',
				success: function(row){
	
					$('.grupos').html(row).select2({});
	
				}
			});
	
		}
	
	
	
		nova_campanha_lista_atualiza();
	
	
	
		var total_permitido = 135;
		$('.restantes b').html(total_permitido);
		$('.mensagem_sms').keyup(function(){
	
			var total_escrito = total_permitido - $(this).val().length;
			$('.restantes b').html(total_escrito);
	
			if (total_escrito < 0){
	
				$('.restantes b').css('color', 'red');
	
				$(this).parent().parent().find('button[type="submit"]').fadeOut(0);
	
			} else {
	
				$('.restantes b').css('color', '#333');
	
				$(this).parent().parent().find('button[type="submit"]').fadeIn(0);
	
			}
	
		});
	
	
	
		function linkpreview(){
	
			var id_landing = $('.landing_visu').val();
	
			$('.link-preview').val('<?php echo $this->GerenciadorCustom->shorturl;?>/l/'+id_landing);
	
		}
	
	
	
		function veragora(){
	
			var id_landing = $('.landing_visu').val();
	
			if (id_landing){
	
				preview(id_landing);
	
			} else {
	
				alert('Selecione um template para visualizar.');
	
			}
	
		}
	
		var pag_atual = 1;
	
		function passo(tipo){
	
			linkpreview();

			$('.c_passo'+pag_atual).slideToggle(500);
	
			var prox = pag_atual + 1;
			var ant = pag_atual - 1;
	
			if (tipo == 'prox'){
	
				pag_atual += 1;
				$('.p_passo'+prox).addClass('ativo');
	
			} else {
	
				$('.p_passo'+pag_atual).removeClass('ativo');
				pag_atual -= 1;
	
			}
	
			ant_mais = ant + 1;
	
			$('.p_passo'+ant_mais+' .atual').fadeOut(0);
			$('.p_passo'+prox+' .atual').fadeOut(0);
			$('.p_passo'+pag_atual+' .atual').fadeIn(0);
			$('.c_passo'+pag_atual).slideToggle(500);
			
		}
	
		$('.picker').datepicker({
			minDate: 0, 
			maxDate: "+1M +10D",
			dateFormat: 'yy-mm-dd'
	
		});
	
		// SALVA A CAMPANHA
		function salvarCampanha(tipo){
	
			var somente_sms = '<?php echo $_GET['tipo'] == "sms" ? "sim" : "nao"; ?>';
			var campanha = $('.nome_campanha').val();
			var id_landing = $('.id_landing').val();
			var id_lista = $('.id_lista').val();
			var mensagem = $('.mensagem_sms').val();
			var block = $('.block:checked').val();
			var types = $('.types:checked').val();
			var titulo_block = $('.titulo_block').val();
			var senha_variavel = $('.senha_variavel').val();
			var senha_fixa = $('.senha_fixa').val();
			var senha_img = $('.box-senha .box_celular .img img').attr('src');
			var senha_bg = $('#cor_senha').val();
			var total_senha = $('.total_senha').val();
			var botao_cancel = $('.botao_cancel:checked').val();
			var nome_botao_cancel = $('.nome_botao_cancel').val();
			var url_botao_cancel = $('.url_botao_cancel').val();
			var tipo_cancel = $('.tipo_cancel:checked').val();
			
			var periodo_inicio = $('.calendario-inicio').val();
			var periodo_final = $('.calendario-sobre-inicio').val();

			var referencia = $('.referencia:checked').val();

			var hora_inicio = $('.hora_inicio').val();
			var hora_final = $('.hora_final').val();

			periodo_inicio = periodo_inicio +' '+ hora_inicio;
			periodo_final = periodo_final +' '+ hora_final;

			if (campanha != '' <?php if ($_GET['tipo'] != 'sms'){ echo "&& id_landing != ''"; } ?> && id_lista != ''){
	
				$.ajax({
					url: '/<?php echo $this->baseModule; ?>/campanha/campanhas-novo',
					type: 'POST',
					data: {referencia:referencia, periodo_inicio:periodo_inicio, periodo_final:periodo_final, nome_botao_cancel:nome_botao_cancel, url_botao_cancel:url_botao_cancel, tipo_cancel:tipo_cancel, botao_cancel:botao_cancel, total_senha:total_senha, senha_img:senha_img, senha_bg:senha_bg, titulo_block:titulo_block, block:block, types:types, senha_variavel:senha_variavel, senha_fixa:senha_fixa, campanha:campanha, somente_sms:somente_sms, <?php if ($_GET['tipo'] != 'sms'){ echo "id_landing:id_landing,"; } ?> id_lista:id_lista, mensagem:mensagem},
					dataType: 'JSON',
					success: function(row){
	
						console.log(row);
	
						if (row.erro != 'false'){
	
							$('#id_campanha').val(row.id_campanha);
	
							if (row.id_campanha){
	
								location.href='/<?php echo $this->baseModule; ?>/campanha-gerenciamento/'+tipo+'/id/'+row.id_campanha;
	
							}
	
						} else {
	
							alert('Não foi possivel salvar a campanha, tente novamente mais tarde.');
	
						}
	
					}
	
				});
	
			} else {
	
				alert('Você esqueceu de preencher algum campo.');
	
			}
		}
									
	</script>



<?php include_once dirname(__FILE__).'/../layout/footer.php';?>