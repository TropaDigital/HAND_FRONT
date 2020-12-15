<?php echo ('P&aacute;gina n&atilde;o encontrada');?>
<?php 
if (Zend_Registry::get('config')->debug):
		$front = Zend_Controller_Front::getInstance();
		$e = $front->getResponse()->getException();
		$e = $e[0];
?>
	<div style="overflow: auto; margin-top: 10px; padding: 2px; border: 1px dashed black; background-color: #eee;font-size: 13px;width: 98%; height: 500px">
		<strong>Debugging information:</strong><br />
		<pre><?php print_r($e->__toString()); ?></pre>
		<pre><?php print_r($_SESSION); ?></pre>		
	</div>
<?php 
endif; 
?>