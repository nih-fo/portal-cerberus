<?php
App::uses('AppModel', 'Model');

class ReportsAssignableParty extends AppModel 
{
	public $displayField = 'name';
	
	public $validate = array(
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
		'slug' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
			),
		),
	);
	
	public $hasMany = array(
		'EolSoftware' => array(
			'className' => 'EolSoftware',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'UsResultLog' => array(
			'className' => 'UsResultLog',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'UsResult' => array(
			'className' => 'UsResult',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'EolResultLog' => array(
			'className' => 'EolResultLog',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'EolResult' => array(
			'className' => 'EolResult',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'PenTestResultLog' => array(
			'className' => 'PenTestResultLog',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'PenTestResult' => array(
			'className' => 'PenTestResult',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'HighRiskResultLog' => array(
			'className' => 'HighRiskResultLog',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'HighRiskResult' => array(
			'className' => 'HighRiskResult',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
		'FovResult' => array(
			'className' => 'FovResult',
			'foreignKey' => 'reports_assignable_party_id',
			'dependent' => false,
		),
	);
	
	public $actsAs = [
		'ReportsAttribute',
	];
	
	public $cacheQueries = true;
	
	public $searchFields = [
		'ReportsAssignableParty.name',
	];
}
