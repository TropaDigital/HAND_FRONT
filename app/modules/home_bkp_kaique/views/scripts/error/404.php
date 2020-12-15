<?php 
	if ($_GET['admin'] == 'true'){
		$front = Zend_Controller_Front::getInstance();
		$e = $front->getResponse()->getException();
		$e = $e[0];
?>


<div style="overflow: auto; margin-top: 10px; padding: 2px; border: 1px dashed black; background-color: #eee;font-size: 13px;width: 98%; height: 500px">
	<pre><?php print_r($e->__toString()); ?></pre>
	<pre><?php print_r($_SESSION); ?></pre>
</div>
<?php } else { ?>

	<h1>Erro 404</h1>
	
<?php } ?>