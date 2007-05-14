<?php

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_128 extends Migration
{

    function Migration_128()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__banners__transparent';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__transparent';
		$this->aTaskList_constructive[] = 'beforeAddField__banners__parameters';
		$this->aTaskList_constructive[] = 'afterAddField__banners__parameters';


		$this->aObjectMap['banners']['parameters'] = array('fromTable'=>'banners', 'fromField'=>'parameters');
    }



	function beforeAlterField__banners__transparent()
	{
		return $this->beforeAlterField('banners', 'transparent');
	}

	function afterAlterField__banners__transparent()
	{
		return $this->migrateData() && $this->afterAlterField('banners', 'transparent');
	}

	function beforeAddField__banners__parameters()
	{
		return $this->beforeAddField('banners', 'parameters');
	}

	function afterAddField__banners__parameters()
	{
		return $this->afterAddField('banners', 'parameters');
	}

	
	function migrateData()
	{
	    $prefix = $this->getPrefix();
	    
	    $sql = "
	       UPDATE {$prefix}banners
	       SET transparent = 0
	       WHERE transparent = 2";
	    $result = $this->oDBH->exec($sql);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse($result);
	    }
	    
	    $sql = "
	       SELECT
	           bannerid,
	           htmlcache
	       FROM
	           {$prefix}banners
	       WHERE
	           contenttype = 'swf'
	    ";
	    $result = $this->oDBH->getAssoc($sql);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse($result);
	    }
	    foreach ($result as $bannerId => $code) {
	        $code = preg_replace('/^.*(<object.*<\/object>).*$/s', '$1', $code);
            preg_match_all('/alink(\d+).*?dest=(.*?)(?:&amp;atar\d+=(.*?))?(?:&amp;|\')/', $code, $m);
            
            if (count($m[0])) {
                $params = array();
                foreach ($m[1] as $k => $v) {
                    $params[$v] = array(
                        'link' => urldecode($m[2][$k]),
                        'tar'  => isset($m[3][$k]) ? urldecode($m[3][$k]) : ''
                    );
                }
                $params = serialize($params);
                $sql = "
        	       UPDATE {$prefix}banners
        	       SET parameters = '".$this->oDBH->escape($params)."'
        	       WHERE bannerid = '{$bannerId}'
                ";
        	    $result2 = $this->oDBH->exec($sql);
        	    if (PEAR::isError($result2)) {
        	        return $this->_logErrorAndReturnFalse($result2);
        	    }
            }
	    }
	    return true;
	}
}
?>