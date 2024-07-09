<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_014 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddIndex__banner_vast_element__banner_vast_element_pkey';
        $this->aTaskList_constructive[] = 'afterAddIndex__banner_vast_element__banner_vast_element_pkey';
        $this->aTaskList_constructive[] = 'beforeRemoveIndex__banner_vast_element__banner_vast_banner_vast_element_id';
        $this->aTaskList_constructive[] = 'afterRemoveIndex__banner_vast_element__banner_vast_banner_vast_element_id';
        $this->aTaskList_destructive[] = 'beforeRemoveField__banner_vast_element__banner_vast_element_id';
        $this->aTaskList_destructive[] = 'afterRemoveField__banner_vast_element__banner_vast_element_id';
    }

    public function beforeAddIndex__banner_vast_element__banner_vast_element_pkey()
    {
        if ('pgsql' === $this->oDBH->dbsyntax) {
            $sql = "
                DELETE FROM
                    {$this->prefix}banner_vast_element e1
                USING
                    {$this->prefix}banner_vast_element e2
                WHERE
                    e1.banner_id = e2.banner_id AND
                    e1.banner_vast_element_id > e2.banner_vast_element_id
            ";
        } else {
            $sql = "
                DELETE FROM
                    e1
                USING
                    {$this->prefix}banner_vast_element e1,
                    {$this->prefix}banner_vast_element e2
                WHERE
                    e1.banner_id = e2.banner_id AND
                    e1.banner_vast_element_id > e2.banner_vast_element_id
            ";
        }

        $result = $this->oDBH->exec($sql);

        return !PEAR::isError($result) && $this->beforeAddIndex('banner_vast_element', 'banner_vast_element_pkey');
    }

    public function afterAddIndex__banner_vast_element__banner_vast_element_pkey()
    {
        return $this->afterAddIndex('banner_vast_element', 'banner_vast_element_pkey');
    }

    public function beforeRemoveIndex__banner_vast_element__banner_vast_banner_vast_element_id()
    {
        return $this->beforeRemoveIndex('banner_vast_element', 'banner_vast_banner_vast_element_id');
    }

    public function afterRemoveIndex__banner_vast_element__banner_vast_banner_vast_element_id()
    {
        return $this->afterRemoveIndex('banner_vast_element', 'banner_vast_banner_vast_element_id');
    }

    public function beforeRemoveField__banner_vast_element__banner_vast_element_id()
    {
        return $this->beforeRemoveField('banner_vast_element', 'banner_vast_element_id');
    }

    public function afterRemoveField__banner_vast_element__banner_vast_element_id()
    {
        if ('pgsql' === $this->oDBH->dbsyntax) {
            $this->oDBH->exec("DROP SEQUENCE IF EXISTS {$this->prefix}banner_vast_element_banner_vast_element_id_seq");
        } else {
            $this->oDBH->exec('DROP TABLE IF EXISTS banner_vast_element_seq');
        }

        return $this->afterRemoveField('banner_vast_element', 'banner_vast_element_id');
    }
}
