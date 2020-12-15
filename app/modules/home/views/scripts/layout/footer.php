	<!--  NOVA LISTA -->
	<div class="modal-bg" id="novo-grupo">
		<div class="modal">
		
			<div class="top cor_b">
				<span class="titulo">
					<i class="fa fa-list-ul"></i> Nova lista
					
					<a class="fechar" onclick="modal('novo-grupo');">
						<i class="fa fa-times"></i>
					</a>
				</span>
			</div>
			
			<div class="box">
				<form method="post" action="javascript:novo_lista();">
					<input type="text" class="nome_lista" style="width:100%" placeholder="Nome da lista">
					<button type="submit" class="bt_verde cor_c_hover"><i class="fa fa-plus-circle"></i> Adicionar</button>
				</form>
			</div>
			
			<div class="load_lista" style="width:100%; max-height:113px; float:left; overflow:hidden"></div>
		</div>
	</div>
	
	<!-- NOVO CONTATO MODAL -->
	<div class="modal-bg" id="adicionar-contatos">
		<div class="modal">
		
			<div class="top cor_b">
				<span class="titulo">
				
					<i class="fa fa-user-plus"></i> Adicionar contatos
					
					<a class="fechar" onclick="modal('adicionar-contatos');">
						<i class="fa fa-times"></i>
					</a>
					
				</span>
			</div>
			
			<div class="box">
				<form method="post" action="javascript:novo_contato();">
					<input type="text" class="nome nome_contato" placeholder="Nome">
					<input type="text" class="sobrenome_contato" placeholder="Sobrenome">
					<input type="text" required class="celular celular_contato" placeholder="Celular" style="width:29%;">
					
					<div class="lista ajax_lista" id="novocontato" style="float:left; width:46%; margin-top:4px; margin-right:9px;"></div>
				
					<button style="float:right;" type="submit" class="bt_verde cor_c_hover"><i class="fa fa-plus-circle"></i> Adicionar</button>
				</form>
			</div>
			
			<div style="width:100%; max-height:111px; float:left; overflow:hidden">
				<div class="load_contatos" style="width:100%; max-height:113px; float:left; overflow:hidden"></div>
			</div>
			
		</div>
	</div>
	
	<script src="assets/home/js/funcoes.js?v=<?php echo $versao;?>" type="text/javascript"></script>
    <?php 
    
    	$this->jsPag = str_replace('site','home',str_replace('/'.$this->GerenciadorCustom->slug, '', $this->jsPag)); 
    	$this->jsPag = str_replace('view/'.$this->me->id_usuario, 'home', $this->jsPag);
    	echo str_replace('.js', '.js?v='.$versao, $this->jsPag);
    
    ?>
    
    <script>
	    $(function(){
			$("#message").delay("6000").fadeOut();
			$("#message").click( function(){ $("#message").stop().fadeOut(); });
			$('.div_content select').select2();
		});
    </script>
	
</body>
</html>