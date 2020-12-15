<?php include_once dirname(__FILE__).'/../layout/header.php';?>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<div class="div_content">
	<div class="box_conteudo">
		<div id="conteudo">

			<div class="passo">
			
				<h2><b class="cor_font_c"><b><?php echo $this->lg->_("NOME2"); ?></b> <?php echo $this->lg->_("DA CAMPANHA2"); ?></h2>
				<p><?php echo $this->lg->_("Para iniciar a criação da sua campanha, preencha um nome para ela."); ?></p>
			
				<input type="text" placeholder="Nome da campanha" class="nome_campanha campanha" name="campanha"/>
			
			</div>

			<div class="passo">
				
				<h2><b class="cor_font_c"><?php echo $this->lg->_("CUSTOMIZE"); ?></b></h2>
				<p><?php echo $this->lg->_("Selecione o modelo de página que sua campanha precisa."); ?></p>
				
				<select name="id_landing_page" <?php echo $_GET['id'] == '' ? '' : 'disabled="disabled"' ?> onchange="linkpreview();" class="landing_visu id_landing" required="required">
					
					<option value=""><?php echo $this->lg->_("Selecione um template"); ?></option>
					<?php foreach($this->landing_page as $row){ ?>
					<option <?php echo $_GET['id'] == $row->id_landing_page ? 'selected' : ''; ?> value="<?php echo $row->id_landing_page; ?>"><?php echo $row->nome; ?></option>
					<?php } ?>
					
				</select>
				
				<button class="cor_b_hover page_id_landing_page" type="button" onclick="veragora();"> <i class="fa fa-search-plus"></i> <?php echo $this->lg->_("Visualizar template "); ?></button>
			
			</div>

			<!-- PUBLICO -->
			<div class="passo">
		
				<h2><b class="cor_font_c"><?php echo $this->lg->_("ESCOLHA O PÚBLICO"); ?></b></h2>
				<p><?php echo $this->lg->_("Adicione os contatos para quem deseja enviar, caso haja necessidade você pode incluir os campos de descrição em cada número."); ?></p>

				<section class="opcao avulso active">
							
					<div class="celulares"></div>
					
					<div class="celular-avulso">
					
            			<label>
            				<input type="text" name="celular" placeholder="Celular" class="celular" value="">
            			</label>
        					
        					
        				<a class="cor_b_hover open_editavel">
        						
        					<i class="fa fa-plus"></i>
        					<?php echo $this->lg->_("Campos de descrição"); ?>
        						
        				</a>
        					
        			</div>
        			
        			<button type="button" class="adicionar-contato-avulso cor_a_hover" onclick="javascript:insereNovoContato();">
        				
        				<i class="fa fa-check"></i>
        				<?php echo $this->lg->_("Adicionar contato"); ?>
        				
        			</button>
			
					<div class="camp_editaveis popup">
					
						<div class="bg-branco">
					
    						<label>
        						<span><?php echo $this->lg->_("Referencia"); ?></span>	
        						<input type="text" name="referencia" value="">
        					</label>
    					
    						<label>
        						<span><?php echo $this->lg->_("Nome"); ?></span>
        						<input type="text" name="nome" value="">
        					</label>
    					
    						<label>
        						<span><?php echo $this->lg->_("Sobrenome"); ?></span>
        						<input type="text" name="sobrenome" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Data de nascimento"); ?></span>	
        						<input class="data" type="text" name="data_nascimento" value="" placeholder="mm/dd/yyyy">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Email"); ?></span>	
        						<input type="text" name="email" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("CPF"); ?></span>	
        						<input type="text" name="campo1" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Empresa"); ?></span>	
        						<input type="text" name="campo2" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Cargo"); ?></span>	
        						<input type="text" name="campo3" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Telefone Comercial"); ?></span>	
        						<input class="telefone" type="text" name="campo4" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Telefone Residencial"); ?></span>	
        						<input class="telefone" type="text" name="campo5" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Pais"); ?></span>	
        						<input type="text" name="campo6" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Estado"); ?></span>	
        						<input type="text" name="campo7" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Cidade"); ?></span>	
        						<input type="text" name="campo8" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Bairro"); ?></span>	
        						<input type="text" name="campo9" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Endereço"); ?></span>	
        						<input type="text" name="campo10" value="">
        					</label>
        						
        					<label>
        						<span><?php echo $this->lg->_("Cep"); ?></span>	
        						<input type="text" name="campo11" value="">
        					</label>
    					
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 1</span>	
    							<input type="text" name="editavel_1" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 2</span>	
    							<input type="text" name="editavel_2" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 3</span>	
    							<input type="text" name="editavel_3" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 4</span>	
    							<input type="text" name="editavel_4" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 5</span>	
    							<input type="text" name="editavel_5" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 6</span>	
    							<input type="text" name="editavel_6" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 7</span>	
    							<input type="text" name="editavel_7" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 8</span>	
    							<input type="text" name="editavel_8" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 9</span>	
    							<input type="text" name="editavel_9" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 10</span>	
    							<input type="text" name="editavel_10" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 11</span>	
    							<input type="text" name="editavel_11" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 12</span>	
    							<input type="text" name="editavel_12" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 13</span>	
    							<input type="text" name="editavel_13" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 14</span>	
    							<input type="text" name="editavel_14" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 15</span>	
    							<input type="text" name="editavel_15" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 16</span>	
    							<input type="text" name="editavel_16" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 17</span>	
    							<input type="text" name="editavel_17" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 18</span>	
    							<input type="text" name="editavel_18" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 19</span>	
    							<input type="text" name="editavel_19" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 20</span>	
    							<input type="text" name="editavel_20" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 21</span>	
    							<input type="text" name="editavel_21" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 22</span>	
    							<input type="text" name="editavel_22" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 23</span>	
    							<input type="text" name="editavel_23" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 24</span>	
    							<input type="text" name="editavel_24" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 25</span>	
    							<input type="text" name="editavel_25" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 26</span>	
    							<input type="text" name="editavel_26" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 27</span>	
    							<input type="text" name="editavel_27" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 28</span>	
    							<input type="text" name="editavel_28" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 29</span>	
    							<input type="text" name="editavel_29" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 30</span>	
    							<input type="text" name="editavel_30" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 31</span>	
    							<input type="text" name="editavel_31" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 32</span>	
    							<input type="text" name="editavel_32" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 33</span>	
    							<input type="text" name="editavel_33" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 34</span>	
    							<input type="text" name="editavel_34" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 35</span>	
    							<input type="text" name="editavel_35" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 36</span>	
    							<input type="text" name="editavel_36" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 37</span>	
    							<input type="text" name="editavel_37" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 38</span>	
    							<input type="text" name="editavel_38" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 39</span>	
    							<input type="text" name="editavel_39" value="">
    						</label>
    						
    						<label><span><?php echo $this->lg->_("Editavel"); ?> 40</span>	
    							<input type="text" name="editavel_40" value="">
    						</label>
						
						</div>
						
						<div class="bg-submit">
						
							<button class="cor_b_hover" onclick="javascript:$('.open_editavel').trigger('click');"><?php echo $this->lg->_("Confirmar"); ?></button>
						
						</div>
						
					</div>
						
					
					<fieldset class="referencia-sms">
					
						<legend><?php echo $this->lg->_("Deseja usar o campo referencia?"); ?></legend>
						
						<select class="referencia" name="referencia">
							<option value="0"><?php echo $this->lg->_("Não"); ?></option>
							<option value="1"><?php echo $this->lg->_("Sim"); ?></option>
						</select>
					
					</fieldset>
					
				</section>

			</div>
			
			<div class="passo">
		
				<h2><b class="cor_font_c"><?php echo $this->lg->_("Configure"); ?></b></h2>
				<p><?php echo $this->lg->_("Deseja bloquear sua campanha com senha?"); ?></p>
			
				<div class="bloqueio" style="margin: 5px 0px 45px 0px;">
    				<div id="deseja-senha">
    
    					<label>
    						<input id="com_senha" type="radio" name="block" class="block" value="s"/>
    						<?php echo $this->lg->_("Sim"); ?>						
    					</label>
    
    					<label>
    						<input checked id="sem_senha" type="radio" name="block" class="block" value="n"/>
    						<?php echo $this->lg->_("Não"); ?>						
    					</label>
    
    				</div>
				</div>
			
				<p style="margin-bottom:40px;"><?php echo $this->lg->_("Escreva o texto da sua mensagem e pré-visualize ao lado"); ?></p>
			
				<div style="width:320px; display:inline-block; vertical-align:top; text-align:left;">

					<div class="celular-miniatura">
						<div class="conteudo_cel">

							<div class="topo-sms cor_b"><?php echo $this->lg->_("SMS"); ?></div>
							
							<div class="avatar">
								<i class="fa fa-user"></i>
							</div>

							<div class="seta"></div>
							<div class="balao_mensagem"><?php echo $this->lg->_("Mensagem da campanha..."); ?></div>
							<div class="data-celular"><?php echo $this->lg->_("Enviado agora"); ?></div>

						</div>

					</div>

				</div>

				<div style="width:370px; display:inline-block; vertical-align:top; text-align:left;">

					<div class="variaveis" style="width: 96%; margin-bottom:15px; overflow:auto; height:215px; padding: 2%; float:left;border: 1px solid rgba(255, 0, 0, 0.05); font-size:12px;color: #999; text-align:center;">
						<b class="variavel"><?php echo $this->lg->_("[nome]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[sobrenome]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[numero]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[celular]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[data_nascimento]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[email]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[cpf]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[empresa]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[cargo]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[telefone_comercial]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[telefone_residencial]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[pais]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[estado]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[cidade]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[bairro]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[endereço]"); ?></b>
						<b class="variavel"><?php echo $this->lg->_("[cep]"); ?></b>
						<?php for ($i = 1; $i <= 40; $i++) {?>
							<b class="variavel"><?php echo $this->lg->_("[editavel_"); ?><?php echo $i;?>]</b>
						<?php } ?>
					</div>

					<div style="width:100%; float:left; text-align:left; text-align:center;">

						<span class="restantes" style="text-align:keft;"><b>135</b> <?php echo $this->lg->_("caracteres restantes"); ?></span><br/>

						<textarea maxlength="135" required class="mensagem_sms msg" name="mensagem-sms" placeholder="<?php echo $this->lg->_("Mensagem da campanha"); ?>"></textarea><br/>

						<p class="nao-colocar"><i class="fa fa-exclamation-circle"></i> <?php echo $this->lg->_("Não colocar esse link na mensagem, o sistema reconhece o link automaticamente."); ?></p>

						<input style="margin-top:5px; width:95%;" type="text" class="link-preview" disabled value="Selecione um template.">

					</div>

				</div>
			
			</div>
			
			<div class="passo">
			
				<h2><b><?php echo $this->lg->_("Publicação"); ?></b></h2>
				<p><?php echo $this->lg->_("Selecione um periodo que sua campanha estará ativa"); ?></p>
			
				<div class="periodo">
							
					<div class="row">
					
						<label>
							<span><?php echo $this->lg->_("Periodo início"); ?></span>
							<input type="text" value="<?php echo date('Y-m-d');?>" placeholder="Periodo início" name="data-inicio" class="calendario-inicio"/>	
						</label>	
						
						<label>
							<span><?php echo $this->lg->_("Horario"); ?></span>
							<input style="visibility:hidden; opacity:0; width:0px; height:0px;" type="text" placeholder="hh:mm" class="horario hora" value="00:00"/>
							<input type="text" placeholder="hh:mm" name="hora-inicio" class="horario hora_inicio" value="00:00"/>	
							<i class="fa fa-clock-o open-time"></i>
						</label>	
						
						
					</div>
					
					<div class="row">		
					
						<label>
							<span><?php echo $this->lg->_("Periodo final"); ?></span>
							<input type="text" value="<?php echo date('Y-m-d');?>"  placeholder="Periodo final" name="data-final" disabled class="calendario-sobre-inicio"/>
						</label>	
						
						<label>
							<span><?php echo $this->lg->_("Horario"); ?></span>
							<input style="visibility:hidden; opacity:0; width:0px; height:0px;" type="text" placeholder="hh:mm" class="horario hora" value="23:59"/>
							<input type="text" placeholder="hh:mm" name="hora-final" class="horario hora_final" value="23:59"/>	
							<i class="fa fa-clock-o open-time"></i>
						</label>
						
					</div>
					
				</div>
				
				<button class="cor_a_hover enviar-campanha" onclick="javascript:salvarCampanha();"><?php echo $this->lg->_("ENVIAR CAMPANHA"); ?></button>
			
			</div>
	
		</div>
	</div>
