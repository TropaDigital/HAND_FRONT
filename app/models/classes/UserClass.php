<?php

include_once 'app/models/db.php';
include_once 'app/models/Model_Data.php';

class UserClass {
	
	protected $db;
	protected $config;
	
	public function __construct($db, $config)
	{
		
		$this->db = $db;
		$this->config = $config;
		
	}
	
	public function get($filter=array())
	{
		
		$sql = new Zend_Db_Select($this->db);
		$sql->from(array('USUARIO'=>$this->config->tb->usuarios),array('*'));
		
			$sql->joinLeft(array('LOGIN'=>$this->config->tb->login),
				'USUARIO.id_usuario = LOGIN.id_usuario',array('*'));
			
			if ($filter['where']){
				$sql->where($filter['where']);
			}
		
		$sql = $sql->query(Zend_Db::FETCH_OBJ);
		return $sql->fetchAll();
		
	}
	
	public function newUsuario($post)
	{
		
		return $this->uptUsuario($post);
		
	}
	
	public function editUsuario($id, $post)
	{
		
		return $this->uptUsuario($post, $id);
		
	}
	
	protected function uptUsuario($post, $id = NULL)
	{
		
		$this->data = new Model_Data(new usuarios());
		$this->data->_required(array('id_usuario', 'id_plano', 'name_user', 'empresa', 'cnpj', 'email', 'telefone', 'creditos', 'tww', 'login_envio', 'senha_envio', 'modificado', 'criado'));
		$this->data->_notNull(array());
		
		if ($id){
			$sql = $this->data->edit($id,$post,NULL,Model_Data::ATUALIZA);
		} else {
			$sql = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
		}
		
		return $sql;
		
	}
	
	public function newLogin($post)
	{
		
		return $this->uptLogin($post);
		
	}
	
	public function editLogin($login, $post)
	{
		
		return $this->uptLogin($post, $login);
		
	}
	
	protected function uptLogin($post, $login = NULL)
	{
	
		$this->data = new Model_Data(new login());
		$this->data->_required(array('id_login', 'id_gerenciado', 'login', 'id_usuario', 'senha', 'nivel', 'ativo', 'email', 'criado'));
		$this->data->_notNull(array());
		
		if ($login){
			$sql = $this->data->edit($login,$post,NULL,Model_Data::ATUALIZA);
		} else {
			$sql = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
		}
		
		return $sql;
	
	}
	
	public function permissoesUser($id_usuario, $permissoes=array())
	{
		
		$this->data = new Model_Data(new usuarios_permissoes());
		$this->data->_required(array('id_permissao_usuario', 'id_permissao', 'id_usuario', 'modificado', 'criado'));
		$this->data->_notNull(array());
		
		$this->data->_table()->getAdapter()->query('DELETE FROM zz_usuarios_permissoes WHERE id_usuario = "'.$id_usuario.'"');
		
		foreach($permissoes as $key => $row){
			
			$post['id_usuario'] = $id_usuario;
			$post['id_permissao'] = $this->permissaoId($key);
			
			if ($row == 'true')
				$sql = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
			
		}
		
		
	}
	
	protected function permissaoId($name)
	{
		 
		$array = array(
				'permissao_criar_template'=>1,
				'permissao_campanhas_submenu'=>2,
				'permissao_nova_campanha_template'=>20,
				'permissao_nova_campanha_template_avulso'=>21,
				'permissao_nova_campanha_sms'=>4,
				'permissao_minhas_campanhas'=>5,
				'permissao_meus_templates'=>6,
				'permissao_contatos_submenu'=>7,
				'permissao_lista_de_contatos'=>8,
				'permissao_importacao'=>9,
				'permissao_caixa_de_entrada'=>10,
				'permissao_relatorios_submenu'=>11,
				'permissao_relatorios_respostas_sms'=>12,
				'permissao_relatorio_de_sms'=>13
		);
		 
		return $array[$name];
		 
	}
	
}