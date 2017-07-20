<?php 
?>
<div class="top">
	<h1><?php echo __('Add %s', __('POA&M Severity')); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('PoamSeverity');?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('POA&M Severity')); ?></legend>
		    	<?php
					echo $this->Form->input('name', array(
						'div' => array('class' => 'twothird'),
					));
					echo $this->Form->input('color_code_hex', array(
						'div' => array('class' => 'third'),
						'label' => __('Assigned Color'),
						'type' => 'color',
					));
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('POA&M Severity'))); ?>
	</div>
</div>