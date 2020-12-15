<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class RelatoriosController extends My_Controller 
{
	
	public function ini()
	{
    	$this->view->tituloPag 	= 'Relatórios';
    	$this->view->jsPag = '<link rel="stylesheet" type="text/css" href="assets/site/css/relatorios.css">
    			<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    			<script src="assets/home/js/relatorios.js"></script>';
    	
    	$params = $this->_request->getParams();
    	$this->view->id = $this->id = $params['id'];
    	
	}

	public function enviosSinteticoAction()
	{
	
	    $get = $this->_request->getParams();
	
	    if ( empty($get['didf']) ){
    	    if ( empty($get['d_i']) ){
    	        $get['d_i'] = date('Y-m-d');
    	    }
    	    
    	    if ( empty($get['d_f']) ){
    	        $get['d_f'] = date('Y-m-d');
    	    }
	    }
	    
	    // FILTRO POR USUARIOS
        $id_usuario = implode(',', $this->me->familia);
	    
	    $campanhas = new campanhas();
	    $this->view->campanhas = $campanhas->fetchAll('id_usuario IN ('.$id_usuario.')');
	         
	    $camp = array();
	    foreach ( $this->view->campanhas as $row ) {
	        $camp[$row->id_campanha] = $row->campanha;
	    }
	    
	    $this->view->camp = $camp;
        
        $url = $this->view->backend.'api/relatorios/get-sintetico?id_usuario='.$id_usuario;

        $filter_get = $get;

        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){
            	
            $filter_get['limit'] = 10;
            	
        } else {
            	
            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){

                $filter_get['limit'] = 10;

            }
            	
        }

        if ( $get['download'] ) {
            $filter_get['limit'] = 10000;
        }

        $filter_get['order'] = 'id_sms_enviado-desc';
        unset($filter_get['whitelabel']);
        unset($filter_get['id_usuario']);

        $filter = http_build_query ( $filter_get );

        $url = $url.'&'.$filter;
        
        if ( $_GET['admin'] ) {
            echo $url;
            echo '<br/>';
            echo 'acessando a url acima:';
            echo file_get_contents( $url );
            exit;
        }

        $file = json_decode( file_get_contents( $url ) );

        $this->view->result = $file;

        $this->enviosSinteticoDownload($this->view->result, $get, ';');

//         		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;
	
	}
	
	private function enviosSinteticoDownload( $result, $get, $formato )
	{
	
	    if ( $get['download'] ) {
	        	
	        if ( $get['arquivo'] != '' ) {
	
	            $name = $get['arquivo'];
	
	        } else {
	
	            $name = time().$this->me->id_usuario.'.csv';
	
	        }
	        	
	        $root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
	        	
	        // ABRE/CRIA O ARQUIVO
	        $fp = fopen($root.$name, 'a');
	        	
	        // INICIA A VARIAVEL DO CSV
	        $csv = NULL;
	        	
	        // MONTA O TOPO DO ARQUIVO
	        if ( $get['p'] == 1 ) {
	
	            $csv .= 'ID';
	            $csv .= $formato;
	            $csv .= 'CAMPANHA';
	            $csv .= $formato;
	            $csv .= 'FILA';
	            $csv .= $formato;
	            $csv .= 'ERROS';
	            $csv .= $formato;
	            $csv .= 'ENVIOS';
	            $csv .= $formato;
	            $csv .= 'ENTREGUES';
	            $csv .= $formato;
	            $csv .= 'NAO ENTREGUES';
	            $csv .= $formato;
	            $csv .= 'ABERTURAS';
	            $csv .= PHP_EOL;
	
	        }
	        	
	        foreach ( $result->registros as $row ):
	
	        $csv .= $row->id_campanha;
	        $csv .= $formato;
	
	        $csv .= strip_tags($row->campanha);
	        $csv .= $formato;
	
	        $csv .= $row->fila;
	        $csv .= $formato;
	
	        $csv .= $row->erros;
	        $csv .= $formato;
	        
	        $csv .= $row->envios;
	        $csv .= $formato;
	        
	        $csv .= $row->entregues;
	        $csv .= $formato;
	        
	        $csv .= $row->nao_entregues;
	        $csv .= $formato;
	        
	        $csv .= $row->aberturas;
	        $csv .= PHP_EOL;
	
	        endforeach;
	        	
	        fwrite($fp, $csv);
	        fclose($fp);
	        	
	        if ( $get['p'] == $result->total_page ) {
	            $refresh = '0';
	        } else {
	            $refresh = '1';
	        }
	        	
	        $retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
	        	
	        echo json_encode( $retorno ); exit;
	        	
	    }
	
	}
	
	public function enviosAction()
	{
		
		$get = $this->_request->getParams();
		
// 		$get['status'] = $get['status'] == 'PEND' ? '' : $get['status'];
		
	    if ( empty($get['didf']) ){
    	    if ( empty($get['d_i']) ){
    	        $get['d_i'] = date('Y-m-d');
    	    }
    	    
    	    if ( empty($get['d_f']) ){
    	        $get['d_f'] = date('Y-m-d');
    	    }
	    }
		
		// SELECT
    	$relatorio = new Zend_Db_Select($this->db);
    	$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'))
    	 
    		->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
    			'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'))
    			 
    		->where('ENVIO.status = "Campanha enviada" ')
    		->where('id_usuario IN ('. implode(',', $this->me->familia) .')');
    			 
    	$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
    	$this->view->campanhas = $relatorio->fetchAll();
    	
    	if ( !$get['id_usuario'] ) {
    		$get['id_usuario'] = array('0'=>'0');
    	}
    	
    	// FILTRO POR USUARIOS
    	if ( !array_diff ( $get['id_usuario'], $this->me->familia ) ){
    		$id_usuario = implode(',', $get['id_usuario']);
    	} else {
    		$id_usuario = implode(',', $this->me->familia);
    	}
    	
		$url = $this->view->backend.'api/relatorios/get-envios?id_usuario='.$id_usuario;
		
