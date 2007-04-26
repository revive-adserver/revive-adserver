<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_127 extends Migration
{

    function Migration_127()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__zones__category';
		$this->aTaskList_constructive[] = 'afterAddField__zones__category';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__ad_selection';
		$this->aTaskList_constructive[] = 'afterAddField__zones__ad_selection';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__forceappend';
		$this->aTaskList_constructive[] = 'afterAddField__zones__forceappend';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__inventory_forecast_type';
		$this->aTaskList_constructive[] = 'afterAddField__zones__inventory_forecast_type';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__comments';
		$this->aTaskList_constructive[] = 'afterAddField__zones__comments';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__cost';
		$this->aTaskList_constructive[] = 'afterAddField__zones__cost';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__cost_type';
		$this->aTaskList_constructive[] = 'afterAddField__zones__cost_type';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__cost_variable_id';
		$this->aTaskList_constructive[] = 'afterAddField__zones__cost_variable_id';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__technology_cost';
		$this->aTaskList_constructive[] = 'afterAddField__zones__technology_cost';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__technology_cost_type';
		$this->aTaskList_constructive[] = 'afterAddField__zones__technology_cost_type';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__updated';
		$this->aTaskList_constructive[] = 'afterAddField__zones__updated';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__block';
		$this->aTaskList_constructive[] = 'afterAddField__zones__block';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__capping';
		$this->aTaskList_constructive[] = 'afterAddField__zones__capping';
		$this->aTaskList_constructive[] = 'beforeAddField__zones__session_capping';
		$this->aTaskList_constructive[] = 'afterAddField__zones__session_capping';


		$this->aObjectMap['zones']['category'] = array('fromTable'=>'zones', 'fromField'=>'category');
		$this->aObjectMap['zones']['ad_selection'] = array('fromTable'=>'zones', 'fromField'=>'ad_selection');
		$this->aObjectMap['zones']['forceappend'] = array('fromTable'=>'zones', 'fromField'=>'forceappend');
		$this->aObjectMap['zones']['inventory_forecast_type'] = array('fromTable'=>'zones', 'fromField'=>'inventory_forecast_type');
		$this->aObjectMap['zones']['comments'] = array('fromTable'=>'zones', 'fromField'=>'comments');
		$this->aObjectMap['zones']['cost'] = array('fromTable'=>'zones', 'fromField'=>'cost');
		$this->aObjectMap['zones']['cost_type'] = array('fromTable'=>'zones', 'fromField'=>'cost_type');
		$this->aObjectMap['zones']['cost_variable_id'] = array('fromTable'=>'zones', 'fromField'=>'cost_variable_id');
		$this->aObjectMap['zones']['technology_cost'] = array('fromTable'=>'zones', 'fromField'=>'technology_cost');
		$this->aObjectMap['zones']['technology_cost_type'] = array('fromTable'=>'zones', 'fromField'=>'technology_cost_type');
		$this->aObjectMap['zones']['updated'] = array('fromTable'=>'zones', 'fromField'=>'updated');
		$this->aObjectMap['zones']['block'] = array('fromTable'=>'zones', 'fromField'=>'block');
		$this->aObjectMap['zones']['capping'] = array('fromTable'=>'zones', 'fromField'=>'capping');
		$this->aObjectMap['zones']['session_capping'] = array('fromTable'=>'zones', 'fromField'=>'session_capping');
    }



	function beforeAddField__zones__category()
	{
		return $this->beforeAddField('zones', 'category');
	}

	function afterAddField__zones__category()
	{
		return $this->afterAddField('zones', 'category');
	}

	function beforeAddField__zones__ad_selection()
	{
		return $this->beforeAddField('zones', 'ad_selection');
	}

	function afterAddField__zones__ad_selection()
	{
		return $this->afterAddField('zones', 'ad_selection');
	}

	function beforeAddField__zones__forceappend()
	{
		return $this->beforeAddField('zones', 'forceappend');
	}

	function afterAddField__zones__forceappend()
	{
		return $this->afterAddField('zones', 'forceappend');
	}

	function beforeAddField__zones__inventory_forecast_type()
	{
		return $this->beforeAddField('zones', 'inventory_forecast_type');
	}

	function afterAddField__zones__inventory_forecast_type()
	{
		return $this->afterAddField('zones', 'inventory_forecast_type');
	}

	function beforeAddField__zones__comments()
	{
		return $this->beforeAddField('zones', 'comments');
	}

	function afterAddField__zones__comments()
	{
		return $this->afterAddField('zones', 'comments');
	}

	function beforeAddField__zones__cost()
	{
		return $this->beforeAddField('zones', 'cost');
	}

	function afterAddField__zones__cost()
	{
		return $this->afterAddField('zones', 'cost');
	}

	function beforeAddField__zones__cost_type()
	{
		return $this->beforeAddField('zones', 'cost_type');
	}

	function afterAddField__zones__cost_type()
	{
		return $this->afterAddField('zones', 'cost_type');
	}

	function beforeAddField__zones__cost_variable_id()
	{
		return $this->beforeAddField('zones', 'cost_variable_id');
	}

	function afterAddField__zones__cost_variable_id()
	{
		return $this->afterAddField('zones', 'cost_variable_id');
	}

	function beforeAddField__zones__technology_cost()
	{
		return $this->beforeAddField('zones', 'technology_cost');
	}

	function afterAddField__zones__technology_cost()
	{
		return $this->afterAddField('zones', 'technology_cost');
	}

	function beforeAddField__zones__technology_cost_type()
	{
		return $this->beforeAddField('zones', 'technology_cost_type');
	}

	function afterAddField__zones__technology_cost_type()
	{
		return $this->afterAddField('zones', 'technology_cost_type');
	}

	function beforeAddField__zones__updated()
	{
		return $this->beforeAddField('zones', 'updated');
	}

	function afterAddField__zones__updated()
	{
		return $this->afterAddField('zones', 'updated');
	}

	function beforeAddField__zones__block()
	{
		return $this->beforeAddField('zones', 'block');
	}

	function afterAddField__zones__block()
	{
		return $this->afterAddField('zones', 'block');
	}

	function beforeAddField__zones__capping()
	{
		return $this->beforeAddField('zones', 'capping');
	}

	function afterAddField__zones__capping()
	{
		return $this->afterAddField('zones', 'capping');
	}

	function beforeAddField__zones__session_capping()
	{
		return $this->beforeAddField('zones', 'session_capping');
	}

	function afterAddField__zones__session_capping()
	{
		return $this->afterAddField('zones', 'session_capping');
	}

}

?>