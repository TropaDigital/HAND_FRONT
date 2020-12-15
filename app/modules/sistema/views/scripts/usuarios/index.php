<?php include 'topo_painel.php'; ?>
	
	<div class="div_content">
	
		<form id="control-top">
			
			<label class="text">
				<input name="u" type="text" value="<?php echo $_GET['u'];?>"/>
				<span>Usuário</span>
			</label>
			
			<label class="calendario">
				<input name="pi" class="calendario" type="text" value="<?php echo $_GET['pi'];?>"/>
				<span>Periodo inicial</span>
			</label>
			
			<label class="calendario">
				<input name="pf" class="calendario" type="text" value="<?php echo $_GET['pf'];?>"/>
				<span>Periodo final</span>
			</label>
			
			<label>
				<input type="submit" value="Buscar"/>
			</label>
					
		</form>
	
		<table class="table-edicao">
				
			<tr>
				<th width="85">Edição</th>
				<th width="90"><i class="fa fa-line-chart" aria-hidden="true"></i> Campanhas</th>
				<th width="90"><i class="fa fa-line-chart" aria-hidden="true"></i> Plano(s)</th>
				<th width="70">Status</th>
				<th width="90">Source Adress</th>
				<th><i class="fa fa-user"></i> User</th>
				<th><i class="fa fa-user"></i> Empresa</th>
				<th width="120"><i class="fa fa-calendar"></i> Data de criação</th>
			</tr>
					
			<?php foreach($this->result as $row){?>
			<tr class="ativo_<?php echo $row->nivel;?>">
				<td><a href="/painel/usuarios/editar-usuario/id/<?php echo $row->id_usuario; ?>" class="edicao-bt"><i class="fa fa-pencil-square-o" ></i> EDITAR</a></td>
				<td><a href="<?php echo $row->total_campanha == 0 ? 'javascript:alert(\'Esse usuário não tem nenhuma campanha\');' : '/painel/usuarios/campanhas/id/'.$row->id_usuario.'';?>" class="edicao-bt">CAMPANHAS</a></td>
				<td><a href="javascript:plano(<?php echo $row->id_usuario;?>);" class="edicao-bt">PLANO(S)</a></td>
				<td>
					<div data-nomes="on,off" data-id="<?php echo $row->login; ?>" data-action="/painel/usuarios/altera-status/" data-status="<?php echo $row->ativo == 0 ? 'off' : 'on'; ?>" class="bt-status">
						<span></span>
						<div class="circle"></div>
					</div>
				</td>
				<td><?php echo $row->source_addr_sms; ?></td>
				<td><?php echo $row->login; ?></td>
				<td><?php echo $row->empresa; ?></td>
				<td><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($row->criado)); ?></td>
			</tr>
			<?php } ?>
					
		</table>
		
		<div id="control-bottom">
			<a class="bt-cinza" href="/painel/usuarios/novo-usuario"><i class="fa fa-plus-circle" aria-hidden="true"></i> Novo usuário</a>
		</div>
		
	</div>
	

<?php include 'rodape_painel.php'; ?>