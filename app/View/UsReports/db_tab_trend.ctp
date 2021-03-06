<?php
$line_options = array('colors' => array());
foreach($stats['legend'] as $key => $name)
{
	$line_options['colors'][] = '#'. substr(md5($name), 0, 6);
}

$page_content = $this->element('Utilities.object_chart_line', array(
	'title' => '',
	'data' => $stats,
	'options' => $line_options,
));

echo $this->element('Utilities.page_generic', array(
	'page_title' => __('%s Trending', __('US Reports')),
	'page_subtitle' => __('Trending of total Results per Report by Report Date'),
	'page_content' => $page_content,
));