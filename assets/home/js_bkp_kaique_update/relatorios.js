	
	// functions visual page
	$('.mostrar_quanto a').bind('click', function(){
	
		$('.paginacao.top-pag').slideToggle();
		
	});
	
	var paginacao_bottom = $('.paginacao.bottom-pag').html();
	$('.paginacao.top-pag').html(paginacao_bottom);
	
	setTimeout(function(){
		
		$('.mostrar_quanto select').select2("destroy");
		
	}, 10);
	
	$(document).on('change', '.mostrar_quanto select', function(){
	
		$('input[name="limit"]').val( $(this).val() );
	
		setTimeout( function () {
	
			$('.filter').submit();
			
		}, 500);
		
	});
	
	$(document).on('change', '.ir_para_pagina', function(){
	
		var p = $(this).val();
		var max = $(this).attr('max');
	
		if ( parseFloat( p ) > parseFloat( max ) ) {
	
			p = max;
	
		}
		
		$('input[name="p"]').val( p );
	
		setTimeout( function () {
	
			$('.filter').submit();
			
		}, 500);
		
	});
	
	// set calendario for class .d_i and .d_f
	calendarioPorPeriodo('.d_i', '.d_f', 60);
	
	// functions for page
	var p = 1;
	var arquivo;
	function downloadPag()
	{
		
		$('.download-page .fa-download').removeClass('fa-download').addClass('fa-spin fa-spinner');
		
		var urlAjax = $('body').data('url-donwload');
		
		console.log( urlAjax )
		
		$.ajax({
			
			url: urlAjax,
			data: { p:p, arquivo:arquivo },
			dataType: 'JSON',
			success: function ( row ) {
				
				console.log( 'success', row )
				
				p = row.next;
				arquivo = row.arquivo;
				
				if ( row.refresh == 1 ){
					
					downloadPag()
					
				} else {
					
					$('.download-page .fa-spinner').removeClass('fa-spin fa-spinner').addClass('fa-download');
					location.href='assets/uploads/csv/'+row.arquivo;
					p = 1;
					arquivo = '';
					
				}
				
			}, error: function( err ){
				
				console.log( 'error', err )
				
			}
			
		});
		
	}