// 		die( $url );
		
		$filter_get = $get;
		
		// FILTRO DE LIMITE
		if ( $get['limit'] == NULL  ){
			
			$filter_get['limit'] = 10;
			
		} else {
			
			if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
				
				$filter_get['limit'] = 10;
				
			}
			
		}
		
		if ( $get['download'] ) {
			$filter_get['limit'] = 10000;
		}
		
		$filter_get['order'] = 'id_sms_enviado-desc';
		unset($filter_get['whitelabel']);
		unset($filter_get['id_usuario']);
		
		$filter = http_build_query ( $filter_get );
		
		$url = $url.'&'.$filter;
		
		if ( $_GET['admin'] ) {
			echo $url;
			echo '<br/>';
			echo 'acessando a url acima:';
			echo file_get_contents( $url );
			exit;
		}
		
		$file = json_decode( file_get_contents( $url ) );
		
		$this->view->result = $file;
		
// 		die('aaaa');
		
// 		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;
		$this->enviosDownload($this->view->result, $get, ';', $url);
		
		
	}
	
	private function enviosDownload( $result, $get, $formato, $url )
	{
	
	    
// 	    header("Content-Type: text/html; charset=ISO-8859-1",true);
// 	    echo $url; exit;
// 	    echo '<pre>'; print_r( $result ); exit;
	    
		if ( $get['download'] ) {
		    
			if ( $get['arquivo'] != '' ) {
				
				$name = $get['arquivo'];
				
			} else {
				
				$name = time().$this->me->id_usuario.'.csv';
				
			}
			
			$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
			
			// ABRE/CRIA O ARQUIVO
			$fp = fopen($root.$name, 'a');
			
			// INICIA A VARIAVEL DO CSV
			$csv = NULL;
			
			// MONTA O TOPO DO ARQUIVO
			if ( $get['p'] == 1 ) {
				
				$csv .= 'CELULAR';
				$csv .= $formato;
				$csv .= 'CAMPANHA';
				$csv .= $formato;
				$csv .= 'MENSAGEM';
				$csv .= $formato;
				$csv .= 'STATUS';
				$csv .= $formato;
				$csv .= 'ABERTO';
				$csv .= $formato;
				$csv .= 'REFERENCIA';
				$csv .= $formato;
				$csv .= 'DATA DE ENVIO';
				$csv .= $formato;
				$csv .= 'DATA DE STATUS';
				$csv .= PHP_EOL;
				
			}
			
			$status = [];
			$status['ESME_ROK'] = 'Enviada';
			$status['ACCEPTD'] = 'Enviada';
			$status['DELIVRD'] = 'Entregue';
			$status['UNDELIV'] = 'Não entregue';
			$status['EXPIRED'] = 'Expirada';
			$status['REJECTED'] = 'Não aberto';
			
			foreach ( $result->registros as $row ):
			
				$horas = NULL;
				$datatime1 = new DateTime( $row->data_lote );
				$datatime2 = new DateTime( date('Y-m-d H:i:s') );
				
				$data1  = $datatime1->format('Y-m-d');
				$data2  = $datatime2->format('Y-m-d');
				
				$diff = $datatime1->diff($datatime2);
				$horas = $diff->h + ($diff->days * 24);
				
				// CELULAR
				$csv .= $row->celular;
				$csv .= $formato;
				
				// CAMPANHA
				$csv .= strip_tags($row->campanha);
				$csv .= $formato;
				
				// MENSAGEM
				$msg = $row->mensagem;
				$msg = strip_tags($msg);
				$msg = str_replace(PHP_EOL, '', $msg);
				$msg = str_replace('\n', '', $msg);
				$msg = str_replace('[zig=interrogazao]', '?', $msg);
				
				$csv .= $msg;
				$csv .= $formato;
				
				// RENOMEIA O STATUS PARA FICAR IGUAL AO DO ZIGZAG
				$csv .= $status[$row->status];
				$csv .= $formato;
				
				// REJEITADO
				$csv .= $row->rejeicao_data == NULL ? 'Nao' : 'Sim';
				$csv .= $formato;
				
				// REFERENCIA
				$csv .= $row->referencia == '' ? 'N/A' : $row->referencia;
				$csv .= $formato;
				
				
				// DATA ENVIADO
				$csv .= date('d-m-Y H:i', strtotime( $row->data_lote ) );
				$csv .= $formato;
			
				// DATA RECIBO
				if ( $row->data_recibo == NULL && $horas >= 24 ) {
				
					if ( date('Y-m-d H:i') < $row->data_lote ) {
						$csv .= 'Agendado para: '.str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
					} else {
						$csv .= str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_lote ) ) );
					}
						
				} else {
						
					$csv .= $row->data_recibo == NULL ? 'Sem informacoes' : str_replace('-', '/', date('d-m-Y H:i', strtotime( $row->data_recibo ) ) );
						
				}
				$csv .= $formato;
				$csv .= PHP_EOL;
				
			endforeach;
			
			fwrite($fp, $csv);
			fclose($fp);
			
			if ( $get['p'] == $result->total_page ) {
				$refresh = '0';
			} else {
				$refresh = '1';
			}
			
			$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
			
			echo json_encode( $retorno ); exit;
			
		}
		
	}
	
	public function duplicadosAction()
	{
	
		$get = $this->_request->getParams();
	
		// SELECT
		$relatorio = new Zend_Db_Select($this->db);
		$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'))
	
			->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
				'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'))
	
			->where('ENVIO.status = "Campanha enviada" ')
			->where('id_usuario IN ('. implode(',', $this->me->familia) .')');
	
		$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
		$this->view->campanhas = $relatorio->fetchAll();
	
		$url = $this->view->backend.'api/relatorios/get-duplicados?id_usuario='.$this->me->id_usuario;
	
		$filter_get = $get;
	
		// FILTRO DE LIMITE
		if ( $get['limit'] == NULL  ){
						
			$filter_get['limit'] = 10;
						
		} else {
						
			if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
				$filter_get['limit'] = 10;
			}
						
		}
	
		if ( $get['download'] ) {
			$filter_get['limit'] = 10000;
		}
	
		$filter_get['order'] = 'id_sms_enviado-desc';
		unset($filter_get['whitelabel']);
	
		$filter = http_build_query ( $filter_get );
	
		$url = $url.'&'.$filter;
		
		$file = json_decode( file_get_contents( $url ) );
		$this->view->result = $file;
		
		$this->duplicadosDownload($this->view->result, $get, ';');
	
	
	}
	
	private function duplicadosDownload( $result, $get, $formato )
	{
	
		if ( $get['download'] ) {
				
			if ( $get['arquivo'] != '' ) {
	
				$name = $get['arquivo'];
	
			} else {
	
				$name = time().$this->me->id_usuario.'.csv';
	
			}
				
			$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
				
			// ABRE/CRIA O ARQUIVO
			$fp = fopen($root.$name, 'a');
				
			// INICIA A VARIAVEL DO CSV
			$csv = NULL;
				
			// MONTA O TOPO DO ARQUIVO
			if ( $get['p'] == 1 ) {
	
				$csv .= 'CELULAR';
				$csv .= $formato;
				$csv .= 'CAMPANHA';
				$csv .= $formato;
				$csv .= 'MENSAGEM';
				$csv .= $formato;
				$csv .= 'QUANTIDADE DE ENVIOS';
				$csv .= $formato;
				$csv .= 'DATA DE ENVIO';
				$csv .= $formato;
				$csv .= PHP_EOL;
	
			}
				
			foreach ( $result->registros as $row ):
				
				// CELULAR
				$csv .= $row->celular;
				$csv .= $formato;
		
				// CAMPANHA
				$csv .= $row->campanha;
				$csv .= $formato;
		
				// MENSAGEM
				$csv .= $row->mensagem;
				$csv .= $formato;
		
				// QUANTIDADE DE ENVIOS
				$csv .= $row->linha;
				$csv .= $formato;
				
				// DATA ENVIADO
				$csv .= date('d-m-Y H:i', strtotime( $row->data_lote ) );
				$csv .= $formato;
					
				$csv .= PHP_EOL;
	
			endforeach;
				
			fwrite($fp, $csv);
			fclose($fp);
				
			if ( $get['p'] == $result->total_page ) {
				$refresh = '0';
			} else {
				$refresh = '1';
			}
				
			$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
				
			echo json_encode( $retorno ); exit;
				
		}
	
	}
	
	public function cliquesAction()
	{
	
		$get = $this->_request->getParams();
	
		// SELECT
		$relatorio = new Zend_Db_Select($this->db);
		$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));
	
		$relatorio->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
			'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'));
	
		$relatorio->where('ENVIO.status = "Campanha enviada" ');
		$relatorio->where('id_usuario IN ('. implode(',', $this->me->familia) .')');
	
		$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
		$this->view->campanhas = $relatorio->fetchAll();

        $this->view->campanhaNome = array();
        foreach( $this->view->campanhas as $row ){
            $this->view->campanhaNome[$row->id_campanha] = $row->campanha;
        }
	
		$url = $this->view->backend.'api/relatorios/get-cliques?id_usuario='.$this->me->id_usuario;
	
		$filter_get = $get;

		// FILTRO DE LIMITE
		if ( $get['limit'] == NULL  ){
				
			$filter_get['limit'] = 10;
				
		} else {
				
			if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){

				$filter_get['limit'] = 10;

			}
				
		}

		if ( $get['download'] ) {
			$filter_get['limit'] = 10000;
		}

		$filter_get['order'] = 'criado-desc';
		unset($filter_get['whitelabel']);

		$filter = http_build_query ( $filter_get );

		$url = $url.'&'.$filter;
		
		if ( $_GET['admin'] ) {
			echo $url; exit;
		}

		$file = json_decode( file_get_contents( $url ) );
		$this->view->result = $file;

		$this->cliquesDownload($this->view->result, $get, ';', $this->view->nome[0]->campanha);

