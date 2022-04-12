<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_627 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAlterField__users__username';
        $this->aTaskList_constructive[] = 'afterAlterField__users__username';
        $this->aTaskList_constructive[] = 'beforeAlterField__users__password';
        $this->aTaskList_constructive[] = 'afterAlterField__users__password';
    }

    public function beforeAlterField__users__username()
    {
        return $this->migrateNullUsername() && $this->beforeAlterField('users', 'username');
    }

    public function afterAlterField__users__username()
    {
        return $this->afterAlterField('users', 'username');
    }

    public function beforeAlterField__users__password()
    {
        return $this->migrateNullPassword() && $this->beforeAlterField('users', 'password');
    }

    public function afterAlterField__users__password()
    {
        return $this->afterAlterField('users', 'password');
    }

    private function migrateNullUsername()
    {
        $prefix = $this->getPrefix();
        $qTblUsers = $this->oDBH->quoteIdentifier($prefix . 'users', true);

        $sql = "DELETE FROM {$qTblUsers}  WHERE username IS NULL";
        $result = $this->oDBH->exec($sql);

        if (!PEAR::isError($result)) {
            return true;
        }

        return $this->_logErrorAndReturnFalse('Error removing users without username during migration 627: ' . $result->getUserInfo());
    }

    private function migrateNullPassword()
    {
        $prefix = $this->getPrefix();
        $qTblUsers = $this->oDBH->quoteIdentifier($prefix . 'users', true);

        $sql = "UPDATE {$qTblUsers} SET password = '' WHERE password IS NULL";
        $result = $this->oDBH->exec($sql);

        if (!PEAR::isError($result)) {
            return true;
        }

        return $this->_logErrorAndReturnFalse('Error updating null passwords during migration 627: ' . $result->getUserInfo());
    }
}
