$(function(){


	$('form').on('submit', function () {

		$(this).hide(0)
		$(this).after('<h4 style="text-align: center;">Enviando, aguarde por favor.</h4>')

	})

    $('.edit[data-copy="true"]').click(function(){
        
        var texto = $(this).find('.texto span span').text()
        $(this).append('<input type="text" name="copy" value="'+texto+'"/>')
        
        var $input = $(this).find('input[name="copy"]')
        
        if (navigator.userAgent.match(/ipad|ipod|iphone/i)) {
		  var el = $input.get(0);
		  var editable = el.contentEditable;
		  var readOnly = el.readOnly;
		  el.contentEditable = true;
		  el.readOnly = false;
		  var range = document.createRange();
		  range.selectNodeContents(el);
		  var sel = window.getSelection();
		  sel.removeAllRanges();
		  sel.addRange(range);
		  el.setSelectionRange(0, 999999);
		  el.contentEditable = editable;
		  el.readOnly = readOnly;
		} else {
		  $input.select();
		}
        
        if(document.execCommand('copy')){
            alert('Copiado para area de transferencia.')
        }else {
            alert('Erro ao copiar, seu navegador pode não ter suporte a essa função.¹')
        }
        
        $(this).find('input[name="copy"]').remove()
        return false;
        
    });
});
	

start_cron();
ativa_slide();

function start_cron(){

	$(function(){
			
		$('.relogio').each(function(){
		
			var ano = $(this).data('ano');
			var mes = $(this).data('mes');
			var dia = $(this).data('dia');
			var hora = $(this).data('hora');
			var minuto = $(this).data('minuto');
			var segundo = $(this).data('segundo');
			var texto = $(this).data('texto');
			$(this).countdown(''+ano+'/'+mes+'/'+dia+' '+hora+':'+minuto+':'+segundo+'', function(event) {
				$(this).html(event.strftime('<span>'+texto+'</span> <b>%D dias %H:%M:%S</b>'));
			});
						
		});
	
	});
			
}

function refaz_slide(){
	
	$(function(){
		
		$('.slide').each(function(){
	
			var time = $(this).data('time');
			var slide  = '<div class="slide" data-time="'+time+'">';
			
			$(this).find('a').each(function(){
				
				if (!$(this).parent().hasClass('cloned')){
					var img = $(this).find('img').attr('src');
					var href = $(this).attr('href');
					slide += '<a href="'+href+'"><img src="'+img+'"/></a>';
				}
				
			});
			
			slide += '</div>';
			$(this).before(slide);
			$(this).remove();
			
		});
	
	});
	
}

function ativa_slide(){
	
	$(function(){
		
		$('.slide').each(function(){
			
			var time = $(this).data('time');
			var timeFinal = time+'000';
				timeFinal = parseFloat(timeFinal);
			
			setTimeout(function(){
			
				$('.slide').owlCarousel({
				    nav:true,
				    autoplay: true,
				    autoplayHoverPause:true,
				    autoplayTimeout: timeFinal,
				    loop: true,
				    responsive:{
				        0:{
				            items:1
				        },
				        600:{
				            items:1
				        },
				        1000:{
				            items:1
				        }
				    }
				});
			
			},100);
		
		});
		
	});
	
}

$( function (){
	
	$('div[data-tipo="formulario"]').each( function (){
		
		var id = $(this).attr('id');
		$(this).find('form').append('<input type="hidden" name="id_form" value="'+id+'"/>');
		
	});
	
});