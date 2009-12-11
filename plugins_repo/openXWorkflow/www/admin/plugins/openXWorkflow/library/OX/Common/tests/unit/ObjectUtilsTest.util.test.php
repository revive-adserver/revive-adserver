<?php

class NoSetters
{
    public $field = 'a';
}

class HasSetters
{
    private $fieldA;
    private $fieldB;


    public function __construct($fieldA, $fieldB)
    {
        $this->fieldA = $fieldA;
        $this->fieldB = $fieldB;
    }


    public function setFieldA($fieldA)
    {
        $this->fieldA = $fieldA;
    }


    public function setFieldB($fieldB)
    {
        $this->fieldB = $fieldB;
    }
}

class OX_Common_ObjectUtilsTest extends UnitTestCase
{


    public function testNoSetters()
    {
        $this->check(new NoSetters(), array ("field" => "value"), array (), new NoSetters(), array (
                "field" => "value"));
    }


    public function testHasSetters()
    {
        $this->check(new HasSetters('a', 'b'), array (
                "fieldA" => "c", 
                "fieldB" => "d"), array (), new HasSetters('c', 'd'), array ());
    }


    public function testForbiddenFields()
    {
        $this->check(new HasSetters('a', 'b'), array (
                "fieldA" => "c", 
                "fieldB" => "d"), array (
                'fieldA'), new HasSetters('a', 'd'), array (
                "fieldA" => "c"));
    }


    public function check($object, $options, $forbidden, $expectedObject, 
            $expectedUnset)
    {
        $unset = OX_Common_ObjectUtils::setOptions($object, $options, $forbidden);
        $this->assertEqual($expectedUnset, $unset);
        $this->assertEqual($expectedObject, $object);
    }
}
