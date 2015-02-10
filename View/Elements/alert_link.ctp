<?php
if (!isset($class)) {
	$class = false;
}
if (!isset($close)) {
	$close = true;
}
?>
<div class="alert<?php echo ($class) ? ' ' . $class : null; ?>">
<?php if ($close): ?>
	<a class="close" data-dismiss="alert" href="#">×</a>
<?php endif; ?>
	<?php echo $message; ?>
	<?php if ($link_text && $link_url): ?>
		<?php echo $this->Html->link($link_text, $link_url, array('escape' => false));?>
	<?php endif; ?>
	
</div>