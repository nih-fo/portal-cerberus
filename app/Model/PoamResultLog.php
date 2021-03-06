<?php
App::uses('AppModel', 'Model');
App::uses('PoamResult', 'Model');

class PoamResultLog extends PoamResult 
{
	public $useTable = 'poam_result_logs';
	
	public $order = array('PoamResultLog.created' => 'DESC');
	
	public $_belongsTo = array(
		'PoamResult' => array(
			'className' => 'PoamResult',
			'foreignKey' => 'poam_result_id',
		),
	);
	
	function __construct($id = false, $table = null, $ds = null) 
	{
		$this->belongsTo = $this->belongsTo+$this->_belongsTo;
		return parent::__construct($id, $table, $ds);
	}
	
	/// overwrite some fuctions from host that we don't need here
	public function afterFind($results = array(), $primary = false)
	{
		return $results;
	}
	
	public function beforeSave($options = array()) 
	{
		return true;
	}
	
	public function afterSave($created = false, $options = array())
	{
		return true;
	}
	
	public function logChanges($poam_result_id = false, $old = array(), $new = array())
	{
		if($poam_result_id and isset($old[$this->PoamResult->alias]) and is_array($old[$this->PoamResult->alias]) and $old[$this->PoamResult->alias])
		{
			// of we're given a new record result, check to see if anything has changed
			$old = $old[$this->PoamResult->alias];
			
			if(isset($new[$this->PoamResult->alias]) and is_array($new[$this->PoamResult->alias]) and $new[$this->PoamResult->alias])
			{
				$new = $new[$this->PoamResult->alias];
				
				if(isset($new['modified_user_id']))
					$old['modified_user_id'] = $new['modified_user_id'];
				
				$update = array();
				foreach($new as $field => $value)
				{
					if(in_array($field, array('created', 'modified')))
						continue;
					
					if(isset($old[$field]) and $old[$field] != $value)
						$update[$field] = $value;
				}
				
				// nothing changed, no need to log it
				if(!$update)
					return true;
			}
			
			// Add usage stats here
			// This will track when any attribute that this object belongs to gets changed
			foreach($update as $update_k => $update_v)
			{
				if(preg_match('/_id$/', $update_k))
				{
					$this->Usage_updateCounts($update_k.'-'.$update_v, 'poamResults');
				}
			}
			
			if(isset($old['id'])) unset($old['id']);
			$old['poam_result_id'] = $poam_result_id;
			
			$old['created'] = date('Y-m-d H:i:s');
			
			$this->create();
			$this->data = $old;
			return $this->save($this->data);
		}
	}
	
	public function scanPastUsage()
	{
		Configure::write('debug', 1);
		$logs = $this->find('all', array(
			'order' => array(
				$this->alias.'.poam_result_id' => 'asc',
				$this->alias.'.created' => 'asc',
			),
			'conditions' => array(
				$this->alias.'.created <' => '2015-10-15 23:59:59',
			),
		));
		
		// reload the UsageCount
		App::uses('UsageEntity', 'Usage.Model');
		$this->UsageEntity = new UsageEntity();
		
		$time_periods = array(
			'year' => 'Y',
			'month' => 'Ym',
			'week' => 'YW',
			'day' => 'Ymd',
			'hour' => 'YmdH',
			'minute' => 'YmdHi',
		);
		
		$past = array();
		$updates = array();
		foreach($logs as $current)
		{
			// different result log
			if(isset($past[$this->alias]['poam_result_id']) and $past[$this->alias]['poam_result_id'] != $current[$this->alias]['poam_result_id'])
				$past = array();
			
			// do everything here
			$updated = array();
			foreach($current[$this->alias] as $field => $value)
			{
				if(in_array($field, array('created', 'modified', 'id')))
					continue;
				
				if(preg_match('/(_user_id|_date)$/', $field))
					continue;
					
				if(isset($past[$this->alias][$field]) and $past[$this->alias][$field] != $value)
				{
					$updated['old'][$field] = $past[$this->alias][$field];
					$updated[$field] = $value;
				}
			}
			
			if($updated)
			{
				$updated['modified'] = $current[$this->alias]['modified'];
				$updates[] = $updated;
			}
			
			$past = $current;
		}
		
		foreach($updates as $update)
		{
			foreach($update as $update_k => $update_v)
			{
				if(preg_match('/_id$/', $update_k))
				{
					foreach($time_periods as $time_period => $time_format)
					{
			
						$this->UsageEntity->updateCount($update_k.'-'.$update_v, 'poamResults', 1, $this->alias, $time_period, date($time_format, strtotime($update['modified'])));
						$this->UsageEntity->updateCount('modified', 'poamResults', 1, $this->alias, $time_period, date($time_format, strtotime($update['modified'])));
						$this->UsageEntity->updateCount('poamResults', 'modified', 1, $this->alias, $time_period, date($time_format, strtotime($update['modified'])));
					}
				}
			}
		}
	}
}
