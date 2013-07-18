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

require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

class OrganisationSelectionFieldTest extends UnitTestCase
{
    function testAdvertiserIsAcceptedFromQueryString()
    {
        $factory = new FieldFactory();

        $query_array = array(
            'example_advertiser' => 392
        );

        $field = $factory->newField('scope');
        $field->setName('example');

        $field->setValueFromArray($query_array);
        $scope = $field->getValue();
        $advertiser_id = $scope->getAdvertiserId();

        $this->assertEqual($advertiser_id, 392);
    }

    function testPublisherIsAcceptedFromQueryString()
    {
        $factory = new FieldFactory();

        $query_array = array(
            'example_publisher' => 768
        );

        $field = $factory->newField('scope');
        $field->setName('example');

        $field->setValueFromArray($query_array);
        $scope = $field->getValue();
        $publisher_id = $scope->getPublisherId();

        $this->assertEqual($publisher_id, 768);
    }
}

?>
