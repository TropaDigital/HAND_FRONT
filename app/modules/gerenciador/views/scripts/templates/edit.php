<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
	
		<form class="div_content" method="post" enctype="multipart/form-data">
			
			<table class="table-edicao edit">
					
				<tr class="cor_b">
					<th width="220">Campos</th>
					<th>Edição</th>
				</tr>
				
				<tr>
					<td>
						Status
					</td>
					<td>
						<select name="status" required>
							<option value="1" <?php echo $this->row->status == '1' ? 'selected' : '';?>>Ativo</option>
							<option value="0" <?php echo $this->row->status == '0' ? 'selected' : '';?>>Inativo</option>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Nome do template
					</td>
					<td>
						<input name="template" type="text" required value="<?php echo $this->row->template;?>"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Categoria do template
					</td>
					<td>
						<select name="id_categoria_gerenciador" required>
							<?php foreach($this->categorias as $row){?>
							<option value="<?php echo $row->id_categoria;?>" <?php echo $this->row->id_categoria == $row->id_categoria ? 'selected' : '';?>><?php echo $row->categoria; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td>
						Pesquisar landing page por empresa
					</td>
					<td>
						<input type="text" class="landing"/>
					</td>
				</tr>
				
				<tr>
					<td>
						Landing Page
					</td>
					<td>
						<select name="id_landing_page" class="id_landing_page">
							<?php if ($this->id){?>
							<option value="<?php echo $this->row->id_landing_page;?>"><?php echo $this->row->nome;?> - <?php echo $this->row->empresa;?></option>
							<?php } ?>
						</select>
						<a href="/l/<?php echo $this->row->id_landing_page?>" target="_blank" style="display:block; margin-top:10px; cursor:pointer;" class="preview-template">Visualizar landing page</a>
					</td>
				</tr>

                <tr>
                    <td>
                        Pago
                    </td>
                    <td>
                        <select name="pago" required>
                            <option value="false" <?php echo $this->row->pago == 'false' ? 'selected' : '';?>>Não</option>
							<option value="true" <?php echo $this->row->pago == 'true' ? 'selected' : '';?>>Sim</option>
                        </select>
                    </td>
                </tr>

                <tr id="valor" style="<?php echo $this->row->pago == 'true' ? 'display:block' : 'display:none;'; ?>">
                    <td>
                        Valor
                    </td>
                    <td>
                        <input name="valor" type="text" value="<?php echo $this->row->valor;?>"/>
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

        $('select[name="pago"]').on('change', function(){

            if ( $(this).val() == 'true' ){
                $("#valor").show(0)
            } else{
                $("#valor").hide(0)
            }

        })

		$('.landing').keyup(function(){

			var empresa = $(this).val();
			$.ajax({
				url: '/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/ajax',
				type: 'POST',
				data: {empresa:empresa},
				dataType: 'JSON',
				success: function(row){

					$('.reset').remove();

					for(var i in row) {

						$('.id_landing_page').append('<option class="reset" value="'+row[i].id_landing_page+'">'+row[i].nome+' - '+row[i].empresa+'</option>');
						
					}
				}
			});
			
		});

		$('.id_landing_page').on('change', function(){

			var id = $(this).val();
			$('.preview-template').attr('href','/l/'+id);
			
		});

	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php'; ?>