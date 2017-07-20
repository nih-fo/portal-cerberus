<?php 
// File: app/View/ReportsVerification/admin_edit.ctp
?>
<div class="top">
	<h1><?php echo __('Edit %s', __('Reports Verification') ); ?></h1>
</div>
<div class="center">
	<div class="form">
		<?php echo $this->Form->create('ReportsVerification');?>
		    <fieldset>
		        <legend><?php echo __('Edit %s', __('Reports Verification') ); ?></legend>
		    	<?php
					echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('details');
		    	?>
		    </fieldset>
		<?php echo $this->Form->end(__('Update %s', __('Reports Verification') )); ?>
	</div>
</div>