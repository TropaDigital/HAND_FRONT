		var js_css_atual = 'css';
		function menu_jscss(div){
			
			if (div == 'mn_opacity'){
				
				$('.bg_edicao').toggleClass('off');
				$('.box_edicao').toggleClass('off');
				$('.'+div).toggleClass('ativo');
				
			} else {
				if (div != js_css_atual){
					$('.txt_'+div).fadeIn(0);
					$('.txt_'+js_css_atual).fadeOut(0);
					$('.'+div).addClass('ativo');
					$('.'+js_css_atual).removeClass('ativo');
					js_css_atual = div;
				}
			}
		}
		
		function abrir_edicao_cssjs(tipo){
			$('.bg_cssjs').fadeToggle(200);
			$('.box_cssjs').fadeToggle(1000);
			menu_jscss(tipo);
		}
		
		function atualizar_personalizado(tipo){
		
			var txt_editor = $('.'+tipo+'_editor').val();
			
			$('.'+tipo+'_personalizado').html(txt_editor);
			$('#'+tipo+'_personalizado').html(txt_editor);
			alert('Aplicado com sucesso.');
			
		}

		$(function(){
		
			$('.fechar_box_edicao').click(function(){
				$('.bg_edicao').fadeOut();
				$('.box_edicao').fadeOut();
			});
			
			$(".box_edicao").draggable({});
			
			$(".box_cssjs").resizable({
				maxHeight: 396,
				minHeight: 396,
				minWidth: 325,
				maxWidth: 1100,
			});
		
			
		$('.pagina_final').click(function(){
			$('.pagina_inicial').removeClass('active');
			$('.pagina_final').addClass('active');
			$('.html_final').animate({'marginTop':'0px'},0);
			$('.html_pagina').animate({'marginTop':'-50000px'},0);
		});
		
		$('.pagina_inicial').click(function(){
			$('.pagina_inicial').addClass('active');
			$('.pagina_final').removeClass('active');
			$('.html_final').animate({'marginTop':'-50000px'},0);
			$('.html_pagina').animate({'marginTop':'0px'},0);
		});
	    
			
	    $('.drag_tabela').click(function(){
	    	$('.drop-tabelas').append('<div class="coluna drop-container clearfix ui-sortable ui-sortable-handle" style="width: 655px; height: 50px;"></div>');
	    });
	    
	    function listagem_id(){
	    	
	    	$.ajax({
	    		url: 'templates/time',
	    		success: function(id_contagem){
	    	
			    	// DRAGS COMUM
				    $(".drag_off").each(function(){
				    	
				    	var tipo = $(this).attr('id');
				    	var datatipo = $(this).data('tipo');
				    	
				    	$(this).removeClass();
				    	$(this).addClass('drag drag_off box_montagem_'+id_contagem+' box_ms_'+datatipo);
				    	
				    	$(this).find('.config').attr('onclick', 'editar_box(\''+id_contagem+'\', \''+tipo+'\')');
				    	$(this).find('.excluir').attr('onclick', 'lixeira_box(\''+id_contagem+'\')');
				       
				    	$(this).attr('data-id', id_contagem);
				        
				    });
				    
				    // DRAG DE FILEIRA
				    $(".drag_tabela_off").each(function(){
				    	
				    	var tipo = $(this).attr('id');
				    	
				    	$(this).find('.excluir').attr('onclick', 'lixeira_fileira_box(\''+id_contagem+'\')');
				        $(this).removeClass();
				    	$(this).addClass('fileira drag drag_tabela_off drop-container box_montagem_tabela_'+id_contagem+' drag_tabela_on');
				        $(this).attr('data-id', id_contagem);
				        
				    });
				    
				    // DRAG DE COLUNA
				    $(".drag_coluna_off").each(function(){
				    	
				    	var tipo = $(this).attr('id');
				    	
				    	$(this).find('.config').attr('onclick', 'editar_box(\''+id_contagem+'\', \''+tipo+'\')');
				    	$(this).find('.excluir').attr('onclick', 'lixeira_coluna_box(\''+id_contagem+'\')');
				    	
				    	$(this).removeClass();
				        $(this).addClass('drag drag_coluna_off coluna drop-container coluna_cem box_montagem_coluna_'+id_contagem+'');
				        $(this).attr('data-id', id_contagem);
				        
				    });
				    
		    	}
		    });
		    
	    }
	    
	    listagem_id();
	    
	    $('.drag_tabela_off').draggable({
	        connectToSortable: '.drop-tabelas',
	        helper: 'clone',
	        stop: function()
	        {
	        	draggedOutOfSocket = false;
		        var tipo = $(this).attr('id');
		        $('.drop-tabelas .drag_tabela_off').addClass('drag_tabela_on');
		        $('.drop-tabelas .drag_tabela_on').removeClass('drag_tabela_off');
		        $('.drop-tabelas .drag_tabela_on').attr('style', '');
		        $('.drop-tabelas .drag_tabela_on .adicionado').addClass('conteudo-fileira').removeClass('adicionado');
		        $('.drop-tabelas .drag_tabela_on .adicionar').remove();
		        listagem_id();
		        montagem_js();
	        }
	    });
	    
	    $('.drag_coluna_off').draggable({
	        connectToSortable: '.fileira',
	        helper: 'clone',
	        revert: "invalid",
	        stop: function()
	        {
	        	draggedOutOfSocket = false;
		        
		        $('.drop-container .drag_coluna_off').addClass('drag_coluna_on');
		        $('.drop-container .drag_coluna_on').removeClass('drag_coluna_off');
		        $('.drop-container .drag_coluna_on .adicionar').remove();
		        
		        listagem_id();
		        montagem_js();
	        }
	    });
	    

	    $('.drag_off').draggable({
	        connectToSortable: '.coluna',
	        helper: 'clone',
	        stop: function()
	        {
	        
	           draggedOutOfSocket = false;
	           var tipo = $(this).attr('id');
	           
	           $('.drop-container .drag_off').addClass('drag_on');
	           $('.drop-container .drag_on').removeClass('drag_off');
	           $('.drop-container .drag_on .adicionar').remove();
	           listagem_id();
	           montagem_js();
	           remove_slide();
	           
	        }
	    });
	    
	    $('.drop-tabelas .drop-container').sortable({});
	    $('.drop-tabelas').sortable({});
	    
	    function montagem_js(){
		    $('.drop-tabelas .drop-container').sortable({});
		    $('.drop-tabelas').sortable({});
		}
	    
	});
		
	    
		
		// LIXEIRA 
	    function lixeira_box(id){
	    	var dataidmae = $('.drop-tabelas .box_montagem_'+id).data('id');
		    if( confirm("Você tem certeza que quer remover este objeto?") ){
		    	$('.drop-tabelas .box_montagem_'+id).each(function(){
		    		var dataid = $(this).data('id');
		    		if (dataidmae == dataid){
		    			if (dataid == id){
					    	$(this).remove();
					    	remove_slide();
				    	}
		    		}
		    	});
		    }
	    	
	    }
	    
	    function lixeira_fileira_box(id){
	    	
	    	var dataidmae = $('.drop-tabelas .box_montagem_tabela_'+id).data('id');
		    if( confirm("Você tem certeza que quer remover este objeto?") ){
		    	$('.drop-tabelas .box_montagem_tabela_'+id).each(function(){
		    		var dataid = $(this).data('id');
		    		if (dataidmae == dataid){
		    			if (dataid == id){
		    				$(this).html('').fadeOut(500).addClass('animated zoomOut');
		    				$(this).remove();
					    	remove_slide();
				    	}
		    		}
		    	});
		    }
	    	
	    }
	    
	    function lixeira_coluna_box(id){
	    	
	    	var dataidmae = $('.drop-container .box_montagem_coluna_'+id).data('id');
		    if( confirm("Você tem certeza que quer remover este objeto?") ){
		    	$('.drop-container .box_montagem_coluna_'+id).each(function(){
		    		var dataid = $(this).data('id');
		    		if (dataidmae == dataid){
		    			if (dataid == id){
					    	$(this).html('').fadeOut(500).addClass('animated zoomOut');
					    	$(this).remove();
					    	remove_slide();
				    	}
		    		}
		    	});
		    }
	    	
	    }
	
	    
	    function paginas(id){
	    	var conteudo_atual = $('.ajax_montagem .off').length;
	    	if (conteudo_atual != '1'){
		    	if( confirm("Você tem certeza que quer editar as páginas? Caso não tenha salvo as alterações você pode perder-las.") ){
		    		editar_box(id, 'paginas');
		    	}
	    	} else {
	    		editar_box(id, 'paginas');
	    	}
	    }
	    
	    function open_edicao(){
	    	var largura = $('.largura_edita').width();
			var largura_site = largura - 304 + 410;
			$('#site').animate({'width': largura_site+'px'},200);
			$('.ajax_montagem').addClass('ativo');
	    }
	    
	    function close_edicao(){
	    	var largura = $('.largura_edita').width();
			var largura_site = largura - 304;
			$('#site').animate({'width': largura_site+'px'},200);
			$('.ajax_montagem').removeClass('ativo');
	    }
	    
	    // EDIÇÃO
		function editar_box(id, tipo){
		
			var total_divs = $('.edicao_box').length;
			
			open_edicao();
			
			$.ajax({
				url: '/templates/ajax-edicao-box/id/'+id+'/tipo/'+tipo,
				success: function(result){
					$('.ajax_montagem').html(result);
					$('.bt_fechar').fadeIn(200);
				}, beforeSend: function(){
					$('.ajax_montagem').html('<center><img src="/assets/home/images/icons/load.gif" style="width:50%; margin-top:50px;"></center>');
					$('.bt_fechar').fadeOut(200);
				}
			});
		        
		}
		
		function remove_slide(){
			
			var total = $('.drop-drops .box_ms_slide').length;
			
			if (total > 0){
				$('#funcoes_land .box_ms_slide').fadeOut(0);
			} else {
				$('#funcoes_land .box_ms_slide').fadeIn(0);
			}
			
		}

		$(document).ready(function () {
			remove_slide();
		});
		
		function refaz_slide(funcao){
			
			var div_slide  = '';
				div_slide += '<div class="bx-viewport">';
				div_slide += '<ul class="bxslider">';
				
			var fim_slide  = '';
				fim_slide += '</ul>';
				fim_slide += '</div>';
	
			var img_slide  = '';
	
			var i = 0;
			$(document).ready(function () {
	
				$(".drop-drops .box_ms_slide .input_img_edita").each(function(index) {
	
					i += 1;
					var value = $(this).val();
						img_slide += '<li style="float: left; list-style: none; position: relative;">';
						img_slide += '<div id="limita_tamanho">';
						img_slide += '<img class="img_img'+i+'" src="'+value+'">';
						img_slide += '</div>';
						img_slide += '</li>';
	
				});
			});
	
			var slide_completo = div_slide+''+img_slide+''+fim_slide;
			$('.bx-wrapper').html(slide_completo);
			
			if (funcao == 'edita'){
				$('.bxslider').bxSlider();
			}
			
		}
		
		var input_galeria = '';
		
		var div_mae ='';
		var input_open = '';
		var input_open_input = '';
		var input_open_input_total = '';
		
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
					$(this).parent().addClass('ativo');
				}
			});
			
			$('.bg_galeria').slideDown(200);
			$('.box_galeria').fadeIn(500);
			
			$('.galeria li').click(function(){
				var link = $(this).find('img').attr('src');
				$('.galeria li').removeClass('ativo');
				$(this).addClass('ativo');
				var input_x = $(div_mae).find('input[type="text"]');
				$(input_open_input).val(link);
				
				$(input_x).parent().parent().find('.imagem_atual').attr('src',link);
				$('.bg_galeria').slideUp(200);
				$('.box_galeria').fadeOut(500);
			});
			
		}