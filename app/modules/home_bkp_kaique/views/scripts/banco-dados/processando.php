<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content_select">
		<div class="box_conteudo">
		
			<div class="box_adc">
			
				<div class="top">
					<span class="titulo"><i class="fa fa-upload"></i> <?php echo $this->lg->_("Importação de CSV"); ?></span>
				</div>
				
				<div class="contatos_novo">
					
					<progress max="100" value="0"></progress>
					<div class="progress" style="display: block; text-align:center;"><i class="fa fa-spin fa-spinner"></i> <?php echo $this->lg->_("Carregando..."); ?></div>
					
				</div>
			
			</div>
		
		</div>
	</div>
	
	<script>

		var total = 0;
		var id_lista = '<?php echo base64_encode( $_GET['id_lista'] );?>';
		var token = '<?php echo base64_encode( $this->me->id_usuario );?>';
		
		$.ajax({

			url: '<?php echo $this->baseModule;?>/banco-dados/acompanhamento?key=<?php echo $_GET['key'];?>&type=start',
			success: function(row){

				porcentagem(row);
				
			}
			
		});

		function porcentagem(total){

			$.ajax({

				url: '<?php echo $this->baseModule;?>/banco-dados/acompanhamento',
				type: 'GET',
				data: {key: '<?php echo $_GET['key'];?>', total:total},
				success: function(row){

					console.log(row);
					if (row != '100'){

						setTimeout(function(){
							porcentagem(total);
						}, 1000);

					}

					if ( row == '100' ){

						$.ajax({

							url: '<?php echo $this->backend?>/api/contatos/get-duplicados',
							type: 'GET',
							data: {token:token, id_lista:id_lista},
							dataType: 'JSON',
							success: function(row){

								
								if (row.total_registros == 0){

									alert('Importação completa.');
									location.href='<?php echo $this->baseModule;?>/contatos?t=c&id_lista=<?php echo $_GET['id_lista'];?>';
									
								} else {

									alert('Importação completa.');
									location.href='<?php echo $this->baseModule;?>/contatos?t=c&id_lista=<?php echo $_GET['id_lista'];?>&duplicados=true';

								}

							}

						});
						
					}
					
					$('.progress').html('<i class="fa fa-spin fa-spinner"></i> '+row+'%');
					$('.contatos_novo progress').attr('value', row);


				}
						
			});

		}

	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>