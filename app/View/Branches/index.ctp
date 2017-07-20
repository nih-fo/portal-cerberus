<?php 
// File: app/View/Branches/index.ctp

$page_title = __('%s', __('Branches'));
if($contactType)
{
	$page_title = __('%s by %s', $page_title, $contactType);
}
$page_options = array();

// content
$th = array();
$th['FismaSystem.count'] = array('content' => __('# %s', __('FISMA Systems')));
$th['UsResult.count'] = array('content' => __('# %s', __('US')));
$th['EolResult.count'] = array('content' => __('# %s', __('EOL')));
$th['PenTestResult.count'] = array('content' => __('# %s', __('PT')));
$th['HighRiskResult.count'] = array('content' => __('# %s', __('HR')));

if($contactType)
{
	$th['parents'] = array('content' => __('# %s', __('Parents')));
	$th['children'] = array('content' => __('# %s', __('Children')));
	$th['pii_count'] = array('content' => __('PII'));
	$th['ongoing_auth_yes'] = array('content' => __('# %s %s', __('Ongoing Auth'), __('Yes')));
	$th['ongoing_auth_no'] = array('content' => __('# %s %s', __('Ongoing Auth'), __('No')));
//	$th['ongoing_auth_na'] = array('content' => __('# %s %s', __('Ongoing Auth'), __('Unknown')));
	$th['fisma_reportable_yes'] = array('content' => __('# %s %s', __('FISMA Reportable'), __('Yes')));
	$th['fisma_reportable_no'] = array('content' => __('# %s %s', __('FISMA Reportable'), __('No')));
//	$th['fisma_reportable_na'] = array('content' => __('# %s %s', __('FISMA Reportable'), __('Unknown')));
	
	foreach($fismaSystemGssStatuses as $id => $name)
		$th['fismaSystemGssStatus_'. $id] = array('content' => __('%s: %s', __('GSS'), $name));
		
	foreach($fismaSystemFipsRatings as $id => $name)
		$th['fismaSystemFipsRating_'. $id] = array('content' => __('%s: %s', __('FIPS'), $name));
		
	foreach($fismaSystemRiskAssessments as $id => $name)
		$th['fismaSystemRiskAssessment_'. $id] = array('content' => __('%s: %s', __('FO Risk'), $name));
		
	foreach($fismaSystemThreatAssessments as $id => $name)
		$th['fismaSystemThreatAssessment_'. $id] = array('content' => __('%s: %s', __('FO Threat'), $name));
//
	foreach($fismaSystemSensitivityCategories as $id => $name)
		$th['fismaSystemSensitivityCategory_'. $id] = array('content' => __('%s: %s', __('Sensitivity Category'), $name));
		
	foreach($fismaSystemSensitivityRatings as $id => $name)
		$th['fismaSystemSensitivityRating_'. $id] = array('content' => __('%s: %s', __('Sensitivity Rating'), $name));
		
	foreach($fismaSystemTypes as $id => $name)
		$th['fismaSystemType_'. $id] = array('content' => __('%s: %s', __('Type'), $name));
		
	foreach($fismaSystemComTotals as $id => $name)
		$th['fismaSystemComTotal_'. $id] = array('content' => __('%s: %s', __('Coms Total'), $name));
		
	foreach($fismaSystemImpacts as $id => $name)
		$th['fismaSystemImpact_'. $id] = array('content' => __('%s: %s', __('Impact'), $name));
		
	foreach($fismaSystemUniquenesses as $id => $name)
		$th['fismaSystemUniqueness_'. $id] = array('content' => __('%s: %s', __('Uniqueness'), $name));
		
	foreach($fismaSystemAmounts as $id => $name)
		$th['fismaSystemAmount_'. $id] = array('content' => __('%s: %s', __('Amount'), $name));
		
	foreach($fismaSystemDependencies as $id => $name)
		$th['fismaSystemDependency_'. $id] = array('content' => __('%s: %s', __('Dependency'), $name));
}

