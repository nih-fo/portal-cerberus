<?php

// tab-hijack
$page_options = array();
$block_options = array();
$page_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), array('action' => 'db_tab_piicount', 'org'), array('class' => 'tab-hijack'));
$block_options['org'] = $this->Html->link(__('By %s', __('ORG/IC')), array('action' => 'db_tab_piicount', 'org', 1), array('class' => 'block-hijack'));
$page_options['division'] = $this->Html->link(__('By %s', __('Division')), array('action' => 'db_tab_piicount', 'division'), array('class' => 'tab-hijack'));
$block_options['division'] = $this->Html->link(__('By %s', __('Division')), array('action' => 'db_tab_piicount', 'division', 1), array('class' => 'block-hijack'));
$page_options['branch'] = $this->Html->link(__('By %s', __('Branch')), array('action' => 'db_tab_piicount', 'branch'), array('class' => 'tab-hijack'));
$block_options['branch'] = $this->Html->link(__('By %s', __('Branch')), array('action' => 'db_tab_piicount', 'branch', 1), array('class' => 'block-hijack'));
$page_options['sac'] = $this->Html->link(__('By %s', __('SAC')), array('action' => 'db_tab_piicount', 'sac'), array('class' => 'tab-hijack'));
$block_options['sac'] = $this->Html->link(__('By %s', __('SAC')), array('action' => 'db_tab_piicount', 'sac', 1), array('class' => 'block-hijack'));
$page_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), array('action' => 'db_tab_piicount', 'owner'), array('class' => 'tab-hijack'));
$block_options['owner'] = $this->Html->link(__('By %s', __('System Owner')), array('action' => 'db_tab_piicount', 'owner', 1), array('class' => 'block-hijack'));
$page_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), array('action' => 'db_tab_piicount', 'system'), array('class' => 'tab-hijack'));
$block_options['system'] = $this->Html->link(__('By %s', __('FISMA System')), array('action' => 'db_tab_piicount', 'system', 1), array('class' => 'block-hijack'));

$th = array();
$th['path'] = array('content' => __('Path'));
$th['name'] = array('content' => $scopeName);
$th['pii_count'] = array('content' => __('PII Count'));

$totals = array();
$td = array();
$stats = array();

$stats['total'] = array(
	'name' => __('Total'),
	'value' => 0,
	'color' => 'FFFFFF',
	'pie_exclude' => true,
);

foreach($results as $resultId => $result)
{
	$td[$resultId] = array();
	
	$td[$resultId]['path'] = false;
	if(isset($result['object']))
		$td[$resultId]['path'] = $this->Contacts->makePath($result['object']);
	
	$td[$resultId]['name'] = $this->Html->link($result['name'], $result['url']);
	$td[$resultId]['pii_count'] = $result['piiCount'];
	
	$stats['total']['value'] = $totals['pii_count'] = ($stats['total']['value'] + $td[$resultId]['pii_count']);
	
	// for the block
	$statId = Inflector::slug(strtolower($result['name']));
	$stats[$statId] = array(
		'name' => $result['name'],
		'value' => $result['piiCount'],
		'color' => substr(md5($result['name']), 0, 6),
	);
}

$totals_row = array();
if(isset($resultId) and isset($td[$resultId]))
{
	$line_count = 0;
	$totals_row['path'] = __('Totals:');
	$totals_row['name'] = count($td);
	foreach($td[$resultId] as $k => $v)
	{
		//$totals_row[$k] = false;
		if(isset($totals[$k]))
			$totals_row[$k] = $totals[$k];
		
		if(!isset($totals_row[$k]))
			$totals_row[$k] = 0;
		
		if($totals_row[$k])
			$totals_row[$k] = array(
				$totals_row[$k],
				array('class' => 'highlight bold'),
			);
	}
	if(is_int($resultId))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}

if($as_block)
{
	$stats = Hash::sort($stats, '{s}.value', 'desc');
	$pie_data = array(array(__('%s', $scopeName), __('PII Count') ));
	$pie_options = array('slices' => array());
	foreach($stats as $i => $stat)
	{
		if($i == 'total')
		{
			$stats[$i]['pie_exclude'] = true;
			$stats[$i]['color'] = 'FFFFFF';
			continue;
		}
		if(!$stat['value'])
		{
			unset($stats[$i]);
			continue;
		}
		$pie_data[] = array(__('%s - %s', $stat['value'], $stat['name']), $stat['value'], $i);
		$pie_options['slices'][] = array('color' => '#'. $stat['color']);
	}
	
	$content = $this->element('Utilities.object_dashboard_chart_pie', array(
		'title' => '',
		'data' => $pie_data,
		'options' => $pie_options,
	));
	
	$content .= $this->element('Utilities.object_dashboard_stats', array(
		'title' => '',
		'details' => $stats,
	));

	echo $this->element('Utilities.object_dashboard_block', array(
		'title' => __('%s by %s', __('PII Counts'), $scopeName),
		'description' => __('Excluding items that have a 0 count. Based on %s grouped by %s', __('FISMA Systems'), $scopeName),
		'content' => $content,
		'page_options' => $block_options,
	));
}
else
{
	echo $this->element('Utilities.page_index', array(
		'page_title' => __('PII Counts'),
		'page_subtitle' => __('By %s', $scopeName),
		'page_options_title' => __('Change Scope'),
		'page_options' => $page_options,
		'th' => $th,
		'td' => $td,
		'use_pagination' => false,
		'use_search' => false,
	));
}