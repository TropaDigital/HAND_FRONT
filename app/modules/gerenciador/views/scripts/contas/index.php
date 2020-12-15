<?php include_once dirname(__FILE__).'/../layout/header.php';?>
<?php include_once dirname(__FILE__).'/../layout/section.php';?>
	
	<div id="central">
	
		<table class="table-edicao">
				
			<tr class="cor_b">
				<th width="95">Visualizar</th>
				<th width="85">Edição</th>
				<th width="70">Créditos</th>
				<th width="70">Status</th>
				<th width="90">LOGIN ENVIO</th>
				<th><i class="fa fa-user"></i> User</th>
				<th><i class="fa fa-user"></i> Empresa</th>
				<th width="120"><i class="fa fa-calendar"></i> Data de criação</th>
			</tr>
					
			<?php foreach($this->result as $row){?>
			<tr class="ativo_<?php echo $row->nivel;?>">
				<td><a target="_blank" href="/view/<?php echo $row->id_usuario;?>/<?php echo $this->GerenciadorCustom->slug;?>">Visualizar usuario</a></td>
				<td><a href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/editar-usuario/id/<?php echo $row->id_usuario; ?>/id_login/<?php echo $row->id_login?>" class="edicao-bt"><i class="fa fa-pencil-square-o" ></i> EDITAR</a></td>
				
				<td style="text-align:center;">
					<a style="margin:5px 0px 0px 0px;" class="new-bt cor_c_hover" href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/creditos/id/<?php echo $row->id_usuario;?>">Gerenciar</a>
				</td>
				
				<td>
					<?php echo $row->ativo == 1 ? 'Ativo' : 'Inativo';?>
				</td>
				<td><?php echo $row->login_envio; ?></td>
				<td><?php echo $row->login; ?></td>
				<td><?php echo $row->empresa; ?></td>
				<td><i class="fa fa-calendar"></i> <?php echo date('d/m/Y', strtotime($row->criado)); ?></td>
			</tr>
			<?php } ?>
					
		</table>
		
		<div id="control-bottom">
			<a class="new-bt cor_c_hover" href="/<?php echo $this->baseModule;?>/<?php echo $this->baseController;?>/novo-usuario"><i class="fa fa-plus-circle" aria-hidden="true"></i> Novo usuário</a>
		</div>
		
	</div>
	

<?php include_once dirname(__FILE__).'/../layout/footer.php';?>