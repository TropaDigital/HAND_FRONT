var module;
function plano(id){
	
	module = $('body').data('module');
	
	$.ajax({
		url: '/'+module+'/contas/plano-user/id/'+id,
		type: 'GET',
		dataType: 'JSON',
		success: function(row){
			
			var total = row.length;
			
			var box  = '';
				box += '<div id="modal-saldo" class="bg-black animated fadeIn" style="margin-bottom:200px;">';
				box += '<div class="modal animated zoomIn" style="background:none;">';
				box += '<i class="fa fa-times close-modal cor_b_hover"></i>';
				box += '<table class="table-edicao edit">';
				
			if (total == 0){
					
				box += '<tr class="cor_b">';
				box += '<th colspan="2">Adicionar um plano principal</th>';
				box += '</tr>';
				box += '<tr>';
				box += '<td width="100">Plano</td>';
				box += '<td><a class="bt-plano cor_c_hover" href="javascript:adc_plano(\'principal\', '+id+');">Adicionar plano principal</a></td>';
				box += '</tr>';
					
			} else {
				
				for(var i in row) {
							
					if (row[i].tipo == 'principal'){
								
						box += '<tr class="cor_b">';
						box += '<th colspan="2">Plano principal</th>';
						box += '</tr>';
						box += '<tr>';
						box += '<td width="100">Plano</td>';
						box += '<td>'+row[i].plano+'</td>';
						box += '</tr>';
						box += '<tr>';
						box += '<td>SMS Disponivel</td>';
						box += '<td>'+row[i].sms_disponivel+'</td>';
						box += '</tr>';
								
					}
						
				}
					
				box += '<tr class="cor_b">';
				box += '<th colspan="2">Plano(s) secundário</th>';
				box += '</tr>';
				
				box += '<tr>';
				box += '<td colspan="2"><a style="text-decoration:none; font-weight:bold;" class="bt-plano cor_c_hover" href="javascript:adc_plano(\'secundario\', '+id+');"><i class="fa fa-plus-circle" aria-hidden="true"></i> Adicionar plano secundario</a></td>';
				box += '</tr>';
				
				box += '<tr><th colspan="2" style="padding:2px;"></th></tr>';
						
				for(var i in row) {	
						
					if (row[i].tipo != 'principal'){
							
						box += '<tr class="tr_'+row[i].id_usuario_plano+' cor_b">';
						box += '<td>Plano</td>';
						box += '<td>'+row[i].plano+'</td>';
						box += '</tr>';
						box += '<tr class="tr_'+row[i].id_usuario_plano+'">';
						box += '<td>SMS Disponivel</td>';
						box += '<td>'+row[i].sms_disponivel+'</td>';
						box += '</tr>';
						box += '<tr class="tr_'+row[i].id_usuario_plano+'">';
						box += '<td colspan="2"><a style="text-decoration:none; color:#666; font-weight:bold;" href="javascript:remover_plano('+row[i].id_usuario_plano+');"><i class="fa fa-trash"></i> Remover plano</a></td>';
						box += '</tr>';
						box += '<tr class="tr_'+row[i].id_usuario_plano+'"><th colspan="2" style="padding:2px;"></th></tr>';
					}
					
				}
			
			}
				
			box += '</table>';
			box += '<div class="new-plano"></div>';
			box += '</div>';
			box += '</div>';
				
			$(function(){
				$('body').append(box);
				
				$('.close-modal').click(function(){
					
					$('#modal-saldo').removeClass('fadeIn').addClass('animated fadeOut');
					$('#modal-saldo .modal').removeClass('zoomIn').addClass('animated zoomOut');
						
					setTimeout(function(){
						$('#modal-saldo').remove();
					},500);
					
				});
					
			});
				
			var altura = $('#modal-saldo .modal').height() / 2 + 10;
			$('#modal-saldo .modal').css('top','50%').css('marginTop', '-'+altura+'px');
			
			
		}
	});
	
}

function adc_plano(tipo, id_usuario){
	
	$(function(){
		
		if (tipo == 'principal'){
			$('.new-plano').css('marginTop','-58px');
		}
		
		var alturaModal = $('#modal-saldo .modal').height() - 44;
		$('.new-plano').addClass('animated fadeInDown').animate({'minHeight': alturaModal+'px'},500).css('overflow','inherit');
		$('#modal-saldo .modal').animate({'marginLeft':'-510px','paddingRight':'435px'},500);
	});
	
	$.ajax({
		url: '/'+module+'/contas/planos',
		dataType: 'JSON',
		success: function(row){
			
			$('.planos_geral').html('');
			
			console.log(row);
			
			for(var i in row) {	
				
				$('.planos_geral').append('<option value="'+row[i].id_plano+'">'+row[i].plano+'</option>');
			
			}
		}
	});
	
	var box  = '';
		box += '<table class="table-edicao edit">';
		box += '<tr class="cor_b">';
		box += '<th colspan="2">Adicionar plano</th>';
		box += '</tr>';
		box += '<tr>';
		box += '<td width="200">Plano</td>';
		box += '<td>';
		box += '<select class="planos_geral">';
		box += '<option>Carregando planos</option>';
		box += '</select>';
		box += '</td>';
		box += '</tr>';
		
		box += '</tr>';
		box += '<tr>';
		box += '<td colspan="2">';
		box += '<button class="bt-plano cor_c_hover" onclick="adc_plano_user(\''+tipo+'\', '+id_usuario+');">Concluir</button>';
		box += '</td>';
		box += '</tr>';
		
		box += '</table>';
		
	$('.new-plano').html(box);
	
}

function adc_plano_user(tipo, id_usuario){
	
	console.log('/'+module+'/contas/adc-plano-usuario/');
	
	var id_plano = $('.planos_geral').val();
	
	$.ajax({
		url: '/'+module+'/contas/adc-plano-usuario/',
		type: 'POST',
		data: {tipo:tipo, id_usuario:id_usuario, id_plano:id_plano},
		success: function(row){
			console.log(row);
			if (row == 'true'){
				$('.close-modal').trigger('click');
				plano(id_usuario);
			} else {
				alert('Erro, tente novamente mais tarde.');
			}
		}
	});
	
}

function remover_plano(id){
	
	console.log(id);
	
	$.ajax({
		url: module+'/contas/remover-plano/id/'+id,
		success: function(row){
			
			console.log(module+'/contas/remover-plano/id/'+id);
			console.log(row);
			$('.tr_'+id).addClass('animated zoomOut');
			
			setTimeout(function(){
				$('.tr_'+id).remove();
			},400);
			
		}
	});
}