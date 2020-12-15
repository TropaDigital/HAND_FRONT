<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
			
			<div class="box_adc" style="width:95%;" id="todas">
				<div class="top">
					<span class="titulo"><i class="fa fa-list-ul"></i><?php echo $this->lg->_("Modelos"); ?> </span>
				</div>
				
				<div class="contatos_lista">
				
					<div class="topo-campanhas" style="border-bottom:1px solid rgba(0,0,0,0.1);margin-top: 10px;padding-bottom: 10px;">
				
						<form id="busca">
							<input type="hidden" name="busca" value="1"/>
							
							<select onchange="javascript:submitForm();" name="categoria">
								<option value=""><?php echo $this->lg->_("Categorias"); ?></option>
								<option <?php echo $_GET['categoria'] == 'lixeira' ? 'selected' : ''; ?> value="lixeira"><?php echo $this->lg->_("Lixeira"); ?></option>
							</select>
							
							<input name="data_i" value="<?php echo $_GET['data_i'];?>" placeholder="Data inicial" style="width:65px;" type="text" class="picker"/> 
							<?php echo $this->lg->_("até"); ?> 
							<input name="data_f" value="<?php echo $_GET['data_f'];?>" placeholder="Data final" style="width:65px;" type="text" class="picker"/>
							<input name="nome" value="<?php echo $_GET['nome'];?>" placeholder="Nome da campanha" style="padding-right:35px;" type="text"/>
							<button type="submit"><i class="fa fa-search"></i></button>
						</form>
						
					</div>
					
					<div class="periodo">
				
					<?php if (!$_GET['data_f'] && !$_GET['data_i']){?>
					<h2><i class="fa fa-calendar"></i> <?php echo $this->lg->_("Este mês"); ?> </h2>
					<?php } ?>
					
						<?php if (count($this->landing_page) == 0 && $_GET['data_i'] != '0000-00-00'){?>
						<span style="color:#666; font-size:13px; padding-top:25px; display:inline-block;">
							<i class="fa fa-exclamation-triangle"></i> <?php echo $this->lg->_("Não existe registros para esse mês, para ver todos"); ?> <a style="color:#333; font-weight:bold;" href="/templates/modelos/?busca=1&data_i=0000-00-00&data_f=<?php echo $_GET['data_f'];?>&categoria=<?php echo $_GET['categoria'];?>&nome=<?php echo $_GET['nome'];?>"><?php echo $this->lg->_("clique aqui"); ?></a>.
						</span>
						<?php } ?>
						
						<?php foreach($this->landing_page as $row){ ?>
						<div class="box-modelo box-<?php echo $row->id_landing_page;?>">
							
							<div class="modelo">
								<i class="fa fa-tablet"></i>
								<div class="nome-template"><?php echo $row->template; ?></div>
							</div>
							
							<div class="funcoes-modelo">
								<a class="preview" onclick="preview('<?php echo $row->id_landing_page; ?>');"><i class="fa fa-eye"></i><?php echo $this->lg->_("Pré visualizar"); ?> </a>
								<a class="preview" onclick="duplicar('<?php echo $row->id_landing_page; ?>');"><i class="fa fa-clone"></i> <?php echo $this->lg->_("Duplicar"); ?></a>
								
								<?php if($row->favorito != '1'){?>
								<a class="preview" onclick="favorito('<?php echo $row->id_landing_page; ?>', '1', this);"><i class="fa fa-heart"></i> <?php echo $this->lg->_("Favoritar"); ?></a>
								<?php } else {?>
								<a class="preview" onclick="favorito('<?php echo $row->id_landing_page; ?>', '2', this);"><i class="fa fa-heart-o"></i><?php echo $this->lg->_("Desfavoritar"); ?> </a>
								<?php } ?>
								
								<?php if($row->status != 'excluido'){?>
								<a class="preview" onclick="del('<?php echo $row->id_landing_page; ?>');"><i class="fa fa-trash"></i> <?php echo $this->lg->_("Excluir"); ?></a>
								<?php } else {?>
								<a class="preview" onclick="restore('<?php echo $row->id_landing_page; ?>');"><i class="fa fa-arrow-circle-up"></i> <?php echo $this->lg->_("Resturar"); ?></a>
								<?php } ?>
								
							</div>
							
							<a class="nome-modelo" href="templates/criacao-nova/id/<?php echo $row->id_landing_page; ?>" title="<?php echo $row->nome == '' ? 'Sem nome' : $row->nome;?>"><?php echo $row->nome == '' ? 'Sem nome' : limita($row->nome,20); ?></a>
							<?php if ($row->modificado){?>
							<div class="enviado_em"><?php echo $this->lg->_("Atualização:"); ?> <b><?php echo date('d/m/Y H:i', strtotime($row->modificado)); ?></b></div>
							<?php } else {?>
							<div class="enviado_em"><?php echo $this->lg->_("Criado:"); ?> <b><?php echo date('d/m/Y H:i', strtotime($row->criado)); ?></b></div>
							<?php } ?>
						</div>
						<?php } ?>
						
					</div>
					
				</div>
			</div>
			
		</div>
	</div>
	
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	<script>
		$('.picker').datepicker({
			dateFormat: 'yy-mm-dd'
		});

		function submitForm(){
			$('#busca').submit();
		}

		function favorito(id, fav, botao){

			var bt = $(botao);
			
			$.ajax({
				url: '/templates/favoritar-template',
				type: 'POST',
				data: {id:id, fav:fav},
				success: function(row){

					$('.box-'+id).animate({'opacity':'1'},500);
					
					if (row == 'true'){

						if (fav == 1){
							$(bt).attr('onclick','favorito(\''+id+'\', \'2\', this);');
							$(bt).html('<i class="fa fa-heart-o"></i> Desfavoritar');
						} else {
							$(bt).attr('onclick','favorito(\''+id+'\', \'1\', this);');
							$(bt).html('<i class="fa fa-heart"></i> Favoritar');
						}
						
					} else {
						alert('Erro, tente novamente mais tarde.');
					}
					
					console.log(row);
					
				}, beforeSend: function(){
					$('.box-'+id).animate({'opacity':'0.8'},500);
				}
			});
		}

		function restore(id){
			$.ajax({
				url: '/templates/modelos/restore/true/id/'+id,
				type: 'GET',
				success: function(row){
					if (row == 'true'){
						$('.box-'+id).addClass('animated bounceOut').delay(350).fadeOut(0);
					} else {
						alert('Erro ao restaurar modelo.');
						$('.box-'+id).animate({'opacity':'1'},500);
					}
					console.log(row);
				}, beforeSend: function(){
					$('.box-'+id).animate({'opacity':'0.8'},500);
				}
			});
		}
		
		function del(id){
			
			$.ajax({
				url: '/templates/modelos/del/true/id/'+id,
				type: 'GET',
				success: function(row){
					if (row == 'true'){
						$('.box-'+id).addClass('animated bounceOut').delay(350).fadeOut(0);
					} else {
						alert('Erro ao remover modelo.');
						$('.box-'+id).animate({'opacity':'1'},500);
					}
					console.log(row);
				}, beforeSend: function(){
					$('.box-'+id).animate({'opacity':'0.8'},500);
				}
			});
		}
	</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>