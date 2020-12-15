var module;

function Modulo(){

	module = $('body').attr('data-module');
	
}

Modulo();

$(function(){
			
	$('.funcoes').remove();
	$('input[type="checkbox"]').each(function(){
		
		var name = $(this).attr('name');
		$(this).removeAttr('name');
		$(this).attr('name', name+'[]');
		
	});
	
	$('.bt').bind('click', function(){
		
		var btHtml = $(this).html();
		$(this).attr('data-value', btHtml);
		$(this).html('<i class="fa fa-spin fa-spinner"></i>');
		
	});
	
	var id = $('#landing-page').data('id');
	var celular = $('#landing-page').data('celular');
	var id_campanha = $('#landing-page').data('id_campanha');
	
	var inputsLanding = '';
		inputsLanding += '<input type="hidden" name="id" value="'+id+'">';
		
		if (celular){
			inputsLanding += '<input type="hidden" name="celular" value="'+celular+'">';
		} else {
			inputsLanding += '<input type="hidden" name="celular" value="Teste">';
		}
		
		if (id_campanha){
			inputsLanding += '<input type="hidden" name="id_campanha" value="'+id_campanha+'">';
		} else {
			inputsLanding += '<input type="hidden" name="id_campanha" value="0">';
		}
	
	$('.form-geral').append(inputsLanding);
			
});

function urlBotao(url, tipo, nomePagina){
	
	console.log('url: '+url);
	console.log('tipo: '+tipo);
	console.log('nomePag: '+nomePagina);
	
	$(function(){
		
		var id = $('#landing-page').data('id');
		var shortUrl = $('body').data('shorturl');
		var tituloPag = $('body').data('pag');
		
		console.log('/'+module+'/templates/click');
		
		if (url == 'home'){
			
			$.ajax({
				url: '/'+module+'/templates/click',
				type: 'POST',
				data: {shortUrl:shortUrl, tipo_acao: 'Interno', acao:nomePagina, id_usuario:$('body').attr('data-user')},
				success: function(row){
					
					console.log(row);
					
					location.href='/'+module+'/templates/detalhe/id/'+id+'?short='+shortUrl;
					
					$('.bt').each(function(){
						
						var value = $(this).attr('data-value');
						$(this).html(value);
						
					});
				}
			});
			
		} else {
			
			if (tipo == 'Interno'){
				
				$.ajax({
					url: '/'+module+'/templates/click',
					type: 'POST',
					data: {shortUrl:shortUrl, tipo_acao: 'Interno', acao:nomePagina, id_usuario:$('body').attr('data-user')},
					success: function(row){
						
						location.href='/'+module+'/templates/detalhe/id/'+id+'/id_pagina/'+url+'?short='+shortUrl;
						
						$('.bt').each(function(){
							
							var value = $(this).attr('data-value');
							$(this).html(value);
							
						});
						
					}
				});
				
				
			} else {
				
				console.log('/'+module+'/templates/click');
				
				$.ajax({
					url: '/'+module+'/templates/click',
					type: 'POST',
					data: {shortUrl:shortUrl, tipo_acao: tipo, acao:url, id_usuario:$('body').attr('data-user')},
					success: function(row){
						
						console.log('caiu aqui');
						
						if ( nomePagina != 'funcao-click' || nomePagina != 'funcao-img' ){
							location.href=url;
						}
						
						$('.bt').each(function(){
							
							var value = $(this).attr('data-value');
							$(this).html(value);
							
						});
						
					}
				});
				
			}
		
		}
	
	});
	
}