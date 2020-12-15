<?php

include_once 'app/models/My_Controller.php';
include_once 'app/models/Model_Data.php';
include_once 'app/models/db.php';

class EmailController extends My_Controller 
{
	
	public function ini()
	{
 
		$this->data = new Model_Data(new contato_campanha());
		$this->data->_required(array('id_contato_campanha', 'celular', 'campos', 'id_campanha', 'criado'));
		$this->data->_notNull(array('celular', 'campos', 'id_campanha'));
		
	}
	
	public function enviarAction()
	{
		
		$post = $this->_request->getPost();
		
		$this->view->form = $this->form = str_replace('?', '', $post['url']);
		
		$form = explode('[&]', $this->form);
		$campos = count($form);
		
		//echo $this->form; exit();
		
		$campanhas = new campanhas();
		$this->view->campanhas = $campanhas->fetchAll('id_campanha = '.$form[1].'');
		
		$contatos = new contatos();
		$this->view->contatos = $contatos->fetchAll("celular LIKE '%".$form[2]."%'");
		
		$email_send = str_replace('email-send: ', '', $form[3]);
		$email_send = str_replace(' ', '', $email_send);

		// REQUIRE DA FUNÇÃO
		require_once 'app/models/SendMail.php';
		$opc_sendmail = array();
		
		// MENSAGEM
		$opc_sendmail['mensagem'] = '<div align="center" style="font-family:\'Arial\';">';
		$opc_sendmail['mensagem'] .= '<div style="border:#dddddd 1pt solid;padding:15px;width:690px; border-radius:3px;">';
		$opc_sendmail['mensagem'] .= '<div style="border:#dddddd 1pt dashed;padding:22.5pt;background:#f6f6f6; border-radius:3px;" align="left">';
		$opc_sendmail['mensagem'] .= '<span style="font-size:13px">';
		
		$opc_sendmail['mensagem'] .= 'Campanha: '.$this->view->campanhas[0]->campanha.'<br/>';
		$opc_sendmail['mensagem'] .= 'Celular: '.$this->view->contatos[0]->celular.'<br/><br/>';
		
		$opc_sendmail['mensagem'] .= '<b>Campos do formulário:</b>';
		
		$i = 1;
		foreach ($form as $row) {
			
			if ($i > 4){
				$opc_sendmail['mensagem'] .= '<br/>'.$form[$i];
			}
			
			$i++;
			
		}
		
		$opc_sendmail['mensagem'] .= '</span>';
		$opc_sendmail['mensagem'] .= '</div>';
		$opc_sendmail['mensagem'] .= '</div>';
		
		$opc_sendmail['mensagem'] = str_replace('<br/>email-send: '.$email_send, '', $opc_sendmail['mensagem']);
		
		// ASSUNTO
		$opc_sendmail['assunto']  = '[FORMULARIO CAMPANHA - '.$this->view->campanhas[0]->campanha.']';
		// EMAIL
		$opc_sendmail['email'] = $email_send;
		// FUNÇÃO PARA ENVIAR
		$envia = SendMail(utf8_decode($opc_sendmail['mensagem']), $opc_sendmail['email'], $opc_sendmail['assunto'],NULL, NULL);

		//echo json_encode($opc_sendmail);
		
		$post['id_campanha'] = $form[1];
		$post['celular'] = $this->view->contatos[0]->celular;
		$post['campos'] = '';
		
		$i = 1;
		foreach ($form as $row) {
			
			if ($i > 4){

				if ($i == 1){
					$post['campos'] .= $form[$i];
				} else {
					$post['campos'] .= '<br/>'.$form[$i];
				}
				
			}
			
			$i++;
			
		}
		
		$post['campos'] = str_replace('<br/>email-send: '.$email_send, '', $post['campos']);
		
		$edt = $this->data->edit(NULL,$post,NULL,Model_Data::NOVO);
		
		if ($edt){
			echo 'true';
		} else {
			echo 'false';
		}
		
		exit();
	}
}