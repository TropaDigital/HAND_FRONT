<?php

class operadora {
	
	var $post;
	var $instancia;
	
	public function __construct($operadora, $post)
	{
		
		$this->post = $post;
		
		if ($operadora == 'tww'):
		
			include_once 'app/models/operadora/twwClass.php';
			$this->instancia = new tww($login, $senha);
		
		elseif ($operadora == 'zoug'):
		
			include_once 'app/models/operadora/zougClass.php';
			$this->instancia = new zoug($login, $senha);
		
		endif;
		
	}
	
	public function newUsuario()
	{
		
		$retorno = $this->instancia->newUsuario($this->post);
		return $retorno;
		
	}
	
	public function editUsuario()
	{
	
		$retorno = $this->instancia->editUsuario($this->post);
		return $retorno;
	
	}
	
	public function saldoUsuario()
	{
	
		$retorno = $this->instancia->saldoUsuario($this->post);
		return $retorno;
	
	}
	
	public function enviarSms($dados)
	{
	
		$retorno = $this->instancia->enviarSms($dados);
		return $retorno;
	
	}
	
}