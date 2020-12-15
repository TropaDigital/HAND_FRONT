
<?php

if ( sizeof($_GET) > 0 )
{
	$g = $_GET; 
	$q = array();
	
	unset($g['p']);
	
	while (list($k,$v) = each($g)) 
		$q[] = $k .'='.$v;
	
	$q = '&' . implode('&',$q);
}

?>

<?php foreach ($this->pagesInRange as $page): ?>
	
	<?php if ($page != $this->current): ?>
	
		<a href="<?php echo '?p='.$page . $q; ?>"><?php echo $page; ?></a>
		
	<?php else: ?>
	
		<a class="inativo"><?php echo $page; ?></a>
		
	<?php endif; ?>
	
<?php endforeach; ?>