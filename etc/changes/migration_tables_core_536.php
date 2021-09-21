<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_536 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__country';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__country';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_region';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_region';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_city';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_city';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_postal_code';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_postal_code';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_latitude';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_latitude';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_longitude';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_longitude';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_dma_code';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_dma_code';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_area_code';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_area_code';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_organisation';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_organisation';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_netspeed';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_netspeed';
        $this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_continent';
        $this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_continent';
    }



    public function beforeRemoveField__data_raw_ad_request__country()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'country');
    }

    public function afterRemoveField__data_raw_ad_request__country()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'country');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_region()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_region');
    }

    public function afterRemoveField__data_raw_ad_request__geo_region()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_region');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_city()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_city');
    }

    public function afterRemoveField__data_raw_ad_request__geo_city()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_city');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_postal_code()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_postal_code');
    }

    public function afterRemoveField__data_raw_ad_request__geo_postal_code()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_postal_code');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_latitude()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_latitude');
    }

    public function afterRemoveField__data_raw_ad_request__geo_latitude()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_latitude');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_longitude()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_longitude');
    }

    public function afterRemoveField__data_raw_ad_request__geo_longitude()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_longitude');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_dma_code()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_dma_code');
    }

    public function afterRemoveField__data_raw_ad_request__geo_dma_code()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_dma_code');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_area_code()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_area_code');
    }

    public function afterRemoveField__data_raw_ad_request__geo_area_code()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_area_code');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_organisation()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_organisation');
    }

    public function afterRemoveField__data_raw_ad_request__geo_organisation()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_organisation');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_netspeed()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_netspeed');
    }

    public function afterRemoveField__data_raw_ad_request__geo_netspeed()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_netspeed');
    }

    public function beforeRemoveField__data_raw_ad_request__geo_continent()
    {
        return $this->beforeRemoveField('data_raw_ad_request', 'geo_continent');
    }

    public function afterRemoveField__data_raw_ad_request__geo_continent()
    {
        return $this->afterRemoveField('data_raw_ad_request', 'geo_continent');
    }
}
