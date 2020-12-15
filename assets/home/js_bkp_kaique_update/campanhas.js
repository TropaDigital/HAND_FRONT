
	var module;

	function Modulo(){
	
		module = $('body').attr('data-module');
		
	}
	
	Modulo();

	function preview(id){
		
		if (id == 'close'){
			$('.ajax-preview .modal-preview').remove();
		} else {
			$.ajax({
				url: module+'/index/preview/id/'+id,
				type: 'GET',
				success: function(row){
					$('.ajax-preview').html(row);
				}
			});
		}
		
	}
	
	function modal(id){
    	$('#'+id).fadeToggle(200);
    	$('#'+id+' .modal').toggleClass('animated bounceInDown');
    	
    	// VERIFICA SE O MODAL É OS PADRÕES DE CONTATOS/GRUPOS
    	if (id == 'adicionar-contatos' || id == 'novo-grupo'){
    		
    		// LIMPA ERRO DE TRUE/FALSE
    		$('.load_lista, .load_contatos').html('');
    		
    		// SE FOR ADICIONAR CONTATOS ELE LIMPA OS CAMPOS, CASO CONTRARIO ELE LIMPA DOS GRUPOS
    		if (id == 'adicionar-contatos'){
	    		$('.nome_contato').val('');
				$('.sobrenome_contato').val('');
				$('.email_contato').val('');
				$('.data_nascimento').val('');
				$('.celular_contato').val('');
				$('.lista_contato').val('');
    		} else {
    			$('.nome_lista').val('');
    		}
			
    	}
    	
    	
    }

	$(document).ready(function () {
    	
    	$('#funcoes_index > li > a').click(function(){
    		
    		$(this).parent().find('.seta').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
    		$(this).parent().find('ul').slideToggle();
    		$(this).parent().toggleClass('ativo');
    		
    	});
    	
	    $(".data").mask("99/99/9999",{placeholder:"mm/dd/yyyy"});
	    $(".data_hora").mask("99/99/9999 99:99");
	    $(".data_agenda").mask("9999-99-99 99:99");
	    $(".telefone").mask("(99) 9999-9999");
	    $(".celular").mask("99 (99) 99999-9999");
	    $(".cpf").mask("999-999-999-99");
	    $(".horario").mask("99:99");
	    $(".cep").mask("99999-999");
    	
    	$('.nav_menu').click(function(){
    		var status_menu = $(this).attr('id');
    		
    		if (status_menu == 'nav_menu_aberto'){
    			
    			$('#logo').animate({'marginLeft':'-233px'},500);
    			
	    		$(this).attr('id', 'nav_menu_fechado');
	    		$(this).html('<i class="fa fa-angle-double-right"></i>');
	    		
	    		$('.div_content').animate({'marginLeft':'0px'},500);
	    		$(this).animate({'left':'-2px'},500);
	    		$('#menu_lateral').animate({'marginLeft':'-233px'},500);
	    		
	    		var tamanho_total = $('#site').width();
	    		var tamanho_total_soma = tamanho_total + 233;
	    		$('#site').animate({'width': +tamanho_total_soma+'px'}, 500);
	    		
    		} else {
    			
    			$('#logo').animate({'marginLeft':'0px'},500);
    			
    			var tamanho_site = $('.drop-drops').width();
    			var tamanho_body = $('body').width();
    			
    			$(this).attr('id', 'nav_menu_aberto');
    			$(this).html('<i class="fa fa-angle-double-left"></i>');
    			
    			
    			$('.div_content').animate({'marginLeft':'233px'},500);
    			$(this).animate({'left':'233px'},500);
	    		$('#menu_lateral').animate({'marginLeft':'0px'},500);
	    		
	    		var tamanho_total = $('#site').width();
	    		var tamanho_total_soma = tamanho_total - 233;
	    		$('#site').animate({'width': +tamanho_total_soma+'px'}, 500);
	    		
    		}
    	});
    	
    	
    	$('li').hover(function(){
    		$(this).find('.submenu').stop(true, true).slideDown(300);
    	}, function(){
    		$(this).find('.submenu').stop(true, true).slideUp(300);
    	});
    	
    });
   
