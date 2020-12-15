<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
	
		<table class="table-edicao">
				
			<tr class="cor_b">
				<th width="85">Edição</th>
				<th width="70">Login</th>
				<th width="90">Senha</th>
			</tr>
					
			<?php foreach($this->result as $row){?>
			<tr>
				<td><a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/editar-usuario/id/<?php echo $row->id_usuario; ?>" class="edicao-bt"><i class="fa fa-pencil-square-o" ></i> EDITAR</a></td>
				<td><?php echo $row->login_envio; ?></td>
				<td><?php echo $row->senha_envio; ?></td>
			</tr>
			<?php } ?>
					
		</table>
		
		<div id="control-bottom">
			<a class="new-bt cor_c_hover" href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/novo-usuario"><i class="fa fa-plus-circle" aria-hidden="true"></i> Novo usuário</a>
		</div>
		
	</div>
	

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>