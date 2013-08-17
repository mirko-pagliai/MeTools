<?php echo "<?php echo \$this->start('sidebar'); ?>\n"; ?>
<?php if (strpos($action, 'add') === false): ?>
	<?php echo "\t<li><?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')), null, __('Are you sure you want to delete this record?')); ?></li>\n"; ?>
<?php endif; ?>
	<?php echo "<li><?php echo \$this->Html->link(__('List " . $pluralHumanName . "'), array('action' => 'index')); ?></li>\n"; ?>
<?php
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?></li>\n";
				echo "\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?></li>\n";
				$done[] = $details['controller'];
			}
		}
	}
?>
<?php echo "<?php echo \$this->end(); ?>\n"; ?>

<div class="<?php echo $pluralVar; ?> form">
<?php echo "\t<?php echo \$this->Form->create('{$modelClass}', array('class' => 'form-base')); ?>\n"; ?>
	<fieldset>
		<legend><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></legend>
<?php
		echo "\t\t<?php\n";
		foreach ($fields as $field) {
			if (strpos($action, 'add') !== false && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				echo "\t\t\techo \$this->Form->input('{$field}');\n";
			}
		}
		if (!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\t\techo \$this->Form->input('{$assocName}');\n";
			}
		}
		echo "\t\t?>\n";
?>
	</fieldset>
	<?php echo "<?php echo \$this->Form->end(__('Submit')); ?>\n"; ?>
</div>