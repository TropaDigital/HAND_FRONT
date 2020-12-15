<?php include_once dirname(__FILE__).'/../layout/header.php';?>

	<div class="div_content">
		<div class="box_conteudo">
		
			<div class="box_adc" style="width:45%; margin-bottom:0px;">
				<div class="top" style="background:#64BE59">
					<span class="titulo">Contato</span>
				</div>
					
				<div class="contatos_novo">
					
					<table>
						<tr>
							<th><i class="fa fa-phone"></i> Entre em contato por telefone</th>
						</tr>
						
						<tr>
							<td>(11) 1111-1111</td>
						</tr>
						
						<tr>
							<td>(11) 1111-1111</td>
						</tr>
						
						<tr style="height:50px;">
							<td><button class="bt_verde" style="position:absolute; margin-top:0; margin-left:0px;"><i class="fa fa-commenting-o" style="margin-right:5px;"></i> Chat Online</button></td>
						</tr>
						
					</table>
					
				</div>
				
			</div>
		
		
			<div class="box_adc" style="width:46%; margin-bottom:0px;">
				<div class="top">
					<span class="titulo">Formulario</span>
				</div>
					
				<div class="contatos_novo">
					
					<form method="post" action="/contato/enviar">
						<input name="nome" type="text" style="width:46%" placeholder="Nome Completo"/>
						<input name="email" type="text" style="width:46%" placeholder="E-mail"/>
						<input name="telefone" class="telefone" type="text" style="width:46%" placeholder="Telefone"/>
						<input name="assunto" type="text" style="width:46%" placeholder="Assunto"/>
						<textarea name="mensagem" class="textarea" style="width:96%;" placeholder="Mensagem"></textarea>
						<button type="submit" class="bt_verde" style="margin-top:0; margin-left:5px; width:80px;">Enviar</button>
					</form>
					
				</div>
				
			</div>
		</div>
		
	</div>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>