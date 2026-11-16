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

class Test_OrganisationSelectionField extends Admin_UI_OrganisationSelectionField
{
    public function _getAdvertisers()
    {
        return [392 => ['advertiser_id' => 392]];
    }

    public function _getPublishers()
    {
        return [768 => ['publisher_id' => 768]];
    }
}

class OrganisationSelectionFieldTest extends UnitTestCase
{
    public function testAdvertiserIsAcceptedFromQueryString()
    {
        $query_array = [
            'example_advertiser' => 392,
        ];

        $field = new Test_OrganisationSelectionField();
        $field->setName('example');

        $field->setValueFromArray($query_array);
        $scope = $field->getValue();
        $advertiser_id = $scope->getAdvertiserId();

        $this->assertEqual($advertiser_id, 392);
    }

    public function testPublisherIsAcceptedFromQueryString()
    {
        $query_array = [
            'example_publisher' => 768,
        ];

        $field = new Test_OrganisationSelectionField();
        $field->setName('example');

        $field->setValueFromArray($query_array);
        $scope = $field->getValue();
        $publisher_id = $scope->getPublisherId();

        $this->assertEqual($publisher_id, 768);
    }

    public function testUnlistedAdvertiserIsRejected()
    {
        $field = new Test_OrganisationSelectionField('example');
        $field->setValueFromArray(['example_advertiser' => 393]);

        $this->assertFalse($field->getValue()->getAdvertiserId());
    }

    public function testUnlistedPublisherIsRejected()
    {
        $field = new Test_OrganisationSelectionField('example');
        $field->setValueFromArray(['example_publisher' => 769]);

        $this->assertFalse($field->getValue()->getPublisherId());
    }
}
