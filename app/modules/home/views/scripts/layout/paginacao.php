<?php
	
	$q = $_SERVER['REDIRECT_QUERY_STRING'];
	
	if ( $_GET['p'] ) {
		
		$pagAntes = explode('&p=', $q);
		$pagAntes = explode('&', $pagAntes[0]);
		$pagAntes = $pagAntes[0];
		
		$q = str_replace($pagAntes, '', $q);
		$q = str_replace('&&', '&', $q);
		
	}
	
?>

<!-- Numbered page links -->
<?php foreach ($this->pagesInRange as $page): ?>

	<?php if ($page != $this->current): ?>
	
		<a data-page="<?php echo '?p='.$page .'&'. $q; ?>"><?php echo $page; ?></a>
		
	<?php else: ?>
	
		<a class="inativo"><?php echo $page; ?></a>
		
	<?php endif; ?>
	
<?php endforeach; ?>