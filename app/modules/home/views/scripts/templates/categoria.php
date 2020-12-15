<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
	
			<div class="box_adc" id="todas">
				
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i> <?php echo $this->lg->_("Como você deseja criar seu novo template?"); ?></span>
				</div>
	
				<div class="info-categoria">
					
					<span class="img" style="background:url(<?php echo $this->categoria[0]->imagem;?>) center no-repeat;"></span>
					<span class="titulo"><?php echo $this->categoria[0]->categoria;?></span>
					<span class="descricao"><?php echo $this->categoria[0]->descricao;?></span>
				
				</div>
				
				<div style="width:100%; float:left; text-align:center;">
				
					<div class="celulares">
						
						<?php foreach($this->templates as $row){?>
                            <div class="box-landing-page">

                                <div class="box-phone">
                                    <iframe src="/l/<?php echo $row->id_landing_page;?>"></iframe>
                                </div>

                                <div class="funcoes">

                                    <?php if ( $row->pago == 'true' && !$this->meus_templates_comprados[$row->id_template] ){?>
                                        <a class="cor_a_hover" onclick="comprar($(this), '<?php echo $row->id_template;?>')">Comprar template (<?php echo $row->valor;?> créditos)</a>
                                    <?php } else {?>
                                        <a class="cor_a_hover" onclick="criar_template($(this), '<?php echo $row->id_template; ?>');">Criar template</a>
                                    <?php } ?>

                                </div>

                            </div>

						<?php } ?>
					
					</div>
				
				</div>
				
			</div>
		
		</div>
	</div>
	
	<script>

        var loadingvar = false

        function comprar(myThis, id){

            if ( loadingvar == false ) {

                loadingvar = true
                var valueOld = myThis.html()

                myThis.html('Carregando...')

                $.ajax({
                    url: '/<?php echo $this->baseModule;?>/templates/comprar-template/id/' + id,
                    dataType: 'json',
                    success: function (row) {

                        console.log( row )
                        loadingvar = false

                        if (row.error == false) {
                            criar_template(myThis, id)
                        } else {
                            alert(row.message)
                            myThis.html(valueOld)
                        }

                    }
                })

            }
        }

		function criar_template(myThis, id){

            var valueOld = myThis.html()

            myThis.html('Carregando...')

			$.ajax({
				url: '/<?php echo $this->baseModule;?>/templates/criar-template/id/'+id,
				success: function(result){

					if (result == 'false'){
                        myThis.html(valueOld)
						alert('Aconteceu algum erro, tente novamente mais tarde.');
					} else {
						location.href='/<?php echo $this->baseModule;?>/templates/criacao/id/'+result;
					}

				}
			});
		}

	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>