$td = array();
foreach ($branches as $i => $branch)
{
	$td[$i] = array();
	
	$td[$i]['FismaSystem.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'fisma_systems', 'action' => 'branch', $branch['Branch']['id']), 
		'url' => array('action' => 'view', $branch['Branch']['id'], 'tab' => 'fisma_systems'),
	));
	$td[$i]['UsResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'us_results', 'action' => 'branch', $branch['Branch']['id']), 
		'url' => array('action' => 'view', $branch['Branch']['id'], 'tab' => 'us_results'),
	));
	$td[$i]['EolResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'eol_results', 'action' => 'branch', $branch['Branch']['id']), 
		'url' => array('action' => 'view', $branch['Branch']['id'], 'tab' => 'eol_results'),
	));
	$td[$i]['PenTestResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'pen_test_results', 'action' => 'branch', $branch['Branch']['id']), 
		'url' => array('action' => 'view', $branch['Branch']['id'], 'tab' => 'pen_test_results'),
	));
	$td[$i]['HighRiskResult.count'] = array('.', array(
		'ajax_count_url' => array('controller' => 'high_risk_results', 'action' => 'branch', $branch['Branch']['id']), 
		'url' => array('action' => 'view', $branch['Branch']['id'], 'tab' => 'high_risk_results'),
	));
	
	if($contactType)
	{
		if(!isset($totals['fisma_systems'])) $totals['fisma_systems'] = 0;
		$totals['fisma_systems'] = ($totals['fisma_systems'] + $td[$i]['fisma_systems']);
		if($td[$i]['fisma_systems'])
			$td[$i]['fisma_systems'] = array($td[$i]['fisma_systems'], array('class' => 'highlight bold'));
		
		$td[$i]['parents'] = $branch['counts']['parents'];
		if(!isset($totals['parents'])) $totals['parents'] = 0;
		$totals['parents'] = ($totals['parents'] + $td[$i]['parents']);
		if($td[$i]['parents'])
			$td[$i]['parents'] = array($td[$i]['parents'], array('class' => 'highlight bold'));
		
		$td[$i]['children'] = $branch['counts']['children'];
		if(!isset($totals['children'])) $totals['children'] = 0;
		$totals['children'] = ($totals['children'] + $td[$i]['children']);
		if($td[$i]['children'])
			$td[$i]['children'] = array($td[$i]['children'], array('class' => 'highlight bold'));
	
		$td[$i]['pii_count'] = $branch['counts']['pii_count'];
		if(!isset($totals['pii_count'])) $totals['pii_count'] = 0;
		$totals['pii_count'] = ($totals['pii_count'] + $td[$i]['pii_count']);
		if($td[$i]['pii_count'])
			$td[$i]['pii_count'] = array($td[$i]['pii_count'], array('class' => 'highlight bold'));
		
		$td[$i]['ongoing_auth_yes'] = $branch['counts']['ongoing_auth_yes'];
		if(!isset($totals['ongoing_auth_yes'])) $totals['ongoing_auth_yes'] = 0;
		$totals['ongoing_auth_yes'] = ($totals['ongoing_auth_yes'] + $td[$i]['ongoing_auth_yes']);
		if($td[$i]['ongoing_auth_yes'])
			$td[$i]['ongoing_auth_yes'] = array($td[$i]['ongoing_auth_yes'], array('class' => 'highlight bold'));
		
		$td[$i]['ongoing_auth_no'] = $branch['counts']['ongoing_auth_no'];
		if(!isset($totals['ongoing_auth_no'])) $totals['ongoing_auth_no'] = 0;
		$totals['ongoing_auth_no'] = ($totals['ongoing_auth_no'] + $td[$i]['ongoing_auth_no']);
		if($td[$i]['ongoing_auth_no'])
			$td[$i]['ongoing_auth_no'] = array($td[$i]['ongoing_auth_no'], array('class' => 'highlight bold'));
		/*
		$td[$i]['ongoing_auth_na'] = $branch['counts']['ongoing_auth_na'];
		if(!isset($totals['ongoing_auth_na'])) $totals['ongoing_auth_na'] = 0;
		$totals['ongoing_auth_na'] = ($totals['ongoing_auth_na'] + $td[$i]['ongoing_auth_na']);
		if($td[$i]['ongoing_auth_na'])
			$td[$i]['ongoing_auth_na'] = array($td[$i]['ongoing_auth_na'], array('class' => 'highlight bold'));
		*/
		$td[$i]['fisma_reportable_yes'] = $branch['counts']['fisma_reportable_yes'];
		if(!isset($totals['fisma_reportable_yes'])) $totals['fisma_reportable_yes'] = 0;
		$totals['fisma_reportable_yes'] = ($totals['fisma_reportable_yes'] + $td[$i]['fisma_reportable_yes']);
		if($td[$i]['fisma_reportable_yes'])
			$td[$i]['fisma_reportable_yes'] = array($td[$i]['fisma_reportable_yes'], array('class' => 'highlight bold'));
		
		$td[$i]['fisma_reportable_no'] = $branch['counts']['fisma_reportable_no'];
		if(!isset($totals['fisma_reportable_no'])) $totals['fisma_reportable_no'] = 0;
		$totals['fisma_reportable_no'] = ($totals['fisma_reportable_no'] + $td[$i]['fisma_reportable_no']);
		if($td[$i]['fisma_reportable_no'])
			$td[$i]['fisma_reportable_no'] = array($td[$i]['fisma_reportable_no'], array('class' => 'highlight bold'));
		/*
		$td[$i]['fisma_reportable_na'] = $branch['counts']['fisma_reportable_na'];
		if(!isset($totals['fisma_reportable_na'])) $totals['fisma_reportable_na'] = 0;
		$totals['fisma_reportable_na'] = ($totals['fisma_reportable_na'] + $td[$i]['fisma_reportable_na']);
		if($td[$i]['fisma_reportable_na'])
			$td[$i]['fisma_reportable_na'] = array($td[$i]['fisma_reportable_na'], array('class' => 'highlight bold'));
		*/
		foreach($fismaSystemGssStatuses as $id => $name)
		{
			$td[$i]['fismaSystemGssStatus_'. $id] = $branch['counts']['fismaSystemGssStatus_'. $id];
			if(!isset($totals['fismaSystemGssStatus_'. $id])) $totals['fismaSystemGssStatus_'. $id] = 0;
			$totals['fismaSystemGssStatus_'. $id] = ($totals['fismaSystemGssStatus_'. $id] + $td[$i]['fismaSystemGssStatus_'. $id]);
			if($td[$i]['fismaSystemGssStatus_'. $id])
				$td[$i]['fismaSystemGssStatus_'. $id] = array($td[$i]['fismaSystemGssStatus_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemFipsRatings as $id => $name)
		{
			$td[$i]['fismaSystemFipsRating_'. $id] = $branch['counts']['fismaSystemFipsRating_'. $id];
			if(!isset($totals['fismaSystemFipsRating_'. $id])) $totals['fismaSystemFipsRating_'. $id] = 0;
			$totals['fismaSystemFipsRating_'. $id] = ($totals['fismaSystemFipsRating_'. $id] + $td[$i]['fismaSystemFipsRating_'. $id]);
			if($td[$i]['fismaSystemFipsRating_'. $id])
				$td[$i]['fismaSystemFipsRating_'. $id] = array($td[$i]['fismaSystemFipsRating_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemRiskAssessments as $id => $name)
		{
			$td[$i]['fismaSystemRiskAssessment_'. $id] = $branch['counts']['fismaSystemRiskAssessment_'. $id];
			if(!isset($totals['fismaSystemRiskAssessment_'. $id])) $totals['fismaSystemRiskAssessment_'. $id] = 0;
			$totals['fismaSystemRiskAssessment_'. $id] = ($totals['fismaSystemRiskAssessment_'. $id] + $td[$i]['fismaSystemRiskAssessment_'. $id]);
			if($td[$i]['fismaSystemRiskAssessment_'. $id])
				$td[$i]['fismaSystemRiskAssessment_'. $id] = array($td[$i]['fismaSystemRiskAssessment_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemThreatAssessments as $id => $name)
		{
			$td[$i]['fismaSystemThreatAssessment_'. $id] = $branch['counts']['fismaSystemThreatAssessment_'. $id];
			if(!isset($totals['fismaSystemThreatAssessment_'. $id])) $totals['fismaSystemThreatAssessment_'. $id] = 0;
			$totals['fismaSystemThreatAssessment_'. $id] = ($totals['fismaSystemThreatAssessment_'. $id] + $td[$i]['fismaSystemThreatAssessment_'. $id]);
			if($td[$i]['fismaSystemThreatAssessment_'. $id])
				$td[$i]['fismaSystemThreatAssessment_'. $id] = array($td[$i]['fismaSystemThreatAssessment_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemSensitivityCategories as $id => $name)
		{
			$td[$i]['fismaSystemSensitivityCategory_'. $id] = $shortname['counts']['fismaSystemSensitivityCategory_'. $id];
			if(!isset($totals['fismaSystemSensitivityCategory_'. $id])) $totals['fismaSystemSensitivityCategory_'. $id] = 0;
			$totals['fismaSystemSensitivityCategory_'. $id] = ($totals['fismaSystemSensitivityCategory_'. $id] + $td[$i]['fismaSystemSensitivityCategory_'. $id]);
			if($td[$i]['fismaSystemSensitivityCategory_'. $id])
				$td[$i]['fismaSystemSensitivityCategory_'. $id] = array($td[$i]['fismaSystemSensitivityCategory_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemSensitivityRatings as $id => $name)
		{
			$td[$i]['fismaSystemSensitivityRating_'. $id] = $shortname['counts']['fismaSystemSensitivityRating_'. $id];
			if(!isset($totals['fismaSystemSensitivityRating_'. $id])) $totals['fismaSystemSensitivityRating_'. $id] = 0;
			$totals['fismaSystemSensitivityRating_'. $id] = ($totals['fismaSystemSensitivityRating_'. $id] + $td[$i]['fismaSystemSensitivityRating_'. $id]);
			if($td[$i]['fismaSystemSensitivityRating_'. $id])
				$td[$i]['fismaSystemSensitivityRating_'. $id] = array($td[$i]['fismaSystemSensitivityRating_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemTypes as $id => $name)
		{
			$td[$i]['fismaSystemType_'. $id] = $shortname['counts']['fismaSystemType_'. $id];
			if(!isset($totals['fismaSystemType_'. $id])) $totals['fismaSystemType_'. $id] = 0;
			$totals['fismaSystemType_'. $id] = ($totals['fismaSystemType_'. $id] + $td[$i]['fismaSystemType_'. $id]);
			if($td[$i]['fismaSystemType_'. $id])
				$td[$i]['fismaSystemType_'. $id] = array($td[$i]['fismaSystemType_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemComTotals as $id => $name)
		{
			$td[$i]['fismaSystemComTotal_'. $id] = $shortname['counts']['fismaSystemComTotal_'. $id];
			if(!isset($totals['fismaSystemComTotal_'. $id])) $totals['fismaSystemComTotal_'. $id] = 0;
			$totals['fismaSystemComTotal_'. $id] = ($totals['fismaSystemComTotal_'. $id] + $td[$i]['fismaSystemComTotal_'. $id]);
			if($td[$i]['fismaSystemComTotal_'. $id])
				$td[$i]['fismaSystemComTotal_'. $id] = array($td[$i]['fismaSystemComTotal_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemImpacts as $id => $name)
		{
			$td[$i]['fismaSystemImpact_'. $id] = $shortname['counts']['fismaSystemImpact_'. $id];
			if(!isset($totals['fismaSystemImpact_'. $id])) $totals['fismaSystemImpact_'. $id] = 0;
			$totals['fismaSystemImpact_'. $id] = ($totals['fismaSystemImpact_'. $id] + $td[$i]['fismaSystemImpact_'. $id]);
			if($td[$i]['fismaSystemImpact_'. $id])
				$td[$i]['fismaSystemImpact_'. $id] = array($td[$i]['fismaSystemImpact_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemUniquenesses as $id => $name)
		{
			$td[$i]['fismaSystemUniqueness_'. $id] = $shortname['counts']['fismaSystemUniqueness_'. $id];
			if(!isset($totals['fismaSystemUniqueness_'. $id])) $totals['fismaSystemUniqueness_'. $id] = 0;
			$totals['fismaSystemUniqueness_'. $id] = ($totals['fismaSystemUniqueness_'. $id] + $td[$i]['fismaSystemUniqueness_'. $id]);
			if($td[$i]['fismaSystemUniqueness_'. $id])
				$td[$i]['fismaSystemUniqueness_'. $id] = array($td[$i]['fismaSystemUniqueness_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemAmounts as $id => $name)
		{
			$td[$i]['fismaSystemAmount_'. $id] = $shortname['counts']['fismaSystemAmount_'. $id];
			if(!isset($totals['fismaSystemAmount_'. $id])) $totals['fismaSystemAmount_'. $id] = 0;
			$totals['fismaSystemAmount_'. $id] = ($totals['fismaSystemAmount_'. $id] + $td[$i]['fismaSystemAmount_'. $id]);
			if($td[$i]['fismaSystemAmount_'. $id])
				$td[$i]['fismaSystemAmount_'. $id] = array($td[$i]['fismaSystemAmount_'. $id], array('class' => 'highlight bold'));
		}
		
		foreach($fismaSystemDependencies as $id => $name)
		{
			$td[$i]['fismaSystemDependency_'. $id] = $shortname['counts']['fismaSystemDependency_'. $id];
			if(!isset($totals['fismaSystemDependency_'. $id])) $totals['fismaSystemDependency_'. $id] = 0;
			$totals['fismaSystemDependency_'. $id] = ($totals['fismaSystemDependency_'. $id] + $td[$i]['fismaSystemDependency_'. $id]);
			if($td[$i]['fismaSystemDependency_'. $id])
				$td[$i]['fismaSystemDependency_'. $id] = array($td[$i]['fismaSystemDependency_'. $id], array('class' => 'highlight bold'));
		}
	}
}

if(isset($i) and isset($td[$i]) and $contactType)
{
	$line_count = 0;
	$totals_row = array(
		'Branch.division_id' => __('Totals:'), 
		'Branch.shortname' => false,
		'Branch.name' => false,
		'Branch.director_id' => false,
	);
	
	foreach($td[$i] as $k => $v)
	{
		$totals_row[$k] = false;
		if(isset($totals[$k]))
			$totals_row[$k] = $totals[$k];
		
		if($totals_row[$k])
			$totals_row[$k] = array(
				$totals_row[$k],
				array('class' => 'highlight bold'),
			);
	}
	$totals_row['actions'] = false;
	if(is_int($i))
		array_push($td, $totals_row);
	else
		$td['totals'] = $totals_row;
}

$this->set(compact('page_title', 'page_options', 'th', 'td'));
$this->extend('Contacts.ContactsBranches/index');