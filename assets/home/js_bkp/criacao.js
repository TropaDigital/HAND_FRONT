var module;

function Modulo(){

	module = $('body').attr('data-module');
	
}

Modulo();

dragDrop();

function dragDrop(){
	
	$( function() {
		$('.drop-drag').sortable({
			containment: ".html_pagina",
			connectWith: ".drop-drag",
			stop: function() {
				reordem();
				ColunasFileiras();
				refaz_slide();
				ativa_slide();
			}
		});
		
		$('.drag').draggable({
			handle: ".move",
			connectToSortable: ".drop-drag",
			helper: "clone",
			stop: function() {
				reordem();
				ColunasFileiras();
		    }
		});
		
	});
	
}

function reordem(){
	
	$('.drop-drag .drag').each(function(){
		
		var tipo = $(this).data('tipo');
		var refreshDrop = $(this).data('refreshdrop');
		var acao = 'new';
		var div = $(this);
		
		$.ajax({
			url: '/'+module+'/templates/box',
			type: 'POST',
			data: {tipo: tipo, acao:acao},
			success: function(row){
				
				$(div).after(row);
				$(div).remove();
				
				ColunasFileiras();
				
				if (refreshDrop){
					dragDrop();
				}
				
				refaz_slide();
				ativa_slide();
				
			}, beforeSend: function(){
				
				$(div).removeAttr('data-titulo').removeAttr('data-frase').removeAttr('class').removeAttr('style').removeAttr('data-refreshdrop');
				
				if (tipo){
					$(div).html('<div class="loader"><i class="fa fa-spin fa-cog"></i></div>');
				}
				
			}
		});
		
	});
	
}

function ColunasFileiras(){
	$('.drop-drag .coluna, .drop-drag .fileira').each(function(){
		
		var conteudo = $(this).find('.drop-drag').children().length;
		
		if (conteudo > 0){
			
			if ($(this).hasClass('empty')){
				$(this).removeClass('empty');
			}
			
		} else {
			
			if (!$(this).hasClass('empty')){
				$(this).addClass('empty');
			}

		}
		
	});
}


// EDIÇÃO DAS BOX
function open_edicao(){
	
	var largura = $('.largura_edita').width();
	var largura_site = largura - 304 + 410;
	$('#site').animate({'width': largura_site+'px'},200);
	$('.ajax_montagem, .edicao_box').addClass('ativo');
	$('body').addClass('active-overflow');
	
}
function close_edicao(){
	
	var largura = $('.largura_edita').width();
	var largura_site = largura - 304;
	$('#site').animate({'width': largura_site+'px'},200);
	$('.edicao_box, .ajax_montagem').removeClass('ativo');
	$('body').removeClass('active-overflow');
	
}

function FuncoesPorBox(div){
			
	var acao = $(div).attr('class');
	var infos = $(div).parent().data();
	var name = $(div).parent().parent().data('tipo');
	var id = $(div).parent().parent().attr('id');
		
	if (acao == 'edit'){
		
		open_edicao();
			
		$('.header-edicao').remove();
			
		var titulo  = '<div class="header-edicao">';
			titulo += '<span>Editar '+name+'</span>';
			titulo += '<i onclick="close_edicao();" class="fa fa-times"></i>';
			titulo += '</div>';
		$('.ajax_montagem').before(titulo);
			
		$.ajax({
			url: '/'+module+'/templates/box',
			type: 'POST',
			data: {infos:infos, acao:acao, tipo:name, id:id},
			success: function(row){
					
				$('.box .funcoes > a').off();
				$('.ajax_montagem').html(row);
					
			}, beforeSend: function(){
				
				$('.ajax_montagem').html('<i class="fa fa-cog fa-spin"></i> Carregando...');
					
			}
		});
			
	} else {
		$(div).parent().parent().remove();
		ColunasFileiras();
	}
	
}

// ABRIR GALERIA, EDIÇÃO DE IMG
function abrir_galeria(div){
	
	div_mae = $(div).parent();
	input_open = $(div_mae).find('input[type="text"]').val();
	input_open_input = $(div_mae).find('input[type="text"]');
	input_open_input_total = $(div_mae).find('input[type="text"]').length;
	
	input_galeria = div;
	
	// SELECIONANDO IMAGEM ATUAL
	$('.galeria li').removeClass('ativo');
	$(".galeria li img").each(function(index) {
		var attr_src = $(this).attr('src');
		if (attr_src == input_open){
			$(this).parent().parent().addClass('ativo');
		}
	});
	
	$('.bg_galeria').slideDown(200);
	$('.box_galeria').fadeIn(500);
	
	$('.galeria li .selecionar').click(function(){
		var link = $(this).parent().find('img').attr('src');
		$('.galeria li').removeClass('ativo');
		$(this).parent().addClass('ativo');
		var input_x = $(div_mae).find('input[type="text"]');
		$(input_open_input).val(link);
		
		$(input_x).parent().parent().find('.imagem_atual').attr('src',link);
		$('.bg_galeria').slideUp(200);
		$('.box_galeria').fadeOut(500);
	});
		
}

function paginas(id){
	
	var name = 'paginas';
	open_edicao();
	
	$('.header-edicao').remove();
		
	var titulo  = '<div class="header-edicao">';
		titulo += '<span>Editar '+name+'</span>';
		titulo += '<i onclick="close_edicao();" class="fa fa-times"></i>';
		titulo += '</div>';
	$('.ajax_montagem').before(titulo);
		
	$.ajax({
		url: '/'+module+'/templates/box',
		type: 'POST',
		data: {tipo:name, id:id},
		success: function(row){
			
			console.log('/'+module+'/templates/box');
			console.log(row);
				
			$('.box .funcoes > a').off();
			$('.ajax_montagem').html(row);
				
		}, beforeSend: function(){
			
			$('.ajax_montagem').html('<i class="fa fa-cog fa-spin"></i> Carregando...');
				
		}
	});
	
}

