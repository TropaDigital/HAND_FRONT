<?php

	$corPadrao = 'c-laranja';
	$headerBox = '<div class="box" id="'.time().'" data-tipo="'.$this->post['tipo'].'">';
	$headerBox .= '<div class="funcoes">';
	$headerBox .= '<a class="edit" onclick="javascript:FuncoesPorBox(this);"><span><i class="fa fa-pencil-square" aria-hidden="true"></i> Editar</span></a>';
	$headerBox .= '<a class="delete" onclick="javascript:FuncoesPorBox(this);"><span><i class="fa fa-times-circle" aria-hidden="true"></i> Deletar</span></a>';
	$headerBox .= '</div>';
	$headerBox .= '<div class="edit">';
	$footerBox = '</div>';
	$footerBox .= '</div>';
	
?>

<?php if ($this->post['acao'] != 'new'){ ?>
	<script>

		tooltip();

	</script>
<?php } ?>

<?php if ($this->post['tipo'] == $this->lg->_("coluna")){ ?>

	<?php if ($this->post['acao'] == 'new'){ ?>
	
	<div class="coluna box" data-fixed="" data-width="100" data-margem="0" id="b-<?php echo time(); ?>" data-tipo="<?php echo $this->post['tipo'];?>">
	
		<div class="funcoes">
			<a class="edit" onclick="javascript:FuncoesPorBox(this);"><span><i class="fa fa-pencil-square" aria-hidden="true"></i> <?php echo $this->lg->_("Editar"); ?></span></a>
			<a class="delete" onclick="javascript:FuncoesPorBox(this);"><span><i class="fa fa-times-circle" aria-hidden="true"></i> <?php echo $this->lg->_("Deletar"); ?></span></a>
		</div>
	
		<div class="drop-drag"></div>
	
	</div>
	
	<?php } else {?>
	
		<script>

		$(function(){

		    // LEITURA
			var id = '<?php echo $this->post['id'];?>';
			var edit = $('#'+id);

			var cor = $(edit).find('.drop-drag').attr('id');
			$('#cor').attr('data-cor', cor);

			var width = $(edit).attr('data-width');
			var margem = $(edit).attr('data-margem');
			var widthFinal = width - (margem * 2);

			//images
			var backgroundImage = $(edit).attr('backgroundImage')

			var fixed = edit.attr('data-fixed')
			
			$('.fixed').val( fixed )

			$('.t-'+width).attr('checked', true);
			$('.margem').val(margem);
            $('.backgroundImage').val( backgroundImage )
			$('.tam').checkboxradio();

			var variavel_existe = edit.attr('data-variavel-existe');
			$('.variavel_existe').val(variavel_existe);

		});

		function aplicar()
		{

			var id = '<?php echo $this->post['id'];?>';
			var edit = $('#'+id);

			var width = $('.tam:checked').val();
			var margem = $('.margem').val();
			var fixed = $('.fixed').val();
            var backgroundImage = $('.backgroundImage').val();
			
			if ( fixed == 'top' && $('div[data-fixed="top"][id!="'+id+'"]').length > 0 ){
				alert('Só é permitido fixar uma coluna em cima.')
			} else if ( fixed == 'bottom' && $('div[data-fixed="bottom"][id!="'+id+'"]').length > 0 ){
				alert('Só é permitido fixar uma coluna em baixo.')
			} else {

    			$(edit).attr('data-fixed', fixed);
    			$(edit).attr('data-width', width);
    			$(edit).attr('data-margem', margem);
                $(edit).attr('backgroundImage', backgroundImage);
    
    			var widthCss = 100 - (margem * 2);
    			$(edit).css('width', width+'%');
    			$(edit).find('.drop-drag').css('width', widthCss+'%').css('padding', margem+'%').css('background-image', 'url('+backgroundImage+')');

                console.log( backgroundImage )
    
    			var cor = $('#cor').attr('data-cor');
    			$(edit).find('.drop-drag').attr('id', cor);
    
    			var variavel_input = $('.variavel_existe').val();
    			if ( variavel_input ) {
    				$(edit).attr('data-variavel-existe', variavel_input);
    			} else {
    				$(edit).removeAttr('data-variavel-existe');
    			}

			}
			
		}

		</script>
		
		<form action="javascript:aplicar();">
		
			<div id="cor">
				<script>coresTemplate('<?php echo $this->post['id'];?>', '.input-label');</script>
			</div>
			
			<div class="input-label">
				
				<span>
					<?php echo $this->lg->_("Sumir com conteudo"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Escreva uma variavel por exemplo: [nome] para esse conteudo aparecer apenas se existir a mesma, caso queira que sempre apareça ignore esse campo."); ?>"></i>
				</span>
				
				<div class="input_ico"><i class="fa fa-font"></i></div>
				<input class="input_text variavel_existe" type="text" placeholder="">
				
			</div>
			
			<div class="input-label">
			
				<span>
				
					<?php echo $this->lg->_("Tamanho (Largura 320px)"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Escolha a largura que deseja para a coluna."); ?>"></i>
				
				</span>
				
				<label class="tamanho-coluna" for="radio-1">
					
					<div>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
					</div>
					<div>100%</div>
					
				</label>
			    <input type="radio" class="tam t-100" name="tamanho" id="radio-1" value="100">
			    
			    <label class="tamanho-coluna" for="radio-2">
			    	<div>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>75%</div>
			    </label>
			    <input type="radio" class="tam t-75" name="tamanho" id="radio-2" value="75">
			    
			    <label class="tamanho-coluna" for="radio-3">
			    	<div>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>50%</div>
			    </label>
			    <input type="radio" class="tam t-50" name="tamanho" id="radio-3" value="50">
			    
			    <label class="tamanho-coluna" for="radio-4">
			    	<div>
			    		<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>25%</div>
			    </label>
			    <input type="radio" class="tam t-25" name="tamanho" id="radio-4" value="25">
			    
		    </div>

            <div class="input-label">
				<span>

					<?php echo $this->lg->_("Imagem"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione a imagem desejada na galeria de imagens."); ?>"></i>

				</span>

                <div class="input_ico abrir_galeria" onclick="abrir_galeria(this);">
                    <i class="fa fa-picture-o"></i>
                </div>

                <input class="input_text backgroundImage" type="text" placeholder="<?php echo $this->lg->_("URl da imagem..."); ?>">

            </div>
		    
		    <div class="input-label">
			
				<span>
				
					<?php echo $this->lg->_("Fixar coluna"); ?>
					<i class="fa fa-question-circle question tooltip" title="Escolha a se deseja fixar a coluna."></i>
				
				</span>
				
				<div class="input_ico">
					<i class="fa fa-arrows" aria-hidden="true"></i>
				</div> 
				
				<select class="input_text fixed">
					<option value="">Não fixar</option>
					<option value="top">Fixar em cima</option>
					<option value="bottom">Fixar em baixo</option>
				</select>
			</div>
		    
		    <div class="input-label">
			
				<span>
				
					<?php echo $this->lg->_("Margem"); ?>
					<i class="fa fa-question-circle question tooltip" title="Escolha a espessura desejada para a coluna."></i>
				
				</span>
				
				<div class="input_ico">
					<i class="fa fa-arrows" aria-hidden="true"></i>
				</div> 
				
				<select class="input_text margem">
					<option>0</option>
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
				</select>
			</div>
				
		
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
			
		</form>
		
	<?php } ?>

<?php } else {?> 

	<?php if ($this->post['acao'] == 'new'){ echo $headerBox; } ?>

	<?php if ($this->post['tipo'] == $this->lg->_("imagem")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>

			<a href="javascript:;">
				<img src="assets/home/images/img-padrao.png" data-width="100" data-height="auto" data-width_tipo="%" style="width: 100%; height:auto" />
			</a>
	
		<?php else: ?>
	
		<script>

			function tipoUrl( bt ){

				var tip = $(bt).val();

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var botao = $(edit).find('.bt');
				var cor = botao.attr('id');
				var radius = botao.attr('data-radius');
				var urlBotao = $(botao).attr('data-href');
				var nomeBotao = $(botao).html();


				if (tip == 'Interno'){

					var id = $('.box-celular').attr('id');
					$('.url-tipo').find('input').remove();

					$.ajax({
						url: '<?php echo $this->baseModule;?>/templates/paginas-landing',
						type: 'POST',
						data: {id: id},
						dataType: 'JSON',
						success: function(row){

							$('.ajax_montagem .loader').remove();

							var select = '<select class="url-botao input_text">';
								select += '<option value="home">Página inicial</option>';
							for(var i in row) {
								select += '<option value="'+row[i].id_pagina+'">'+row[i].nome+'</option>';
							}
							select += '</select>';
							$('.url-tipo').append(select);
								
						}, beforeSend: function(){

							$('.url-tipo').append('<span class="loader" style="width:311px; height:21px;"><i class="fa fa-spin fa-spinner"></i> Carregando páginas...</san>');
							
						}
					});
					
						
				} else {

					
					$('.url-tipo').find('select').remove();
					$('.url-tipo').append('<input class="input_text url-botao" type="text" placeholder=""/>');

					$('.ajax_montagem .nome-botao').val(nomeBotao);
						
				}
				
			}
		
			// LEITURA
			$(function(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');

				var obj = $(edit).find('img');
				var linkOld = $(edit).find('a').attr('href')
				
				if ( obj.attr('data-tipo') == '<?php echo $this->lg->_("Interno"); ?>' ){

					$('.change-tipo').val('<?php echo $this->lg->_("Interno"); ?>')

					var id = $('.box-celular').attr('id');
					$('.url-tipo').find('input').remove();

					$.ajax({
						url: '<?php echo $this->baseModule;?>/templates/paginas-landing',
						type: 'POST',
						data: {id: id},
						dataType: 'JSON',
						success: function(row){

							$('.ajax_montagem .loader').remove();

							var select = '<select class="url-botao input_text">';
								select += '<option value="home">Página inicial</option>';
							for(var i in row) {

								if ( obj.attr('data-url') == row[i].id_pagina ){
									select += '<option selected value="'+row[i].id_pagina+'">'+row[i].nome+'</option>';
								} else {
									select += '<option value="'+row[i].id_pagina+'">'+row[i].nome+'</option>';
								}
								
							}
							select += '</select>';
							$('.url-tipo').append(select);
								
						}, beforeSend: function(){

							$('.url-tipo').append('<span class="loader" style="width:311px; height:21px;"><i class="fa fa-spin fa-spinner"></i> Carregando páginas...</san>');
							
						}
					});
					
				} else {

					if ( linkOld != 'javascript:;' ){

						var linkOld = linkOld.split("javascript:urlBotao('")
							linkOld = linkOld[1].split("'")
							linkOld = linkOld[0]

						$('.url-botao').val( linkOld )
						
					} else {

						$('.url-botao').val( obj.attr('data-url') )

					}
					

				}
				
				var rowURL = $(obj).attr('src');
				var rowWidth = $(obj).attr('data-width');
				var rowHeight = $(obj).attr('data-height');
				var rowWidthTipo = $(obj).attr('data-width_tipo');

				// CASO SEJA IMAGEM NOVA
				if (!rowWidth){
					rowWidth = $(obj).css('width');
					rowWidth = rowWidth.split('px');
					rowWidth = rowWidth[0];

					rowWidthTipo = $(obj).css('width');
					rowWidthTipo = rowWidthTipo.split(rowWidth);
					rowWidthTipo = rowWidthTipo[1];
					console.log(rowWidthTipo);
					
				}

				$('.imagem_atual').attr('src', rowURL);
				$('.input_imagem_atual').val(rowURL);

				$('.width').val(rowWidth);
				$('.height').val(rowHeight);
				$('.width_tipo').val(rowWidthTipo);

			});

			// APLICAÇÃO
			function aplicar()
			{

				// DIV
				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var obj = $(edit).find('img');

				if (obj.length == 0) {
					
					alert('Esse objeto foi deletado.');
					close_edicao();
					
				} else {

					// VALORES DAS INPUTS
					var imagem_atual = $('.input_imagem_atual').val();
					var width = $('.width').val();
					var height = $('.height').val();
					var width_tipo = $('.width_tipo').val();

					var tipo = $('.change-tipo').val();
					var url = $('.url-botao').val();
	
					if (width_tipo == '%' && width > 100){
						alert('Excedeu o tamanho da imagem.');
					} else if (width > 320){
						alert('Excedeu o tamanho da imagem.');
					} else {

						
						$(obj).attr('data-tipo', tipo);
						$(obj).attr('data-url', url);
						$(obj).attr('data-width', width);
						$(obj).attr('data-height', height);
						$(obj).attr('data-width_tipo', width_tipo);
						$(obj).attr('src', imagem_atual);
						$(obj).css('width', width+''+width_tipo);

						if ( height == 'auto' ) {
							$(obj).css('height', 'auto');
						} else {
							$(obj).css('height', height+'px');
						}
						

						var tipo_link = $(obj).attr('data-tipo')
						var url_link = $(obj).attr('data-url')
						var nome_link = $('.url-botao option:selected').text()
						
						if ( tipo_link == '<?php echo $this->lg->_("Interno"); ?>' ){
							var urlFinal = "javascript:urlBotao('"+url_link+"', 'Interno', '"+nome_link+"');";
						} else {
							if ( url_link ){
								var urlFinal = "javascript:urlBotao('"+url_link+"', 'Externo', '')";
							} else {
								var urlFinal = "javascript:;";
							}
						}

						console.log( urlFinal )
						
						// altera isso aqui
						$(obj).parent().attr('href', urlFinal);
						
						$(obj).attr('src', imagem_atual);
						$(obj).attr('display', 'inline-block');
					}

				}
				
			}
				

		</script>
	
		<form action="javascript:aplicar();">
		
			<div class="input-label" style="background:rgba(0,0,0,0.08);">
				<img class="imagem_atual" style="max-width: 100%; max-height: 150px;" />
			</div>
			
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Tipo de link"); ?>
				
				</span>
				<div class="input_ico"><i class="fa fa-link" aria-hidden="true"></i></div>
				<select class="option input_text change-tipo" onchange="tipoUrl(this);">
					<option><?php echo $this->lg->_("Externo"); ?></option>
					<option><?php echo $this->lg->_("Interno"); ?></option>
				</select>
			</div>
		
			<div class="input-label url-tipo">
			
				<span>
				
					URL
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Inclua aqui a URL para qual você deseja que o usuário seja direcionado ao clicar no botão."); ?>"></i>
				
				</span>
				<div class="input_ico">
					<i class="fa fa-link" aria-hidden="true"></i>
				</div>
				<input class="input_text url-botao" type="text" placeholder="">
				
			</div>
			
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Imagem"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione a imagem desejada na galeria de imagens."); ?>"></i>
				
				</span>
		
				<div class="input_ico abrir_galeria" onclick="abrir_galeria(this);">
					<i class="fa fa-picture-o"></i>
				</div> 
				
				<input class="input_text input_imagem_atual" type="text" placeholder="<?php echo $this->lg->_("URl da imagem..."); ?>">
		
			</div>
			
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Largura"); ?>
					<i class="fa fa-question-circle question tooltip top" title="<?php echo $this->lg->_("Selecione (em pixels ou porcentagem) o largura desejado para a imagem. A imagem será aumentada ou reduzida proporcionalmente."); ?>"></i>
				
				</span>
		
				<div class="input_ico">
					<i class="fa fa-arrows-h"></i>
				</div> 
				
				<input class="input_text width" style="width: 80px;" type="text" placeholder="<?php echo $this->lg->_("Largura"); ?>"> 
				
				<select class="input_text width_tipo" style="height: 31px; margin-top: 0px; margin-left: -2px; width: 258px;">
					<option value="px"><?php echo $this->lg->_("Pixel"); ?></option>
					<option value="%"><?php echo $this->lg->_("Porcentagem"); ?></option>
				</select>
		
			</div>
			
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Altura"); ?>
				
				</span>
				
				<a style="width:100%; float:left; color:#666; text-decoration:none; font-size:12px; margin:5px 0px;" href="javascript:heightAuto();"><?php echo $this->lg->_("Detectar altura."); ?></a>
		
				<div class="input_ico">
					<i class="fa fa-arrows-v"></i>
				</div> 
				
				<input class="input_text height" type="text" placeholder="<?php echo $this->lg->_("Altura"); ?>"> 
				
				<script>

					function heightAuto(){

						$('input.height').val('auto');
						
					}
				
				</script>
		
			</div>
		
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>

	<?php } elseif ($this->post['tipo'] == $this->lg->_("formulario")){ ?>
	
		<?php if ($this->post['acao'] == 'new'): ?>

			<form font-size="14" font-family="Roboto" class="form-geral" id="<?php echo $corPadrao;?>" method="post">
				
				<label class="pergunta" id="1516282105" type="text" null="" data-placeholder="<?php echo $this->lg->_("Qual seu nome?"); ?>">
				
					<input type="hidden" name="name[qualseunome]" value="<?php echo $this->lg->_("Qual seu nome?"); ?>">
					<input type="text" null="" required="required" name="qualseunome" placeholder="<?php echo $this->lg->_("Qual seu nome?"); ?>">
					
				</label>
				
				<label class="pergunta" id="1516282130" type="tel" pattern="[0-9]+$" data-placeholder="<?php echo $this->lg->_("Qual sua idade?"); ?>">
				
					<input type="hidden" name="name[qualsuaidade]" value="Qual sua idade?">
					<input type="tel" null="" pattern="[0-9]+$" required="required" name="qualsuaidade" placeholder="<?php echo $this->lg->_("Qual sua idade?"); ?>">
				
				</label>
				
				<label class="pergunta" id="1516281772" type="date" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}$" data-placeholder="Data">
					
					<input type="hidden" name="name[data]" value="Data">
					<input type="date" null="" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}$" required="required" name="data" placeholder="Data">
					
				</label>
				
				<div id="b-1516281798" class="form-radio">
					
					<p><?php echo $this->lg->_("Alternativas"); ?></p>
					<input type="hidden" name="name[1516281798]" value="Alternativas">
					
					<label class="radio">
    					<input type="radio" required="required" name="1516281798" value="Um">
    					<span><?php echo $this->lg->_("Um"); ?></span>
					</label>
				
    				<label class="radio">
    					<input type="radio" required="required" name="1516281798" value="Dois">
    					<span><?php echo $this->lg->_("Dois"); ?></span>
    				</label>
				
    				<label class="radio">
    					<input type="radio" null="" name="1516281798" value="Três">
    					<span><?php echo $this->lg->_("Três"); ?></span>
    				</label>
				
				</div>
				
				<div id="b-1516282088" class="form-checkbox">
					<p><?php echo $this->lg->_("Seleção"); ?></p>
					<input type="hidden" name="name[1516282088]" value="<?php echo $this->lg->_("Seleção");?>">
					
					<label class="checkbox">
    					<input type="checkbox" required="required" name="1516282088" value="Um">
    					<span><?php echo $this->lg->_("Um"); ?></span>
					</label>
					<label class="checkbox">
						<input type="checkbox" null="" name="1516282088" value="<?php echo $this->lg->_("Dois"); ?>">
						<span><?php echo $this->lg->_("Dois"); ?></span>
					</label>
					<label class="checkbox">
						<input type="checkbox" null="" name="1516282088" value="<?php echo $this->lg->_("Três"); ?>">
						<span><?php echo $this->lg->_("Três"); ?></span>
					</label>
				</div>
				
				<label class="texto" id="1516281828" type="text" null="" data-placeholder="<?php echo $this->lg->_("Texto"); ?>">
					<input type="hidden" name="name[texto]" value="<?php echo $this->lg->_("Texto"); ?>">
					<textarea name="texto" placeholder="<?php echo $this->lg->_("Texto"); ?>"></textarea>
				</label>
				
				<label id="b-24260507280" class="submit">
				
					<input font-size="13" border-radius="4" font-family="Roboto" italic="false" bold="false" type="hidden" value="Enviar">
					<input font-size="13" placeholder="Enviar" border-radius="4" font-family="Roboto" italic="false" bold="false" type="submit" value="Enviar" style="display:none;">
                    <a font-size="13" border-radius="4" font-family="Roboto" italic="false" bold="false" class="submit-link">Enviar</a>
					
				</label>
				
			</form>
	
		<?php else: ?>
		
		<script>

            $('.ajax_montagem').attr('id', '<?php echo $this->post['id'];?>');
            var id = '<?php echo $this->post['id'];?>';

            var elForm = $('#'+id);
            var paginaFinal = elForm.find('input[name="pagina_final"]').val()

            var edit = $('#'+id+' div.edit');
            var obj = $(edit).find('form');
            var meusForm = [];


            var fontSize = obj.attr('font-size')
            var fontFamily = obj.attr('font-family')
            var italic = obj.attr('italic')
            var bold = obj.attr('bold')
            var formulario = $(obj).html();
            var cor = $(obj).attr('id');

			$(function(){

				setTimeout(function(){

					$('.edicao_box').animate({
						scrollTop: $('#submit').offset()
					}, 1000);

				},2000);

                //carregamento de redirecionamento
                var id = $('.box-celular').attr('id');
                $('.url-tipo').find('input').remove();
                $.ajax({
                    url: '<?php echo $this->baseModule;?>/templates/paginas-landing',
                    type: 'POST',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function(row){

                        $('.redi').html('')
                        $('.redi').append('<option selected value="pag=final">Página Final</option>')
                        for ( i in row ) {
                            $('.redi').append('<option value="id_pagina='+row[i].id_pagina+'">'+row[i].nome+'</option>')
                        }

                        if ( paginaFinal ){
                            $('.redi').val( paginaFinal )
                        }

                    }
                })

                // PEGA FORMULARIO EXATAMENTE IGUAL
                $('.formulario-set').html(formulario).attr('id', cor);
                $('.formulario-set').attr('font-size', fontSize)
                $('.formulario-set').attr('font-family', fontFamily)
                $('.formulario-set').attr('bold', bold)
                $('.formulario-set').attr('italic', italic)
                $('.formulario-set button[type="button"]').remove();
                $('.formulario-set').append('<div id="submit"><button type="button" onclick="aplicarAlteracao();" style="margin-right:0px;">Aplicar alterações</button></div>');

				$('#cor').attr('data-cor', cor);

            });

			// ADICIONA FUNÇÕES EDIT/EXCLUIR
			function adcFuncoes(){

				$('.o-options').remove();
				var funcoes  = '<div class="o-options">';
					funcoes += '<i class="fa fa-pencil-square edicao-indi" aria-hidden="true"></i>';
					funcoes += '<i class="fa fa-times-circle remove-indi" aria-hidden="true"></i>';
					funcoes += '<i class="fa fa-arrows move" aria-hidden="true"></i>';
					funcoes += '</div>';
				$('.formulario-set > label, .formulario-set > div').prepend(funcoes);

				$('.formulario-set label.submit .move,.formulario-set label.submit .remove-indi').remove();
				
				// EDIÇÃO
				$('.remove-indi').click(function(){
					$(this).parent().parent().remove();
				});

				$('.edicao-indi').click(function(e){

				    e.stopPropagation()

					var id = $(this).parent().parent().attr('id');
					var tipo = $(this).parent().parent().attr('class');

					if (tipo == 'pergunta'){
						newPergunta(id);
					} else if (tipo == 'texto'){
						newTexto(id);
					} else if (tipo == 'form-checkbox'){
						newSelecao(tipo, id);
					} else if (tipo == 'form-radio'){
						newAlternativas(tipo, id);
					} else if (tipo == 'submit'){
						editSubmit(id);
					} else if (tipo == 'termos-accept'){
                        newTermos('termos', id);
                    }
						
				});

				$(".formulario-set").sortable({
					handle: ".move"
				});

			    $(".formulario-set").disableSelection();
			    
			}
			

			adcFuncoes();
				

			function aplicaEdicao(acao, id){

				// ESCONDE TODOS FORMS	
				var i = 0;
				$('.box-celular form').each(function(){

					meusForm[i] = $(this).html();
					$(this).html('Carregando mais informações...');
					i++;
					
				});
				
				var slug = $('.aplica-edicao .pergunta input').val();
					slug = slug.replace(/(<([^>]+)>)/ig,"");

                if ( acao == 'submit' ){

                    var styleSubmit = 'style="'
                        styleSubmit += 'font-size: '+ $('.font-size').val() +'px;'
                        styleSubmit += 'font-family: '+ $('.font-family').val() +';'
                        styleSubmit += 'font-weight: '+ $('.bold').val() +';'
                        styleSubmit += 'font-style: '+ $('.italic').val() +';'
                        styleSubmit += 'border-radius: '+ $('.border-radius').val() +'px;'
                        styleSubmit += '" '

                    console.log( 'console', $('.italic').val(), $('.bold').val() )

                } else {

                    var styleSubmit = ''

                }

				if ( $('.aplica-edicao .pergunta input').attr('data-type') ) {
					var type = 'type="'+$('.aplica-edicao .pergunta input').attr('data-type')+'"';
				} else {
					var type = 'type="text"';
				}

				if ( $('.aplica-edicao .pergunta input').attr('data-class') ) {
					var classe = 'data-class="'+$('.aplica-edicao .pergunta input').attr('data-class')+'"';
				} else {
					var classe = '';
				}
				
				if ( $('.aplica-edicao .pergunta input').attr('data-pattern') ) {
					var pattern = 'pattern="'+$('.aplica-edicao .pergunta input').attr('data-pattern')+'"';
				} else {
					var pattern = '';
				}

				if ( $('.aplica-edicao .pergunta input').attr('data-required') ) {
					var required = 'required="'+$('.aplica-edicao .pergunta input').attr('data-required')+'"';
				} else {
					var required = '';
				}

				if ( $('.aplica-edicao .pergunta input').attr('data-minlength') ) {
					var minlength = 'minlength="'+$('.aplica-edicao .pergunta input').attr('data-minlength')+'"';
				} else {
					var minlength = '';
				}

				if ( $('.aplica-edicao .pergunta input').attr('data-maxlength') ) {
					var maxlength = 'maxlength="'+$('.aplica-edicao .pergunta input').attr('data-maxlength')+'"';
				} else {
					var maxlength = '';
				}

				if ( $('.aplica-edicao .pergunta input').attr('title') ) {
					var title = 'title="'+$('.aplica-edicao .pergunta input').attr('title')+'"';
				} else {
					var title = '';
				}

				$.ajax({
					url: '<?php echo $this->baseModule;?>/templates/edicao-box',
					type: 'POST',
					data: {slug: slug},
					dataType: 'JSON',
					success: function(row){

					    console.log( row, required )

						var newE  = '<label class="'+acao+'" id="'+row.time+'" '+type+' '+pattern+' data-placeholder="'+slug+'" '+required+'>';

							if (acao == 'pergunta'){

							    if ( type == 'type="date"' || type == 'type="time"' ){
							        newE += '<p>'+slug+'</p>'
                                }

								newE += '<input type="hidden" name="name['+row.slug+']" value="'+slug+'">';
								newE += '<input '+type+' '+title+' '+maxlength+' '+minlength+' '+classe+' '+pattern+' '+required+' name="'+row.slug+'" placeholder="'+slug+'">';
								
							} else if (acao == 'texto'){
								
								newE += '<input type="hidden" name="name['+row.slug+']" value="'+slug+'">';
								newE += '<textarea name="'+row.slug+'" placeholder="'+slug+'"></textarea>';
								
							} else if (acao == 'submit'){
								
								newE += '<input type="hidden" value="'+slug+'" font-size="'+$('.font-size').val()+'" border-radius="'+$('.border-radius').val()+'" font-family="'+$('.font-family').val()+'" italic="'+$('.italic').val()+'" bold="'+$('.bold').val()+'">';
								newE += '<input placeholder="'+slug+'" type="submit" font-size="'+$('.font-size').val()+'" border-radius="'+$('.border-radius').val()+'" font-family="'+$('.font-family').val()+'" italic="'+$('.italic').val()+'" bold="'+$('.bold').val()+'" value="'+slug+'" style="display:none;">';
								newE += '<a '+styleSubmit+' class="submit-link" font-size="'+$('.font-size').val()+'" border-radius="'+$('.border-radius').val()+'" font-family="'+$('.font-family').val()+'" italic="'+$('.italic').val()+'" bold="'+$('.bold').val()+'">'+slug+'</a>'
								
							}
							
							newE += '</label>';

						if (id == 'null'){
							
							$('.formulario-set .submit').before(newE);
							
						} else {
							
							$('.formulario-set #'+id).before(newE);
							$('.formulario-set #'+id).remove();
							
						}

						adcFuncoes();

						$('.back').trigger('click');

						// ESCONDE TODOS FORMS	
						var i = 0;
						$('.box-celular form').each(function(){

							$(this).html(meusForm[i]);
							
							i++;
							
						});
						
					}
				});
				
			}

			function montaFormulario(acao, id){

			    console.log(acao,id)

				if (!id){
					var id = null;
				}
				
				$('.formulario-set').slideUp();
				$('#edicao-form').html('<div class="loader"><i class="fa fa-cog fa-spin"></i> carregando edição...</div>');

				var edit  = '<form class="aplica-edicao" action="javascript:aplicaEdicao(\''+acao+'\',\''+id+'\');">';
					edit += '<label class="pergunta">';

					if ( acao == 'submit' ) {
                        edit += '<span>Nome do botão</span>';
                    } else {
                        edit += '<span>Nome da pergunta.</span>';
                    }

					edit += '<input type="text" class="pergunta config-campo" placeholder="Ex: Qual seu nome?">';

					if ( acao != 'texto' && acao != 'submit' ) {
						edit += '<button type="button" class="my-config"><i class="fa fa-cog"></i> Configurar esse campo.</button>';
					}

                    if ( acao == 'submit' ) {

                        edit += '<div class="load-button">'

                        edit += '<div class="tipo">'
                        edit += '<span>Arredondamento</span>'
                        edit += '<select class="border-radius">'
                        for (var i = 0; i < 51; i++) {
                            edit += '<option>'+i+'</option>'
                        }
                        edit += '</select>'
                        edit += '</div>'

                        edit += '<div class="tipo">'
                        edit += '<span>Tamanho do texto</span>'
                        edit += '<select class="font-size">'
                        for (var i = 12; i < 40; i++) {
                            edit += '<option>'+i+'</option>'
                        }
                        edit += '</select>'
                        edit += '</div>'

                        edit += '<div class="tipo">'
                        edit += '<span>Fonte</span>'
                        edit += '<select class="font-family">'
                        edit += '<option>Roboto</option>'
                        edit += '<option>Arial</option>'
                        edit += '<option>Comic Sans MS</option>'
                        edit += '<option>Courier New</option>'
                        edit += '<option>Georgia</option>'
                        edit += '<option>Lucida Sans Unicode</option>'
                        edit += '<option>Tahoma</option>'
                        edit += '<option>Times New Roman</option>'
                        edit += '<option>Trebuchet MS</option>'
                        edit += '<option>Verdana</option>'
                        edit += '</select>'
                        edit += '</div>'

                        edit += '<div class="tipo">'
                        edit += '<span>Italico</span>'
                        edit += '<select class="italic">'
                        edit += '<option value="italic">Sim</option>'
                        edit += '<option value="normal">Não</option>'
                        edit += '</select>'
                        edit += '</div>'

                        edit += '<div class="tipo">'
                        edit += '<span>Negrito</span>'
                        edit += '<select class="bold">'
                        edit += '<option value="bold">Sim</option>'
                        edit += '<option value="normal">Não</option>'
                        edit += '</select>'
                        edit += '</div>'

                        edit += '</div>'

                    }
					
					edit += '</label>';
					edit += '<div class="box-edicao">';
					edit += '<input type="submit" value="Salvar alteração"/>';
					edit += '<a class="back">Voltar</a>';
					edit += '</div>';
					edit += '</form>';
					
				$('#edicao-form').html(edit);

                $(".total-arredonda").html($("#slider").slider("value"));
	
				$('.back').click(function(){
					$('#edicao-form').html('');
					$('.formulario-set').slideDown();
				});
				
				if (id){
					
					var valor = $('.formulario-set #'+id+' input[type="hidden"]').val();

					var campoEditavel = $('.formulario-set #'+id+' *[placeholder="'+valor+'"]');

                    $('.aplica-edicao input[type="text"]').attr('font-size', campoEditavel.attr('font-size'));
                    $('.aplica-edicao input[type="text"]').attr('font-family', campoEditavel.attr('font-family'));
                    $('.aplica-edicao input[type="text"]').attr('italic', campoEditavel.attr('italic'));
                    $('.aplica-edicao input[type="text"]').attr('bold', campoEditavel.attr('bold'));
                    $('.aplica-edicao input[type="text"]').attr('border-radius', campoEditavel.attr('border-radius'));

					$('.aplica-edicao input[type="text"]').attr('data-pattern', campoEditavel.attr('pattern'));
					$('.aplica-edicao input[type="text"]').attr('data-required', campoEditavel.attr('required'));
					$('.aplica-edicao input[type="text"]').attr('data-type', campoEditavel.attr('type'));
					$('.aplica-edicao input[type="text"]').attr('data-maxlength', campoEditavel.attr('maxlength'));
					$('.aplica-edicao input[type="text"]').attr('data-minlength', campoEditavel.attr('minlength'));
					$('.aplica-edicao input[type="text"]').attr('data-class', campoEditavel.attr('data-class'));
					
					$('.aplica-edicao input[type="text"]').val(valor);

					$('.font-size').val( campoEditavel.attr('font-size') )
                    $('.font-family').val( campoEditavel.attr('font-family') )
                    $('.italic').val( campoEditavel.attr('italic') )
                    $('.bold').val( campoEditavel.attr('bold') )
                    $('.border-radius').val( campoEditavel.attr('border-radius') )

				}
				
			}

			function montaFormularioOpcoes(tipo, id){
				//alert('lalala');
				if (!id){
					var id = null;
				}

				$('.formulario-set').slideUp();
				$('#edicao-form').html('<div class="loader"><i class="fa fa-cog fa-spin"></i> carregando edição...</div>');

				var edit  = '<form id="'+cor+'" class="aplica-edicao" action="javascript:aplicaOpcoes(\''+tipo+'\',\''+id+'\');">';

                    edit += '<label class="pergunta">';
                    edit += '<span>Nome da pergunta.</span>';
                    edit += '<input type="text" class="pergunta" placeholder="Ex: qual seu sexo?">';
                    edit += '</label>';


                    edit += '<a class="new new-op">Adicionar opção</a>';

                    edit += '<div class="opcoes"></div>';

                    edit += '<div class="box-edicao">';
                    edit += '<input type="submit" value="Salvar alteração"/>';
                    edit += '<a class="back">Voltar</a>';
                    edit += '</div>';


					
					edit += '</form>';
					
				$('#edicao-form').html(edit);
	
				$('.back').click(function(){
					$('#edicao-form').html('');
					$('.formulario-set').slideDown();
				});

				if (id){
					
					var valor = $('.formulario-set #'+id+' input[type="hidden"]').val();
					$('.aplica-edicao input[type="text"]').val(valor);

					var opcoesGeral = '';

					$('.formulario-set #'+id+' label').each(function(){

						if ( $(this).find('input').attr('required') ) {
							var required = 'data-required="required" required="required"';
						} else {
							var required = null;
						}
						
						opcoesGeral += '<div>';
						opcoesGeral += '<div class="config-op"><i class="fa fa-arrows move" aria-hidden="true"></i><i class="fa fa-times-circle remove-op" aria-hidden="true"></i></div>';

						if ( tipo != 'radio' ){
// 							opcoesGeral += '<button type="button" class="my-config" style="margin-bottom:6px;" > <i class=fa fa-cog"></i> Configurar esse campo. </button>';
						}

                        opcoesGeral += '<span '+required+' class="config-campo" contenteditable="true">';
                        opcoesGeral += $(this).find('span').html();
                        opcoesGeral += '</span>';
                        opcoesGeral += '</div>';

						
					});
					
				}

				$('.opcoes').html(opcoesGeral);
				$('.opcoes input').removeClass();

				if ( tipo == 'radio' || tipo == 'checkbox' ){

					$('.opcoes').prepend('<button type="button" class="my-config radio" style="margin-bottom:6px;" > <i class=fa fa-cog"></i> Configurar esse campo. </button>');

				}
				
				adcFuncoes();
				remove_edit();

				$(".opcoes").sortable({
					handle: ".move"
				});

				$('.new-op').click(function(){

					var newOp  = '';
						newOp += '<div>';
						newOp += '<div class="config-op"><i class="fa fa-arrows move" aria-hidden="true"></i><i class="fa fa-times-circle remove-op" aria-hidden="true"></i></div>';

						if ( tipo != 'radio' ){
// 							newOp += '<button type="button" class="my-config" style="margin-bottom:6px;"> <i class=fa fa-cog"></i> Configurar esse campo. </button>';
						}

                        newOp += '<span class="config-campo" contenteditable="true">Opção</span>';

						newOp += '</div>';

					$('.opcoes').append(newOp);

					$(".opcoes").sortable({
						handle: ".move"
					});
					
					remove_edit();
						
				});

				function remove_edit(){

					$('.remove-op').click(function(){
						$(this).parent().parent().remove();
					});
					
				}
				
			}

            function montaTermos(tipo, id){

                if (!id){
                    var id = null;
                }

                $('.formulario-set').slideUp();
                $('#edicao-form').html('<div class="loader"><i class="fa fa-cog fa-spin"></i> carregando edição...</div>');

                var edit  = '<form id="'+cor+'" class="aplica-edicao" action="javascript:aplicaTermos(\''+tipo+'\',\''+id+'\');">';

                edit += '<label class="pergunta">';
                edit += '<span>Titulo do termos</span>';
                edit += '<input type="text" class="pergunta titulo" placeholder="Ex: Eu aceito os termos e...">';
                edit += '</label>';

                edit += '<label class="pergunta" style="width: 90%; float: left;margin: 0px 5% 5% 5%;">';
                edit += '<span style="width: 100%;float: left;padding: 0px 0px 5px 0px;text-transform: uppercase;font-size: 12px;color: #666;">Botão para ler o texto</span>';
                edit += '<input type="text" class="pergunta botao" placeholder="Saiba mais">';
                edit += '</label>';

                edit += '<label class="pergunta" style="width: 90%; float: left;margin: 0px 5% 5% 5%;">';
                edit += '<span style="width: 100%;float: left;padding: 0px 0px 5px 0px;text-transform: uppercase;font-size: 12px;color:#666;">Texto do termos</span>';
                edit += '<textarea type="text" id="editor_termos" class="pergunta termos" placeholder="Ex: Leia nossos termos de..."></textarea>';
                edit += '</label>';

                edit += '<div class="box-edicao">';
                edit += '<input type="submit" value="Salvar alteração"/>';
                edit += '<a class="back">Voltar</a>';
                edit += '</div>';


                edit += '</form>';

                $('#edicao-form').html(edit);

                CKEDITOR.replace("editor_termos");

                $('.back').click(function(){
                    $('#edicao-form').html('');
                    $('.formulario-set').slideDown();
                });

                if (id){

                    var valor = $('.formulario-set #'+id+' .text-accept div').html();
                    $('.aplica-edicao textarea').val(valor);

                    var valor = $('.formulario-set #'+id+' .text-accept span').html();
                    $('.aplica-edicao input[type="text"].titulo').val(valor);

                    var valor = $('.formulario-set #'+id+' .text-accept > a').text();
                    $('.aplica-edicao input[type="text"].botao').val(valor);

                }

                adcFuncoes();
                remove_edit();

                function remove_edit(){

                    $('.remove-op').click(function(){
                        $(this).parent().parent().remove();
                    });

                }

            }

			// EDIÇÕES/INSERÇÕES
			function newPergunta(id){
				montaFormulario('pergunta', id);
			}

			function newTexto(id){
				montaFormulario('texto', id);
			}

			function newAlternativas(tipo, id){

				montaFormularioOpcoes('radio', id);
				
			}

			function newSelecao(tipo, id){

				montaFormularioOpcoes('checkbox', id);
				
			}

            function newTermos(tipo, id){

                montaTermos('termos', id);

            }

			function editSubmit(id){

				montaFormulario('submit', id);

			}

			// APLICANDO
			function aplicarAlteracao(){

				$('ui-state-active').removeClass();

				$('.formulario-set input[name="id_form"]').remove();

				var id_form = '';
				$('.formulario-set input[type="hidden"]').each( function (){
					if ( $(this).attr('name') != 'pagina_final' ){
						id_form += $(this).attr('name');
					}
				});	

				var pagina_final = $('.redi.input_text').val()
				
				$('.formulario-set input[name="id_form"]').remove()
				$('.formulario-set input[name="pagina_final"]').remove()
				
				$('.formulario-set').append('<input type="hidden" name="id_form" value="'+id_form+'"/>');
				$('.formulario-set').append('<input type="hidden" name="pagina_final" value="'+pagina_final+'"/>');

				var formulario = $('.formulario-set').html();
				$(obj).html(formulario);

				var cor = $('#cor').attr('data-cor');
				$(obj).attr('id', cor);

                $(function(){
                    $(obj).attr('font-size', $('.formulario-set').attr('font-size'))
                    $(obj).attr('font-family', $('.formulario-set').attr('font-family'))
                    $(obj).attr('italic', $('.formulario-set').attr('italic'))
                    $(obj).attr('bold', $('.formulario-set').attr('bold'))
                })



				$(obj).find('.o-options').remove();
				$(obj).find('button[type="button"]').remove();
				
			}

            function aplicaTermos(tipo, id){

                var slug = $('.aplica-edicao input[type="text"].titulo').val();
                    slug = slug.replace(/(<([^>]+)>)/ig,"");

                var termos = $('.aplica-edicao textarea').val();

                var botao = $('.aplica-edicao input.botao').val();

                console.log( slug, termos, id )

                $.ajax({
                    url: '<?php echo $this->baseModule;?>/templates/edicao-box',
                    type: 'POST',
                    data: {slug: slug},
                    dataType: 'JSON',
                    success: function(row){

                        var newE = '<div id="t-'+row.time+'" class="termos-accept">'
                            newE += '<div class="checkbox-accept">'
                            newE += '<input type="checkbox" required="required"/>'
                            newE += '</div>'
                            newE += '<div class="text-accept">'
                            newE += '<span>'+slug+'</span>'
                            newE += '<a>'+botao+'</a>'
                            newE += '<div class="texto-termos">'+termos+'</div>'
                            newE += '</div>'
                            newE += '</div>'

                        if (id != 'null'){
                            $('.formulario-set #'+id).before(newE);
                            $('.formulario-set #'+id).remove();
                        } else {
                            $('.formulario-set .submit').before(newE);
                        }

                        $('.back').trigger('click');
                        adcFuncoes();

                    }
                });

                adcFuncoes();

            }

			function aplicaOpcoes(tipo, id){

				var slug = $('.aplica-edicao input[type="text"]').val();
					slug = slug.replace(/(<([^>]+)>)/ig,"");

				$.ajax({
					url: '<?php echo $this->baseModule;?>/templates/edicao-box',
					type: 'POST',
					data: {slug: slug},
					dataType: 'JSON',
					success: function(row){


                        var newE = '<div id="b-'+row.time+'" class="form-'+tipo+'">';
                            newE += '<p>'+slug+'</p>';
                            newE += '<input type="hidden" name="name['+row.time+']" value="'+slug+'"/>';

                        $('.opcoes > div').each(function(){

                            var valor = $(this).find('span').text();
                                valor = valor.replace(/(<([^>]+)>)/ig,"");

                            if ( $('.config-campo.radio').length > 0 ) {

                                if ( $('.config-campo.radio').attr('data-required') ) {
                                    var required = 'required="'+$('.config-campo.radio').attr('data-required')+'"';
                                } else {
                                    var required = null;
                                }

                            } else {

                                if ( $(this).find('.config-campo').attr('data-required') ) {
                                    var required = 'required="'+$(this).find('.config-campo').attr('data-required')+'"';
                                } else {
                                    var required = null;
                                }

                            }

                            newE += '<label class="'+tipo+'">';
                            newE += '<input type="'+tipo+'" '+required+' name="'+row.time+'" value="'+valor+'"/>';
                            newE += '<span>'+valor+'</span>';
                            newE += '</label>';

                        });

                        newE += '</div>';

						if (id != 'null'){
							$('.formulario-set #'+id).before(newE);
							$('.formulario-set #'+id).remove();
						} else {
							$('.formulario-set .submit').before(newE);
						}

						$('.back').trigger('click');
						adcFuncoes();
						
					}
				});

				adcFuncoes();
				
			}

		</script>
		
		<div id="cor">
			<script>coresTemplate('<?php echo $this->post['id'];?>', 'form');</script>
		</div>
		
		<div id="new">
		
			<a href="javascript:newPergunta();">
			
				<?php echo $this->lg->_("Adicionar Linha simples"); ?>
				<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione uma linha simples com um texto ou pergunta."); ?>"></i>
			
			</a>
			<a href="javascript:newTexto();">
			
				<?php echo $this->lg->_("Adicionar caixa"); ?>
				<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Adicione uma caixa de texto. Ela permite que sejam escritos textos mais longos do que na linha simples."); ?>"></i>
			
			</a>
			
			<a href="javascript:newAlternativas();">
			
				<?php echo $this->lg->_("Adicionar alternativas"); ?>
				<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione perguntas para serem respondidas com alternativas. É possível adicionar inúmeras opções de resposta."); ?>"></i>
			
			</a>
			<a href="javascript:newSelecao();">
			
				<?php echo $this->lg->_("Adicionar seleção"); ?>
				<i class="fa fa-question-circle question tooltip left" title="<?php echo $this->lg->_("Adicione perguntas para serem respondidas dentre opções determinadas. É possível adicionar apenas uma opção como resposta."); ?>"></i>
				
			</a>

            <a href="javascript:newTermos();" style="width:92%;">

                <?php echo $this->lg->_("Adicionar Confirmação de formulário"); ?>

            </a>
			
			<label class="pergunta">
    			<input type="hidden" data-tipo="config-form" value="<?php echo $this->lg->_("Configuração do formulario"); ?>" class="config-campo">
				<button type="button" class="my-config"><i class="fa fa-cog"></i> <?php echo $this->lg->_("Configurar formulario."); ?></button>
			</label>
			
			<div class="input-label">
				<span>
					Redirecionamento
				</span>
				
				<div class="input_ico"><i class="fa fa-link" aria-hidden="true"></i></div>
				<select required class="redi input_text">
					<option value="">Carregando...</option>
				</select>
				
			</div>
		
		</div>
		
		<form class="form-geral formulario-set" action="javascript:"></form>
		
		<div id="edicao-form"></div>
		
		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("texto")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<div class="texto">
				<p style="text-align:center"><span style="color:#999999">Lorem ipsum dolor sit amet, consectetur adipiscing elit...</span></p>
			</div>
			<div class="copy_el"></div>
	
		<?php else: ?>
		
		<div style="width: 90%;margin-left: 0%;overflow:auto;padding:5%;float:left;border:1px solid rgba(255, 0, 0, 0.3);font-size:12px;color:#666;height: 120px;">
		
			<i class="fa fa-info-circle"></i> <b><?php echo $this->lg->_("DICA"); ?></b>
			<?php echo $this->lg->_("Você pode utilizar os dados do contato usando a tag <b>[nome]</b>, <b>[sobrenome]</b>, <b>[celular]</b>, etc. Mas cuidado ao usar tags que o usuário não possui o campo pode ficar vázio. "); ?>
				
			<?php echo $this->lg->_("Confira a lista de todas as tags:"); ?>
			
			<b><?php echo $this->lg->_("[nome]"); ?></b> = <?php echo $this->lg->_("Nome"); ?><br/>
			<b><?php echo $this->lg->_("[sobrenome]"); ?></b> = <?php echo $this->lg->_("Sobrenome"); ?><br/>
			<b><?php echo $this->lg->_("[numero]"); ?></b> = <?php echo $this->lg->_("Celular"); ?><br/>
			<b><?php echo $this->lg->_("[celular]"); ?></b> = <?php echo $this->lg->_("Celular"); ?><br/>
			<b><?php echo $this->lg->_("[data_nascimento]"); ?></b> = <?php echo $this->lg->_("Data_nascimento"); ?><br/>
			<b><?php echo $this->lg->_("[email]"); ?></b> = <?php echo $this->lg->_("E-mail"); ?><br/>				
			<b><?php echo $this->lg->_("[cpf]"); ?></b> = <?php echo $this->lg->_("CPF"); ?><br/>
			<b><?php echo $this->lg->_("[empresa]"); ?></b> = <?php echo $this->lg->_("Empresa"); ?><br/>
			<b><?php echo $this->lg->_("[cargo]"); ?></b> = <?php echo $this->lg->_("Cargo"); ?><br/>
			<b><?php echo $this->lg->_("[telefone_comercial]"); ?></b> = <?php echo $this->lg->_("Telefone Comercial"); ?><br/>
			<b><?php echo $this->lg->_("[telefone_residencial]"); ?></b> = <?php echo $this->lg->_("Telefone Residencial"); ?><br/>
			<b><?php echo $this->lg->_("[pais]"); ?></b> = <?php echo $this->lg->_("Pais"); ?><br/>
			<b><?php echo $this->lg->_("[estado]"); ?></b> = <?php echo $this->lg->_("Estado"); ?><br/>
			<b><?php echo $this->lg->_("[cidade]"); ?></b> = <?php echo $this->lg->_("Cidade"); ?><br/>
			<b><?php echo $this->lg->_("[bairro]"); ?></b> = <?php echo $this->lg->_("Bairro"); ?><br/>
			<b><?php echo $this->lg->_("[endereço]"); ?></b> = <?php echo $this->lg->_("Endereço"); ?><br/>
			<b><?php echo $this->lg->_("[cep]"); ?></b> = <?php echo $this->lg->_("CEP"); ?><br/>
				
			<?php for ($i = 1; $i <= 40; $i++) {?>	
			<b><?php echo $this->lg->_("[editavel_"); ?><?php echo $i;?>]</b> =  <?php echo $this->lg->_("EDITAVEL "); ?><?php echo $i;?><br/>
			<?php } ?>
		
		</div>
			
		<form action="javascript:aplicar();">
		
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Copiar area de transferencia?")?></span>
				
				<div class="input_ico"><i class="fa fa-files-o"></i></div>
				<select name="copy_transfer" class="option input_text">
					<option value="">Não</option>
					<option value="true">Sim</option>
				</select>
			
			</div>
			
			<div class="input-label copy_div" style="display:none;">
			
				<span><?php echo $this->lg->_("Cor do botão")?></span>
				
				<div class="input_ico"><i class="fa fa-font"></i></div>
				<input class="input_text copy_cor" type="color" placeholder="" value="#000">
			
			</div>
		
			<div class="input-label copy_div" style="display:none;">
			
				<span><?php echo $this->lg->_("Texto do botão")?></span>
				
				<div class="input_ico"><i class="fa fa-font"></i></div>
				<input class="input_text copy_texto" type="text" value="Copiar para area de transferencia" placeholder="">
			
			</div>
			
			<div class="input-label copy_div" style="display:none;">
			
				<span><?php echo $this->lg->_("Cor do texto")?></span>
				
				<div class="input_ico"><i class="fa fa-font"></i></div>
				<input class="input_text copy_cor_texto" type="color" placeholder="" value="#FFF">
			
			</div>
		
			<div class="input-label">
				
				<span>
					<?php echo $this->lg->_("Sumir com conteudo"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Escreva uma variavel por exemplo: [nome] para esse conteudo aparecer apenas se existir a mesma, caso queira que sempre apareça ignore esse campo."); ?>"></i>
				</span>
				
				<div class="input_ico"><i class="fa fa-font"></i></div>
				<input class="input_text variavel_existe" type="text" placeholder="">
			</div>
		
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Texto"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione um texto corrido ao conteúdo do seu template, podendo escolher entre diversas opções de formatação (cor, fonte, posicionamento etc.)."); ?>"></i>
				
				</span>
				<textarea style="height:150px; width:386px; border:1px solid rgba(0,0,0,0.05);" id="editor_zigzag" name="editor_zigzag" class="input_textarea input_cont_final_edita"></textarea>
			</div>
		
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>
		
		<script>

			$(function(){

				$(document).on('change', 'select[name="copy_transfer"]', function(){

					if ( $(this).val() == 'true' ) {

						$('.copy_div').slideDown()
						
					} else {

						$('.copy_div').slideUp()

					}
					
				})
				

				var id = '<?php echo $this->post['id'];?>'
				var edit = $('#'+id+' div.edit')
				var copy_el = edit.find('.copy_el')
				var text = $(edit).find('.texto')
				
				if ( copy_el.length == 0 ){
					edit.append('<div class="copy_el"></div>')
				}

				$('#editor_zigzag').val(text.html());

				$('select[name="copy_transfer"]').val( edit.attr('data-copy') )
				$('.copy_cor').val( edit.attr('data-copy-cor') )
				$('.copy_cor_texto').val( edit.attr('data-copy-cor-texto') )
				$('.copy_texto').val( edit.attr('data-copy-texto') )

				var variavel_existe = edit.attr('data-variavel-existe');
				$('.variavel_existe').val(variavel_existe);
				
				CKEDITOR.replace("editor_zigzag");

				if ( $('select[name="copy_transfer"]').val() == 'true' ) {

					$('.copy_div').slideDown()
					
				} else {

					$('.copy_div').slideUp()

				}
				
			});

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var text = $(edit).find('.texto');

				var texto = $("textarea#editor_zigzag").val();
				var copy = $('select[name="copy_transfer"]').val()
				var copy_cor = $('.copy_cor').val()
				var copy_cor_texto = $('.copy_cor_texto').val()
				var copy_texto = $('.copy_texto').val()
				
				$(text).html(texto);

				edit.attr('data-copy', copy)
				edit.attr('data-copy-cor', copy_cor)
				edit.attr('data-copy-cor-texto', copy_cor_texto)
				edit.attr('data-copy-texto', copy_texto)
				
				edit.find('.copy_el').attr('style', 'background:'+copy_cor+'; color:'+copy_cor_texto+'')
				edit.find('.copy_el').html( copy_texto )

				var variavel_input = $('.variavel_existe').val();
				
				if ( variavel_input ) {
					$(edit).attr('data-variavel-existe', variavel_input);
				} else {
					$(edit).removeAttr('data-variavel-existe');
				}
				
			}
		
		</script>

		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("contagem")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<div class="cron" id="<?php echo $corPadrao;?>" data-fonte="14">
				<div class="icone">
					<i class="fa fa-clock-o" aria-hidden="true"></i>
				</div>
				<div style="font-size:14px;" class="relogio" id="<?php echo time();?>" data-ano="<?php echo date('Y', strtotime(date('Y/m/d H:i:s'). ' + 1 month'));?>" data-mes="<?php echo date('m', strtotime(date('Y/m/d H:i:s'). ' + 1 month'));?>" data-dia="<?php echo date('d', strtotime(date('Y/m/d H:i:s'). ' + 1 month'));?>" data-hora="<?php echo date('H', strtotime(date('Y/m/d H:i:s'). ' + 1 month'));?>" data-minuto="<?php echo date('i', strtotime(date('Y/m/d H:i:s'). ' + 1 month'));?>" data-segundo="<?php echo date('s', strtotime(date('Y/m/d H:i:s'). ' + 1 month'));?>">
					<span><?php echo $this->lg->_("Expira em"); ?></span> <b>0 dias 00:00:00</b>
				</div>
			</div>
	
		<?php else: ?>
	
			<script>
	
				$(function(){
	
					var id = '<?php echo $this->post['id'];?>';
					var edit = $('#'+id+' div.edit');
					var clock = $(edit).find('.cron');
	
					var cor = $(clock).attr('id');
	
					$(function(){
						$('#cor').attr('data-cor', cor);
					});

					var texto = $(clock).find('.relogio').find('span').html();
					console.log(texto);

					
					var ano = $(clock).find('.relogio').data('ano');
					var mes = $(clock).find('.relogio').data('mes');
					var dia = $(clock).find('.relogio').data('dia');
					var hora = $(clock).find('.relogio').data('hora');
					var minuto = $(clock).find('.relogio').data('minuto');
					var segundo = $(clock).find('.relogio').data('segundo');
					var fonte = $(clock).attr('data-fonte');

					$('.texto_cron').val(texto);
					$('.ano').val(ano);
					$('.mes').val(mes);
					$('.dia').val(dia);
					$('.hora').val(hora);
					$('.minuto').val(minuto);
					$('.segundo').val(segundo);

					$("#slider").slider({
						range: "min",
						value: fonte,
						min: 10,
						max: 18,
						slide: function( event, ui ) {
							$("#fonte").val(ui.value);
							$('.tamanho-fonte').attr('style','font-size:'+ui.value+'px');
						}
					});
					$("#fonte").val($("#slider").slider("value"));
					$('.tamanho-fonte').attr('style','font-size:'+$("#slider").slider("value")+'px');
					
				});
	
				function aplicar(){

					var texto = $('.ajax_montagem .texto_cron').val();
					var ano = $('.ajax_montagem .ano').val();
					var mes = $('.ajax_montagem .mes').val();
					var dia = $('.ajax_montagem .dia').val();
					var hora = $('.ajax_montagem .hora').val();
					var minuto = $('.ajax_montagem .minuto').val();
					var segundo = $('.ajax_montagem .segundo').val();
					var fonte = $('#fonte').val();

					var id = '<?php echo $this->post['id'];?>';
					var edit = $('#'+id+' div.edit');
					var clock = $(edit).find('.cron');
	
					var cor = $('#cor').attr('data-cor');
					$(clock).attr('id', cor);
					
					$(clock).find('.relogio').remove();
					$(clock).find('.icone').after('<div class="relogio" id="<?php echo time();?>"></div>');
					$(clock).attr('data-fonte', fonte);
					$(clock).find('.relogio').attr('style','font-size:'+fonte+'px;');
					$(clock).find('.relogio').attr('data-ano', ano);
					$(clock).find('.relogio').attr('data-mes', mes);
					$(clock).find('.relogio').attr('data-dia', dia);
					$(clock).find('.relogio').attr('data-hora', hora);
					$(clock).find('.relogio').attr('data-minuto', minuto);
					$(clock).find('.relogio').attr('data-segundo', segundo);
					$(clock).find('.relogio').attr('data-texto', texto);
					start_cron();
					
				}
			
			</script>
			
			<div id="cor">
				<script>coresTemplate('<?php echo $this->post['id'];?>', 'form');</script>
			</div>
	
			<form action="javascript:aplicar();">
			
				<div class="input-label">
					<span><?php echo $this->lg->_("Texto"); ?></span>
					<div class="input_ico"><i class="fa fa-font"></i></div>
					<input maxlength="11" class="input_text texto_cron" type="text" placeholder="">
				</div>
			
				<div class="input-label">
					<span><?php echo $this->lg->_("Ano"); ?></span>
					<div class="input_ico"><i class="fa fa-clock-o"></i></div>
					<input class="input_text ano" type="text" placeholder="">
				</div>
				
				<div class="input-label">
					<span><?php echo $this->lg->_("Mês"); ?></span>
					<div class="input_ico"><i class="fa fa-clock-o"></i></div>
					<input class="input_text mes" type="text" placeholder="">
				</div>
				
				<div class="input-label">
					<span><?php echo $this->lg->_("Dia"); ?></span>
					<div class="input_ico"><i class="fa fa-clock-o"></i></div>
					<input class="input_text dia" type="text" placeholder="">
				</div>
				
				<div class="input-label">
					<span><?php echo $this->lg->_("Hora"); ?></span>
					<div class="input_ico"><i class="fa fa-clock-o"></i></div>
					<input class="input_text hora" type="text" placeholder="">
				</div>
				
				<div class="input-label">
					<span><?php echo $this->lg->_("Minuto"); ?></span>
					<div class="input_ico"><i class="fa fa-clock-o"></i></div>
					<input class="input_text minuto" type="text" placeholder="">
				</div>
				
				<div class="input-label">
					<span><?php echo $this->lg->_("Segundo"); ?></span>
					<div class="input_ico"><i class="fa fa-clock-o"></i></div>
					<input class="input_text segundo" type="text" placeholder="">
				</div>
				
				<div class="input-label">
					<span><?php echo $this->lg->_("Tamanho da fonte"); ?></span>
					<input type="hidden" id="fonte"/>
					<div id="slider"></div>
					<span><?php echo $this->lg->_("Tamanho de exemplo:"); ?></span>
					<span class="tamanho-fonte"><?php echo $this->lg->_("Expira em "); ?><b>0 <?php echo $this->lg->_("dias "); ?>00:00:00</b></span>
				</div>
			
				<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
			
			</form>

		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("slide")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<div class="slide" data-time="4">
			
				<a href="javascript:;">
					<img src="assets/home/images/img-padrao.png"/>
				</a>
				
				<a href="javascript:;">
					<img src="assets/home/images/img-padrao.png"/>
				</a>
				
			</div>
	
		<?php else: ?>
		
		<script>

			var id = '<?php echo $this->post['id'];?>';
			var edit = $('#'+id+' div.edit');
			var img = $(edit).find('.slide a');
			var inputs = '';
			var time = edit.find('.slide').attr('data-time');

			$(function(){
				$('.time').val(time);
			});

			$(document).on('click', '.fa-times', function(){

				$(this).parents('.input-label').remove();
				
			});

			function removeInput(){
				
			}

			$(img).each(function(){

				if (!$(this).parent().hasClass('cloned')){
					
					var img = $(this).find('img').attr('src');
					var link = $(this).attr('href');

					if ( link != "javascript:;" && link != "'javascript:;'" ){

						var urlLimpa = link.split("javascript:urlBotao('");
							urlLimpa = urlLimpa[1].split("'");
							link = urlLimpa[0];

					} else {

						link = '';

					}

					
					inputs += '<div class="input-label">';
					inputs += '<span><i class="fa fa-arrows move" aria-hidden="true"></i> Imagem</span>';

					inputs += '<div style="width:100%; float:left;">';
					
					inputs += '<div class="input_ico abrir_galeria" onclick="abrir_galeria(this);">';
					inputs += '<i class="fa fa-picture-o"></i>';
					inputs += '</div>';
					
					inputs += '<input class="input_text input_imagem_atual" type="text" value="'+img+'" placeholder="URl da imagem...">';

					inputs += '</div>';
					
					inputs += '<div class="input_ico" style="float:right; margin-top:-33px;">';
					inputs += '<i class="fa fa-times"></i>';
					inputs += '</div>';

					inputs += '<div style="width:100%; float:left;">';

					inputs += '<div class="input_ico">';
					inputs += '<i class="fa fa-link"></i>';
					inputs += '</div>';
					
					inputs += '<input class="input_text input_link" type="text" value="'+link+'" placeholder="URl da imagem...">';

					inputs += '</div>';
					
					inputs += '</div>';
				}
				
			});

			$('.new-slide').click(function(){

				var inputs  = '';

					inputs += '<div class="input-label">';
					inputs += '<span><i class="fa fa-arrows move" aria-hidden="true"></i> Imagem</span>';

					inputs += '<div style="width:100%; float:left;">';
					
					inputs += '<div class="input_ico abrir_galeria" onclick="abrir_galeria(this);">';
					inputs += '<i class="fa fa-picture-o"></i>';
					inputs += '</div>';
					
					inputs += '<input class="input_text input_imagem_atual" type="text" placeholder="URl da imagem...">';

					inputs += '<div class="input_ico" style="float:right; margin-top:-33px;">';
					inputs += '<i class="fa fa-times"></i>';
					inputs += '</div>';

					inputs += '</div>';

					inputs += '<div style="width:100%; float:left;">';

					inputs += '<div class="input_ico">';
					inputs += '<i class="fa fa-link"></i>';
					inputs += '</div>';
					
					inputs += '<input class="input_text input_link" type="text" placeholder="Link da imagem...">';

					inputs += '</div>';
					
					inputs += '</div>';

					removeInput();
					
				$('.img-slide').append(inputs);

				$(".img-slide").sortable({
					handle: ".move"
				});
				
			});

			$('.img-slide').html(inputs);
			$(".img-slide").sortable({
				handle: ".move"
			});
			
			removeInput();

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var time = $('.time').val();

				var slide  = '<div class="slide" data-time="'+time+'">';

				$('.img-slide .input-label .input_imagem_atual').each(function(){

					var img = $(this).val();
					var link = $(this).parents('.input-label').find('.input_link').val();

					if ( link ) {
						var urlFuncao = "javascript:urlBotao('"+link+"', '"+img+"', 'funcao-slide');";
					} else {
						var urlFuncao = "javascript:;";
					}
					
					slide += "<a href=\""+urlFuncao+"\"><img src='"+img+"'/></a>";

				});
				
				slide += '</div>';

				$(edit).find('.slide').remove();
				$(edit).append(slide);
				refaz_slide();
				ativa_slide();
				
			}

		</script>
	
		<form action="javascript:aplicar();">
		
			<a class="new-slide">
			
				<?php echo $this->lg->_("Adicionar imagem"); ?>
				<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione as imagens desejada na galeria de imagens."); ?>"></i>
			
			</a>
			
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Tempo de transição (segundos)"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione o tempo de transição que você deseja entre as imagens do slide."); ?>"></i>
				
				</span>
				<div class="input_ico"><i class="fa fa-clock-o"></i></div>
				<input class="input_text time" type="text" placeholder="">
			</div>
		
			<div class="img-slide"></div>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("oferta")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<a href="javascript:;" class="oferta" id="<?php echo $corPadrao;?>">
				<img src="assets/uploads/imagens/temp/aviao_19.jpg"/>
				<span class="valor">
					<span class="de">
						<?php echo $this->lg->_("de R$ "); ?><b class="value">00,00</b>
					</span>
					<span class="por">
						<b><?php echo $this->lg->_("por R$"); ?></b><b class="value">00,00</b>
					</span>
				</span>
			</a>
	
		<?php else: ?>
		
		<script>

			$(function(){
				
				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var cor = edit.find('.oferta').attr('id');

				var obj = edit.find('.oferta');
				
				var rowLink = $(obj).attr('href');

				if ( $(obj).parent().find('a').length != 1 ) {

					$('.link-img').remove();
					
				} else {

					if ( rowLink != 'javascript:;' ){

						var urlLimpa = rowLink.split("javascript:urlBotao('");
							urlLimpa = urlLimpa[1].split("'");
							rowLink = urlLimpa[0];
						
						$('.input_link').val(rowLink);
						
					}

				}

				$('#cor').attr('data-cor', cor);
				
				var de = $(edit).find('.de').find('.value').html();
				var por = $(edit).find('.por').find('.value').html();
				var img = $(edit).find('img').attr('src');

				$('.input_imagem_atual').val(img);
				$('.ajax_montagem .por').val(por);
				$('.ajax_montagem .de').val(de);

			});

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var oferta = $(edit).find('.oferta');

				var cor = $('#cor').attr('data-cor');

				var link = $('.input_link').val();
				var img = $('.input_imagem_atual').val();
				var de = $('.ajax_montagem .de').val();
				var por = $('.ajax_montagem .por').val();

				if ( link ) {
					var urlFuncao = "javascript:urlBotao('"+link+"', '"+img+"', 'funcao-oferta');";
				} else {
					var urlFuncao = "javascript:;";
				}
				
				$(oferta).attr('href', urlFuncao);
				
				$(oferta).attr('id', cor);
				$(oferta).find('img').attr('src', img);
				$(oferta).find('.de').find('.value').html(de);
				$(oferta).find('.por').find('.value').html(por);
				
			}

		</script>
		
		<div id="cor">
			<script>coresTemplate('<?php echo $this->post['id'];?>', 'form');</script>
		</div>
	
		<form action="javascript:aplicar();">
		
			<div class="input-label link-img">
				<span>
				
					<?php echo $this->lg->_("Link da oferta"); ?>
				
				</span>
		
				<div class="input_ico">
					<i class="fa fa-link"></i>
				</div> 
				
				<input class="input_text input_link" type="text" placeholder="<?php echo $this->lg->_("Link da oferta"); ?>">
		
			</div>
		
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Imagem"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione a imagem desejada na galeria de imagens."); ?>"></i>
				
				</span>
		
				<div class="input_ico abrir_galeria" onclick="abrir_galeria(this);">
					<i class="fa fa-picture-o"></i>
				</div> 
				
				<input class="input_text input_imagem_atual" type="text" placeholder="<?php echo $this->lg->_("URl da imagem..."); ?>">
		
			</div>
			
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Valor de"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione o valor anterior do produto em divulgação."); ?>"></i>
				
				</span>
				<div class="input_ico"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
				<input class="input_text de" type="text" placeholder="">
			</div>
			
			<div class="input-label">
			
				<span>
				
					<?php echo $this->lg->_("Valor por"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione o atual valor (promocional) do produto em divulgação."); ?>"></i>
				
				</span>
				
				<div class="input_ico"><i class="fa fa-credit-card" aria-hidden="true"></i></div>
				<input class="input_text por" type="text" placeholder="">
			</div>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("botão")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<a class="bt" data-tipo="Externo" data-href="http://google.com" id="<?php echo $corPadrao; ?>" href="javascript:;"><?php echo $this->lg->_("Botão"); ?></a>
	
		<?php else: ?>
		
		<script>

			$(function(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var botao = $(edit).find('.bt');
				var cor = botao.attr('id');
				var radius = botao.attr('data-radius');
				var tipo = botao.attr('data-tipo');
				var urlBotao = $(botao).attr('data-href');
				var nomeBotao = $(botao).html();
				
				if (tipo == 'Externo'){
					$('.url-tipo').find('select').remove();
					$('.url-tipo').append('<input class="input_text url-botao" type="text" placeholder=""/>');
				} else {
					var id = $('.box-celular').attr('id');
					$('.url-tipo').find('input').remove();
					$.ajax({
						url: '<?php echo $this->baseModule;?>/templates/paginas-landing',
						type: 'POST',
						data: {id: id},
						dataType: 'JSON',
						success: function(row){

							$('.ajax_montagem .loader').remove();

							var select = '<select class="url-botao input_text">';
								select += '<option value="home">Página inicial</option>';
							for(var i in row) {
								select += '<option value="'+row[i].id_pagina+'">'+row[i].nome+'</option>';
							}
							select += '</select>';
							$('.url-tipo').append(select);
							$('.url-botao').val(urlBotao);
								
						}, beforeSend: function(){

							$('.url-tipo').append('<span class="loader" style="width:311px; height:21px;"><i class="fa fa-spin fa-spinner"></i> Carregando páginas...</san>');
							
						}
					});
				}	
				
				if (!radius){
					radius = 0;
				}

				$("#slider").slider({
					range: "min",
					value: radius,
					min: 0,
					max: 30,
					slide: function( event, ui ) {
						$("#radius").val(ui.value );
					}
				});
				$("#radius").val($("#slider").slider("value"));

				$('#cor').attr('data-cor', cor);

				$('.ajax_montagem .option').val(tipo);
				$('.ajax_montagem .url-botao').val(urlBotao);
				$('.ajax_montagem .nome-botao').val(nomeBotao);
				
				
			});

			function tipoUrl(bt){
				
				var tip = $(bt).val();

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var botao = $(edit).find('.bt');
				var cor = botao.attr('id');
				var radius = botao.attr('data-radius');
				var urlBotao = $(botao).attr('data-href');
				var nomeBotao = $(botao).html();


				if (tip == 'Interno'){

					var id = $('.box-celular').attr('id');
					$('.url-tipo').find('input').remove();

					$.ajax({
						url: '<?php echo $this->baseModule;?>/templates/paginas-landing',
						type: 'POST',
						data: {id: id},
						dataType: 'JSON',
						success: function(row){

							$('.ajax_montagem .loader').remove();

							var select = '<select class="url-botao input_text">';
								select += '<option value="home">Página inicial</option>';
							for(var i in row) {
								select += '<option value="'+row[i].id_pagina+'">'+row[i].nome+'</option>';
							}
							select += '</select>';
							$('.url-tipo').append(select);
								
						}, beforeSend: function(){

							$('.url-tipo').append('<span class="loader" style="width:311px; height:21px;"><i class="fa fa-spin fa-spinner"></i> Carregando páginas...</san>');
							
						}
					});
					
						
				} else {

					
					$('.url-tipo').find('select').remove();
					$('.url-tipo').append('<input class="input_text url-botao" type="text" placeholder=""/>');

					$('.ajax_montagem .nome-botao').val(nomeBotao);
						
				}
					
			}

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var botao = $(edit).find('.bt');
				var option = $('.option').val();

				var cor = $('#cor').attr('data-cor');

				var radius = $('#radius').val();
				var urlBotao = $('.url-botao').val();
				var nomePage = $('.url-botao option:selected').text();
				var nomeBotao = $('.nome-botao').val();

				$(botao).attr('data-radius', radius);
				$(botao).attr('data-href', urlBotao);
				$(botao).attr('data-tipo', option);
				$(botao).attr('href','javascript:urlBotao(\''+urlBotao+'\', \''+option+'\', \''+nomePage+'\');');
				$(botao).html(nomeBotao);
				$(botao).attr('id',cor);
				$(botao).css('borderRadius',radius+'px');
				
			}

		</script>
		
		<div id="cor">
			<script>coresTemplate('<?php echo $this->post['id'];?>', 'form');</script>
		</div>
	
		<form action="javascript:aplicar();">
		
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Tipo de link"); ?>
				
				</span>
				<div class="input_ico"><i class="fa fa-link" aria-hidden="true"></i></div>
				<select class="option input_text" onchange="tipoUrl(this);">
					<option><?php echo $this->lg->_("Externo"); ?></option>
					<option><?php echo $this->lg->_("Interno"); ?></option>
				</select>
			</div>
		
			<div class="input-label url-tipo">
				<span>
				
					URL
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Inclua aqui a URL para qual você deseja que o usuário seja direcionado ao clicar no botão."); ?>"></i>
				
				</span>
				<div class="input_ico"><i class="fa fa-link" aria-hidden="true"></i></div>
			</div>
			
			<div class="input-label">
				<span><?php echo $this->lg->_("Nome do botão"); ?></span>
				<div class="input_ico"><i class="fa fa-font" aria-hidden="true"></i></div>
				<input class="input_text nome-botao" type="text" placeholder="">
			</div>
			
			<div class="input-label">
				<span><?php echo $this->lg->_("Arredondamento da borda"); ?></span>
				<input type="hidden" id="radius"/>
				<div id="slider"></div>
			</div>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("boleto")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<form data-width="100" method="post" class="boleto" target="_blank" action="<?php echo $this->baseModule;?>/templates/boleto" id="<?php echo $corPadrao; ?>">
		
				<input type="hidden" name="codbarras"/>	
				<input type="hidden" name="codcli"/>	
				<input type="hidden" name="vencimento"/>	
				<input type="hidden" name="saldo"/>	
				<input type="hidden" name="prinome"/>	
				<input type="hidden" name="cpf_mascara"/>	
				
				<input type="submit" value="Gerar boleto"/>
			
			</form>
	
		<?php else: ?>
		
		<?php 
		
			$variaveis = [];
			
			$variaveis[0] = '[nome]';
			$variaveis[1] = '[sobrenome]';
			$variaveis[2] = '[numero]';
			$variaveis[3] = '[celular]';
			$variaveis[4] = '[data_nascimento]';
			$variaveis[5] = '[email]';
			$variaveis[7] = '[cpf]';
			$variaveis[8] = '[empresa]';
			$variaveis[9] = '[cargo]';
			$variaveis[10] = '[telefone_comercial]';
			$variaveis[11] = '[telefone_residencial]';
			$variaveis[12] = '[pais]';
			$variaveis[13] = '[estado]';
			$variaveis[14] = '[cidade]';
			$variaveis[15] = '[bairro]';
			$variaveis[16] = '[endereço]';
			$variaveis[17] = '[cep]';
			
			$a=18;
			for ($i = 1; $i <= 40; $i++) {
			
				$variaveis[$a] = '[editavel_'.$i.']';
				$a++;
				
			}
			
