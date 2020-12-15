<?php include 'topo_painel.php'; ?>
	
	<form class="div_content" method="post" action="/painel/planos/remover">
	
		<table class="table-edicao">
				
			<tr>
				<th width="10"><i class="fa fa-trash"></i></th>
				<th width="90">Edição</th>
				<th>Usuário</th>
				<th>Mensagem</th>
				<th>Nivel</th>
				<th width="100">Data</th>
			</tr>
					
			<?php foreach($this->result as $row){?>
			<tr>
				<td><input value="<?php echo $row->id_plano; ?>" type="checkbox" name="id[]"/></td>
				<td><a href="/painel/notificacoes/editar/id/<?php echo $row->id_notificacao; ?>" class="edicao-bt"><i class="fa fa-pencil-square-o" ></i> EDITAR</a></td>
				<td><?php echo $row->name_user == NULL ? 'Geral' : $row->name_user; ?></td>
				<td><?php echo $row->mensagem; ?></td>
				<td><?php echo $row->nivel; ?></td>
				<td><?php echo date('d/m/Y', strtotime($row->criado)); ?></td>
			</tr>
			<?php } ?>
					
		</table>
		
		<div id="control-bottom">
			<button type="submit" class="bt-cinza"><i class="fa fa-trash"></i> Excluir</button>
			<a class="bt-cinza" href="/painel/notificacoes/novo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nova notificação</a>
		</div>
	
	</form>
		

<?php include 'rodape_painel.php'; ?>