// 		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;
	
	}
	
	private function cliquesDownload( $result, $get, $formato, $campanha )
	{
	
		if ( $get['download'] ) {
				
			if ( $get['arquivo'] != '' ) {
	
				$name = $get['arquivo'];
	
			} else {
	
				$name = time().$this->me->id_usuario.'.csv';
	
			}
				
			$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
				
			// ABRE/CRIA O ARQUIVO
			$fp = fopen($root.$name, 'a');
				
			// INICIA A VARIAVEL DO CSV
			$csv = NULL;
				
			// MONTA O TOPO DO ARQUIVO
			if ( $get['p'] == 1 ) {
	
				$csv .= 'CELULAR';
				$csv .= $formato;
				$csv .= 'CAMPANHA';
				$csv .= $formato;
				$csv .= 'URL DA ACAO';
				$csv .= $formato;
				$csv .= 'ACAO';
				$csv .= $formato;
				$csv .= 'DATA';
				$csv .= PHP_EOL;
	
			}
				
			foreach ( $result->registros as $row ):
				
				// CELULAR
				$csv .= $row->contato;
				$csv .= $formato;
		
				// CAMPANHA
				$csv .= $campanha;
				$csv .= $formato;
		
				// AÇÃO
				$csv .= $row->acao;
				$csv .= $formato;
				
				// URL DA AÇÃO
				$csv .= $row->tipo_acao;
				$csv .= $formato;
		
				// DATA ENVIADO
				$csv .= date('d-m-Y H:i', strtotime( $row->criado ) );
				$csv .= $formato;
				$csv .= PHP_EOL;
	
			endforeach;
				
			fwrite($fp, $csv);
			fclose($fp);
				
			if ( $get['p'] == $result->total_page ) {
				$refresh = '0';
			} else {
				$refresh = '1';
			}
				
			$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
				
			echo json_encode( $retorno ); exit;
				
		}
	
	}
	
	public function aberturasAction()
	{
	
		$get = $this->_request->getParams();
	
		// SELECT
		$relatorio = new Zend_Db_Select($this->db);
		$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));
	
		$relatorio->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
				'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'));
	
		$relatorio->where('ENVIO.status = "Campanha enviada" ');
		$relatorio->where('id_usuario IN ('. implode(',', $this->me->familia) .')');
	
		$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
		$this->view->campanhas = $relatorio->fetchAll();

        $this->view->campanhaNome = array();
        foreach( $this->view->campanhas as $row ){
            $this->view->campanhaNome[$row->id_campanha] = $row->campanha;
        }

		$url = $this->view->backend.'api/relatorios/get-aberturas?id_usuario='.$this->me->id_usuario;
	
		$filter_get = $get;
	
		// FILTRO DE LIMITE
		if ( $get['limit'] == NULL  ){
	
			$filter_get['limit'] = 10;
	
		} else {
	
			if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
	
				$filter_get['limit'] = 10;
	
			}
	
		}
	
		if ( $get['download'] ) {
			$filter_get['limit'] = 10000;
		}
	
		$filter_get['order'] = 'criado-desc';
		unset($filter_get['whitelabel']);
	
		$filter = http_build_query ( $filter_get );
	
		$url = $url.'&'.$filter;
	
		$file = json_decode( file_get_contents( $url ) );
		$this->view->result = $file;
	
		$this->aberturasDownload($this->view->result, $get, ';', $this->view->nome[0]->campanha);
	
		// 		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;
	
	}
	
	private function aberturasDownload( $result, $get, $formato, $campanha )
	{
	
		if ( $get['download'] ) {
	
			if ( $get['arquivo'] != '' ) {
	
				$name = $get['arquivo'];
	
			} else {
	
				$name = time().$this->me->id_usuario.'.csv';
	
			}
	
			$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
	
			// ABRE/CRIA O ARQUIVO
			$fp = fopen($root.$name, 'a');
	
			// INICIA A VARIAVEL DO CSV
			$csv = NULL;
	
			// MONTA O TOPO DO ARQUIVO
			if ( $get['p'] == 1 ) {
	
				$csv .= 'CELULAR';
				$csv .= $formato;
				$csv .= 'CAMPANHA';
				$csv .= $formato;
				$csv .= 'DATA';
				$csv .= PHP_EOL;
	
			}
	
			foreach ( $result->registros as $row ):
	
			// CELULAR
			$csv .= $row->contato;
			$csv .= $formato;
	
			// CAMPANHA
			$csv .= $campanha;
			$csv .= $formato;
	
			// DATA ENVIADO
			$csv .= date('d-m-Y H:i', strtotime( $row->criado ) );
			$csv .= $formato;
			$csv .= PHP_EOL;
	
			endforeach;
	
			fwrite($fp, $csv);
			fclose($fp);
	
			if ( $get['p'] == $result->total_page ) {
				$refresh = '0';
			} else {
				$refresh = '1';
			}
	
			$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
	
			echo json_encode( $retorno ); exit;
	
		}
	
	}

    public function aceitesAction()
    {

        $get = $this->_request->getParams();

        // SELECT
        $relatorio = new Zend_Db_Select($this->db);
        $relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));

        $relatorio->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
            'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'));

        $relatorio->where('ENVIO.status = "Campanha enviada" ');
        $relatorio->where('id_usuario IN ('. implode(',', $this->me->familia) .')');

        $relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
        $this->view->campanhas = $relatorio->fetchAll();

        $this->view->campanhaNome = array();
        foreach( $this->view->campanhas as $row ){
            $this->view->campanhaNome[$row->id_campanha] = $row->campanha;
        }

        $url = $this->view->backend.'api/relatorios/get-aceites?id_usuario='.$this->me->id_usuario;

        $filter_get = $get;

        // FILTRO DE LIMITE
        if ( $get['limit'] == NULL  ){

            $filter_get['limit'] = 10;

        } else {

            if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){

                $filter_get['limit'] = 10;

            }

        }

        if ( $get['download'] ) {
            $filter_get['limit'] = 10000;
        }

        $filter_get['order'] = 'criado-desc';
        unset($filter_get['whitelabel']);

        $filter = http_build_query ( $filter_get );

        $url = $url.'&'.$filter;

        $file = json_decode( file_get_contents( $url ) );
        $this->view->result = $file;

        $this->aberturasDownload($this->view->result, $get, ';', $this->view->nome[0]->campanha);

        // 		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;

    }

    private function aceitesDownload( $result, $get, $formato, $campanha )
    {

        if ( $get['download'] ) {

            if ( $get['arquivo'] != '' ) {

                $name = $get['arquivo'];

            } else {

                $name = time().$this->me->id_usuario.'.csv';

            }

            $root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';

            // ABRE/CRIA O ARQUIVO
            $fp = fopen($root.$name, 'a');

            // INICIA A VARIAVEL DO CSV
            $csv = NULL;

            // MONTA O TOPO DO ARQUIVO
            if ( $get['p'] == 1 ) {

                $csv .= 'CELULAR';
                $csv .= $formato;
                $csv .= 'CAMPANHA';
                $csv .= $formato;
                $csv .= 'DATA';
                $csv .= PHP_EOL;

            }

            foreach ( $result->registros as $row ):

                // CELULAR
                $csv .= $row->contato;
                $csv .= $formato;

                // CAMPANHA
                $csv .= $campanha;
                $csv .= $formato;

                // DATA ENVIADO
                $csv .= date('d-m-Y H:i', strtotime( $row->criado ) );
                $csv .= $formato;
                $csv .= PHP_EOL;

            endforeach;

            fwrite($fp, $csv);
            fclose($fp);

            if ( $get['p'] == $result->total_page ) {
                $refresh = '0';
            } else {
                $refresh = '1';
            }

            $retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);

            echo json_encode( $retorno ); exit;

        }

    }
	
	public function moAction()
	{
	
		$get = $this->_request->getParams();
	
	    if ( empty($get['didf']) ){
    	    if ( empty($get['d_i']) ){
    	        $get['d_i'] = date('Y-m-d');
    	    }
    	    
    	    if ( empty($get['d_f']) ){
    	        $get['d_f'] = date('Y-m-d');
    	    }
	    }
		
		// SELECT
		$relatorio = new Zend_Db_Select($this->db);
		$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));
	
		$relatorio->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
				'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'));
	
		$relatorio->where('ENVIO.status = "Campanha enviada" ');
		$relatorio->where('id_usuario IN ('. implode(',', $this->me->familia) .')');
	
		$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
		$this->view->campanhas = $relatorio->fetchAll();
	
		/*
		 * não tava chamando as repostas quando era outro usuario da mesma empresa @capetão
		 */
		//$url = $this->view->backend.'api/relatorios/get-mo?id_usuario='.$this->me->id_usuario;
		$url = $this->view->backend.'api/relatorios/get-mo?id_usuario='.( implode(',', $this->me->familia) );
	
		$filter_get = $get;
	
		// FILTRO DE LIMITE
		if ( $get['limit'] == NULL  ){
	
			$filter_get['limit'] = 10;
	
		} else {
	
			if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
	
				$filter_get['limit'] = 10;
	
			}
	
		}
	
		if ( $get['download'] ) {
			$filter_get['limit'] = 10000;
		}
	
		$filter_get['order'] = 'criado-desc';
		unset($filter_get['whitelabel']);
	
		$filter = http_build_query ( $filter_get );
	
		$url = $url.'&'.$filter;
		
		$file = json_decode( file_get_contents( $url ) );
		
		$this->view->result = $file;
	
		$this->moDownload($this->view->result, $get, ';', $this->view->nome[0]->campanha);
	
		// 		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;
	
	}
	
	private function moDownload( $result, $get, $formato, $campanha )
	{
	
		if ( $get['download'] ) {
	
			if ( $get['arquivo'] != '' ) {
	
				$name = $get['arquivo'];
	
			} else {
	
				$name = time().$this->me->id_usuario.'.csv';
	
			}
	
			$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
	
			// ABRE/CRIA O ARQUIVO
			$fp = fopen($root.$name, 'a');
	
			// INICIA A VARIAVEL DO CSV
			$csv = NULL;
	
			// MONTA O TOPO DO ARQUIVO
			if ( $get['p'] == 1 ) {
	
				$csv .= 'CELULAR';
				$csv .= $formato;
				$csv .= 'CAMPANHA';
				$csv .= $formato;
				$csv .= 'MENSAGEM ENVIADA';
				$csv .= $formato;
				$csv .= 'MENSAGEM RECEBIDA';
				$csv .= $formato;
				$csv .= 'DATA';
				$csv .= PHP_EOL;
	
			}
	
			foreach ( $result->registros as $row ):
	
			// CELULAR
			$csv .= $row->celular;
			$csv .= $formato;
	
			// CAMPANHA
			$csv .= $row->campanha;
			$csv .= $formato;
			
			// MENSAGEM ENVIADA
			$csv .= $row->mensagem;
			$csv .= $formato;
			
			// MENSAGEM RECEBIDA
			$csv .= $row->msg_resp;
			$csv .= $formato;
	
			// DATA ENVIADO
			$csv .= date('d-m-Y H:i', strtotime( $row->criado ) );
			$csv .= $formato;
			$csv .= PHP_EOL;
	
			endforeach;
	
			fwrite($fp, $csv);
			fclose($fp);
	
			if ( $get['p'] == $result->total_page ) {
				$refresh = '0';
			} else {
				$refresh = '1';
			}
	
			$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
	
			echo json_encode( $retorno ); exit;
	
		}
	
	}
	
	public function formAction()
	{
	
		$get = $this->_request->getParams();
	
		// SELECT
		$relatorio = new Zend_Db_Select($this->db);
		$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'));
	
		$relatorio->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
				'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'));
	
		$relatorio->where('ENVIO.status = "Campanha enviada" ');
		$relatorio->where('id_usuario IN ('. implode(',', $this->me->familia) .')');
	
		$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
		$this->view->campanhas = $relatorio->fetchAll();

        $this->view->campanhaNome = array();
        foreach( $this->view->campanhas as $row ){
            $this->view->campanhaNome[$row->id_campanha] = $row->campanha;
        }
		
		$url = $this->view->backend.'api/relatorios/get-form?id_usuario='.$this->me->id_usuario;
	
		$filter_get = $get;
	
		// FILTRO DE LIMITE
		if ( $get['limit'] == NULL  ){
	
			$filter_get['limit'] = 10;
	
		} else {
	
			if ( $get['limit'] != 10 && $get['limit'] != 25 && $get['limit'] != 50 && $get['limit'] != 100 && $get['limit'] != 250 && $get['limit'] != 500 ){
	
				$filter_get['limit'] = 10;
	
			}
	
		}
	
		$filter_get['order'] = 'criado-desc';
		unset($filter_get['whitelabel']);
		
		if ( $get['download'] ) {
		    $filter_get['limit'] = 10000;
		    $filter_get['order'] = 'id_form ASC';
		}
	
		$filter = http_build_query ( $filter_get );
	
		$url = $url.'&'.$filter;
	
		$file = json_decode( file_get_contents( $url ) );
        $this->view->result = $file;

		if ( $_GET['unique'] == 'true' ){

            $this->view->result->registros = array();

		    foreach ( json_decode( file_get_contents( $url ) )->registros as $row ){

                $this->view->result->registros[$row->celular] = $row;

            }

        }
		
		$this->formDownload($this->view->result, $get, ';', $this->view->nome[0]);
	
		// 		echo '<pre>'; echo $url; print_r( $this->view->result ); exit;
	
	}
	
	private function formDownload( $result, $get, $formato, $campanha )
	{
	
		if ( $get['download'] ) {
	
			if ( $get['arquivo'] != '' ) {
	
				$name = $get['arquivo'];
	
			} else {
	
				$name = time().$this->me->id_usuario.'.csv';
	
			}
	
			$root = $_SERVER['DOCUMENT_ROOT'].'/assets/uploads/csv/';
	
			// ABRE/CRIA O ARQUIVO
			$fp = fopen($root.$name, 'a');

			/*
			 * ANNA TAVA RECLAMANDO Q NO EXCEL ABRIA COM CODIFICAÇÃO ZUADA, ACHEI ESSE LINK E FIZ ESSA ALTERAÇÃO @capetão
			 * 
			 * https://www.skoumal.net/en/making-utf-8-csv-excel/
			 * 
			 */
			fputs($fp, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
	
			// INICIA A VARIAVEL DO CSV
			$csv = NULL;
			
			$id_form = 0;
			
			foreach ( $result->registros as $row ):
			
				$campos = json_decode ( $row->campos );
		
				if ( $id_form != $row->id_form ) {
				    
				    if ( $id_form != 0 ) {
				        
				        $csv .= PHP_EOL;
				        
				    }
				    
				    $id_form = $row->id_form;
				    
    				$csv .= 'Celular';
    				$csv .= $formato;
    				
    				$csv .= 'Campanha';
    				$csv .= $formato;
    				
    				// CAMPOS
    				foreach ( $campos as $key => $myrow ){
    				    
    				    if ( key($myrow) != '_empty_' ){
        					$csv .= strip_tags( key( $myrow ) );
        					$csv .= $formato;
    				    }
    				
    				}
    				
    				$csv .= 'Data';
    				$csv .= $formato;
    				$csv .= PHP_EOL;
				
				}
		
				// CELULAR
				$csv .= $row->celular;
				$csv .= $formato;
		
				// CAMPANHA
				$csv .= $campanha->campanha;
				$csv .= $formato;
				
				// CAMPOS
				foreach ( $campos as $key => $myrow ){
				
				    if ( strip_tags( key( $myrow ) ) != '_empty_' ){
				    
    					if ( is_array( current($myrow) ) ){
    					
    						$i=0;
    						foreach ( current( $myrow ) as $secondrow ) {	
    						
    							if ( $i == 0 ) {
    								
    								// current para chckbox
    								$csv .= strip_tags( ( $secondrow ) );
    								
    							} else {
    								
    								$csv .= ' ,'.strip_tags( $secondrow );
    								
    							}
    							
    							$i++;
    							
    						}
    						
    						$csv .= $formato;
    					
    					} else {
    					
    					    /*
    					     * TAVA QUEBRANDO NA HORA DE GERAR RELATORIO @capetão
    					     */
    					    $csv .=  str_replace( ';', ',', ( strip_tags( current( $myrow ) ) ));
    						$csv .= $formato;
    					
    					}
					
				    }
				
				}
		
				// DATA
				$csv .= date('d-m-Y H:i', strtotime( $row->criado ) );
				$csv .= $formato;
				$csv .= PHP_EOL;
	
			endforeach;
	
			fwrite($fp, $csv);
			fclose($fp);
	
			if ( $get['p'] == $result->total_page ) {
				$refresh = '0';
			} else {
				$refresh = '1';
			}
			
			$retorno = array('arquivo'=>$name, 'refresh'=>$refresh, 'next'=>$get['p'] + 1);
	
			echo json_encode( $retorno ); exit;
	
		}
	
	}
	
	public function indexAction ()
    {
    	
    	// SELECT
    	$relatorio = new Zend_Db_Select($this->db);
    	$relatorio->from(array('CAMPANHA'=>$this->config->tb->campanhas),array('*'))
    	 
    		->joinLeft(array('ENVIO'=>$this->config->tb->campanhas_envio),
    			'ENVIO.id_campanha = CAMPANHA.id_campanha',array('*'))
    			 
    		->order('CAMPANHA.id_campanha DESC')
    		->where('id_usuario IN ('. implode(',', $this->me->familia) .')')
    		->group('CAMPANHA.id_campanha');
    			 
    	$relatorio = $relatorio->query(Zend_Db::FETCH_OBJ);
    	$this->view->campanhas = $relatorio->fetchAll();
    			 
    	// PAGINACAO
    	$paginator = Zend_Paginator::factory ($this->view->campanhas);
    	// Seta a quantidade de registros por página
    	$paginator->setItemCountPerPage ( 20 );
    	// numero de paginas que serão exibidas
    	$paginator->setPageRange ( 5 );
    	// Seta a página atual
    	$paginator->setCurrentPageNumber ( $pagina );
    	// Passa o paginator para a view
    	$this->view->campanhas = $paginator;
    
    }
    
    public function formulariosAction ()
    {
    	
    	$this->view->tituloPag = 'Relatórios Formulários';
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	
    	$this->view->id = $params['id'];
    	
    	// RESULT SELECT
    	$this->view->relatorio = $this->postgre('relatorios','formularios', $post, $params);
    		
    	// PAGINAÇÃO
    	$page = (isset($_GET['p'])) ? intval($_GET['p']) : 1;
    	$this->view->relatorio = $this->paginacao($this->view->relatorio, 80, $page);
    	$this->view->paginacao = $this->paginacaoView($page, $this->view->totalResult);
    	
    }
    
    public function formulariosDownloadAction ()
    {
    	
    	header("Content-type: text/csv; charset=utf-8");
    	header("Content-Disposition: attachment; filename=formularios.csv");
    	header("Pragma: no-cache");
    	header("Expires: 0");
    	
    	$post = $this->_request->getPost();
    	$params = $this->_request->getParams();
    	 
    	// RESULT SELECT
    	$this->view->relatorio = $this->postgre('relatorios','formularios', $post, $params);
    	
    	foreach($this->view->relatorio as $row){
    		
    		$json = $row->campos;
    		$array = json_decode($json);
    		$total = count($array) - 1;
    		
    		echo 'Celular;';
    		
	    	for ($i = 0; $i <= $total; $i++) {
	
	    		foreach($array[$i] as $key => $row){
	    	
	    			echo utf8_decode($key).';';
	    			
	    		}
	    	
	    	}
	    	
	    	echo PHP_EOL;
	    	
	    	for ($i = 0; $i <= $total; $i++) {
	    	
	    		foreach($array[$i] as $key => $row){
	    			
	    			echo $row->celular.';';
	    	
	    			if (is_array($row)){
	    	
	    				foreach($row as $rara){
	    	
	    					if (is_array($rara)){
	    	
	    						foreach($row as $rere){
	    	
	    							echo utf8_decode($rere[0]);
	    	
	    						}
	    	
	    					} else {
	    	
	    						echo utf8_decode($rara);
	    	
	    					}
	    	
	    				}
	    	
	    			} else {
	    	
	    				echo utf8_decode($row);
	    	
	    			}
	    		}
	    		 
	    		echo ';';
	    		 
	    	}
	    	
	    	echo PHP_EOL;
	    	
    	}
    	
    	exit;
    	
    }

    public function comprasTemplatesAction()
    {

        $sql = new Zend_Db_Select($this->db);
        $sql->from(array('templates_comprados'=>$this->config->tb->templates_comprados),array('*'))

            ->joinLeft(array('landing_page'=>$this->config->tb->landing_page),
                'landing_page.id_landing_page = templates_comprados.id_landing_page',array('nome'))

            ->group('templates_comprados.id_template_comprado');

        $sql = $sql->query(Zend_Db::FETCH_OBJ);
        $this->view->result = $sql->fetchAll();

    }
    
}