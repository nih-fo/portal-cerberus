<?php

$line_options = array('colors' => array());
if(isset($snapshotStats['legend']))
{
	foreach($snapshotStats['legend'] as $key => $name)
	{
		$snapshotStats['legend'][$key] = __('With Status: %s', $name);
		$color = '#'. substr(md5($name), 0, 6);
		if(strpos($key, '-'))
		{
			$parts = explode('-', $key);
			$key_id = array_pop($parts);
			if(isset($reportsStatuses[$key_id]))
				$color = $reportsStatuses[$key_id];
			$line_options['colors'][] = $color;
		}
	}
}

$content = $this->element('Utilities.object_dashboard_chart_line', array(
	'title' => '',
	'data' => $snapshotStats,
	'options' => $line_options,
));

echo $this->element('Utilities.object_dashboard_block', array(
	'title' => $this->Html->link(__('%s - By %s Trending', __('US'), __('Status')), array('action' => 'dashboard')),
	'content' => $content,
));