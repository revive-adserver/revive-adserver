<?php

require_once MAX_PATH . '/lib/OA/Upgrade/Migration.php';

class Migration_629 extends Migration
{
    public function __construct()
    {
        foreach (['ad_category_assoc', 'category'] as $table) {
            $this->aTaskList_destructive[] = "beforeRemoveTable__{$table}";
            $this->aTaskList_destructive[] = "afterRemoveTable__{$table}";
        }

        foreach ([
            'affiliates__oac_country_code',
            'affiliates__oac_language_id',
            'affiliates__oac_category_id',
            'affiliates_extra__category',
            'zones__oac_category_id',
            'zones__category',
        ] as $field) {
            $this->aTaskList_destructive[] = "beforeRemoveField__{$field}";
            $this->aTaskList_destructive[] = "afterRemoveField__{$field}";
        }
    }

    public function beforeRemoveTable__ad_category_assoc()
    {
        return $this->beforeRemoveTable('ad_category_assoc');
    }

    public function afterRemoveTable__ad_category_assoc()
    {
        return $this->afterRemoveTable('ad_category_assoc');
    }

    public function beforeRemoveTable__category()
    {
        return $this->beforeRemoveTable('category');
    }

    public function afterRemoveTable__category()
    {
        return $this->afterRemoveTable('category');
    }

    public function beforeRemoveField__affiliates__oac_country_code()
    {
        return $this->beforeRemoveField('affiliates', 'oac_country_code');
    }

    public function afterRemoveField__affiliates__oac_country_code()
    {
        return $this->afterRemoveField('affiliates', 'oac_country_code');
    }

    public function beforeRemoveField__affiliates__oac_language_id()
    {
        return $this->beforeRemoveField('affiliates', 'oac_language_id');
    }

    public function afterRemoveField__affiliates__oac_language_id()
    {
        return $this->afterRemoveField('affiliates', 'oac_language_id');
    }

    public function beforeRemoveField__affiliates__oac_category_id()
    {
        return $this->beforeRemoveField('affiliates', 'oac_category_id');
    }

    public function afterRemoveField__affiliates__oac_category_id()
    {
        return $this->afterRemoveField('affiliates', 'oac_category_id');
    }

    public function beforeRemoveField__zones__oac_category_id()
    {
        return $this->beforeRemoveField('zones', 'oac_category_id');
    }

    public function afterRemoveField__zones__oac_category_id()
    {
        return $this->afterRemoveField('zones', 'oac_category_id');
    }

    public function beforeRemoveField__affiliates_extra__category()
    {
        return $this->beforeRemoveField('affiliates_extra', 'category');
    }

    public function afterRemoveField__affiliates_extra__category()
    {
        return $this->afterRemoveField('affiliates_extra', 'category');
    }

    public function beforeRemoveField__zones__category()
    {
        return $this->beforeRemoveField('zones', 'category');
    }

    public function afterRemoveField__zones__category()
    {
        return $this->afterRemoveField('zones', 'category');
    }
}
