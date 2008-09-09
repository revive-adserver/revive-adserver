<?php

require_once LIB_PATH.'/Plugin/Component.php';

class Plugins_testExtension1_testGroup1_testComponent1 extends OX_Component
{

    function staticMethod()
    {
        return 'staticMethodResult1';
    }

    function staticMethodWithParams($result)
    {
        return 'staticMethodWithParams1='.$result;
    }

    function hookHandler()
    {
        return 'testGroup1:testComponent1 hook handled';
    }


}

?>