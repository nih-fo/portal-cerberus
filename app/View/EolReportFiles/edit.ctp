<?php 
// File: app/View/EolReportFiles/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('%s %s', __('EOL Report'), __('File'))); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('EolReportFile');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('%s %s', __('EOL Report'), __('File'))); ?></legend>
		    	<?php
					
					echo $this->Form->input('id');

					echo $this->Form->input('nicename', array(
						'label' => __('Friendly Name'),
						'div' => array('class' => 'half'),
					));
					
					echo $this->Wrap->divClear();
					
					echo $this->Form->input('notes', array(
						'label' => array(
							'text' => __('Notes'),
						),
					));
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('%s %s', __('EOL Report'), __('File')))); ?>
	</div>
</div>