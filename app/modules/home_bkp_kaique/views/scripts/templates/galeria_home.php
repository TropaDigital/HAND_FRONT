		<script>

		$(function () {
			var form;
			$('#uploadfile').change(function (event) {
				form = new FormData();
				form.append('uploadfile', event.target.files[0]);
			});
			
		
			$('#fazer_upload').click(function(){
				$('#uploadfile').trigger('click');
			});
		
			$('#btnEnviar').click(function () {
				$.ajax({
					url: '/<?php echo $this->baseModule;?>/templates/upload/id/<?php echo $this->id; ?>',
					data: form,
					processData: false,
					//contentType: 'multipart/form-data',
					contentType: false,
					type: 'POST',
					dataType: 'JSON',
					success: function (data) {

						console.log(data);

						if (data.criado != 'false'){

							var liImage  = '<li data-data="'+data.criado+'">';
								liImage += '<figure>';
								liImage += '<img src="'+data.link+'"/>';
								liImage += '<span style="background:url('+data.link+'); background-size:cover;"></span>';
								liImage += '</figure>';
								liImage += '<a class="selecionar"><i class="fa fa-picture-o" aria-hidden="true"></i> Selecionar imagem</a>';
								liImage += '<a class="status" data-status="inativo" data-id="30">Mover para lixeira</a>';
								liImage += '</li>';
							
							$('.galeria').append(liImage);
							$('.galeria').animate({scrollTop: $('.galeria').prop("scrollHeight")}, 500);
							$('#btnEnviar').html('ENVIAR&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>');
							change_foto();

						} else {
							
							alert(data.msg);
							$('#btnEnviar').html('ENVIAR&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i>');
							change_foto();

						}

						abrir_galeria(input_galeria);
						
					}, beforeSend: function(){
		
						$('#btnEnviar').html('ENVIANDO <i class="fa fa-spinner fa-spin"></i>');
											
					}
				});
			});

		});

		function enviar_foto(){
			$("#uploadfile").trigger('click');
		}

		function change_foto(){
			var caminho_foto = document.getElementById('uploadfile').value;
			$('#btnEnviar').fadeToggle(0);
			$('.cancel').fadeToggle(0);
			$('.caminho').fadeToggle(0).html(caminho_foto);
			$('.bt_enviar').fadeToggle(0);
		}

		$(function(){
			$('.cancel').click(function(){
				$('#uploadfile').val('');
				change_foto();
			});
			$('.calendar').datepicker({
				dateFormat: 'yy-mm-dd'
			});
		});
		

	</script>

	<div class="bg_edicao bg_galeria">
		<div class="box_edicao box_galeria" style="height:500px; width: 1100px; margin-top:5%;">
			<div class="top cor_a">
				<p id="btnGaleria" class="btnGaleria active" data-aba="galeria"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;&nbsp;Galeria de imagens</p>
				<p id="btnGaleria" class="btnGaleria" data-aba="lixeira"><i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;Lixeira</p>
				
				<form method="post" action="javascript:buscargaleria();">
					<input type="text" class="data_ini calendar" placeholder="Data inicial"/>
					<input type="text" class="data_final calendar" placeholder="Data final"/>
					<input type="submit" class="bt_submit cor_c_hover" value="Buscar"/>
				</form>
				
				<script>
					$('.btnGaleria').click(function(){

						var aba = $(this).data('aba');
						$('.btnGaleria').removeClass('active');
						$(this).addClass('active');
						$('.box_edicao ul.conteudo').hide(0);
						$('.box_edicao ul.conteudo.'+aba).show(0);
						
					});
					function buscargaleria(){
						var data_final = $('.data_final').val();
						var data_ini = $('.data_ini').val();
						$('.conteudo.galeria li').each(function(){
							var data = $(this).data('data');
							if (data >= data_ini && data <= data_final){
								$(this).fadeIn();
							} else {
								$(this).fadeOut();
							}
						});
					}	
				</script>
				
			</div>
			
			<ul class="conteudo galeria">
			
				<?php foreach($this->uploads as $row){?>
					
					<?php if ( file_exists($_SERVER['DOCUMENT_ROOT'].$row->link) ) {?>
					<li data-data="<?php echo $row->data; ?>">
						
						<figure>
							<img src="<?php echo $row->link; ?>"/>
							<span style="background:url(<?php echo $row->link; ?>); background-size:cover;"></span>
						</figure>
					
						<a class="selecionar"><i class="fa fa-picture-o" aria-hidden="true"></i> Selecionar imagem</a>
						<a class="status" data-status="inativo" data-id="<?php echo $row->id_upload;?>">Mover para lixeira</a>
					
					</li>
					<?php } ?>
					
				<?php } ?>
		
			</ul>
			
			<ul class="conteudo lixeira">
			
				<?php foreach($this->uploads_lixeira as $row){?>
					
					<?php if ( file_exists($_SERVER['DOCUMENT_ROOT'].$row->link) ) {?>
					<li data-data="<?php echo $row->data; ?>">
						
						<figure>
							<img src="<?php echo $row->link; ?>"/>
							<span style="background:url(<?php echo $row->link; ?>); background-size:cover;"></span>
						</figure>
					
						<a class="remover" data-id="<?php echo $row->id_upload;?>"><i class="fa fa-trash"></i> Remover imagem</a>
						<a class="status" data-status="ativo" data-id="<?php echo $row->id_upload;?>">Restaurar imagem</a>
					
					</li>
					<?php } ?>
					
				<?php } ?>
		
			</ul>
				
			<div class="funcoes">
				<button type="button" class="bt_red cor_c_hover fechar_box_edicao" style="margin-left:10px">Fechar</button>
				
				<div style="float:right; margin-right:10px;">
					<span style="font-size: 12px;color: #666;padding-right: 5px;vertical-align: top;display: inline-block;">Largura máxima: <b>1200px</b><br/>Formatos: <b>png,jpg,gif,bmp</b></span>
					<button type="button" class="bt_red cor_c_hover bt_enviar" onclick="enviar_foto();"><i class="fa fa-upload"></i>&nbsp;&nbsp;&nbsp;Fazer upload</button>
					
					<button type="button" class="bt_red cor_c_hover cancel" style="display:none; margin-left:5px;"> <i class="fa fa-times"></i> CANCELAR UPLOAD</button>
					<button type="button" class="bt_red cor_c_hover" id="btnEnviar" style="display:none;">ENVIAR&nbsp;&nbsp;&nbsp;<i class="fa fa-angle-right"></i></button>
					
					
					<span class="caminho" style="float: left; display:none; padding: 9px 10px; font-size: 12px; color: rgb(102, 102, 102);"></span>
					
					<input type="file" onchange="change_foto();" style="display:none;" id="uploadfile" name="uploadfile" />
				</div>
				
			</div>
			
		</div>
	</div>