</div>

<!-- BLOQUEIO DE SENHA -->
<div class="bloqueio">
    <div class="tipo_senha">
    
    	<div class="box-senha">
    	
    		<a class="fa fa-times fecha_senha"></a>
    		
    		<div class="box_celular">
    		
    			<a class="altera_cor">
    			
    				<i class="fa fa-cog"></i> <?php echo $this->lg->_("Alterar cor"); ?>
    				<input type="color" id="cor_senha" value="#ff7a08"/>
    				
    			</a>
    			
    			<div class="img">
    			
    				<input style="display:none;" type="file" name="uploadfile" id="uploadfile"/>
    				<a class="fa fa-cog"></a>
    				<img src="/assets/uploads/contas/logo/logosolo.png"/>
    				
    			</div>
    			
    			<div class="form">
    			
    				<div class="titulo"><?php echo $this->lg->_("Titulo da senha"); ?></div>
    				
    				<input type="text" placeholder="<?php echo $this->lg->_("Titulo da senha"); ?>"/>
    				
    				<input type="button" value="Enviar"/>
    				
    				<div class="box-right">
    				
    					<div class="box-cancel">
    					
    						<a class="fa fa-times"></a>
    						
    						<p><?php echo $this->lg->_("Deseja ter botão cancelar?"); ?></p>
    						
    						<label>
    							<input type="radio" checked name="botao_cancel" class="botao_cancel" value="sim"/> <?php echo $this->lg->_("Sim"); ?>
    						</label>
    
    						<label>
    							<input type="radio" name="botao_cancel" class="botao_cancel" value="nao"/> <?php echo $this->lg->_("Não"); ?>
    						</label>
    						
    						<input type="text" class="nome_botao_cancel" maxlength="15" placeholder="<?php echo $this->lg->_("Nome do botão"); ?>"/>
    
    						<p><?php echo $this->lg->_("URL do botão voltar"); ?></p>
    
    						<label>
    							<input type="radio" checked name="tipo_cancel" class="tipo_cancel" value="url"/><?php echo $this->lg->_("URL"); ?> 
    						</label>
    
    						<label>
    							<input type="radio" name="tipo_cancel" class="tipo_cancel" value="final"/> <?php echo $this->lg->_("Página final"); ?>
    						</label>
    
    						<input type="text" class="url_botao_cancel" placeholder="<?php echo $this->lg->_("URL do botão"); ?>"/>
    						
    						<input type="button" value="Salvar"/>
    
    					</div>
    
    					<a class="cancel">
    						<span><?php echo $this->lg->_("Cancelar"); ?></span>
    						<i class="fa fa-cog"></i>
    					</a>
    					
    				</div>
    				
    			</div>
    
    			<div class="aviso"><i class="fa fa-warning"></i> <?php echo $this->lg->_("Isso é uma uma pré-visualização!"); ?></div>
    
    		</div>
    
    		<div class="lateral-config">
    
    			<h3><?php echo $this->lg->_("Você deseja uma senha fixa ou uma senha que venha através de uma variavel dos contatos?"); ?></h3>
    
    			<label>
    				<input type="radio" name="types" class="types" value="f"/>
    				<?php echo $this->lg->_("Fixa"); ?>					
    			</label>
    
    			<label>
    				<input type="radio" name="types" class="types" value="v"/>
    				<?php echo $this->lg->_("Variavel"); ?>						
    			</label>
    
    			<div class="senha_campanha">
    
    				<div>
    					<input type="text" style="width:340px; text-align:center;" class="total_senha" placeholder="<?php echo $this->lg->_("Quantos digitos tem a senha?"); ?>"/>
    				</div>
    				
    				<div>
    					<input type="text" style="width:340px; text-align:center;" class="titulo_block" placeholder="<?php echo $this->lg->_("Preencha um titulo para o pedido de senha."); ?>"/>
    				</div>
    
    				<div class="input">
    					<input type="text" style="text-align:center; width:340px;" class="senha_fixa" placeholder="<?php echo $this->lg->_("Digite uma senha"); ?>"/>
    				</div>
    
    				<div class="select">
    					<select style="width:358px;" class="senha_variavel">
    						<option selected disabled><?php echo $this->lg->_("Escolha uma variavel para ser a senha."); ?></option>
								<option><?php echo $this->lg->_("[nome]"); ?></option>
								<option><?php echo $this->lg->_("[sobrenome]"); ?></option>
								<option><?php echo $this->lg->_("[numero]"); ?></option>
								<option><?php echo $this->lg->_("[celular]"); ?></option>
								<option><?php echo $this->lg->_("[data_nascimento]"); ?></option>
								<option><?php echo $this->lg->_("[email]"); ?></option>
								<option><?php echo $this->lg->_("[cpf]"); ?></option>
								<option><?php echo $this->lg->_("[empresa]"); ?></option>
								<option><?php echo $this->lg->_("[cargo]"); ?></option>
								<option><?php echo $this->lg->_("[telefone_comercial]"); ?></option>
								<option><?php echo $this->lg->_("telefone_residencial]"); ?>[</option>
								<option><?php echo $this->lg->_("[pais]"); ?></option>
								<option><?php echo $this->lg->_("[estado]"); ?></option>
								<option><?php echo $this->lg->_("[cidade]"); ?></option>
								<option><?php echo $this->lg->_("[bairro]"); ?></option>
								<option><?php echo $this->lg->_("[endereço]"); ?></option>
								<option><?php echo $this->lg->_("[cep]"); ?></option>
								<?php for ($i = 1; $i <= 40; $i++) {?>
								<option><?php echo $this->lg->_("[editavel_"); ?><?php echo $i;?>]</option>
								<?php } ?>
    					</select>
    
    				</div>
    
    			</div>
    
    			<div class="config_bt_senha">
    				<a class="cancel-senha bt-senha fecha_senha"><?php echo $this->lg->_("CANCELAR"); ?></a>
    				<a class="submit-senha bt-senha"><?php echo $this->lg->_("SALVAR"); ?></a>
    			</div>
    			
    		</div>
    
    	</div>
    
    </div>