// 			echo '<pre>'; print_r( $variaveis );
		
		?>
		
		<script>

			$(function(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var botao = $(edit).find('.boleto');
				var cor = botao.attr('id');
				var nomeBotao = $(botao).find('input[type="submit"]').val();

				$('#cor').attr('data-cor', cor);
				$('.input-label').attr('id', cor);
				
				$('.nome-botao').val(nomeBotao);

				$(botao).find('input[name="codbarras"]').val(  );

				$('.codbarras').val( $(botao).find('input[name="codbarras"]').val() );
				$('.codcli').val( $(botao).find('input[name="codcli"]').val() );
				$('.vencimento').val( $(botao).find('input[name="vencimento"]').val() );
				$('.saldo').val( $(botao).find('input[name="saldo"]').val() );
				$('.prinome').val( $(botao).find('input[name="prinome"]').val() );
				$('.cpf_mascara').val( $(botao).find('input[name="cpf_mascara"]').val() );

				var width = $(botao).attr('data-width');
				var margem = $(botao).attr('data-margem');
				var widthFinal = width - (margem * 2);

				$('.t-'+width).attr('checked', true);

				$('.tam').checkboxradio();
				
			});

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var botao = $(edit).find('.boleto');
				
				var cor = $('#cor').attr('data-cor');
				var nomeBotao = $('.nome-botao').val();

				$(botao).find('input[name="codbarras"]').val( $('.codbarras').val() );
				$(botao).find('input[name="codcli"]').val( $('.codcli').val() );
				$(botao).find('input[name="vencimento"]').val( $('.vencimento').val() );
				$(botao).find('input[name="saldo"]').val( $('.saldo').val() );
				$(botao).find('input[name="prinome"]').val( $('.prinome').val() );
				$(botao).find('input[name="cpf_mascara"]').val( $('.cpf_mascara').val() );

				$(botao).find('input[type="submit"]').val(nomeBotao);
				$(botao).attr('id',cor);

				var width = $('.tam:checked').val();
				
				$(botao).attr('data-width', width);

				$(edit).parent('.box').css('width', width+'%');
				$(edit).parent('.box').css('width', width+'%');
				
			}

		</script>
		
		<div id="cor">
			<script>coresTemplate('<?php echo $this->post['id'];?>', 'form');</script>
		</div>
	
		<form action="javascript:aplicar();">
		
			<div class="input-label">
			
				<span>
					<?php echo $this->lg->_("Tamanho"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Escolha a largura que deseja."); ?>"></i>
				</span>
				
				<label class="tamanho-coluna" for="radio-1">
					
					<div>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
					</div>
					<div>100%</div>
					
				</label>
			    <input type="radio" class="tam t-100" name="tamanho" id="radio-1" value="100">
			    
			    <label class="tamanho-coluna" for="radio-2">
			    	<div>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>75%</div>
			    </label>
			    <input type="radio" class="tam t-75" name="tamanho" id="radio-2" value="75">
			    
			    <label class="tamanho-coluna" for="radio-3">
			    	<div>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>50%</div>
			    </label>
			    <input type="radio" class="tam t-50" name="tamanho" id="radio-3" value="50">
			    
			    <label class="tamanho-coluna" for="radio-4">
			    	<div>
			    		<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>25%</div>
			    </label>
			    <input type="radio" class="tam t-25" name="tamanho" id="radio-4" value="25">
			    
		    </div>
		
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Nome do botão"); ?></span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				<input type="text" class="nome-botao input_text"/>
				
			</div>
		
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Código de barras"); ?></span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				
				<select class="codbarras input_text">
					<?php foreach ( $variaveis as $row ){?>
					<option><?php echo $row;?></option>
					<?php } ?>
				</select>
				
			</div>
			
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Nosso numero"); ?></span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				
				<select class="codcli input_text">
					<?php foreach ( $variaveis as $row ){?>
					<option><?php echo $row;?></option>
					<?php } ?>
				</select>
				
			</div>
			
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Vencimento"); ?></span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				
				<select class="vencimento input_text">
					<?php foreach ( $variaveis as $row ){?>
					<option><?php echo $row;?></option>
					<?php } ?>
				</select>
				
			</div>
			
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Valor do documento"); ?></span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				
				<select class="saldo input_text">
					<?php foreach ( $variaveis as $row ){?>
					<option><?php echo $row;?></option>
					<?php } ?>
				</select>
				
			</div>
			
			<div class="input-label">
			
				<span><?php echo $this->lg->_("Nome"); ?></span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				
				<select class="prinome input_text">
					<?php foreach ( $variaveis as $row ){?>
					<option><?php echo $row;?></option>
					<?php } ?>
				</select>
				
			</div>
			
			<div class="input-label">
			
				<span>CPF</span>
				
				<div class="input_ico"><i class="fa fa-align-justify" aria-hidden="true"></i></div>
				
				<select class="cpf_mascara input_text">
					<?php foreach ( $variaveis as $row ){?>
					<option><?php echo $row;?></option>
					<?php } ?>
				</select>
				
			</div>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("mapa")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			<a class="a-maps" target="_blank" href="https://maps.google.com/maps?q=Avenida Paulista&output=embed"></a>
			<iframe class="maps" data-endereco="Avenida Paulista" src="https://maps.google.com/maps?q=Avenida Paulista&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
		<?php else: ?>
		
		<script>

			$(function(){
				
				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var mapa = $(edit).find('.maps');

				var endereco = $(mapa).attr('data-endereco');
				
				$('.ajax_montagem .endereco').val(endereco);

			});

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');AXNrnWasnh
				var mapa = $(edit).find('.maps');
				var aMapa = $(edit).find('.a-maps');
				var endereco = $('.endereco').val();
				$(mapa).attr('data-endereco', endereco);
				$(aMapa).attr('href', 'https://maps.google.com/maps?q='+endereco+'&output=embed');
				$(mapa).attr('src', 'https://maps.google.com/maps?q='+endereco+'&output=embed');
				
			}

		</script>
		
		<form action="javascript:aplicar();">
		
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Endereço"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Selecione o endereço que você deseja que apareça no mapa."); ?>"></i>
				
				</span>
				<div class="input_ico"><i class="fa fa-map" aria-hidden="true"></i></div>
				<input class="input_text endereco" type="text" placeholder="">
			</div>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>

    <?php } elseif ($this->post['tipo'] == $this->lg->_("modal")){ ?>

        <?php if ($this->post['acao'] == 'new'): ?>

            <div class="modal-template" opacidade="1">

                <a class="close-modal">[FECHAR]</a>

                <h3>Titulo modal</h3>

                <div class="texto">
                    <p style="text-align: center;">
                        <span style="font-size:12px;">Texto exemplo...</span>
                    </p>
                </div>

            </div>

            <script>

                $('.drag[data-tipo="modal"]').hide(0)

                $(document).on('click', 'div[data-tipo="modal"] .delete', function(){

                    $('.drag[data-tipo="modal"]').show(0)

                })

            </script>

        <?php else: ?>

            <script>

                $(function(){

                    var id = '<?php echo $this->post['id'];?>';
                    var el = $('#'+id)
                    var cor = el.find('.modal-template').attr('id')


                    $('#cor').attr('data-cor', cor)

                    var titulo = el.find('h3').html()
                    var texto = el.find('.texto').html()
                    var opacidade = el.find('.modal-template').attr('opacidade')

                    $('.opacidade-modal').val( opacidade )
                    $('.titulo-modal').val( titulo )
                    $('#ckeditormodal').val( texto )

                    CKEDITOR.replace("ckeditormodal");


                })

                function aplicar()
                {

                    var id = '<?php echo $this->post['id'];?>'
                    var el = $('#'+id)

                    var cor = $('#cor').attr('data-cor')
                    el.find('.modal-template').attr('id', cor)
                    el.find('.modal-template').attr('opacidade', $('.opacidade-modal').val()).css('opacity', $('.opacidade-modal').val())
                    el.find('h3').html(  $('.titulo-modal').val() )
                    el.find('.texto').html(  $('#ckeditormodal').val() )

                }

            </script>

            <div id="cor">
                <script>coresTemplate('<?php echo $this->post['id'];?>', '.input-label');</script>
            </div>

            <form action="javascript:aplicar();">

                <div class="input-label">
                    <span><?php echo $this->lg->_("Opacidade"); ?></span>
                    <div class="input_ico"><i class="fa fa-font" aria-hidden="true"></i></div>
                    <select class="input_text opacidade-modal">
                        <?php for ($i = 1; $i <= 10; $i++) {?>
                        <option value="<?php echo $i/10;?>"><?php echo $i;?>0%</option>
                        <?php } ?>
                    </select>
                </div>

                <div class="input-label">
                    <span><?php echo $this->lg->_("Titulo"); ?></span>
                    <div class="input_ico"><i class="fa fa-font" aria-hidden="true"></i></div>
                    <input class="input_text titulo-modal" type="text" placeholder="">
                </div>

                <div class="input-label">
                    <textarea id="ckeditormodal"></textarea>
                </div>

                <input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />

            </form>

        <?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == $this->lg->_("video")){ ?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
			<iframe class="video" data-video="https://www.youtube.com/watch?v=KPND6SgkN7Q" src="https://www.youtube.com/embed/KPND6SgkN7Q" frameborder="0" allowfullscreen></iframe>
			
		<?php else: ?>
		
		<script>

			$(function(){
				
				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var video = $(edit).find('.video');

				var url = $(video).attr('data-video');
				
				$('.video-url').val(url);

			});

			function aplicar(){

				var id = '<?php echo $this->post['id'];?>';
				var edit = $('#'+id+' div.edit');
				var video = $(edit).find('.video');

				var videoO = $('.video-url').val();
				var videoE = videoO.split('?v=');

				$(video).attr('data-video', videoO);
				$(video).attr('src', 'https://www.youtube.com/embed/'+videoE[1]);
				
			}

		</script>
		
		<form action="javascript:aplicar();">
		
			<div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Vídeo (Youtube)"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Adicione aqui a URL (Youtube) do vídeo desejado."); ?>"></i>
					
				</span>
				<div class="input_ico"><i class="fa fa-youtube" aria-hidden="true"></i></div>
				<input class="input_text video-url" type="text" placeholder="">
			</div>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
		
		</form>

		<?php endif; ?>
	
	<?php } elseif ( $this->post['tipo'] == 'instagram-funcao' || $this->post['tipo'] == 'facebook-funcao' || $this->post['tipo'] == 'telefone-funcao' || $this->post['tipo'] == 'email-funcao' || $this->post['tipo'] == 'sms-funcao' || $this->post['tipo'] == 'whatsapp-funcao' || $this->post['tipo'] == 'download-funcao' || $this->post['tipo'] == 'video-funcao' || $this->post['tipo'] == 'localizacao-funcao'){ ?>
		
		<?php 
			
				$icone = array('instagram-funcao'=>'instagram', 'facebook-funcao'=>'facebook', 'telefone-funcao'=>'phone','email-funcao'=>'envelope-o','sms-funcao'=>'comments','whatsapp-funcao'=>'whatsapp','download-funcao'=>'download','video-funcao'=>'youtube','localizacao-funcao'=>'map');
				$tipo = array('instagram-funcao'=>'Instagram', 'facebook-funcao'=>'Facebook','telefone-funcao'=>'Telefone','email-funcao'=>'E-mail','sms-funcao'=>'SMS','whatsapp-funcao'=>'WhatsApp','download-funcao'=>'Download','video-funcao'=>'Video','localizacao-funcao'=>'Localização');
			
			?>
		
		<?php if ($this->post['acao'] == 'new'): ?>
		
			<a data-width="100" data-margem="0" class="ico-funcao" id="<?php echo $corPadrao; ?>">
			
				<i class="fa fa-<?php echo $icone[$this->post['tipo']];?>"></i>
				<span><?php echo $tipo[$this->post['tipo']];?></span>
			
			</a>
			
		<?php else: ?>
		
		<script>

		$(function(){

		    // LEITURA
			var id = '<?php echo $this->post['id'];?>';
			var edit = $('#'+id);
			var funcao = edit.find('.ico-funcao');

			var msg = edit.attr('data-msg')
			var nome = edit.find('.ico-funcao span').html();
			var link = edit.find('.ico-funcao').attr('data-link');

			$('.ajax_montagem .funcao').val(link);
			$('.ajax_montagem .nome').val(nome);
			$('.ajax_montagem .msg').val(msg);

			var cor = funcao.attr('id');
			$('#cor').attr('data-cor', cor);
			$('.input-label').attr('id', cor);

			var width = $(funcao).attr('data-width');
			var margem = $(funcao).attr('data-margem');
			var widthFinal = width - (margem * 2);

			$('.t-'+width).attr('checked', true);

			$('.tam').checkboxradio();

		});

		function aplicar()
		{

			var id = '<?php echo $this->post['id'];?>';
			var edit = $('#'+id);
			var tipo_edicao = edit.attr('data-tipo');

			var width = $('.tam:checked').val();
			var link = $('.ajax_montagem .funcao').val();
			var msg = $('.ajax_montagem .msg').val();
			var nome = $('.ajax_montagem .nome').val();

			edit.attr('data-msg', msg)
			
			edit.find('.ico-funcao span').html(nome);
			edit.find('.ico-funcao').attr('data-link', link);

			$(edit).find('.ico-funcao').attr('data-width', width);

			$(edit).css('width', width+'%');
			$(edit).css('width', width+'%');

			var cor = $('#cor').attr('data-cor');
			$(edit).find('.ico-funcao').attr('id', cor);

			edit.find('a.ico-funcao').attr('onclick', "javascript:urlBotao('"+link+"', '"+nome+"', 'funcao-click');");
			
			if (tipo_edicao == 'email-funcao'){
				edit.find('.ico-funcao').attr('target', '');
				edit.find('.ico-funcao').attr('href', 'mailto:'+link);
			} else if (tipo_edicao == 'telefone-funcao'){
				edit.find('.ico-funcao').attr('target', '');
				edit.find('.ico-funcao').attr('href', 'tel:'+link);
			} else if (tipo_edicao == 'sms-funcao'){
				edit.find('.ico-funcao').attr('target', '');
				edit.find('.ico-funcao').attr('href', 'sms:'+link);
			} else if (tipo_edicao == 'whatsapp-funcao'){
				edit.find('.ico-funcao').attr('target', '');
				edit.find('.ico-funcao').attr('href', 'https://api.whatsapp.com/send?phone='+link+'&text='+msg);
			} else if (tipo_edicao == 'localizacao-funcao'){
				edit.find('.ico-funcao').attr('target', '_blank');
				edit.find('.ico-funcao').attr('href', 'http://maps.google.com/maps?q='+link+'&output=embed');
			} else {
				edit.find('.ico-funcao').attr('target', '_blank');
				edit.find('.ico-funcao').attr('href', link);
			}
			
		}

		</script>
		
		<form action="javascript:aplicar();">
		
			<div id="cor">
				<script>coresTemplate('<?php echo $this->post['id'];?>', '.input-label');</script>
			</div>
			
			<div class="input-label">
			
				<span>
					<?php echo $this->lg->_("Tamanho"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $this->lg->_("Escolha a largura que deseja."); ?>"></i>
				</span>
				
				<label class="tamanho-coluna" for="radio-1">
					
					<div>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
						<i class="fa fa-square" aria-hidden="true"></i>
					</div>
					<div>100%</div>
					
				</label>
			    <input type="radio" class="tam t-100" name="tamanho" id="radio-1" value="100">
			    
			    <label class="tamanho-coluna" for="radio-2">
			    	<div>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>75%</div>
			    </label>
			    <input type="radio" class="tam t-75" name="tamanho" id="radio-2" value="75">
			    
			    <label class="tamanho-coluna" for="radio-3">
			    	<div>
				    	<i class="fa fa-square" aria-hidden="true"></i>
				    	<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>50%</div>
			    </label>
			    <input type="radio" class="tam t-50" name="tamanho" id="radio-3" value="50">
			    
			    <label class="tamanho-coluna" for="radio-4">
			    	<div>
			    		<i class="fa fa-square" aria-hidden="true"></i>
			    	</div>
			    	<div>25%</div>
			    </label>
			    <input type="radio" class="tam t-25" name="tamanho" id="radio-4" value="25">
			    
		    </div>
		    
		    <?php 
		    
		    	if ($tipo[$this->post['tipo']] == 'Mapa'){
		    		$placeholder = 'Endereço';
		    	} elseif ($tipo[$this->post['tipo']] == 'Video'){
		    		$placeholder = 'URL do youtube';
		    	} else {
		    		$placeholder = $tipo[$this->post['tipo']];
		    	}
		    
		    ?>
		    
		    
		    <?php 
		    
			    if ( $this->post['tipo'] == 'facebook-funcao' || $this->post['tipo'] == 'instagram-funcao' ){ 
			    
			    	$nome = 'Adicione aqui o nome que aparecerá abaixo do botão. Pode ser o nome da página a ser divulgada, por exemplo.';
			    	$funcao = 'Adicione a URL da página desejada.';
			    	
			    } elseif ( $this->post['tipo'] == 'telefone-funcao' ){
			    	
			    	$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
			    	$funcao = 'Adicione o número de telefone desejado.';
			    	
		    	} elseif ( $this->post['tipo'] == 'email-funcao' ){
		    		
		    		$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
		    		$funcao = 'Adicione o endereço de e-mail desejado.';
		    		
		    	} elseif ( $this->post['tipo'] == 'sms-funcao' ){
		    		
		    		$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
		    		$funcao = 'Adicione o número de telefone desejado, lembre-se de colocar 55 se você estiver no Brasil.';
		    		
		    	} elseif ( $this->post['tipo'] == 'whatsapp-funcao' ){
		    		
		    		$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
		    		$funcao = 'Adicione o número de telefone desejado, lembre-se de colocar 55 se você estiver no Brasil.';
		    		
	    		} elseif ( $this->post['tipo'] == 'download-funcao' ){
	    			
	    			$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
	    			$funcao = 'Adicione a URL para o download.';
	    			
    			} elseif ( $this->post['tipo'] == 'video-funcao' ){
    				
    				$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
    				$funcao = 'Adicione a URL do vídeo.';
    				
    			} elseif ( $this->post['tipo'] == 'localizacao-funcao' ){
    				
    				$nome = 'Adicione aqui o nome que aparecerá abaixo do botão.';
    				$funcao = 'Adicione o endereço desejado.';
    				
    			}
			    
		    ?>
		    
		    <div class="input-label">
				<span>
				
					<?php echo $this->lg->_("Nome da função"); ?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $nome;?>"></i>
					
				</span>
				
				<input class="input_text nome" type="text" placeholder="<?php echo $this->lg->_("Nome da função..."); ?>">
			</div>
			
			<div class="input-label">
				<span>
				
					<?php echo $placeholder;?>
					<i class="fa fa-question-circle question tooltip" title="<?php echo $funcao;?>"></i>
				
				</span>
				<input class="input_text funcao" type="text" placeholder="<?php echo $placeholder;?>">
			</div>
			
			<?php if ( $this->post['tipo'] == 'whatsapp-funcao' ){?>
			<div class="input-label">
				<span>
					Mensagem
				</span>
				<input class="input_text msg" type="text" placeholder="Olá Fulano, tenho interess...">
			</div>
			<?php } ?>
			
			<input type="submit" style="float:right; margin-top:8px;" class="input_bt_azul cor_b_hover" value="<?php echo $this->lg->_("Aplicar alterações"); ?>" />
			
			
		</form>

		<?php endif; ?>
	
	<?php } elseif ( $this->post['tipo'] == 'compartilhar-funcao' ){ ?>
		
		
		<?php if ($this->post['acao'] == 'new'): ?>
			
            <div class="addthis_inline_share_toolbox"></div>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d8d00ef7f3f12fd"></script>
			
			<script>
			$(function(){

    	        $('.box[data-tipo="compartilhar-funcao"]').find('.funcoes .edit').remove();
    	        $('.box[data-tipo="compartilhar-funcao"]').find('.funcoes .delete').attr('style','width:100%;');

			});
			</script>
			
		<?php endif; ?>
	
	<?php } elseif ($this->post['tipo'] == 'paginas'){ ?>

	<script>

		paginasGeral();
		
		function newPag(id){

			var nome = $('.pagename').val();
			var ordem = $('.ordempage').val();
			console.log(id);
			$.ajax({
				url: '<?php echo $this->baseModule;?>/campanha/paginas-landing?novo=sim',
				type: 'POST',
				data: {id: id, nome: nome},
				success: function(row){

					console.log(row);
					
					$('.new-page').html('Adicionar página');
					paginasGeral();
					
				}, beforeSend: function(){
					$('.new-page').html('<i class="fa fa-spin fa-spinner"></i>');
				}
				
			});
			
		}

		function paginasGeral(){

			$('.opcoes').html('<center><i class="fa fa-cog fa-spin"></i></center>');
			
			$.ajax({
				url: '<?php echo $this->baseModule;?>/templates/paginas-landing',
				type: 'POST',
				data: {id: '<?php echo $this->post['id']; ?>'},
				dataType: 'JSON',
				success: function(row){
	
					$('.opcoes').html('');

					var pagInicial = '<div class="off" data-delete="false">';
						pagInicial += '<span style="padding:5px 0px; display:inline-block;">Página principal</span>';
						pagInicial += '<button onclick="location.href=\'/<?php echo $this->baseModule;?>/templates/criacao/id/<?php echo $this->post['id'];?>\';" title="Visualizar/Editar página" type="button"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></button>';
						pagInicial += '</div>';
					
					$('.opcoes').append(pagInicial);
					
					for(var i in row) {
						
						var op  = '';
							op += '<div id="'+row[i].id_pagina+'" data-delete="false">';
							op += '<span style="padding:5px 0px; display:inline-block;" contenteditable="true">'+row[i].nome+'</span>';
							op += '<button onclick="location.href=\'/<?php echo $this->baseModule;?>/templates/criacao/id/<?php echo $this->post['id'];?>/id_pagina/'+row[i].ordem+'\';" title="Visualizar/Editar página" type="button"><i class="fa fa-mouse-pointer" aria-hidden="true"></i></button>';
							op += '<button onclick="removerPag(this);" title="Remover página" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>';
							op += '<a title="Alterar ordem das páginas" class="move""><i class="fa fa-arrows" aria-hidden="true"></i></a>';
							op += '</div>';
						$('.opcoes').append(op);
	
						ordemPaginas();
	
						$(".opcoes").sortable({
							handle: ".move",
							items: "div:not(.off)",
							stop: function(event, ui){
								ordemPaginas();
							}
						});
	
					}
					
				}
			});
		}

		function ordemPaginas(){

			var i = 0;
			$('.opcoes > div').each(function(){

				if (i != 0){
					$(this).attr('data-ordem',i);
				}
								
				i++;
				
			});

		}

		function aplicaOrdem(){

			$(function(){

				$('.opcoes').addClass('ui-state-disabled');
				
				var i = 0;
				$('.opcoes > div').each(function(){
	
					if (i != 0){
	
						var nome = $(this).find('span').html();
						var ordem = $(this).data('ordem');
						var id_pagina = $(this).attr('id');
						var del = $(this).attr('data-delete');
						
						$.ajax({
							url: '<?php echo $this->baseModule;?>/campanha/editar-pagina',
							type: 'POST',
							data: {del:del, nome:nome, id_pagina:id_pagina, ordem:ordem, id_lading_page: '<?php echo $this->post['id'];?>'},
							success: function(row){
								paginasGeral();
								$('.opcoes').removeClass('ui-state-disabled');
								$('.app-pag').html('Salvar alterações');
							}, beforeSend: function(){
								$('.app-pag').html('<i class="fa fa-spinner fa-spin"></i>');
							}
						});
	
					}
	
					i++;

				});


			});
			
		}

		function removerPag(bt){

			var del = $(bt).parent().attr('data-delete');

			if (del == 'true'){
				$(bt).parent().attr('data-delete','false');
				$(bt).parent().removeClass('del');
				$(bt).find('i').removeClass('fa-undo').addClass('fa-times');
			} else {
				$(bt).parent().attr('data-delete','true');
				$(bt).parent().addClass('del');
				$(bt).find('i').addClass('fa-undo').removeClass('fa-times');
			}

		}

	</script>

	<form class="aplica-edicao" action="javascript:aplicaOrdem();">
		
		<label class="pergunta">
			
			<span><?php echo $this->lg->_("Nome da página"); ?></span>
			
			<input type="text" class="pagename" placeholder="<?php echo $this->lg->_("Nome da página."); ?>">
		</label>
		<a onclick="newPag('<?php echo $this->post['id'];?>');" class="new-page cor_b_hover"><?php echo $this->lg->_("Adicionar página"); ?></a>
		
		<div class="opcoes"></div>
		
		<div class="box-edicao">
			<button type="submit" class="app-pag cor_b_hover"><?php echo $this->lg->_("Salvar alterações"); ?></button>
		</div>
		
	</form>
	
	<?php } ?>
	
	<?php if ($this->post['acao'] == 'new'){ echo $footerBox; } ?>

<?php } ?>