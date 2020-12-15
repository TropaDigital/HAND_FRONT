	var module;

	function Modulo(){
	
		module = $('body').attr('data-module');
		
	}
	
	Modulo();
	
	function relatorioCampanha( id_campanha ) {
	
		$.ajax({
	
			url: module+'/campanha/relatorio',
			type: 'GET',
			data: { id:id_campanha },
			success: function( row ){
	
				$('.load').remove();
				$('body').append(row);
	
			}, beforeSend: function(){
				
				$('body').append('<div class="load"><i class="fa fa-cog fa-spin"></i> Carregando os dados da campanha.</div>');
				
			}
	
		});
	
	}
	
	function loadPage(status){
    	
    	if (status == 'true'){
    		
    		var loadhtml  = '<div class="bg-load animated fadeIn">';
    			loadhtml += '<div class="aviao animated bounceInDown">';
    			loadhtml += '<i class="fa fa-paper-plane"></i>';
    			loadhtml += '<div class="aviao-active">';
    			loadhtml += '<i class="fa fa-paper-plane cor_font_a"></i>';
    			loadhtml += '</div>';
    			loadhtml += '</div>';
    			loadhtml += '<div class="titulo animated zoomIn">';
    			loadhtml += 'Carregando';
    			loadhtml += '</div>';
    		
    		$(function(){
    			
    			$('body').append(loadhtml);
    			
    		});
    		
    			
    	} else {
    		
    		$(function(){
    			
    			$('.bg-load').removeClass('fadeIn').addClass('fadeOut');
    			
    			setTimeout(function(){
    				
    				$('.bg-load').remove();
    				
    			},1000);
    			
    		});
    		
    	}
    	
    }
    
	function download(paginaUrl){
		
		if($('.load').length == 0){
			$('body').append('<div class="load"><i class="fa fa-cog fa-spin"></i> Carregando o download, isso pode demorar alguns minutos.</div>');
		}
		
		console.log(paginaUrl);
		
		$.ajax({
			url: paginaUrl,
			type: 'GET',
			dataType: 'JSON',
			success: function(row){
				
				if (row.total_page >= row.pagina){
					var newpage = paginaUrl+'&p='+row.next+'&arquivo='+row.arquivo;
					download(newpage);
					console.log(newpage);
				} else {
					location.href=row.arquivo;
					$('.load').remove();
				}
				
				
			}
		});
		
	}

	function preview(id){
		
		console.log('/'+module+'/index/preview/id/'+id);
		
		if (id == 'close'){
			$('.ajax-preview .modal-preview').remove();
		} else {
			$.ajax({
				url: '/'+module+'/index/preview/id/'+id,
				type: 'GET',
				success: function(row){
					$('.ajax-preview').html(row);
				}
			});
		}
		
	}
	
	function duplicar(id){
		$.ajax({
			url: '/'+module+'/templates/duplicar/id/'+id,
			success: function(row){
				console.log(row);
				if(row != 'false'){
					alert('Template duplicado com sucesso.');
					location.href='/'+module+'/templates/criacao/id/'+row;
				} else {
					alert('Erro ao duplicar, tente novamente mais tarde.');
				}
			}, beforeSend: function(){
			}
		});
	}
		
	function modal(id, extra){
		
    	$('#'+id).fadeToggle(200);
    	$('#'+id+' .modal').toggleClass('animated bounceInDown');
    	
		$('.lista_contato_modal').val(extra);
		
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
	
	function sendPausa(tipo, id){

		if (tipo == 'pausa'){
			
			$('.pause-envio').fadeOut(0);
			$('.play-envio').fadeIn(0);
			
			$('#processando').append('<div class="campanha-'+id+'"></div>');
			
		} else {
			
			$('.pause-envio').fadeIn(0);
			$('.play-envio').fadeOut(0);
			
			$('#processando .campanha-'+id).remove();
			
		}
		
		$.ajax({

			url: '/'+module+'/campanha-gerenciamento/send-campanha-pausa',
			type: 'GET',
			data: {id: id, tipo:tipo},
			success: function(row){

				console.log(row);
				
			}

		});

	}
	
	function delCampanha(id){
		
		$.ajax({
			url: '/'+module+'/campanha-gerenciamento/del-campanha',
			type: 'POST',
			data: {id:id},
			success: function(row){
				
				console.log(row);
				if (row == 'true'){
				$('#enviando-'+id).slideUp();
				}
				
				
			}
		});
		
	}
	
	// 
	// LISTA
	listagem_lista();
	select_lista();

	function deletar_lista( id, id_usuario ){
		if( confirm("Você tem certeza que quer remover esta lista? Você irá perder todos os contatos que está nela") ){
			$.ajax({
				url: '/'+module+'/contatos/deleta-lista/id/'+id,
				data: { id_usuario:id_usuario },
				success: function(row){
					console.log(row);
					$('.lista_'+id).fadeOut();
					select_lista();
				}
			});
		}
	}
	
	function novo_lista(){
		var nome_lista = $('.nome_lista').val();
		var refresh = $('.refresh').val();
		$.ajax({
			url: '/'+module+'/contatos/nova-lista',
			type: 'POST',
			dataType: 'JSON',
			data: {nome_lista:nome_lista},
			success: function(row){

				console.log(row);
				$('.load_lista .error.loads').fadeOut(0);

				if (row.error == 'true'){

					if (refresh != 'true'){
						$('.load_lista').append('<div class="error true">Lista salva com sucesso, adicione contatos a ela, clique <span style="cursor:pointer; font-weight:bold;" onclick="modal(\'adicionar-contatos\', \''+row.id+'\'); modal(\'novo-grupo\');">aqui.</span></div>');
						listagem_lista();
						select_lista();
						$('.nome_lista').val('');
						nova_campanha_lista_atualiza();
					} else {
						location.reload();
					}
				} else {
					$('.load_lista').append('<div class="error false">Não foi possivel adicionar essa lista.</div>');
				}
			}, beforeSend: function(){

				console.log('carregando nova lista');
				
				$('.load_lista').append('<div class="error loads">Carregando...</div>');
				$('.load_lista').animate({scrollTop: $('.load_lista').prop("scrollHeight")}, 500);
			}
		});
	}

	function listagem_lista(){
		$.ajax({
			url: '/'+module+'/contatos/listagem-lista',
			success: function(row){
				$('.listagem_lista').html(row);
			}
		});
	}

	function select_lista(){
		$.ajax({
			url: '/'+module+'/contatos/select-lista?class=_modal',
			success: function(row){
				$('.ajax_lista').html(row);
			}
		});
	}


	// CONTATOS
	function novo_contato(){
		var nome_contato = $('.nome_contato').val();
		var sobrenome_contato = $('.sobrenome_contato').val();
		var email_contato = $('.email_contato').val();
		var data_nascimento = $('.data_nascimento').val();
		var celular_contato = $('.celular_contato').val();
		var lista_contato = $('#novocontato .lista_contato_modal').val();
		
		
		if (!lista_contato){
			
			$('.load_contatos').append('<div class="error loads">Carregando...</div>');
			$('.load_contatos').animate({scrollTop: $('.load_contatos').prop("scrollHeight")}, 500);
			$('.load_contatos .error.loads').fadeOut(0);
			$('.load_contatos').append('<div class="error false">Selecione uma lista de contatos antes de adiciona-lo.</div>');
			
		} else {
			
			$.ajax({
				url: '/'+module+'/contatos/novo-contato',
				type: 'POST',
				data: {nome_contato:nome_contato, sobrenome_contato:sobrenome_contato, email_contato:email_contato, data_nascimento:data_nascimento, celular_contato:celular_contato, lista_contato:lista_contato},
				success: function(row){
				
					console.log(row);
					
					$('.load_contatos .error.loads').fadeOut(0);
					if (row == 'true'){
	
						$('.load_contatos').append('<div class="error true">Contato salvo com sucesso.</div>');
	
						$('.nome_contato').val('');
						$('.sobrenome_contato').val('');
						$('.email_contato').val('');
						$('.data_nascimento').val('');
						$('.celular_contato').val('');
						$('#novocontato .lista_contato_modal').val('');
						
					} else {
						$('.load_contatos').append('<div class="error false">Não foi possivel adicionar esse contato.</div>');
					}
				}, beforeSend: function(){
					$('.load_contatos').append('<div class="error loads">Carregando...</div>');
					$('.load_contatos').animate({scrollTop: $('.load_contatos').prop("scrollHeight")}, 500);
				}
			});
			
		}
	}

	function ajax_lista_all(){
		var id = $('.contatos_lista .ajax_lista .lista_contato').val();
		if (id != ''){
			$.ajax({
				url: '/'+module+'/contatos/listagem-contatos/id/'+id,
				success: function(row){
					$('.listagem_contatos').html(row);
				}
			});
		}
	}

	function ajax_lista_all_modal(){
		var id = $('.lista_contato_modal').val();
		
		if (id != ''){
			$.ajax({
				url: '/'+module+'/contatos/listagem-contatos/id/'+id,
				success: function(row){
					$('.listagem_contatos_modal').html(row);
				}
			});
		}
	}

	function deletar_contato(id){
		if( confirm("Você tem certeza que quer remover este contato?") ){
			$.ajax({
				url: '/'+module+'/contatos/deleta-contato/id/'+id,
				success: function(row){
					console.log(row);
					$('.contato_'+id).fadeOut();
				}
			});
		}
	}
	
function calendarioPorPeriodo ( d_i, d_f, max ){
		
		var dataInicio = $(d_i).val();
		
		var time = new Date(dataInicio);
		var outraData = new Date();
		outraData.setDate(time.getDate() + parseFloat(max) );
		
		$( d_f ).datepicker({ 
			
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
		
		$( d_i ).datepicker({
		
			dateFormat: 'yy-mm-dd',
		
			dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		    nextText: 'Prox',
		    prevText: 'Ant',
			
			onSelect: function() {
		
				var dataInicio = $(d_i).val();
				
				var time = new Date(dataInicio);
				var outraData = new Date();
				outraData.setDate(time.getDate() + max);
		
				$( d_f ).datepicker("destroy");
				$( d_f ).datepicker({ 
					
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
		
					console.log( dataInicio );
					
					$(d_f).val('');
		
					console.log(dataInicio.length );
					
					if ( parseFloat(dataInicio.length) > 1 ) {
		
						$( d_f ).removeAttr('disabled');
						$( d_f ).focus();
						
					} else {
		
						$( d_f ).attr('disabled','true');
						
					}
		
				},500 );
				
			}
			
		});
		
	}

	function tooltip(){
		
		$('.tooltip').tooltipster({
			animationDuration: 100,
			multiple: true,
			delay: 0,
		});
		
	}

	tooltip();
	
	$(document).ready(function () {
		
		var users = [];
		$('[data-user]').each( function(index) {
			
			var tr = $(this);
			var id = $(this).data('user');

			if ( !users[id] ){

				users[id] = [];
				
				$.ajax({
					url: module+'/index/get-info-user',
					type: 'GET',
					data: { id:id },
					dataType: 'JSON',
					success: function ( row ) {

						$('tr[data-user="'+id+'"]').find('.user').html('<i class="fa fa-user"></i> '+row.name_user);

						console.log(row);
						
					}
					
				});

			}

		});
		
		// MAD-RIPPLE // (jQ+CSS)
		$(document).on("mousedown", "[data-ripple]", function(e) {
		    
			var $self = $(this);
		    
			if($self.is(".btn-disabled")) {
				return;
			}
			
			if($self.closest("[data-ripple]")) {
				e.stopPropagation();
			}
		    
			var initPos = $self.css("position"),
				offs = $self.offset(),
				x = e.pageX - offs.left,
				y = e.pageY - offs.top,
				dia = Math.min(this.offsetHeight, this.offsetWidth, 100), // start diameter
				$ripple = $('<div/>', {class:"ripple", appendTo:$self});
		    
		    if(!initPos || initPos==="static") {
		      $self.css({position:"relative"});
		    }
		    
		    $('<div/>', {
		    	class : "rippleWave",
		    	css : {
		    		background: $self.data("ripple"),
		    		width: dia,
		    		height: dia,
		    		left: x - (dia/2),
		    		top: y - (dia/2),
		    	},
		    	appendTo : $ripple,
		    	one : {
		    		animationend : function(){
		    			$ripple.remove();
		    		}
		    	}
		    });
		});
		
		$('.submenu-list button').bind('click', function( event ){
			
			$('.submenu-list ul').removeClass('active');
			event.stopPropagation();
			$( this ).parent().find('ul').toggleClass('active');
			$( this ).toggleClass('active');
			
		});
		
		$('.submenu-list ul').bind('click', function(event){
			
			event.stopPropagation();
		
		});
		
		$('body').bind('click', function(event){
			
			$('.submenu-list ul').removeClass('active');
			$('.submenu-list button').removeClass('active');
		
		});
		
		$(document).on('click', 'div#bg-black div#relatorio-campanha .fa-times', function(){
			
			$('.relatorio-campanha-individual').remove();
			
		});
		
		$('.bt-refresh').click(function(){
			$('.refresh').val('true');
		});
    	
		$('.paginacao > a').each(function(){
			
			var pg = $(this).data('page');
			var controller = $('body').data('controller');
			var action = $('body').data('action');
			var module = $('body').data('module');
			
			if (pg){
			
				var url = '';
					url += controller+'/';
				
				if (action){
					url += action+'/';
				}
				
				url += pg;
			
				$(this).attr('href', module+'/'+url);
			}
			
		});
		
    	$('#funcoes_index > li > a').click(function(){
    		
    		if ( $(this).parent().hasClass('ativo') ){
    			
    			$(this).parent().find('.seta').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
    			$(this).parent().find('ul').slideUp();
	    		$(this).parent().removeClass('ativo');
    			
    		} else {
    		
	    		$('#funcoes_index > li').removeClass('ativo');
	    		$('#funcoes_index > li ul').slideUp();
	    		$('#funcoes_index > li .seta').removeClass('fa-angle-up').addClass('fa-angle-down');
	    		
	    		$(this).parent().find('.seta').toggleClass('fa-angle-up').toggleClass('fa-angle-down');
    			$(this).parent().find('ul').slideDown();
	    		$(this).parent().addClass('ativo');
    		
    		}
    		
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
    			
    			
	    		$(this).attr('id', 'nav_menu_fechado');
	    		$(this).html('<i class="fa fa-angle-double-right"></i>');
	    		
	    		$('.div_content, .div_content_select').animate({'marginLeft':'0px'},500);
	    		$(this).animate({'left':'-2px'},500);
	    		$('#menu_lateral').animate({'marginLeft':'-233px'},500);
	    		
	    		var tamanho_total = $('#site').width();
	    		var tamanho_total_soma = tamanho_total + 233;
	    		$('#site').animate({'width': +tamanho_total_soma+'px'}, 500);
	    		
    		} else {
    			
    			
    			var tamanho_site = $('.drop-drops').width();
    			var tamanho_body = $('body').width();
    			
    			$(this).attr('id', 'nav_menu_aberto');
    			$(this).html('<i class="fa fa-angle-double-left"></i>');
    			
    			
    			$('.div_content, .div_content_select').animate({'marginLeft':'233px'},500);
    			$(this).animate({'left':'233px'},500);
	    		$('#menu_lateral').animate({'marginLeft':'0px'},500);
	    		
	    		var tamanho_total = $('#site').width();
	    		var tamanho_total_soma = tamanho_total - 233;
	    		$('#site').animate({'width': +tamanho_total_soma+'px'}, 500);
	    		
    		}
    	});
    	
    	
//		//create a new WebSocket object.
//		var wsUri = "ws://sistema.naichefm.com.br:1339"; 	
//		websocket = new WebSocket(wsUri); 
//		
//		websocket.onopen = function(ev) { // connection is open 
//			console.log('conectou');
//		}
//
//		websocket.onmessage = function(ev) {
//			
//			var myId = $('body').data('ids');
//			var msg = JSON.parse(ev.data); //PHP sends Json data
//			
//			//console.log(msg);
//			
//			if (msg['id_usuario'] == myId){
//				
//				var pausado = $('#processando > .campanha-'+msg['id_campanha']).length;
//				
//				var box  = '<div class="enviando-campanha" id="enviando-'+msg['id_campanha']+'">';
//					box += '<div class="box-titulo">'+msg['campanha']+' <span class="porce">('+msg['porcentagem']+'%)</span> <span class="minizar">-</span></div>';
//					box += '<div class="geral">';
//					box += '<progress value="'+msg['porcentagem']+'" max="100"></progress>';
//					
//					box += '<div class="pause-send pause-envio" onclick="sendPausa(\'pausa\', \''+msg['id_campanha']+'\');"><i class="fa fa-pause"></i> Pausar envio</div>';
//					box += '<div class="pause-send play-envio" onclick="sendPausa(\'despausa\', \''+msg['id_campanha']+'\');"><i class="fa fa-play"></i> Retornar envio</div>';
//					
//					box += '<div class="pause-send" onclick="delCampanha(\''+msg['id_campanha']+'\');"><i class="fa fa-stop"></i> Encerrar envio</div>';
//					
//					box += '</div>';
//					box += '</div>';
//				
//				var total = $('#enviando-'+msg['id_campanha']).length;
//				
//				if (total == 0){
//					$('#enviando').append(box);
//				} else {
//					 $('#enviando-'+msg['id_campanha']).find('progress').attr('value', msg['porcentagem']);
//					 $('#enviando-'+msg['id_campanha']).find('.porce').html('('+msg['porcentagem']+'%)');
//				}
//				
//				if (pausado == 1){
//					$('.pause-envio').fadeOut(0);
//					$('.play-envio').fadeIn(0);
//				} else {
//					$('.pause-envio').fadeIn(0);
//					$('.play-envio').fadeOut(0);
//				}
//				
//				if (msg['porcentagem'] >= '100'){
//					$('#enviando-'+msg['id_campanha']).find('.box-titulo').prepend('<span class="close">X</span>');
//					$('#enviando-'+msg['id_campanha']).find('.pause-send').remove();
//				}
//				
//				$('.enviando-campanha .box-titulo span.minizar').off().bind('click', function(){
//					
//					$(this).parent().parent().find('.geral').slideToggle();
//					var html = $(this).html();
//					if (html == '-'){
//						$(this).html('+');
//					} else {
//						$(this).html('-');
//					}
//					
//				});
//				
//				$('.enviando-campanha .box-titulo span.close').off().bind('click', function(){
//					
//					$(this).parent().parent().slideUp();
//					
//					setTimeout(function(){
//						$(this).parent().parent().remove();
//					},1000);
//					
//				});
//				
//			}
//				
//
//		};
//		
//		websocket.onerror	= function(ev){
//			
//			console.log('Conexão perdida');
//			
//		}; 
//		websocket.onclose 	= function(ev){
//			
//			console.log('Conexão fechada');
//			
//		}; 
    	
	});
	