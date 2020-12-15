	var module;

	function Modulo(){
	
		module = $('body').attr('data-module');
		
	}
	
	Modulo();

	function valida()
	{
		
		var aba = $('.opcao-envio.active').data('tipo');
		var id_lista = $('.id_lista').val();
		
		if ( aba == 'lista' ) {
		
			if ( id_lista != null ) {
			
				loadPage('true');
				
				var selected = $('.grupos.id_lista').val();
				var id = selected.join(',');
				
				$.ajax({
					
					url: module+'/campanha/contatos-duplicados',
					type: 'GET',
					data: {id: id},
					dataType: 'JSON',
					success: function(row){
						
						
						if (row.total_registros == 0){
							
							passo('prox');
							
						} else {
							
							popupDuplicados(row.registros);
							
						}
						
						loadPage('false');
						
					}
					
				});
			
			} else {
				
				alert('Selecione uma lista de contatos.');
				
			}
		
		} else {
			
			if ( id_lista == null ) {
				
				alert('Não foi adicionado nenhum contato a essa campanha, adicione antes de avançar.');
				
			} else {
				
				passo('prox');
				
			}
			
			
		}
		
	}
	
	function insereNovoContato( id_lista ) {
		
		var campos = $( '.opcao.avulso input' ).serializeArray();

		var celular = $('section.opcao.avulso.active input[name="celular"]').val();
		
		if ( !celular && $('.celulares span').length == 0 ) {
			
			alert('O campo celular é obrigatório.');
			
		} else {
		
			loadPage('true');
			
			console.log(module+'/campanha/new-lista-avulso?id_lista='+id_lista);
			
			$.ajax({
				
				url: module+'/campanha/new-lista-avulso?id_lista='+id_lista,
				type: 'POST',
				data: { campos },
				dataType: 'JSON',
				success: function( row ) {
	
					console.log( row );
					
					loadPage('false');
					
					if ( row.retorno == 'true' ) {

						$('section.opcao.avulso.active input').val('');
						
						if ( !id_lista ) {
							
							$('.adicionar-contato-avulso').attr('onclick',"javascript:insereNovoContato('"+row.id_lista+"');");
							
	 						$('.id_lista').remove();
							$('.celulares').after('<input type="hidden" name="id_lista" class="id_lista" value="'+row.id_lista+'"/>');
						
						}
						
						$('.celulares').append('<span class="phone" data-lista="'+row.id_lista+'" data-id="'+row.id_contato+'">'+celular+' <i style="cursor:pointer;" class="fa fa-times"></i></span>');
						
						
					} else {
						
						alert( row.msg );
						
					}
					
				}
				
			});
		
		}
	
	}
	
	$(document).on('click', '.celulares .phone .fa-times', function(){
		
		var id_lista = $(this).parent().data('lista');
		var id_contato = $(this).parent().data('id');
		var id_usuario = $('body').data('ids');
		
		var span = $(this).parent();
		
		$.ajax({
			
			url: module+'/campanha/del-contato-avulso?id_contato='+id_contato+'&id_lista='+id_lista+'&id_usuario='+id_usuario,
			success: function( row ){
				
				console.log( module+'campanha/del-contato-avulso?id_contato='+id_contato+'&id_lista='+id_lista+'&id_usuario='+id_usuario );
				console.log( row );
				
				$(span).remove();
				
			}, beforeSend: function(){
				
				$(span).html('Carregando... <i class="fa fa-spin fa-cog"></i>');
				
			}
			
		})
		
	});
	
	function popupDuplicados(row)
	{
		
		if (row.length == 1){
			var nameCelular = 'Celular duplicado';
		} else {
			var nameCelular = 'Celulares duplicados';
		}
		
		var box  = '<div class="bg-black-duplicados animated fadeIn">';
			
			box += '<form action="javascript:passo(\'prox\'); javascript:fechaDuplicados();" class="box-duplicados animated bounceInDown">';
			box += '<h2><i class="fa fa-warning"></i> '+row.length+' '+nameCelular+'</h2>';
			box += '<h3>Existem '+row.length+' celulares duplicados nas listas selecionadas. </h3>';
			
			box += '<div class="scroll">';
			box += '<table>';
			
			box += '<tr>';
//			box += '<th>Lista de contatos</th>';
			box += '<th>Celular</th>';
			box += '<th>Repetidos</th>';
			box += '</tr>';
			
			for(var i in row) {
				
				if (row[i].celular == null){
					row[i].celular = 'Vázio';
				}
				
				box += '<tr>';
//				box += '<td>'+row[i].lista+'</td>';
				box += '<td>'+row[i].celular+'</td>';
				box += '<td>'+row[i].linha+'</td>';
				box += '</tr>';
			}
			
			box += '</table>';
			box += '</div>';
			
			box += '<div class="opcoes">';
			box += '<button type="button" class="cor_b_hover" onclick="javascript:fechaDuplicados();">Voltar</button>';
			box += '<button type="submit" class="cor_c_hover">Continuar</button>';
			box += '</div>';
			
			box += '</form>';
			box += '</div>';
			
		$('body').append(box);
		
	}
	
	function fechaDuplicados()
	{
		
		$('.bg-black-duplicados').removeClass('fadeIn').addClass('fadeOut');
		
		setTimeout(function(){
			
			$('.bg-black-duplicados').remove();
			
		}, 800);
		
	}
	
	var campanha = [];
	
	function setCampanha(id_campanha){
		
		$.ajax({
			url: module+'/relatorios/geral',
			type: 'GET',
			data: {id:id_campanha},
			dataType: 'JSON',
			success: function(row){
				
				campanha[id_campanha] = row;
				console.log(campanha);
				
			}
		});
		
	}
	
	function getDados(id_campanha, tipo, local, localParent){
	
		if (!campanha[id_campanha]){
			
			$(localParent).find(local).html('<i class="fa fa-spin fa-cog"></i>');
			
			setTimeout(function(){
				getDados(id_campanha, tipo, local, localParent);
			},2000);
			
		} else {
			
			if (tipo == 'enviados'){
				$(localParent).find(local).html(campanha[id_campanha].enviados);
			}
			if (tipo == 'sucesso'){
				$(localParent).find(local).html(campanha[id_campanha].sucesso);
			}
			if (tipo == 'erro'){
				$(localParent).find(local).html(campanha[id_campanha].erro);
			}
			if (tipo == 'pendentes'){
				$(localParent).find(local).html(campanha[id_campanha].pendentes);
			}
			if (tipo == 'rejeicoes'){
				$(localParent).find(local).html(campanha[id_campanha].rejeicoes);
			}
			if (tipo == 'cliques'){
				$(localParent).find(local).html(campanha[id_campanha].cliques);
			}
			if (tipo == 'aberturas'){
				$(localParent).find(local).html(campanha[id_campanha].aberturas);
			}
			
		}
		
	}
	
	function getGraficos(id_campanha){
		
		var boxGrafico = '';
			boxGrafico += '<div class="bg-black">';
			boxGrafico += '<div class="modal graph">';
			boxGrafico += '<div class="header cor_a">';
			boxGrafico += '<span>Detalhes</span><i class="fa fa-times"></i>';
			boxGrafico += '</div>';
			boxGrafico += '<div id="grafico-campanha"><i class="fa fa-spin fa-cog"></i> Carregando gráfico</div>';
			boxGrafico += '</div>';
			boxGrafico += '</div>';
			
		if ($('.modal.graph').length > 0){
			$('.modal.graph').parent().remove();
		}
		
		$('body').append(boxGrafico);
		
		$('.bg-black > .modal.graph .fa-times').click(function(){
			$('.bg-black').remove();
		});
		
		$('#grafico-campanha').html('<i class="fa fa-spin fa-cog"></i> Carregando dados da campanha');
		
		viewGraficos(id_campanha);
		
	}
	
	function viewGraficos(id_campanha){

		var chart = Highcharts.chart('grafico-campanha', {

			chart: {
                inverted: true,
                polar: false
            },

	        title: {
	            text: false
	        },

	        subtitle: {
	            text: false
	        },

	        xAxis: {
	            categories: ['Enviados','Erros','Sucessos','Pendentes','Aberturas','Rejeições']
	        },

	        series: [{
	        	name: 'SMS',
	            type: 'column',
	            colorByPoint: true,
	            data: [
	                   parseFloat(campanha_view[id_campanha].envios.total),
	                   parseFloat(campanha_view[id_campanha].envios.erro),
	                   parseFloat(campanha_view[id_campanha].envios.sucesso),
	                   parseFloat(campanha_view[id_campanha].envios.pendentes),
	                   parseFloat(campanha_view[id_campanha].aberturas.total),
	                   parseFloat(campanha_view[id_campanha].envios.rejeicoes)],
	        }]

	    });
		
		var table  = '';
			table += '<table style="width:100%;">';
			
			table += '<tr>';
			table += '<td>Iniciado em:</td>';
			table += '<td>'+campanha_view[id_campanha].envios.inicio+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Finalizado em:</td>';
			table += '<td>'+campanha_view[id_campanha].envios.fim+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Visualizações:</td>';
			table += '<td>'+campanha_view[id_campanha].aberturas.total+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Visualizações unicas:</td>';
			table += '<td>'+campanha_view[id_campanha].aberturas.unicos+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Primeira abertura:</td>';
			table += '<td>'+campanha_view[id_campanha].aberturas.primeiro+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Última abertura:</td>';
			table += '<td>'+campanha_view[id_campanha].aberturas.ultimo+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Primeiro clique:</td>';
			table += '<td>'+campanha_view[id_campanha].cliques.primeiro+'</td>';
			table += '</tr>';
			
			table += '<tr>';
			table += '<td>Último clique:</td>';
			table += '<td>'+campanha_view[id_campanha].cliques.ultimo+'</td>';
			table += '</tr>';
			table += '</table>';
			
				
		$('#grafico-campanha').append(table);

	}
		

