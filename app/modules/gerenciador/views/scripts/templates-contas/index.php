<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
	
	<div id="central">
		<form class="div_content" method="post" action="<?php echo $this->baseModule;?>/templates-contas/send">
			
			<input type="hidden" name="id" value="<?php echo $this->id; ?>"/>
			<input type="hidden" name="id_zoug" value="<?php echo $this->row->id_zoug; ?>"/>
			
			<table class="table-edicao">
					
				<tr class="cor_b">
					<th width="220">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
				
					<td>Buscar</td>
					<td>
					
						<input type="text" class="search" placeholder="Buscar por usuario/nome do template"/>
						<a href="javascript:;">
							<i class="fa fa-search"></i>
						</a>
					
					</td>
				
				</tr>
				
				<tr>
				
					<td>Template(s)</td>
					<td class="result">Nenhum resultado encontrado...</td>
				
				</tr>
				
				<tr>
				
					<td>Transferir para o usuario</td>
					<td>
					
						<select class="select2" name="id_usuario" style="width:100%;">
							<?php foreach ( $this->result as $row ){?>
							<option value="<?php echo $row->id_usuario; ?>"><?php echo $row->login_envio == NULL ? 'N/A' : $row->login_envio; ?> - <?php echo $row->name_user; ?></option>
							<?php } ?>
						</select>
					
					</td>
				
				</tr>
				
				<tr>
					<td colspan="2" align="right">
					
						<a href="/<?php echo $this->baseModule; echo '/'; echo $this->baseController; ?>" class="edicao-false-bt cor_c_hover">VOLTAR</a>
						<button class="cor_c_hover">CONCLUIR</button>
						
					</td>
				</tr>
				
			</table>
		</form>
	</div>	

	<script>

	$(".select2").select2();

	$('.search').on('blur', function(){

		var busca = $(this).val();

		if ( busca.length > 0 ) {
		
    		$.ajax({
    			url: '<?php echo $this->baseModule;?>/templates-contas/search',
    			dataType: 'JSON',
    			data: {busca:busca},
    			type: 'GET',
    			success: function(row){
    
    				if ( row.length > 0 ) {
    
    					$('.result').html('');
    
    				} else {
    
    					$('.result').html('Nenhum resultado encontrado...');
    					
    				}
    
    				
    				for(var i in row) {
    
    					console.log(row[i]);

    					var htmlAppend  = '';
    						htmlAppend += '<label class="landing_page">';
    						htmlAppend += '<input type="radio" name="id_landing_page" value="'+row[i].id_landing_page+'">';
    						htmlAppend += '<span>NOME DO TEMPLATE: <b>'+row[i].nome+'</b></span>';
    						htmlAppend += '<span>LOGIN DE ENVIO: <b>'+row[i].login_envio+'</b></span>';
    						htmlAppend += '<span>USUARIO: <b>'+row[i].name_user+'</b></span>';
    						htmlAppend += '<span><a target="_blank" href="/l/'+row[i].id_landing_page+'">Visualizar template</a></span>';
    						htmlAppend += '<label>';
    					
    					$('.result').append( htmlAppend );
    					
    				}
    
    			}
    
    		});

		} else {

			$('.result').html('Nenhum resultado encontrado...');
			
		}

	});

	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>