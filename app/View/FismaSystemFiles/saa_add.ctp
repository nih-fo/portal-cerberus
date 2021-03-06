<?php 
// File: app/View/FismaSystemFiles/add.ctp

$file_type = __('File');
if($raf)
	$file_type = __('Risk Acceptance Form');
?>
<div class="top">
	<h1><?php echo __('Add %s', __('FISMA System %s', $file_type)); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('FismaSystemFile', array('type' => 'file'));?>
		    <fieldset>
		        <legend><?php echo __('Add %s', __('FISMA System %s', $file_type)); ?></legend>
		    	<?php
					echo $this->Form->input('fisma_system_id', array('type' => 'hidden'));
					echo $this->Form->input('nicename', array(
						'label' => __('Friendly Name'),
						'div' => array('class' => 'half'),
					));
					echo $this->Form->input('fisma_system_file_state_id', array(
						'options' => $fisma_system_file_states,
						'label' => __('The %s %s', $file_type, __('State')),
						'div' => array('class' => 'forth'),
					));
					echo $this->Form->input('expiration_date', array(
						'div' => array('class' => 'forth'),
						'value' => false,
					));
					echo $this->Wrap->divClear();
					echo $this->Form->input('file', array('type' => 'file'));
					echo $this->Wrap->divClear();
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes'),
						),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Save %s', __('FISMA System %s', $file_type))); ?>
	</div>
</div>