</div>

<script>

	/* calendario */
	$('.horario').on('change', function(){

		$(this).parent().find('.horario').val( $(this).val() );

	});

	$('.open-time').bind('click', function(){

		$(this).parent().find('.hora').focus();
		
	});
	
	$(".hora").mask("99:99");
	$('.hora').bootstrapMaterialDatePicker({
		
		date: false,
		format : 'HH:mm',
		cancelText: 'Cancelar',
		okText: 'OK',
		switchOnClick: true,
		triggerEvent: 'click'
		
	});
		    

	$( '.calendario-inicio' ).datepicker({
		
		dateFormat: 'yy-mm-dd',

		dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Prox',
	    prevText: 'Ant',
		
		onSelect: function() {

			var dataInicio = $('.calendario-inicio').val();
			
			var time = new Date(dataInicio);
			var outraData = new Date();
			outraData.setDate(time.getDate() + 60);

			console.log( outraData );
			
			$( '.calendario-sobre-inicio' ).datepicker("destroy");
			$( '.calendario-sobre-inicio' ).datepicker({ 
				
				minDate: dataInicio, 
				maxDate: outraData,
				dateFormat: 'yy-mm-dd',
				dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
			    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
			    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
			    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			    nextText: 'Prox',
			    prevText: 'Ant'
					
			});

			setTimeout( function(){
				
				$('.calendario-sobre-inicio').val('');
	
				console.log(dataInicio.length );
				
				if ( parseFloat(dataInicio.length) > 1 ) {
	
					$( '.calendario-sobre-inicio' ).removeAttr('disabled');
					$( '.calendario-sobre-inicio' ).focus();
					
				} else {
	
					$( '.calendario-sobre-inicio' ).attr('disabled','true');
					
				}
	
			},500 );
			
		}
		
	});

	$('.mensagem_sms').on('keyup', function(){

		$(this).val( retira_acentos($(this).val()) );
		this.value = this.value.replace(/[^a-zA-Z-0-9.@\[\]!?%$&#*,:; ]/g,'');

	});

	function retira_acentos(str) {

		com_acento = "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝŔÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿŕ\n\r";
		sem_acento = "AAAAAAACEEEEIIIIDNOOOOOOUUUUYRsBaaaaaaaceeeeiiiionoooooouuuuybyr";
		novastr="";
		
		for(i=0; i<str.length; i++) {
			troca=false;
			for (a=0; a<com_acento.length; a++) {
				if (str.substr(i,1)==com_acento.substr(a,1)) {
					novastr+=sem_acento.substr(a,1);
					troca=true;
					break;
				}
			}
			if (troca==false) {
				novastr+=str.substr(i,1);
			}
		}
		
		return novastr;
		
	}
	
	/* mensagens restantes */
	$('.mensagem_sms').keyup(function(){

		var texto = $(this).val();
		var link = $('.link-preview').val();

		$('.balao_mensagem').html(texto+'<br/>'+link);

	});

	var total_permitido = 135;
	$('.restantes b').html(total_permitido);
	$('.mensagem_sms').keyup(function(){

		var total_escrito = total_permitido - $(this).val().length;
		$('.restantes b').html(total_escrito);

		if (total_escrito < 0){

			$('.restantes b').css('color', 'red');

			$(this).parent().parent().find('button[type="submit"]').fadeOut(0);

		} else {

			$('.restantes b').css('color', '#333');

			$(this).parent().parent().find('button[type="submit"]').fadeIn(0);

		}

	});
	
	/* variaveis arrastando */
	$(document).ready( function() {
		
	  $(".variavel").draggable({helper: 'clone'});
	  $("textarea").droppable({
	  	accept: ".variavel",
	    drop: function(ev, ui) {
	      $(this).insertAtCaret(ui.draggable.text());
	    }
	  });
	});

	$.fn.insertAtCaret = function (myValue) {
	  return this.each(function(){
	  //IE support
	  if (document.selection) {
	    this.focus();
	    sel = document.selection.createRange();
	    sel.text = myValue;
	    this.focus();
	  }

	  //MOZILLA / NETSCAPE support
	  else if (this.selectionStart || this.selectionStart == '0') {

		var startPos = this.selectionStart;
	    var endPos = this.selectionEnd;
	    var scrollTop = this.scrollTop;
	    this.value = this.value.substring(0, startPos)+ myValue+ this.value.substring(endPos,this.value.length);
	    this.focus();
	    this.selectionStart = startPos + myValue.length;
	    this.selectionEnd = startPos + myValue.length;
	    this.scrollTop = scrollTop;

	  } else {

	    this.value += myValue;
	    this.focus();

	  }

	  });

	};
	
	
	
	$('.open_editavel').bind('click', function(){

		$('.camp_editaveis').slideToggle();

		$(this).toggleClass('active');

		if (  $( this ).hasClass('active') ) {

			$( this ).find('.fa-plus').removeClass('fa-plus').addClass('fa-minus');

		} else {

			$( this ).find('.fa-minus').removeClass('fa-minus').addClass('fa-plus');
			
		}
		
	});

	function veragora(){
		
		var id_landing = $('.landing_visu').val();

		if (id_landing){

			preview(id_landing);

		} else {

			alert('Selecione um template para visualizar.');

		}

	}

	function linkpreview(){
		
		var id_landing = $('.landing_visu').val();

		$('.link-preview').val('<?php echo $this->GerenciadorCustom->shorturl;?>/l/'+id_landing);

	}

	/* box senha */
	$('.block').on('change', function(){

		var block = $(this).val();

		if (block == 's'){

			$('.tipo_senha').fadeIn(300);

		} else {

			$('.config-minha-senha').remove();

			$('.tipo_senha').fadeOut(300);

		}

	});

	$('.box-cancel .fa-times, input[type="button"], a').bind('click', function(){

		$('.box-cancel').slideUp();

	});

	$('.cancel').bind('click', function(event){

		event.stopPropagation();

		$('.box-cancel').slideDown();

	});

	$('.nome_botao_cancel').on('keyup', function(){

		var nomeBotao = $(this).val();

		$('.cancel span').html(nomeBotao);

	});

	$('.tipo_cancel').on('change', function(){

		var selecionado = $('.tipo_cancel:checked').val();

		if (selecionado == 'final'){

			$('.url_botao_cancel').attr('disabled','true');

		} else {

			$('.url_botao_cancel').removeAttr('disabled');

		}

	});

	$('.botao_cancel').on('change', function(){

		var selecionado = $('.botao_cancel:checked').val();

		if (selecionado == 'nao'){

			$('.nome_botao_cancel').attr('disabled','true');
			$('.url_botao_cancel').attr('disabled','true');
			$('.tipo_cancel').attr('disabled','true');

		} else {

			$('.nome_botao_cancel').removeAttr('disabled');
			$('.url_botao_cancel').removeAttr('disabled');
			$('.tipo_cancel').removeAttr('disabled');

		}

	});

	$('.types').on('change', function(){

		$('.senha_campanha').show(0);
		$('.senha_campanha input, .senha_campanha select').val('');

		var types = $(this).val();

		if (types == 'f'){

			$('.senha_campanha .input').show(0);
			$('.senha_campanha .select').hide(0);

		} else {

			$('.senha_campanha .input').hide(0);
			$('.senha_campanha .select').show(0);

		}

	});

	$('.fecha_senha').bind('click', function(){

		$('#sem_senha').trigger('click');
		$('.config-minha-senha').remove();

	});

	var form;

	$('#uploadfile').change(function (event) {

		var e = $(this);
		form = new FormData();
		form.append('uploadfile', event.target.files[0]);

		$.ajax({
			url: '/<?php echo $this->baseModule;?>/campanha/upload',
			data: form,
			processData: false,
			//contentType: 'multipart/form-data',
			contentType: false,
			type: 'POST',
			//dataType: 'JSON',
			success: function (data) {
				console.log(data);
				e.parent().find('img').attr('src', data);
			}

		});

	});

	$('.img a').bind('click', function(){

		$('#uploadfile').trigger('click');

	});

	$('#cor_senha').on('change', function(){

		var cor = $(this).val();

		$('.box-senha .box_celular').attr('style','background:'+cor+'');

	});

	$('.titulo_block').on('keyup', function(){

		var e = $(this).val();

		$('.box-senha .box_celular .form .titulo').html(e);

		$('.box-senha .box_celular .form > input[type="text"]').attr('placeholder',e);
		

	});

	$('.submit-senha').bind('click', function(){

		if (!$('.types:checked').val()){

			alert('Preencha um tipo de senha.');

		} else if (!$('.titulo_block').val()){

			alert('Preencha um titulo.');

		} else if (!$('.total_senha'.val)){ 

			alert('Preencha uma quantidade para senha.');

		} else {

			if ($('.types:checked').val() == 'v'){

				if (!$('.senha_variavel').val()){

					alert('Selecione uma variavel para ser a senha.');

				} else {

					sendSenha();

				}

			} else {

				if (!$('.senha_fixa').val()){

					alert('Preencha uma senha.');

				} else {

					sendSenha();

				}

			}

		}

	});

	function sendSenha(){

		if ($('.config-minha-senha').length == 0){

			$('#deseja-senha').append('<a class="config-minha-senha">Configurações da senha.</a>');

		}

		$('.bloqueio .tipo_senha').fadeOut(500);

		$('.config-minha-senha').bind('click', function(){

			$('.bloqueio .tipo_senha').fadeIn(500);

		});

	}


	//send campanha
	function salvarCampanha(tipo){
		
		var somente_sms = 'nao';
		var campanha = $('.nome_campanha').val();
		var id_landing = $('.id_landing').val();
		var id_lista = $('.phone').data('lista');
		var mensagem = $('.mensagem_sms').val();
		var block = $('.block:checked').val();
		var types = $('.types:checked').val();
		var titulo_block = $('.titulo_block').val();
		var senha_variavel = $('.senha_variavel').val();
		var senha_fixa = $('.senha_fixa').val();
		var senha_img = $('.box-senha .box_celular .img img').attr('src');
		var senha_bg = $('#cor_senha').val();
		var total_senha = $('.total_senha').val();
		var botao_cancel = $('.botao_cancel:checked').val();
		var nome_botao_cancel = $('.nome_botao_cancel').val();
		var url_botao_cancel = $('.url_botao_cancel').val();
		var tipo_cancel = $('.tipo_cancel:checked').val();
		
		var periodo_inicio = $('.calendario-inicio').val();
		var periodo_final = $('.calendario-sobre-inicio').val();

		var referencia = $('.referencia').val();

		var hora_inicio = $('.hora_inicio').val();
		var hora_final = $('.hora_final').val();

		periodo_inicio = periodo_inicio +' '+ hora_inicio;
		periodo_final = periodo_final +' '+ hora_final;

		console.log('referencia', referencia);
		
		loadPage('true');

		$.ajax({
			url: '/<?php echo $this->baseModule; ?>/campanha/campanhas-avulso-novo',
			type: 'POST',
			data: { referencia:referencia, periodo_inicio:periodo_inicio, periodo_final:periodo_final, nome_botao_cancel:nome_botao_cancel, url_botao_cancel:url_botao_cancel, tipo_cancel:tipo_cancel, botao_cancel:botao_cancel, total_senha:total_senha, senha_img:senha_img, senha_bg:senha_bg, titulo_block:titulo_block, block:block, types:types, senha_variavel:senha_variavel, senha_fixa:senha_fixa, campanha:campanha, somente_sms:somente_sms, id_landing:id_landing, id_lista:id_lista, mensagem:mensagem},
			dataType: 'JSON',
			success: function(row){

				console.log(row);
				if ( row.retorno == 'false' ) {


					$('html, body').animate({
						scrollTop: $(row.classe).offset().top - 200
					}, 1000);

					$(row.classe).focus();

					alertMessage( row.mensagem, row.classe );
					
					loadPage('false');

				} else {

					location.href='<?php echo $this->baseModule;?>/campanha-gerenciamento/enviar/id/'+row.id_campanha;

				}
				

			}, error (data){

				console.log( data.responseText );

			}

		});

	}

	function alertMessage( mensagem, classe ){

		$('.alert-message').remove();
		$(classe).after( ' <div style="clear:both"></div> <div class="alert-message">'+mensagem+'  <i onclick="javascript:$(this).parent().remove();" style="cursor:pointer;" class="fa fa-times"></i></div> <div style="clear:both"></div>' );
		
	}
	
</script>

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>