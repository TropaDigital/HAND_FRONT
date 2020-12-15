<?php include 'topo_painel.php'; ?>
	
	<form class="div_content" method="post">
		
		<input type="hidden" name="id" value="<?php echo $this->id; ?>"/>
		<input type="hidden" name="id_zoug" value="<?php echo $this->row->id_zoug; ?>"/>
		
		<table class="table-edicao edit">
				
			<tr>
				<th width="220">Campos</th>
				<th>Edição</th>
			</tr>
			
			<tr>
				<td>
					Status*
				</td>
				<td>
					<select name="ativo" required>
						<option value="1" <?php echo $this->row->ativo == '1' ? 'selected' : '';?>>Ativo</option>
						<option value="0" <?php echo $this->row->ativo == '0' ? 'selected' : '';?>>Inativo</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					Empresa*
					<br/><span style="font-size:10px;">Nome da Empresa que será cadastrada.</span>
				</td>
				<td>
					<input name="empresa" required type="text" value="<?php echo $this->row->empresa;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Email da empresa*
					<br/><span style="font-size:10px;">E-mail da Empresa que será cadastrada.</span>
				</td>
				<td>
					<input name="emailEmp" required type="text" value="<?php echo $this->row->emailEmp;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Telefone da empresa*
					<br/><span style="font-size:10px;">Telefone da Empresa que será cadastrada.</span>
				</td>
				<td>
					<input class="celular" name="telEmp" required type="text" value="<?php echo $this->row->telEmp;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					CNPJ*
					<br/><span style="font-size:10px;">Cnpj da empresa que será cadastrada.</span>
				</td>
				<td>
					<input name="cnpj" required type="text" value="<?php echo $this->row->cnpj;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Login user*
					<br/><span style="font-size:10px;">Login para a nova Empresa cadastrada.</span>
				</td>
				<td>
					
					<?php if (!$this->id){ ?>
					<div class="label-100-left">
						<input class="validaLogin" required type="text" value="<?php echo $this->row->login;?>"/>
					</div>
					<?php } ?>
					
					<div class="label-100-left">
						<input class="auto-preenche" disabled="disabled" required type="text" value="<?php echo $this->row->login;?>"/>
					</div>
					
					<input class="auto-preenche" name="login_user" required type="hidden" value="<?php echo $this->row->login;?>"/>
				
					<script>
						$('.validaLogin').bind('keyup change blur', function(){

							var login = $(this).val();
							
							$.ajax({
								url: '/painel/usuarios/valida-login',
								type: 'POST',
								data: {login: login},
								success: function(row){
									console.log(row)
									$('.auto-preenche').val(row);
								}
							});
						});
					</script>
				
				</td>
			</tr>
			
			<tr>
				<td>
					Senha user*
					<br/><span style="font-size:10px;">Senha para a Nova Empresa cadastrada.</span>
				</td>
				<td>
					<input name="senha_user" required type="password" value="<?php echo $this->row->senha;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Nome user*
					<br/><span style="font-size:10px;">Nome do Usuário que irá usar o login da Nova Empresa.</span>
				</td>
				<td>
					<input name="name_user" required type="text" value="<?php echo $this->row->name_user;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Email user*
					<br/><span style="font-size:10px;">E-mail do Usuário que irá usar o login da Nova Empresa.</span>
				</td>
				<td>
					<input name="email_user" required type="text" value="<?php echo $this->row->email_user;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Sexo*
					<br/><span style="font-size:10px;">Sexo do Usuário que irá usar o login da Nova Empresa</span>
				</td>
				<td>
				
					<label class="label-100-left">
						<input type="radio" name="sexo" value="M" required <?php echo $this->row->sexo == 'M' ? 'checked' : '';?>/> Masculino
					</label>
					<label class="label-100-left">
						<input type="radio" name="sexo" value="F" required <?php echo $this->row->sexo == 'F' ? 'checked' : '';?>/> Feminino
					</label>
					
				</td>
			</tr>
			
			<tr>
				<td>
					Telefone user*
					<br/><span style="font-size:10px;">Telefone do Usuário que irá usar o login da nova empresa</span>
				</td>
				<td>
					<input class="celular" name="tel_user" required type="text" value="<?php echo $this->row->tel_user;?>"/>
				</td>
			</tr>
			
			<tr>
				<td>
					Time
					<br/><span style="font-size:10px;">Hora de funcionamento que o centro de custo irá poder enviar SMS</span>
				</td>
				<td>
					
					<div class="label-100-left">
					
						<?php $time = explode(':', $this->row->time);?>
					
						<select name="time_inicio" style="min-width: 50px;">
							<option value="0" <?php echo $time[0] == '0' ? 'selected' : ''; ?>>00:00</option>
							<option value="1" <?php echo $time[0] == '1' ? 'selected' : ''; ?>>01:00</option>
							<option value="2" <?php echo $time[0] == '2' ? 'selected' : ''; ?>>02:00</option>
							<option value="3" <?php echo $time[0] == '3' ? 'selected' : ''; ?>>03:00</option>
							<option value="4" <?php echo $time[0] == '4' ? 'selected' : ''; ?>>04:00</option>
							<option value="5" <?php echo $time[0] == '5' ? 'selected' : ''; ?>>05:00</option>
							<option value="6" <?php echo $time[0] == '6' ? 'selected' : ''; ?>>06:00</option>
							<option value="7" <?php echo $time[0] == '7' ? 'selected' : ''; ?>>07:00</option>
							<option value="8" <?php echo $time[0] == '8' ? 'selected' : ''; ?>>08:00</option>
							<option value="9" <?php echo $time[0] == '9' ? 'selected' : ''; ?>>09:00</option>
							<option value="10" <?php echo $time[0] == '10' ? 'selected' : ''; ?>>10:00</option>
							<option value="11" <?php echo $time[0] == '11' ? 'selected' : ''; ?>>11:00</option>
							<option value="12" <?php echo $time[0] == '12' ? 'selected' : ''; ?>>12:00</option>
							<option value="13" <?php echo $time[0] == '13' ? 'selected' : ''; ?>>13:00</option>
							<option value="14" <?php echo $time[0] == '14' ? 'selected' : ''; ?>>14:00</option>
							<option value="15" <?php echo $time[0] == '15' ? 'selected' : ''; ?>>15:00</option>
							<option value="16" <?php echo $time[0] == '16' ? 'selected' : ''; ?>>16:00</option>
							<option value="17" <?php echo $time[0] == '17' ? 'selected' : ''; ?>>17:00</option>
							<option value="18" <?php echo $time[0] == '18' ? 'selected' : ''; ?>>18:00</option>
							<option value="19" <?php echo $time[0] == '19' ? 'selected' : ''; ?>>19:00</option>
							<option value="20" <?php echo $time[0] == '20' ? 'selected' : ''; ?>>20:00</option>
							<option value="21" <?php echo $time[0] == '21' ? 'selected' : ''; ?>>21:00</option>
							<option value="22" <?php echo $time[0] == '22' ? 'selected' : ''; ?>>22:00</option>
							<option value="23" <?php echo $time[0] == '23' ? 'selected' : ''; ?>>23:00</option>
						</select>
						
						<i class="fa fa-clock-o"></i> Inicio
						
					</div>
					
					<div class="label-100-left">
					
						<select name="time_fim" style="min-width: 50px;">
							<option value="0" <?php echo $time[1] == '0' ? 'selected' : ''; ?>>00:00</option>
							<option value="1" <?php echo $time[1] == '1' ? 'selected' : ''; ?>>01:00</option>
							<option value="2" <?php echo $time[1] == '2' ? 'selected' : ''; ?>>02:00</option>
							<option value="3" <?php echo $time[1] == '3' ? 'selected' : ''; ?>>03:00</option>
							<option value="4" <?php echo $time[1] == '4' ? 'selected' : ''; ?>>04:00</option>
							<option value="5" <?php echo $time[1] == '5' ? 'selected' : ''; ?>>05:00</option>
							<option value="6" <?php echo $time[1] == '6' ? 'selected' : ''; ?>>06:00</option>
							<option value="7" <?php echo $time[1] == '7' ? 'selected' : ''; ?>>07:00</option>
							<option value="8" <?php echo $time[1] == '8' ? 'selected' : ''; ?>>08:00</option>
							<option value="9" <?php echo $time[1] == '9' ? 'selected' : ''; ?>>09:00</option>
							<option value="10" <?php echo $time[1] == '10' ? 'selected' : ''; ?>>10:00</option>
							<option value="11" <?php echo $time[1] == '11' ? 'selected' : ''; ?>>11:00</option>
							<option value="12" <?php echo $time[1] == '12' ? 'selected' : ''; ?>>12:00</option>
							<option value="13" <?php echo $time[1] == '13' ? 'selected' : ''; ?>>13:00</option>
							<option value="14" <?php echo $time[1] == '14' ? 'selected' : ''; ?>>14:00</option>
							<option value="15" <?php echo $time[1] == '15' ? 'selected' : ''; ?>>15:00</option>
							<option value="16" <?php echo $time[1] == '16' ? 'selected' : ''; ?>>16:00</option>
							<option value="17" <?php echo $time[1] == '17' ? 'selected' : ''; ?>>17:00</option>
							<option value="18" <?php echo $time[1] == '18' ? 'selected' : ''; ?>>18:00</option>
							<option value="19" <?php echo $time[1] == '19' ? 'selected' : ''; ?>>19:00</option>
							<option value="20" <?php echo $time[1] == '20' ? 'selected' : ''; ?>>20:00</option>
							<option value="21" <?php echo $time[1] == '21' ? 'selected' : ''; ?>>21:00</option>
							<option value="22" <?php echo $time[1] == '22' ? 'selected' : ''; ?>>22:00</option>
							<option value="23" <?php echo $time[1] == '23' ? 'selected' : ''; ?>>23:00</option>
						</select>
						
						<i class="fa fa-clock-o"></i> Fim
						
					</div>
					
				</td>
			</tr>
			
			<tr>
				<td>
					Dias
					<br/><span style="font-size:10px;">Dias da semana que será permitido o envio de SMS</span>
				</td>
				<td>
				
					<?php $dias = explode(':', $this->row->dias); ?>
				
					<script>
						$(function() {
							$( "#slider-range" ).slider({
								min: 0,
								max: 6,
								values: [ <?php echo $dias[0] != '' ? $dias[0] : '1'; ?>, <?php echo $dias[1] != '' ? $dias[1] : '6'; ?> ],
								slide: function( event, ui ) {
									$("#dias, #dias-disabled").val(ui.values[ 0 ]+":"+ ui.values[ 1 ]);
						      }
							});
						});
					</script>
					
					<label class="label-100-left">
						<input type="text" disabled id="dias-disabled" value="<?php echo $this->row->dias == '' ? '1:6' : $this->row->dias; ?>"/>
	  					<input type="hidden" name="dias" id="dias" value="<?php echo $this->row->dias == '' ? '1:6' : $this->row->dias; ?>">
  					</label>
  					
  					<div class="dias-liberados">
						<div id="slider-range"></div>
					</div>
						
					<div class="dias-nome">
						
						<div class="dia">Domingo</div>
						<div class="dia">Segunda</div>
						<div class="dia">Terça</div>
						<div class="dia">Quarta</div>
						<div class="dia">Quinta</div>
						<div class="dia">Sexta</div>
						<div class="dia" style="width:auto;">Sábado</div>
							
					</div>

				</td>
			</tr>
			
			<tr>
				<td>
					Type
					<br/><span style="font-size:10px;">Tipo de conexão que será permitida a esse usuário a enviar para o zoug</span>
				</td>
				<td>
					<select name="type" required>
						<option value="1" <?php echo $this->row->type == '1' ? 'selected' : '';?>>HTTP</option>
						<option value="2" <?php echo $this->row->type == '2' ? 'selected' : '';?>>SMPP</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>
					Expira
					<br/><span style="font-size:10px;">Caso o SMS venha a dar erro ao enviar este campo informa se vai reenviar este sms ou não</span>
				</td>
				<td>
					<select name="expira" required>
						<option value="1" <?php echo $this->row->expira == '1' ? 'selected' : '';?>>Reenviar</option>
						<option value="0" <?php echo $this->row->expira == '0' ? 'selected' : '';?>>Não reenviar</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td colspan="2" align="right">
				
					<a href="/<?php echo $this->baseModule; echo '/'; echo $this->baseController; ?>" class="edicao-false-bt">VOLTAR</a>
					<button class="edicao-bt">CONCLUIR</button>
					
				</td>
			</tr>
				
		</table>
	</form>
		

<?php include 'rodape_painel.php'; ?>