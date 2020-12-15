<?php

class tww {
	
	public $login = 'zznaiche2';
	public $senha = 'funknovo';
	
	public function __construct($login = null, $senha = null)
	{
		
		if ($login && $senha){
			
			$this->login = $login;
			$this->senha = $senha;
			
		}
		
	}
	
	public function enviarSms($dados)
	{
		
		// AJEITA O CELULAR
		$dados['Celular'] = str_replace(' ', '', $dados['Celular']);
		$dados['Celular'] = str_replace('(', '', $dados['Celular']);
		$dados['Celular'] = str_replace(')', '', $dados['Celular']);
		$dados['Celular'] = str_replace('-', '', $dados['Celular']);
		
		// RETIRA ACENTOS DA MENSAGEM
		$dados['Mensagem'] = preg_replace(array("/(ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c a A e E i I o O u U n N"),$dados['Mensagem']);
		
		// USUARIO
		$dados['NumUsu'] = $this->login;
		
		// SENHA
		$dados['Senha'] = $this->senha;
		
		// URL API
		$url = 'http://webservices2.twwwireless.com.br';
		
		// RESOURCE API
		$api = '/reluzcap/wsreluzcap.asmx/EnviaSMS?';
		
		// REQUEST, CONVERTE ARRAY EM GET
		$request = http_build_query($dados);
	
		// JUNTA A URL INTEIRA DA API E ACESSA
		$file = file_get_contents($url.$api.$request);
		
		echo $url.$api.$request; exit;
		
		$xml = simplexml_load_string($file);
		$retornoXml = $xml[0];
		
		// RETORNA A URL
		return $retornoXml[0];
	
	}
	
	public function delSms($dados)
	{
	
		// USUARIO
		$dados['NumUsu'] = $this->login;
		
		// SENHA
		$dados['Senha'] = $this->senha;
	
		// URL API
		$url = 'http://webservices2.twwwireless.com.br';
	
		// RESOURCE API
		$api = '/reluzcap/wsreluzcap.asmx/DelSMSAgenda?';
	
		// REQUEST, CONVERTE ARRAY EM GET
		$request = http_build_query($dados);
	
		// JUNTA A URL INTEIRA DA API E ACESSA
		$file = file_get_contents($url.$api.$request);
	
		$xml = simplexml_load_string($file);
		$retornoXml = $xml[0];
	
		// RETORNA A URL
		return $retornoXml[0];
	
	}
	
	public function enviarLote($xml)
	{
	
		// RETIRA ACENTOS DA MENSAGEM
		$dados['Mensagem'] = preg_replace(array("/(ç)/","/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","c a A e E i I o O u U n N"),$dados['Mensagem']);
	
		// USUARIO
		$dados['NumUsu'] = $this->login;
		
		// SENHA
		$dados['Senha'] = $this->senha;
		
		// XML
		$dados['StrXML'] = $xml;
	
		// URL API
		$url = 'http://webservices2.twwwireless.com.br';
	
		// RESOURCE API
		$api = '/reluzcap/wsreluzcap.asmx/EnviaSMSXML?';
	
		// REQUEST, CONVERTE ARRAY EM GET
		$request = http_build_query($dados);
	
		// JUNTA A URL INTEIRA DA API E ACESSA
		$urlFinal = $url.$api.$request;
		
		// CODIFICA O POST
		$postdata = http_build_query($dados);
		
		$context = stream_context_create(array(
		    'http' => array(
		        'method' => 'POST',
		        'content' => $postdata,
		        'header' => "Content-type: application/x-www-form-urlencoded\r\n"
		        . "Content-Length: " . strlen($postdata) . "\r\n",
		    )
		));
		
		// FILE GET CONTENTS
		$file = file_get_contents($urlFinal, false, $context);
		
		// RETORNO EM XML
		$xml = simplexml_load_string($file);
		$retornoXml = $xml[0];
	
		// RETORNA A URL
		return $retornoXml[0];
	
	}
	
	public function creditos()
	{
		
		// USUARIO
		$dados['NumUsu'] = $this->login;
		
		// SENHA
		$dados['Senha'] = $this->senha;
		
		$url = 'http://webservices2.twwwireless.com.br';
		
		// RESOURCE API
		$api = '/reluzcap/wsreluzcap.asmx/VerCredito?';
		
		// REQUEST, CONVERTE ARRAY EM GET
		$request = http_build_query($dados);
		
		// JUNTA A URL INTEIRA DA API E ACESSA
		$file = file_get_contents($url.$api.$request);
		
		$xml = simplexml_load_string($file);
		$retornoXml = $xml[0];
		
		return $retornoXml;
		
	}
	
	public function creditosValidade()
	{
		
		// USUARIO
		$dados['NumUsu'] = $this->login;
		
		// SENHA
		$dados['Senha'] = $this->senha;
		
		$url = 'http://webservices2.twwwireless.com.br';
		
		// RESOURCE API
		$api = '/reluzcap/wsreluzcap.asmx/VerValidade?';
		
		// REQUEST, CONVERTE ARRAY EM GET
		$request = http_build_query($dados);
		
		// JUNTA A URL INTEIRA DA API E ACESSA
		$file = file_get_contents($url.$api.$request);
		
		$xml = simplexml_load_string($file);
		$retornoXml = $xml[0];
		
		return $retornoXml;
		
	}
	
}