// FUNÇÕES ALTEATÓRIOS DA PÁGINA, SEM SER CRIAÇÃO
$(function(){
	
	$(document).on('click', '.conteudo li .remover', function(){
		
		var txt;
		var r = confirm("Você tem certeza que deseja remover essa imagem? Caso existe em algum template irá sumir.");
		if (r == true) {
		
			var id_upload = $(this).data('id');
			var li = $(this);
			var img = $(this).parent().find('img').attr('src');
			console.log('/'+module+'/templates/excluir-imagem');
			
			$.ajax({
				url: '/'+module+'/templates/excluir-imagem',
				type: 'POST',
				data: {id_upload:id_upload, img:img},
				success: function(row){
					console.log(row);
					$(li).parent().remove();
				}
			});
		    
		}
		
	});
	
	$(document).on('click', '.conteudo li .status', function(){
		
		var id_upload = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		var data = $(this).parent().attr('data-data');
		var li = $(this).parent();
		var liReplace = li.html();
		
		if (status == 'ativo'){
			liReplace = liReplace.replace('Restaurar imagem', 'Mover para lixeira');
			liReplace = liReplace.replace('ativo', 'inativo');
		} else {
			liReplace = liReplace.replace('Mover para lixeira', 'Restaurar imagem');
			liReplace = liReplace.replace('inativo', 'ativo');
		}
			
		var contLi = '<li data-data="'+data+'">'+liReplace+'</li>';
			
		$.ajax({
			url: '/'+module+'/templates/status-imagem',
			type: 'POST',
			data: {id_upload:id_upload, status:status},
			success: function(row){
				
				$(li).remove();
				
				if (status == 'ativo'){
					
					$('.conteudo.galeria').append(contLi);
					$('.conteudo.galeria').find('.remover').before('<a class="selecionar"><i class="fa fa-picture-o" aria-hidden="true"></i> Selecionar imagem</a>');
					$('.conteudo.galeria').find('.remover').remove();
					
				} else {
					
					$('.conteudo.lixeira').append(contLi);
					$('.conteudo.lixeira').find('.selecionar').before('<a class="remover" data-id="'+id_upload+'"><i class="fa fa-trash"></i> Remover imagem</a>');
					$('.conteudo.lixeira').find('.selecionar').remove();
					
				}
				
			}
		});
		
	});
	
	$('.sfuncoes-ico').click(function(){
		$('.sconteudo').slideUp(500);
		$('.sfuncoes').slideDown(500);
		$('.sfuncoes-ico i').removeClass('fa-angle-double-up');
		$('.sfuncoes-ico i').addClass('fa-angle-double-down');
		$('.sconteudo-ico i').removeClass('fa-angle-double-down');
		$('.sconteudo-ico i').addClass('fa-angle-double-up');
	});
	$('.sconteudo-ico').click(function(){
		$('.sconteudo').slideDown(500);
		$('.sfuncoes').slideUp(500);
		$('.sfuncoes-ico i').addClass('fa-angle-double-up');
		$('.sfuncoes-ico i').removeClass('fa-angle-double-down');
		$('.sconteudo-ico i').addClass('fa-angle-double-down');
		$('.sconteudo-ico i').removeClass('fa-angle-double-up');
	});

	$('.fechar_box_edicao').click(function(){
		$('.bg_galeria').slideUp();
	});
	
		$(".celular-scroll").mCustomScrollbar({
			theme:"minimal-dark",
		});
		$(".edicao_box").mCustomScrollbar({
			theme:"minimal-dark"
		});
	
	$('.pre_visualizar').click(function(){
		
		var boxCelular = '<div class="bg-black">';
		boxCelular += '<i class="fa fa-times"></i>';
		boxCelular += '<div class="box-center">';
		boxCelular += '<div class="box-celular preview-cel">';
		boxCelular += '<div class="celular-scroll">';
			
		boxCelular += '<i class="fa fa-spin fa-cog"></i> Carregando...';
			
		boxCelular += '</div>';
		boxCelular += '</div>';
		boxCelular += '</div>';
		boxCelular += '</div>';
			
		$('body').append(boxCelular);
		$('.bg-black .box').addClass('remove-shadow');
		refaz_slide();
		ativa_slide();
		
		$('.bg-black .form-geral label').each(function(){

			var classes = $(this).attr('class');
			var classePrimaria = classes.split(' ');
			$(this).removeClass();
			$(this).addClass(classePrimaria[0]);
			
		});
		
		$('.bg-black .fa-times').click(function(){
			
			$('.bg-black').remove();
			
		});
		
		$('.celular-scroll').animate({'opacity':'1'},100);
		
		$(".bg-black .celular-scroll").mCustomScrollbar({
			theme:"minimal-dark"
		});
		
		console.log(module+'/templates/preview-save');
		
		var id = $(this).data('id');
		var html_preview = $('.html_pagina').html();
		var html_final_preview = $('.html_final').html();
		
		$.ajax({
			
			url: module+'/templates/preview-save',
			type: 'POST',
			data: {id:id, html_preview:html_preview, html_final_preview:html_final_preview},
			success: function(row){
				
				console.log(row);
				console.log(html_final_preview);
				$('.bg-black .celular-scroll').html('<iframe id="preview-mobile" src="'+module+'/templates/detalhe/id/'+id+'/?prev=true"></iframe>');
				
			}
			
		});
		
	});
	
});
